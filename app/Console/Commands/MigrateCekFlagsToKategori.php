<?php

namespace App\Console\Commands;

use App\Models\BaKategori;
use App\Models\CekFlagMapping;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Migrate flag legacy Tr_Ba_Main_New.Cek* → tr_ba_kategori_d
 * berdasarkan tabel ms_cek_flag_mapping.
 *
 * Usage:
 *   php artisan ba:migrate-cek-flags --dry-run   (preview)
 *   php artisan ba:migrate-cek-flags --force     (eksekusi)
 *
 * Behavior:
 *   - Skip BA yang sudah punya kategori_d rows (anti-duplicate).
 *   - Bila satu BA punya multi Cek* aktif → insert multi rows (sesuai aturan
 *     BA multi-kategori di sistem v2).
 *   - opsi_id selalu NULL (legacy tidak ada opsi).
 */
class MigrateCekFlagsToKategori extends Command
{
    protected $signature = 'ba:migrate-cek-flags
                            {--dry-run : Preview, jangan tulis ke DB}
                            {--force   : Eksekusi insert ke tr_ba_kategori_d}';

    protected $description = 'Migrate legacy Tr_Ba_Main_New.Cek* flags → tr_ba_kategori_d (v2 kategori system)';

    public function handle(): int
    {
        $dry   = (bool) $this->option('dry-run');
        $force = (bool) $this->option('force');

        if (!$dry && !$force) {
            $this->error('Wajib pilih salah satu: --dry-run atau --force');
            return self::FAILURE;
        }

        // 1. Load mapping
        $mappings = CekFlagMapping::where('active', true)->get()
            ->keyBy('legacy_flag');
        if ($mappings->isEmpty()) {
            $this->error('Tidak ada mapping aktif di ms_cek_flag_mapping.');
            return self::FAILURE;
        }
        $this->info('Mapping aktif: ' . $mappings->count() . ' flag.');

        // 2. Lookup kategori_kode → kategori_id
        $katMap = BaKategori::pluck('id', 'kode')->all();
        foreach ($mappings as $m) {
            if (!isset($katMap[$m->kategori_kode])) {
                $this->error("Kategori kode '{$m->kategori_kode}' (untuk flag {$m->legacy_flag}) tidak ditemukan di ms_ba_kategori. Skip.");
                $mappings->forget($m->legacy_flag);
            }
        }

        // 3. Iterate semua BA legacy yang punya flag aktif
        $flagCols = $mappings->keys()->all();
        if (empty($flagCols)) {
            $this->warn('Tidak ada mapping valid setelah validasi. Selesai.');
            return self::SUCCESS;
        }

        $baQuery = DB::table('Tr_Ba_Main_New as h')
            ->select(array_merge(['h.Tr_BA_Main_Code'], array_map(fn($f) => "h.{$f}", $flagCols)));
        // Filter: minimal 1 flag aktif
        $baQuery->where(function ($q) use ($flagCols) {
            foreach ($flagCols as $f) {
                $q->orWhere("h.{$f}", 1);
            }
        });

        $totalBa   = (clone $baQuery)->count();
        $this->info("Total BA dengan minimal 1 flag aktif: {$totalBa}");

        if ($totalBa === 0) {
            $this->info('Tidak ada BA legacy yang perlu di-migrasi.');
            return self::SUCCESS;
        }

        // 4. Loop & build insert rows
        $now = now();
        $stats = [
            'ba_processed'    => 0,
            'ba_skipped_dup'  => 0,
            'rows_inserted'   => 0,
            'rows_to_insert'  => 0,
        ];
        $sample = [];

        $baQuery->orderBy('h.Tr_BA_Main_Code')->chunk(500, function ($chunk) use (&$stats, &$sample, $mappings, $katMap, $flagCols, $now, $dry) {
            foreach ($chunk as $ba) {
                $code = $ba->Tr_BA_Main_Code;

                // Anti-dup: skip kalau sudah ada kategori_d row
                $hasKategori = DB::table('tr_ba_kategori_d')
                    ->where('tr_ba_main_code', $code)->exists();
                if ($hasKategori) {
                    $stats['ba_skipped_dup']++;
                    continue;
                }

                $insertRows = [];
                foreach ($flagCols as $f) {
                    if ((int) ($ba->$f ?? 0) === 1) {
                        $m = $mappings->get($f);
                        if (!$m) continue;
                        $katId = $katMap[$m->kategori_kode] ?? null;
                        if (!$katId) continue;
                        $insertRows[] = [
                            'tr_ba_main_code' => $code,
                            'kategori_id'     => $katId,
                            'opsi_id'         => null,
                            'created_at'      => $now,
                            'updated_at'      => $now,
                        ];
                    }
                }

                if (empty($insertRows)) continue;

                if (count($sample) < 10) {
                    $sample[] = [
                        'code'  => $code,
                        'count' => count($insertRows),
                        'flags' => array_filter($flagCols, fn($f) => (int) ($ba->$f ?? 0) === 1),
                    ];
                }

                if (!$dry) {
                    DB::table('tr_ba_kategori_d')->insert($insertRows);
                    $stats['rows_inserted'] += count($insertRows);
                } else {
                    $stats['rows_to_insert'] += count($insertRows);
                }
                $stats['ba_processed']++;
            }
        });

        // 5. Report
        $this->newLine();
        $this->info(($dry ? '[DRY RUN]' : '[EXECUTED]') . ' Summary:');
        $this->table(['Metric', 'Count'], [
            ['BA processed',              $stats['ba_processed']],
            ['BA skipped (sudah punya kategori)', $stats['ba_skipped_dup']],
            ['Rows inserted (atau "to insert" pada dry-run)',
                $dry ? $stats['rows_to_insert'] : $stats['rows_inserted']],
        ]);

        if (!empty($sample)) {
            $this->newLine();
            $this->info('Sample (max 10):');
            foreach ($sample as $s) {
                $this->line("  {$s['code']}  → {$s['count']} kategori (flags: " . implode(', ', $s['flags']) . ')');
            }
        }

        if ($dry) {
            $this->newLine();
            $this->warn('Ini DRY RUN. Tidak ada perubahan. Jalankan lagi dengan --force untuk eksekusi.');
        } else {
            $this->newLine();
            $this->info('Selesai. Periksa BA detail untuk verify.');
        }

        return self::SUCCESS;
    }
}
