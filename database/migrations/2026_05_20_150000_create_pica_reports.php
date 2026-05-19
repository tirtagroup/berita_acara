<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * PICA v2 — Structured Report (compiled).
 *
 * Architecture HYBRID:
 *   - Q&A working phase  → tr_pica_pertanyaan_d + tr_pica_jawaban (existing)
 *   - Compiled report    → tr_pica_reports + tr_pica_report_why + tr_pica_report_action
 *
 * Flow: setelah Q&A discussion cukup, PIC compile jawaban ke structured report (final dokumen).
 *
 * Sections:
 *   A. Identification (5W + 2H) — narrative per dimensi
 *   B. 4M+1E Analysis           — narrative per faktor (Man/Machine/Material/Method/Env)
 *   C. 5 Why                    — dynamic rows (tr_pica_report_why)
 *   D. Corrective Actions       — dynamic rows (tr_pica_report_action where tipe=corrective)
 *   E. Preventive Actions       — dynamic rows (tr_pica_report_action where tipe=preventive)
 *   F. Verification             — KPI, review, audit result
 *   G. Closure                  — approver, date, pelajaran, dokumentasi
 */
return new class extends Migration
{
    public function up()
    {
        // 1. Report header (1 row per PICA)
        Schema::create('tr_pica_reports', function (Blueprint $t) {
            $t->id();
            $t->string('tr_pica_main_code', 100)->unique();

            // Section A — Identification (5W + 2H)
            $t->text('section_a_what')->nullable();
            $t->text('section_a_when')->nullable();
            $t->text('section_a_where')->nullable();
            $t->text('section_a_who')->nullable();
            $t->text('section_a_why_awal')->nullable();
            $t->text('section_a_how')->nullable();
            $t->text('section_a_howmuch')->nullable();

            // Section B — 4M + 1E narasi
            $t->text('section_b_man')->nullable();
            $t->text('section_b_machine')->nullable();
            $t->text('section_b_material')->nullable();
            $t->text('section_b_method')->nullable();
            $t->text('section_b_environment')->nullable();

            // Section F — Verification
            $t->text('section_f_kpi')->nullable();
            $t->string('section_f_review_schedule', 255)->nullable();
            $t->text('section_f_audit_result')->nullable();

            // Section G — Closure
            $t->unsignedBigInteger('section_g_approver_id')->nullable();
            $t->date('section_g_closure_date')->nullable();
            $t->text('section_g_pelajaran')->nullable();
            $t->string('section_g_dokumentasi_path', 500)->nullable();

            // Meta
            $t->unsignedBigInteger('compiled_by')->nullable();
            $t->timestamp('compiled_at')->nullable();
            $t->timestamps();

            $t->index('tr_pica_main_code');
        });

        // 2. Section C — 5 Why dynamic rows
        Schema::create('tr_pica_report_why', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('report_id');
            $t->integer('urutan')->default(0); // Why level 1, 2, 3, ...
            $t->text('pertanyaan')->nullable(); // "Mengapa ...?"
            $t->text('jawaban')->nullable();    // "Karena ..."
            $t->timestamps();

            $t->foreign('report_id')->references('id')
              ->on('tr_pica_reports')->cascadeOnDelete();
            $t->index(['report_id', 'urutan']);
        });

        // 3. Section D + E — Action (corrective + preventive), beda kolom tipe
        Schema::create('tr_pica_report_action', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('report_id');
            $t->enum('tipe', ['corrective', 'preventive']);
            $t->text('deskripsi');
            $t->unsignedBigInteger('pic_user_id')->nullable();
            $t->date('deadline')->nullable();
            $t->enum('status', ['pending', 'in_progress', 'done', 'cancelled'])->default('pending');
            $t->date('completed_at')->nullable();
            $t->text('notes')->nullable();
            $t->integer('urutan')->default(0);
            $t->timestamps();

            $t->foreign('report_id')->references('id')
              ->on('tr_pica_reports')->cascadeOnDelete();
            $t->index(['report_id', 'tipe']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tr_pica_report_action');
        Schema::dropIfExists('tr_pica_report_why');
        Schema::dropIfExists('tr_pica_reports');
    }
};
