<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Add bu_kode kolom ke Tr_PICA_Emp_h untuk dukung dashboard PICA v2 slice per BU/konteks
 * (LAKA/FNB/OP_HR/REVISI). Wizard PICA v2 sudah collect bu_kode di step 1 tapi belum disimpan.
 *
 * Tidak ada FK constraint ke ms_business_unit (kolom legacy, nullable). Aplikasi yang validate.
 */
return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('Tr_PICA_Emp_h', 'bu_kode')) {
            Schema::table('Tr_PICA_Emp_h', function (Blueprint $t) {
                $t->string('bu_kode', 20)->nullable()->after('NoBA');
                $t->index('bu_kode');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('Tr_PICA_Emp_h', 'bu_kode')) {
            Schema::table('Tr_PICA_Emp_h', function (Blueprint $t) {
                $t->dropIndex(['bu_kode']);
                $t->dropColumn('bu_kode');
            });
        }
    }
};
