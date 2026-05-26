<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CheckDocsSchemaCommand extends Command
{
    protected $signature = 'docs:check-schema {--strict : Exit non-zero if any drift detected}';

    protected $description = 'Verify docs/categories.md & docs/tables/ vs actual DB schema. Exits non-zero on drift with --strict.';

    public function handle(): int
    {
        $this->info('🔍 BA-PICA Schema Drift Check');
        $this->line('');

        $drift = 0;

        $drift += $this->checkKonteks();
        $drift += $this->checkKategori();
        $drift += $this->checkOpsi();
        $drift += $this->checkJunctionTables();
        $drift += $this->checkLegacyMigration();

        $this->line('');
        if ($drift === 0) {
            $this->info('✅ No drift detected against expected baseline.');
            return self::SUCCESS;
        }

        $this->warn("⚠️  {$drift} drift item(s) detected.");
        $this->line('Review the items above. Update docs/categories.md or docs/decisions/ to reflect actual state.');

        return $this->option('strict') ? self::FAILURE : self::SUCCESS;
    }

    private function checkKonteks(): int
    {
        $this->info('▶ ms_konteks');

        if (!Schema::hasTable('ms_konteks')) {
            $this->error('  ❌ Table ms_konteks not found. Did the rename from ms_business_unit happen?');
            return 1;
        }

        $rows = DB::table('ms_konteks')->orderBy('id')->get(['id', 'kode', 'nama', 'active']);
        $this->table(
            ['ID', 'Kode', 'Nama', 'Active'],
            $rows->map(fn ($r) => [$r->id, $r->kode, $r->nama, $r->active ? 'yes' : 'no'])->all()
        );

        $expected = ['LAKA', 'FNB', 'OP_HR', 'REVISI', 'FMCG'];
        $actual = $rows->pluck('kode')->all();
        $missing = array_diff($expected, $actual);
        $extra = array_diff($actual, $expected);

        $drift = 0;
        if ($missing) {
            $this->warn('  ⚠️  Expected konteks missing: ' . implode(', ', $missing));
            $drift++;
        }
        if ($extra) {
            $this->warn('  ⚠️  Extra konteks beyond docs baseline: ' . implode(', ', $extra) . ' (update docs/categories.md)');
            $drift++;
        }

        return $drift;
    }

    private function checkKategori(): int
    {
        $this->line('');
        $this->info('▶ ms_ba_kategori');

        if (!Schema::hasTable('ms_ba_kategori')) {
            $this->error('  ❌ Table ms_ba_kategori not found.');
            return 1;
        }

        $rows = DB::table('ms_ba_kategori')->orderBy('id')->get(['id', 'kode', 'nama', 'active']);
        $count = $rows->count();
        $this->line("  Found {$count} kategori.");

        $expectedCount = 14;
        if ($count !== $expectedCount) {
            $this->warn("  ⚠️  Expected {$expectedCount} kategori per docs/categories.md, found {$count}");
            return 1;
        }
        $this->line('  ✓ Count matches docs baseline (14).');

        return 0;
    }

    private function checkOpsi(): int
    {
        $this->line('');
        $this->info('▶ ms_ba_kategori_opsi (global, deskripsi UNIQUE)');

        if (!Schema::hasTable('ms_ba_kategori_opsi')) {
            $this->error('  ❌ Table ms_ba_kategori_opsi not found.');
            return 1;
        }

        $cols = Schema::getColumnListing('ms_ba_kategori_opsi');

        if (in_array('kategori_id', $cols, true)) {
            $this->warn('  ⚠️  Column `kategori_id` still exists on ms_ba_kategori_opsi.');
            $this->line('     Expected: opsi global with deskripsi UNIQUE (see ADR-006).');
            return 1;
        }

        if (!in_array('deskripsi', $cols, true)) {
            $this->error('  ❌ Column `deskripsi` not found.');
            return 1;
        }

        $count = DB::table('ms_ba_kategori_opsi')->count();
        $this->line("  Found {$count} opsi global. Columns: " . implode(', ', $cols));

        // Show opsi terisi per kategori (via junction)
        $perKategori = DB::table('ms_kategori_opsi_mapping as m')
            ->join('ms_ba_kategori as k', 'k.id', '=', 'm.kategori_id')
            ->select('k.id', 'k.kode', 'k.nama', DB::raw('count(m.id) as opsi_count'))
            ->groupBy('k.id', 'k.kode', 'k.nama')
            ->orderBy('k.id')
            ->get();

        $rows = [];
        for ($id = 1; $id <= 14; $id++) {
            $kat = DB::table('ms_ba_kategori')->where('id', $id)->first();
            $count = $perKategori->firstWhere('id', $id)->opsi_count ?? 0;
            $rows[] = [
                $id,
                $kat->kode ?? '?',
                $kat->nama ?? '?',
                $count > 0 ? "✅ {$count}" : '⏳ 0',
            ];
        }
        $this->table(['ID', 'Kode', 'Nama', 'Opsi'], $rows);

        return 0;
    }

    private function checkJunctionTables(): int
    {
        $this->line('');
        $this->info('▶ Junction tables (per ADR-006)');

        $expected = [
            'ms_konteks_kategori_mapping' => 'konteks × kategori (boolean per ADR-008, post migration 2026_05_25_120000)',
            'ms_kategori_opsi_mapping' => 'kategori × opsi (kode + sort_order)',
            'ms_opsi_konteks_mapping' => 'opsi × konteks (context-specific filter)',
        ];

        $drift = 0;
        foreach ($expected as $table => $purpose) {
            if (Schema::hasTable($table)) {
                $count = DB::table($table)->count();
                $this->line("  ✓ {$table} exists ({$count} rows) — {$purpose}");
            } else {
                $this->error("  ❌ {$table} MISSING — {$purpose}");
                $drift++;
            }
        }

        return $drift;
    }

    private function checkLegacyMigration(): int
    {
        $this->line('');
        $this->info('▶ Legacy migration check');

        $migrationFile = base_path('database/migrations/2026_05_19_200000_create_ba_kategori_system.php');

        if (!file_exists($migrationFile)) {
            $this->line('  Migration file not present — skip.');
            return 0;
        }

        $content = @file_get_contents($migrationFile);
        if ($content === false) {
            $this->line('  Could not read migration file — skip.');
            return 0;
        }

        if (str_contains($content, 'ms_business_unit') && !str_contains($content, 'ms_konteks')) {
            $this->warn('  ⚠️  database/migrations/2026_05_19_200000_create_ba_kategori_system.php still references `ms_business_unit`.');
            $this->line('     Actual DB uses `ms_konteks` (ADR-006). Consider archiving or rewriting this migration.');
            return 1;
        }

        $this->line('  ✓ Migration file alignment OK.');
        return 0;
    }
}
