<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah indexes untuk speed up dashboard filter queries.
 *
 * tr_ba_kategori_d.kategori_id & opsi_id sudah punya FK indexes dari migration revert.
 * Tr_Ba_Main_New.Ms_BA_type_Code (konteks legacy) belum ada index — paling sering dipakai
 * di filter dashboard/list (where Ms_BA_type_Code = 'LAKA', dll).
 */
return new class extends Migration
{
    public function up()
    {
        Schema::table('Tr_Ba_Main_New', function (Blueprint $t) {
            $t->index('Ms_BA_type_Code', 'idx_ba_konteks');
        });
    }

    public function down()
    {
        Schema::table('Tr_Ba_Main_New', function (Blueprint $t) {
            try { $t->dropIndex('idx_ba_konteks'); } catch (\Throwable $e) {}
        });
    }
};
