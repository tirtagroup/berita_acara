<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * ms_cek_flag_mapping — pemetaan flag legacy Tr_Ba_Main_New.Cek*
 * ke kategori v2 (+ opsional opsi_kode) untuk artisan migrate.
 *
 * Diisi default mapping + bisa di-tweak via admin UI sebelum dieksekusi.
 */
return new class extends Migration
{
    public function up()
    {
        Schema::create('ms_cek_flag_mapping', function (Blueprint $t) {
            $t->id();
            $t->string('legacy_flag', 50)->unique()->comment('mis. CekPelanggaran, CekLaka, dst');
            $t->string('kategori_kode', 50)->comment('FK lookup ke ms_ba_kategori.kode');
            $t->string('opsi_kode', 50)->nullable()->comment('Optional opsi kode dlm ms_kategori_opsi_mapping.kode');
            $t->boolean('active')->default(true);
            $t->text('notes')->nullable()->comment('Catatan untuk admin (kenapa mapping ini)');
            $t->timestamps();

            $t->index('kategori_kode');
        });

        // Seed default mapping
        $now = now();
        $rows = [
            // [legacy_flag, kategori_kode, notes]
            ['CekPelanggaran',   'PELANGGARAN_SOP',     'Pelanggaran SOP umum.'],
            ['CekKerusakan',     'KERUSAKAN_KEHILANGAN','Kerusakan aset/alat.'],
            ['CekFraud',         'FRAUD',               'Tindakan fraud / kecurangan.'],
            ['CekRevisi',        'KESALAHAN_ADMIN',     'Revisi data administratif.'],
            ['CekDisiplin',      'INDISIPLINER_ETIKA',  'Pelanggaran disiplin / etika.'],
            ['CekSalahIsi',      'KESALAHAN_ADMIN',     'Salah isi data — admin error.'],
            ['CekNoClosing',     'KESALAHAN_ADMIN',     'Tidak closing transaksi — admin error.'],
            ['CekLaka',          'LAKA_PENYEBAB',       'Kecelakaan kerja / laka lalin.'],
            ['CekPembelian',     'LOGISTIK',            'Pembelian (logistik).'],
            ['CekKehilangan',    'KERUSAKAN_KEHILANGAN','Kehilangan aset.'],
            ['CekPerubahanSOP',  'PELANGGARAN_SOP',     'Perubahan SOP — review SOP.'],
        ];

        $insertRows = [];
        foreach ($rows as [$flag, $kategoriKode, $notes]) {
            $insertRows[] = [
                'legacy_flag'   => $flag,
                'kategori_kode' => $kategoriKode,
                'opsi_kode'     => null,
                'active'        => true,
                'notes'         => $notes,
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        }
        DB::table('ms_cek_flag_mapping')->insert($insertRows);
    }

    public function down()
    {
        Schema::dropIfExists('ms_cek_flag_mapping');
    }
};
