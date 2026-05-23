<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * PICA v4 status rename + kolom DONE:
 *   - Status: ACTION_PLANNING → FINALIZED, CLOSED → DONE
 *   - Kolom baru: done_at + done_by (kapan & siapa PIC set DONE)
 *
 * Workflow final: PREPARING (PICA Plan) → MEETING → FINALIZED → DONE
 *
 * Migrasi data: kalau ada row Status_PICA = 'ACTION_PLANNING'|'CLOSED' (di DB lain),
 * di-update ke nama baru. Saat migration ini dijalankan, 0 row dengan status itu.
 */
return new class extends Migration
{
    public function up()
    {
        Schema::table('Tr_PICA_Emp_h', function (Blueprint $t) {
            if (!Schema::hasColumn('Tr_PICA_Emp_h', 'done_at')) {
                $t->timestamp('done_at')->nullable()->after('meeting_ended_at');
            }
            if (!Schema::hasColumn('Tr_PICA_Emp_h', 'done_by')) {
                $t->string('done_by', 100)->nullable()->after('done_at');
            }
        });

        // Rename existing status values (best-effort — kalau ada data)
        DB::table('Tr_PICA_Emp_h')->where('Status_PICA', 'ACTION_PLANNING')
            ->update(['Status_PICA' => 'FINALIZED', 'updated_at' => now()]);
        DB::table('Tr_PICA_Emp_h')->where('Status_PICA', 'CLOSED')
            ->update(['Status_PICA' => 'DONE', 'updated_at' => now()]);
    }

    public function down()
    {
        DB::table('Tr_PICA_Emp_h')->where('Status_PICA', 'FINALIZED')
            ->update(['Status_PICA' => 'ACTION_PLANNING', 'updated_at' => now()]);
        DB::table('Tr_PICA_Emp_h')->where('Status_PICA', 'DONE')
            ->update(['Status_PICA' => 'CLOSED', 'updated_at' => now()]);

        Schema::table('Tr_PICA_Emp_h', function (Blueprint $t) {
            foreach (['done_at', 'done_by'] as $col) {
                if (Schema::hasColumn('Tr_PICA_Emp_h', $col)) {
                    $t->dropColumn($col);
                }
            }
        });
    }
};
