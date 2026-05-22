<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * PICA v3 — split workflow jadi 2 fase:
 *   PREPARING (persiapan agenda + pertanyaan)
 *   → MEETING (dokumentasi saat meeting berlangsung)
 *
 * Tambah kolom dokumentasi inline di Tr_PICA_Emp_h:
 *   - agenda_pembahasan       : markdown bullet (PIC siapkan di PREPARING)
 *   - meeting_started_at      : timestamp PIC trigger Mulai Meeting
 *   - hasil_meeting_pic       : catatan moderator (PIC saat MEETING)
 *   - catatan_pelaku          : catatan independen pelaku
 *   - pernyataan_pelaku       : statement formal pelaku
 *   - pernyataan_signed_at    : timestamp tandatangan
 *   - pernyataan_signed_by    : username yg sign
 *   - meeting_ended_at        : timestamp PIC trigger Selesai Meeting
 *
 * Migrasi data: Status_PICA='WAITING_PELAKU' (kalau ada) → 'MEETING'.
 */
return new class extends Migration
{
    public function up()
    {
        Schema::table('Tr_PICA_Emp_h', function (Blueprint $t) {
            if (!Schema::hasColumn('Tr_PICA_Emp_h', 'agenda_pembahasan')) {
                $t->text('agenda_pembahasan')->nullable()->after('Problem_Note');
            }
            if (!Schema::hasColumn('Tr_PICA_Emp_h', 'meeting_started_at')) {
                $t->timestamp('meeting_started_at')->nullable()->after('agenda_pembahasan');
            }
            if (!Schema::hasColumn('Tr_PICA_Emp_h', 'hasil_meeting_pic')) {
                $t->text('hasil_meeting_pic')->nullable()->after('meeting_started_at');
            }
            if (!Schema::hasColumn('Tr_PICA_Emp_h', 'catatan_pelaku')) {
                $t->text('catatan_pelaku')->nullable()->after('hasil_meeting_pic');
            }
            if (!Schema::hasColumn('Tr_PICA_Emp_h', 'pernyataan_pelaku')) {
                $t->text('pernyataan_pelaku')->nullable()->after('catatan_pelaku');
            }
            if (!Schema::hasColumn('Tr_PICA_Emp_h', 'pernyataan_signed_at')) {
                $t->timestamp('pernyataan_signed_at')->nullable()->after('pernyataan_pelaku');
            }
            if (!Schema::hasColumn('Tr_PICA_Emp_h', 'pernyataan_signed_by')) {
                $t->string('pernyataan_signed_by', 100)->nullable()->after('pernyataan_signed_at');
            }
            if (!Schema::hasColumn('Tr_PICA_Emp_h', 'meeting_ended_at')) {
                $t->timestamp('meeting_ended_at')->nullable()->after('pernyataan_signed_by');
            }
        });

        // Data migration: WAITING_PELAKU → MEETING
        DB::table('Tr_PICA_Emp_h')
            ->where('Status_PICA', 'WAITING_PELAKU')
            ->update(['Status_PICA' => 'MEETING', 'updated_at' => now()]);
    }

    public function down()
    {
        // Reverse data migration
        DB::table('Tr_PICA_Emp_h')
            ->where('Status_PICA', 'MEETING')
            ->update(['Status_PICA' => 'WAITING_PELAKU', 'updated_at' => now()]);

        Schema::table('Tr_PICA_Emp_h', function (Blueprint $t) {
            foreach ([
                'agenda_pembahasan','meeting_started_at','hasil_meeting_pic',
                'catatan_pelaku','pernyataan_pelaku','pernyataan_signed_at',
                'pernyataan_signed_by','meeting_ended_at',
            ] as $col) {
                if (Schema::hasColumn('Tr_PICA_Emp_h', $col)) {
                    $t->dropColumn($col);
                }
            }
        });
    }
};
