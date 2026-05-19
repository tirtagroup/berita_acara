<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Tambah konteks REVISI ke ms_business_unit + mapping wajib ke KESALAHAN_ADMIN.
 *
 * Konteks REVISI = BA jenis "Permintaan Revisi" yang berdiri sendiri
 * (standalone — bukan tindak lanjut BA induk).
 */
return new class extends Migration
{
    public function up()
    {
        $now = now();

        // 1. Insert BU REVISI
        $revisiId = DB::table('ms_business_unit')->insertGetId([
            'kode'       => 'REVISI',
            'nama'       => 'Permintaan Revisi',
            'deskripsi'  => 'BA untuk permintaan revisi data/dokumen (standalone)',
            'active'     => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 2. Map REVISI × KESALAHAN_ADMIN dengan level wajib
        $kategoriId = DB::table('ms_ba_kategori')->where('kode', 'KESALAHAN_ADMIN')->value('id');
        if ($kategoriId) {
            DB::table('ms_bu_kategori_mapping')->insert([
                'bu_id'       => $revisiId,
                'kategori_id' => $kategoriId,
                'level'       => 'wajib',
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }
    }

    public function down()
    {
        $revisiId = DB::table('ms_business_unit')->where('kode', 'REVISI')->value('id');
        if ($revisiId) {
            DB::table('ms_bu_kategori_mapping')->where('bu_id', $revisiId)->delete();
            DB::table('ms_business_unit')->where('id', $revisiId)->delete();
        }
    }
};
