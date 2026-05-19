<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * PICA v2 — Fase 1: Master & pivot tables.
 *
 * Tidak ALTER tabel legacy (Tr_PICA_Emp_h, Tr_PICA_Pertanyaan).
 * Pakai logical FK ke tabel legacy (tidak DB-enforced).
 */
return new class extends Migration
{
    public function up()
    {
        // 1. Master kategori PICA
        Schema::create('ms_pica_kategori', function (Blueprint $t) {
            $t->id();
            $t->string('kode', 50)->unique();
            $t->string('nama', 100);
            $t->string('deskripsi', 255)->nullable();
            $t->boolean('active')->default(true);
            $t->timestamps();
        });

        // 2. Master pertanyaan PICA (library)
        Schema::create('ms_pica_pertanyaan_master', function (Blueprint $t) {
            $t->id();
            $t->string('kode', 50)->unique();
            $t->text('pertanyaan');
            $t->enum('tipe', ['pertanyaan', 'pernyataan'])->default('pertanyaan');
            $t->enum('scope', ['wajib_universal', 'bantuan'])->default('bantuan');
            $t->integer('urutan')->default(0);
            $t->boolean('active')->default(true);
            $t->timestamps();
        });

        // 3. Pivot PICA × Kategori
        Schema::create('tr_pica_kategori_d', function (Blueprint $t) {
            $t->id();
            $t->string('tr_pica_main_code', 100)->index();
            $t->unsignedBigInteger('kategori_id');
            $t->timestamps();

            $t->foreign('kategori_id')->references('id')->on('ms_pica_kategori')->cascadeOnDelete();
            $t->unique(['tr_pica_main_code', 'kategori_id'], 'uq_pica_kategori');
        });

        // 4. Participants PICA (pelaku/pic/dewan)
        Schema::create('tr_pica_participants', function (Blueprint $t) {
            $t->id();
            $t->string('tr_pica_main_code', 100)->index();
            $t->unsignedBigInteger('user_id'); // FK ke users.id (logical, not enforced)
            $t->enum('role', ['pelaku', 'pic', 'dewan']);
            $t->timestamps();

            $t->unique(['tr_pica_main_code', 'user_id', 'role'], 'uq_pica_user_role');
            $t->index(['tr_pica_main_code', 'role']);
        });

        // 5. Jawaban (Q&A forum thread)
        Schema::create('tr_pica_jawaban', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('pertanyaan_id')->index(); // FK ke Tr_PICA_Pertanyaan.id (logical)
            $t->unsignedBigInteger('user_id'); // FK ke users.id
            $t->text('jawaban')->nullable();
            $t->enum('ack_status', ['setuju', 'tidak_setuju'])->nullable(); // untuk tipe pernyataan
            $t->boolean('is_final')->default(false); // true = jawaban final dari pelaku
            $t->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tr_pica_jawaban');
        Schema::dropIfExists('tr_pica_participants');
        Schema::dropIfExists('tr_pica_kategori_d');
        Schema::dropIfExists('ms_pica_pertanyaan_master');
        Schema::dropIfExists('ms_pica_kategori');
    }
};
