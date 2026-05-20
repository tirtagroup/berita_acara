<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah kolom edit_allowed ke Tr_Ba_Main_New.
 *
 * Aturan akses edit BA v2:
 *   - User role 'admin' / 'super_admin' SELALU bisa edit.
 *   - Creator (Rec_UserCreated) bisa edit BILA edit_allowed = TRUE.
 *   - Admin toggle edit_allowed via tombol di show page.
 */
return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('Tr_Ba_Main_New', 'edit_allowed')) {
            Schema::table('Tr_Ba_Main_New', function (Blueprint $t) {
                $t->boolean('edit_allowed')->default(false)->after('Rec_UserCreated');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('Tr_Ba_Main_New', 'edit_allowed')) {
            Schema::table('Tr_Ba_Main_New', function (Blueprint $t) {
                $t->dropColumn('edit_allowed');
            });
        }
    }
};
