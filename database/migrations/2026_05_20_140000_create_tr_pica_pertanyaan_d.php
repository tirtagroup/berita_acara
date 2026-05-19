<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * PICA v2 — Tabel transactional pertanyaan per-PICA.
 *
 * Parallel dengan legacy `Tr_PICA_Pertanyaan` (yang punya schema minimal).
 *
 * Source pertanyaan:
 *   - Linked dari ms_pica_pertanyaan_master (pertanyaan_master_id NOT NULL)
 *   - Bebas / ad-hoc (pertanyaan_master_id NULL)
 *
 * Per item, PIC bisa toggle `wajib_jawab` (apakah pelaku wajib jawab).
 *
 * Plus tambah FK proper di tr_pica_jawaban.pertanyaan_id → tr_pica_pertanyaan_d.id
 */
return new class extends Migration
{
    public function up()
    {
        Schema::create('tr_pica_pertanyaan_d', function (Blueprint $t) {
            $t->id();
            $t->string('tr_pica_main_code', 100)->index();
            $t->unsignedBigInteger('pertanyaan_master_id')->nullable()
              ->comment('FK ke ms_pica_pertanyaan_master; NULL bila pertanyaan bebas');
            $t->text('pertanyaan')->comment('Salinan dari master atau custom bebas');
            $t->enum('tipe', ['pertanyaan', 'pernyataan'])->default('pertanyaan');
            $t->boolean('wajib_jawab')->default(false)
              ->comment('TRUE = pelaku wajib jawab sebelum PICA close');
            $t->integer('urutan')->default(0);
            $t->unsignedBigInteger('created_by')->nullable()->comment('user_id yang tambah');
            $t->timestamps();

            $t->foreign('pertanyaan_master_id')->references('id')
              ->on('ms_pica_pertanyaan_master')->nullOnDelete();
            $t->index(['tr_pica_main_code', 'urutan']);
        });

        // Add FK constraint pada tr_pica_jawaban.pertanyaan_id
        // (existing column unsignedBigInteger, sekarang point ke new tabel)
        Schema::table('tr_pica_jawaban', function (Blueprint $t) {
            $t->foreign('pertanyaan_id')->references('id')
              ->on('tr_pica_pertanyaan_d')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::table('tr_pica_jawaban', function (Blueprint $t) {
            $t->dropForeign(['pertanyaan_id']);
        });
        Schema::dropIfExists('tr_pica_pertanyaan_d');
    }
};
