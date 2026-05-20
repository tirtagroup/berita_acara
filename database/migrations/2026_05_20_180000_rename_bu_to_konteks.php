<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Rename "Business Unit" terminologi → "Konteks" di seluruh schema.
 *
 * Rename:
 *   - Table  ms_business_unit          → ms_konteks
 *   - Table  ms_bu_kategori_mapping    → ms_konteks_kategori_mapping
 *   - Table  ms_opsi_bu_mapping        → ms_opsi_konteks_mapping
 *   - Column bu_id (di mapping tables) → konteks_id
 *   - Column bu_kode (di Tr_PICA_Emp_h)→ konteks_kode
 *
 * Karena ada FK constraint, urutan:
 *   1. Drop FK yang reference ms_business_unit
 *   2. Rename column bu_id → konteks_id di mapping tables
 *   3. Rename column bu_kode → konteks_kode di Tr_PICA_Emp_h
 *   4. Rename ms_business_unit → ms_konteks
 *   5. Rename mapping tables
 *   6. Re-add FK dengan referensi baru
 *   7. Update unique index name
 */
return new class extends Migration
{
    public function up()
    {
        // 1. Drop FK constraints yang reference ms_business_unit + drop unique index
        Schema::table('ms_bu_kategori_mapping', function (Blueprint $t) {
            $t->dropForeign(['bu_id']);
            $t->dropForeign(['kategori_id']);
            // Drop unique constraint (named auto)
            try { $t->dropUnique(['bu_id', 'kategori_id']); } catch (\Throwable $e) {}
        });
        Schema::table('ms_opsi_bu_mapping', function (Blueprint $t) {
            $t->dropForeign(['bu_id']);
            $t->dropForeign(['opsi_id']);
            try { $t->dropUnique('uq_opsi_bu'); } catch (\Throwable $e) {}
        });

        // 2. Rename column bu_id → konteks_id di mapping tables
        Schema::table('ms_bu_kategori_mapping', function (Blueprint $t) {
            $t->renameColumn('bu_id', 'konteks_id');
        });
        Schema::table('ms_opsi_bu_mapping', function (Blueprint $t) {
            $t->renameColumn('bu_id', 'konteks_id');
        });

        // 3. Rename column bu_kode → konteks_kode di Tr_PICA_Emp_h (hanya bila ada)
        if (Schema::hasColumn('Tr_PICA_Emp_h', 'bu_kode')) {
            // Drop index dulu (kita bikin di migration sebelumnya)
            Schema::table('Tr_PICA_Emp_h', function (Blueprint $t) {
                try { $t->dropIndex(['bu_kode']); } catch (\Throwable $e) {}
            });
            Schema::table('Tr_PICA_Emp_h', function (Blueprint $t) {
                $t->renameColumn('bu_kode', 'konteks_kode');
            });
            Schema::table('Tr_PICA_Emp_h', function (Blueprint $t) {
                $t->index('konteks_kode');
            });
        }

        // 4. Rename master table ms_business_unit → ms_konteks
        Schema::rename('ms_business_unit', 'ms_konteks');

        // 5. Rename mapping tables
        Schema::rename('ms_bu_kategori_mapping',  'ms_konteks_kategori_mapping');
        Schema::rename('ms_opsi_bu_mapping',      'ms_opsi_konteks_mapping');

        // 6. Re-add FK constraints dgn referensi baru
        Schema::table('ms_konteks_kategori_mapping', function (Blueprint $t) {
            $t->foreign('konteks_id')->references('id')->on('ms_konteks')->cascadeOnDelete();
            $t->foreign('kategori_id')->references('id')->on('ms_ba_kategori')->cascadeOnDelete();
            $t->unique(['konteks_id', 'kategori_id'], 'uq_konteks_kategori');
        });
        Schema::table('ms_opsi_konteks_mapping', function (Blueprint $t) {
            $t->foreign('konteks_id')->references('id')->on('ms_konteks')->cascadeOnDelete();
            $t->foreign('opsi_id')->references('id')->on('ms_ba_kategori_opsi')->cascadeOnDelete();
            $t->unique(['opsi_id', 'konteks_id'], 'uq_opsi_konteks');
        });
    }

    public function down()
    {
        // Reverse: rename back.
        Schema::table('ms_konteks_kategori_mapping', function (Blueprint $t) {
            $t->dropForeign(['konteks_id']);
            $t->dropForeign(['kategori_id']);
            try { $t->dropUnique('uq_konteks_kategori'); } catch (\Throwable $e) {}
        });
        Schema::table('ms_opsi_konteks_mapping', function (Blueprint $t) {
            $t->dropForeign(['konteks_id']);
            $t->dropForeign(['opsi_id']);
            try { $t->dropUnique('uq_opsi_konteks'); } catch (\Throwable $e) {}
        });

        Schema::table('ms_konteks_kategori_mapping', function (Blueprint $t) {
            $t->renameColumn('konteks_id', 'bu_id');
        });
        Schema::table('ms_opsi_konteks_mapping', function (Blueprint $t) {
            $t->renameColumn('konteks_id', 'bu_id');
        });

        if (Schema::hasColumn('Tr_PICA_Emp_h', 'konteks_kode')) {
            Schema::table('Tr_PICA_Emp_h', function (Blueprint $t) {
                try { $t->dropIndex(['konteks_kode']); } catch (\Throwable $e) {}
            });
            Schema::table('Tr_PICA_Emp_h', function (Blueprint $t) {
                $t->renameColumn('konteks_kode', 'bu_kode');
            });
            Schema::table('Tr_PICA_Emp_h', function (Blueprint $t) {
                $t->index('bu_kode');
            });
        }

        Schema::rename('ms_konteks',                       'ms_business_unit');
        Schema::rename('ms_konteks_kategori_mapping',      'ms_bu_kategori_mapping');
        Schema::rename('ms_opsi_konteks_mapping',          'ms_opsi_bu_mapping');

        Schema::table('ms_bu_kategori_mapping', function (Blueprint $t) {
            $t->foreign('bu_id')->references('id')->on('ms_business_unit')->cascadeOnDelete();
            $t->foreign('kategori_id')->references('id')->on('ms_ba_kategori')->cascadeOnDelete();
            $t->unique(['bu_id', 'kategori_id']);
        });
        Schema::table('ms_opsi_bu_mapping', function (Blueprint $t) {
            $t->foreign('bu_id')->references('id')->on('ms_business_unit')->cascadeOnDelete();
            $t->foreign('opsi_id')->references('id')->on('ms_ba_kategori_opsi')->cascadeOnDelete();
            $t->unique(['opsi_id', 'bu_id'], 'uq_opsi_bu');
        });
    }
};
