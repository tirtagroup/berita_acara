<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah kolom temuan dan rekomendasi ke Tr_Ba_Main_New.
 */
return new class extends Migration
{
    public function up()
    {
        Schema::table('Tr_Ba_Main_New', function (Blueprint $table) {
            if (!Schema::hasColumn('Tr_Ba_Main_New', 'ba_temuan')) {
                $table->text('ba_temuan')->nullable()->after('BA_Desc')->comment('Findings / issues yang ditemukan');
            }
            if (!Schema::hasColumn('Tr_Ba_Main_New', 'ba_rekomendasi')) {
                $table->text('ba_rekomendasi')->nullable()->after('ba_temuan')->comment('Recommendations / follow-up actions');
            }
        });
    }

    public function down()
    {
        Schema::table('Tr_Ba_Main_New', function (Blueprint $table) {
            if (Schema::hasColumn('Tr_Ba_Main_New', 'ba_temuan')) {
                $table->dropColumn('ba_temuan');
            }
            if (Schema::hasColumn('Tr_Ba_Main_New', 'ba_rekomendasi')) {
                $table->dropColumn('ba_rekomendasi');
            }
        });
    }
};
