<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Drop kolom `level` (ENUM: wajib/disarankan/opsional) dari
 * `ms_konteks_kategori_mapping`.
 *
 * Setelah migration ini, mapping konteks × kategori adalah BOOLEAN murni:
 *   - Row ada     = kategori muncul di konteks itu (available)
 *   - Row tidak ada = kategori tidak muncul (hidden)
 *
 * Konsekuensi yang harus di-handle terpisah (lihat ADR-008):
 *   - Behavior "auto-check Wajib" di form BA HILANG → semua kategori opsional.
 *   - Highlight "Disarankan" HILANG → tidak ada hint UX prioritas.
 *
 * Kode yang HARUS di-update bersamaan dengan migration ini:
 *   1. app/Models/KonteksKategoriMapping.php
 *        - Hapus 'level' dari $fillable
 *        - Hapus const LEVELS
 *   2. app/Http/Controllers/BeritaAcaraV2Controller.php
 *        - Hapus SELECT m.level + ORDER BY FIELD(m.level, ...)
 *        - Hapus computeDomain via $wajibByKategori (cari mapping konteks→FNB/LAKA)
 *   3. app/Http/Controllers/MasterKategoriController.php
 *        - Hapus 'allLevels' compact
 *        - Validation: tidak ada field 'level'
 *        - Logic upsert: just create row (no level), 'none' = delete
 *   4. resources/views/master/konteks_kategori_mapping/index.blade.php
 *        - Replace 3-radio dengan single checkbox
 *   5. resources/views/berita_acara_v2/wizard.blade.php
 *        - Hapus auto-check Wajib + lock logic
 *        - Hapus badge "Wajib"/"Disarankan"
 *
 * ADR-008: docs/decisions/008-drop-konteks-kategori-level.md
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ms_konteks_kategori_mapping', function (Blueprint $table) {
            $table->dropColumn('level');
        });
    }

    public function down(): void
    {
        // Revert: re-add ENUM kolom dengan default 'opsional'.
        // CATATAN: Data Wajib/Disarankan original akan HILANG — tidak bisa di-recover otomatis.
        // Semua mapping yang ada akan jadi 'opsional' setelah rollback.
        // Backup `ms_konteks_kategori_mapping` sebelum migrate kalau perlu rollback exact data.
        Schema::table('ms_konteks_kategori_mapping', function (Blueprint $table) {
            $table->enum('level', ['wajib', 'disarankan', 'opsional'])
                  ->default('opsional')
                  ->after('kategori_id');
        });
    }
};
