<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Tag BU langsung ke opsi (direct relation).
 *
 * Schema:
 *   ms_opsi_bu_mapping (id, opsi_id FK, bu_id FK, timestamps)
 *   UNIQUE(opsi_id, bu_id)
 *
 * Backfill: untuk tiap opsi existing, salin BU dari kategori parent-nya
 * (union dari semua kategori yang attach ke opsi tersebut).
 *
 * Tujuan: filter opsi di wizard berdasarkan BU yang dipilih.
 */
return new class extends Migration
{
    public function up()
    {
        Schema::create('ms_opsi_bu_mapping', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('opsi_id');
            $table->unsignedBigInteger('bu_id');
            $table->timestamps();

            $table->foreign('opsi_id')->references('id')->on('ms_ba_kategori_opsi')->cascadeOnDelete();
            $table->foreign('bu_id')->references('id')->on('ms_business_unit')->cascadeOnDelete();
            $table->unique(['opsi_id', 'bu_id'], 'uq_opsi_bu');
        });

        // Backfill: untuk tiap opsi, ambil BU dari kategori parent-nya
        $now = now();
        $pairs = DB::table('ms_kategori_opsi_mapping as ko')
                    ->join('ms_bu_kategori_mapping as bk', 'ko.kategori_id', '=', 'bk.kategori_id')
                    ->select('ko.opsi_id', 'bk.bu_id')
                    ->distinct()
                    ->get();

        $rows = $pairs->map(fn($p) => [
            'opsi_id'    => $p->opsi_id,
            'bu_id'      => $p->bu_id,
            'created_at' => $now,
            'updated_at' => $now,
        ])->all();

        if (!empty($rows)) {
            DB::table('ms_opsi_bu_mapping')->insert($rows);
        }
    }

    public function down()
    {
        Schema::dropIfExists('ms_opsi_bu_mapping');
    }
};
