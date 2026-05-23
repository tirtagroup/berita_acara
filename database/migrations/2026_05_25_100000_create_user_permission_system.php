<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * User Permission System — 4 tabel + seed default.
 *
 * Konsep:
 *   ms_user_level                  → tier user (SUPER_ADMIN, ADMIN, KOORDINATOR, USER)
 *   ms_panel                       → panel/module aplikasi (BA_LIST, MASTER_KONTEKS, dll)
 *   ms_action                      → action yang bisa dilakukan (view, create, edit, delete, approve...)
 *   ms_user_level_panel_action     → pivot 3-way + SCOPE (all/own/participant/none)
 *
 * Tidak dipakai untuk enforcement YET — table only. Enforcement nanti via middleware.
 *
 * Untuk lookup permission: hubungkan users.level_id (kolom baru, nullable)
 * ke ms_user_level. Fallback: pakai users.role text matching kalau level_id NULL.
 */
return new class extends Migration
{
    public function up()
    {
        // 1. Level tier
        Schema::create('ms_user_level', function (Blueprint $t) {
            $t->id();
            $t->string('kode', 50)->unique();
            $t->string('nama', 100);
            $t->text('deskripsi')->nullable();
            $t->boolean('is_super')->default(false)->comment('Bypass semua permission check');
            $t->integer('urutan')->default(0);
            $t->boolean('active')->default(true);
            $t->timestamps();
        });

        // 2. Panel/module aplikasi
        Schema::create('ms_panel', function (Blueprint $t) {
            $t->id();
            $t->string('kode', 50)->unique();
            $t->string('nama', 100);
            $t->unsignedBigInteger('parent_id')->nullable();
            $t->enum('modul', ['BA', 'PICA', 'MASTER', 'HELP', 'UMUM'])->default('UMUM');
            $t->string('url', 255)->nullable();
            $t->string('icon', 50)->nullable();
            $t->integer('urutan')->default(0);
            $t->boolean('scopable')->default(false)->comment('Panel ini punya row-level scope?');
            $t->json('supported_scopes')->nullable()->comment('JSON array: [all,own,participant,division]');
            $t->boolean('active')->default(true);
            $t->timestamps();

            $t->foreign('parent_id')->references('id')->on('ms_panel')->nullOnDelete();
            $t->index(['modul', 'urutan']);
        });

        // 3. Action master
        Schema::create('ms_action', function (Blueprint $t) {
            $t->id();
            $t->string('kode', 30)->unique();
            $t->string('nama', 100);
            $t->text('deskripsi')->nullable();
            $t->integer('urutan')->default(0);
            $t->boolean('active')->default(true);
            $t->timestamps();
        });

        // 4. Pivot 3-way: level × panel × action + scope
        Schema::create('ms_user_level_panel_action', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('level_id');
            $t->unsignedBigInteger('panel_id');
            $t->unsignedBigInteger('action_id');
            $t->enum('scope', ['all', 'own', 'participant', 'division', 'none'])->default('all')
              ->comment('Row-level filter: all/own/participant/division/none');
            $t->boolean('active')->default(true);
            $t->timestamps();

            $t->foreign('level_id')->references('id')->on('ms_user_level')->cascadeOnDelete();
            $t->foreign('panel_id')->references('id')->on('ms_panel')->cascadeOnDelete();
            $t->foreign('action_id')->references('id')->on('ms_action')->cascadeOnDelete();
            $t->unique(['level_id', 'panel_id', 'action_id'], 'uq_level_panel_action');
        });

        // 5. Extend users dengan level_id (nullable — fallback ke users.role text matching)
        if (!Schema::hasColumn('users', 'level_id')) {
            Schema::table('users', function (Blueprint $t) {
                $t->unsignedBigInteger('level_id')->nullable()->after('role');
                $t->index('level_id');
            });
        }

        // =====================
        // SEED DATA
        // =====================
        $now = now();

        // -- 4 Levels --
        $levels = [
            ['kode' => 'SUPER_ADMIN',  'nama' => 'Super Administrator', 'is_super' => true,  'urutan' => 1, 'deskripsi' => 'Bypass semua permission check. Hanya untuk owner/IT root.'],
            ['kode' => 'ADMIN',        'nama' => 'Administrator',       'is_super' => false, 'urutan' => 2, 'deskripsi' => 'Full access ke master + BA + PICA + edit lain.'],
            ['kode' => 'KOORDINATOR',  'nama' => 'Koordinator',         'is_super' => false, 'urutan' => 3, 'deskripsi' => 'Review BA + PICA. Read-only master. Bisa edit data sendiri.'],
            ['kode' => 'USER',         'nama' => 'User',                'is_super' => false, 'urutan' => 4, 'deskripsi' => 'User reguler. Hanya lihat BA/PICA sendiri (own scope).'],
        ];
        foreach ($levels as $i => $l) {
            DB::table('ms_user_level')->insert(array_merge($l, [
                'active' => true, 'created_at' => $now, 'updated_at' => $now,
            ]));
        }
        $levelIds = DB::table('ms_user_level')->pluck('id', 'kode')->all();

        // -- 8 Actions --
        $actions = [
            ['kode' => 'view',    'nama' => 'View',    'deskripsi' => 'Lihat data (list/detail)', 'urutan' => 1],
            ['kode' => 'create',  'nama' => 'Create',  'deskripsi' => 'Buat row baru',            'urutan' => 2],
            ['kode' => 'edit',    'nama' => 'Edit',    'deskripsi' => 'Edit data existing',       'urutan' => 3],
            ['kode' => 'delete',  'nama' => 'Delete',  'deskripsi' => 'Hapus data',               'urutan' => 4],
            ['kode' => 'approve', 'nama' => 'Approve', 'deskripsi' => 'Approve/validate workflow', 'urutan' => 5],
            ['kode' => 'sign',    'nama' => 'Sign',    'deskripsi' => 'Tanda tangan formal (pernyataan, dll)', 'urutan' => 6],
            ['kode' => 'close',   'nama' => 'Close',   'deskripsi' => 'Tutup/finalize workflow',  'urutan' => 7],
            ['kode' => 'export',  'nama' => 'Export',  'deskripsi' => 'Export data (PDF/Excel)',  'urutan' => 8],
        ];
        foreach ($actions as $a) {
            DB::table('ms_action')->insert(array_merge($a, [
                'active' => true, 'created_at' => $now, 'updated_at' => $now,
            ]));
        }
        $actionIds = DB::table('ms_action')->pluck('id', 'kode')->all();

        // -- ~20 Panels --
        $panels = [
            // BA module (scopable)
            ['kode' => 'BA_DASHBOARD', 'nama' => 'BA Dashboard',        'modul' => 'BA', 'url' => '/beritaacara/v2/dashboard', 'icon' => 'bx-bar-chart-square', 'scopable' => true, 'urutan' => 10],
            ['kode' => 'BA_LIST',      'nama' => 'BA List',             'modul' => 'BA', 'url' => '/beritaacara/v2/list',      'icon' => 'bx-list-ul',          'scopable' => true, 'urutan' => 11],
            ['kode' => 'BA_CREATE',    'nama' => 'Buat BA Baru',        'modul' => 'BA', 'url' => '/beritaacara/v2/create',    'icon' => 'bx-edit',             'scopable' => false, 'urutan' => 12],
            ['kode' => 'BA_VIEW',      'nama' => 'Detail BA',           'modul' => 'BA', 'url' => '/beritaacara/v2/show',      'icon' => 'bx-show',             'scopable' => true, 'urutan' => 13],
            ['kode' => 'BA_EDIT',      'nama' => 'Edit BA',             'modul' => 'BA', 'url' => '/beritaacara/v2/edit',      'icon' => 'bx-edit-alt',         'scopable' => true, 'urutan' => 14],
            // PICA module (scopable)
            ['kode' => 'PICA_DASHBOARD', 'nama' => 'PICA Dashboard',    'modul' => 'PICA', 'url' => '/pica/v2/dashboard',      'icon' => 'bx-bar-chart-square', 'scopable' => true, 'urutan' => 20],
            ['kode' => 'PICA_LIST',      'nama' => 'PICA List',         'modul' => 'PICA', 'url' => '/pica/v2/list',           'icon' => 'bx-list-ul',          'scopable' => true, 'urutan' => 21],
            ['kode' => 'PICA_CREATE',    'nama' => 'Buat PICA Baru',    'modul' => 'PICA', 'url' => '/pica/v2/create',         'icon' => 'bx-list-plus',        'scopable' => false, 'urutan' => 22],
            ['kode' => 'PICA_DISCUSS',   'nama' => 'PICA Discussion',   'modul' => 'PICA', 'url' => '/pica/v2/discussion',     'icon' => 'bx-conversation',     'scopable' => true, 'urutan' => 23],
            ['kode' => 'PICA_REPORT',    'nama' => 'PICA Report',       'modul' => 'PICA', 'url' => '/pica/v2/report',         'icon' => 'bx-file',             'scopable' => true, 'urutan' => 24],
            // MASTER (non-scopable: all-or-nothing)
            ['kode' => 'MASTER_KONTEKS',  'nama' => 'Master Konteks',          'modul' => 'MASTER', 'url' => '/master/konteks',                  'icon' => 'bx-category',  'scopable' => false, 'urutan' => 30],
            ['kode' => 'MASTER_KATEGORI', 'nama' => 'Master Kategori BA',      'modul' => 'MASTER', 'url' => '/master/kategori',                 'icon' => 'bx-tag',       'scopable' => false, 'urutan' => 31],
            ['kode' => 'MASTER_OPSI',     'nama' => 'Master Opsi Global',      'modul' => 'MASTER', 'url' => '/master/opsi',                     'icon' => 'bx-list-check','scopable' => false, 'urutan' => 32],
            ['kode' => 'MASTER_MAPPING',  'nama' => 'Konteks × Kategori Map',  'modul' => 'MASTER', 'url' => '/master/konteks-mapping',          'icon' => 'bx-grid-alt',  'scopable' => false, 'urutan' => 33],
            ['kode' => 'MASTER_OPSI_MAP', 'nama' => 'Opsi × Konteks Map',      'modul' => 'MASTER', 'url' => '/master/opsi-konteks-mapping',     'icon' => 'bx-grid-alt',  'scopable' => false, 'urutan' => 34],
            ['kode' => 'MASTER_CEK',      'nama' => 'Cek Flag Mapping',        'modul' => 'MASTER', 'url' => '/master/cek-mapping',              'icon' => 'bx-transfer',  'scopable' => false, 'urutan' => 35],
            ['kode' => 'MASTER_DOC',      'nama' => 'Doc Workflow (Help)',     'modul' => 'MASTER', 'url' => '/master/doc-workflow',             'icon' => 'bx-book',      'scopable' => false, 'urutan' => 36],
            ['kode' => 'MASTER_PICA',     'nama' => 'Master PICA',             'modul' => 'MASTER', 'url' => '/master/pica/kategori',            'icon' => 'bx-list-ul',   'scopable' => false, 'urutan' => 37],
            ['kode' => 'MASTER_PERM',     'nama' => 'User Permission',         'modul' => 'MASTER', 'url' => '/master/permission-matrix',        'icon' => 'bx-shield-quarter','scopable' => false, 'urutan' => 38],
            // HELP
            ['kode' => 'HELP_VIEW',       'nama' => 'Help Center',             'modul' => 'HELP',   'url' => '/help',                            'icon' => 'bx-help-circle','scopable' => false, 'urutan' => 50],
        ];
        foreach ($panels as $p) {
            // Set supported_scopes berdasarkan modul + scopable
            $supportedScopes = null;
            if (!empty($p['scopable'])) {
                if ($p['modul'] === 'BA') {
                    $supportedScopes = json_encode(['all', 'own', 'division']);
                } elseif ($p['modul'] === 'PICA') {
                    $supportedScopes = json_encode(['all', 'own', 'participant']);
                }
            }
            DB::table('ms_panel')->insert(array_merge($p, [
                'supported_scopes' => $supportedScopes,
                'parent_id' => null,
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
        $panelIds = DB::table('ms_panel')->pluck('id', 'kode')->all();

        // -- Default permission matrix per level --
        $insertPerm = function ($levelKode, $panelKode, $actionKode, $scope) use (&$levelIds, &$panelIds, &$actionIds, $now) {
            if (!isset($levelIds[$levelKode]) || !isset($panelIds[$panelKode]) || !isset($actionIds[$actionKode])) {
                return;
            }
            DB::table('ms_user_level_panel_action')->insert([
                'level_id'   => $levelIds[$levelKode],
                'panel_id'   => $panelIds[$panelKode],
                'action_id'  => $actionIds[$actionKode],
                'scope'      => $scope,
                'active'     => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        };

        // SUPER_ADMIN: full access to all panels x all actions x all scope
        foreach ($panels as $p) {
            foreach (['view', 'create', 'edit', 'delete', 'approve', 'sign', 'close', 'export'] as $act) {
                $insertPerm('SUPER_ADMIN', $p['kode'], $act, 'all');
            }
        }

        // ADMIN: full to BA + PICA + MASTER. All scope = all.
        foreach ($panels as $p) {
            $isHelp = $p['modul'] === 'HELP';
            foreach (['view', 'create', 'edit', 'delete'] as $act) {
                $insertPerm('ADMIN', $p['kode'], $act, 'all');
            }
            if (!$isHelp) {
                $insertPerm('ADMIN', $p['kode'], 'export', 'all');
            }
        }
        $insertPerm('ADMIN', 'BA_EDIT', 'approve', 'all');
        $insertPerm('ADMIN', 'PICA_DISCUSS', 'close', 'all');
        $insertPerm('ADMIN', 'PICA_REPORT', 'close', 'all');

        // KOORDINATOR: lihat semua BA/PICA, edit own data, read-only master
        foreach (['BA_DASHBOARD', 'BA_LIST', 'BA_VIEW', 'BA_CREATE'] as $kode) {
            $insertPerm('KOORDINATOR', $kode, 'view', 'all');
        }
        $insertPerm('KOORDINATOR', 'BA_CREATE', 'create', 'all');
        $insertPerm('KOORDINATOR', 'BA_EDIT', 'view', 'own');
        $insertPerm('KOORDINATOR', 'BA_EDIT', 'edit', 'own');
        foreach (['PICA_DASHBOARD', 'PICA_LIST', 'PICA_CREATE'] as $kode) {
            $insertPerm('KOORDINATOR', $kode, 'view', 'all');
        }
        $insertPerm('KOORDINATOR', 'PICA_CREATE', 'create', 'all');
        $insertPerm('KOORDINATOR', 'PICA_DISCUSS', 'view', 'participant');
        $insertPerm('KOORDINATOR', 'PICA_DISCUSS', 'edit', 'participant');
        $insertPerm('KOORDINATOR', 'PICA_DISCUSS', 'sign', 'participant');
        $insertPerm('KOORDINATOR', 'PICA_REPORT', 'view', 'participant');
        $insertPerm('KOORDINATOR', 'PICA_REPORT', 'edit', 'participant');
        // Master read-only
        foreach (['MASTER_KONTEKS', 'MASTER_KATEGORI', 'MASTER_OPSI', 'MASTER_MAPPING',
                  'MASTER_OPSI_MAP', 'MASTER_CEK', 'MASTER_DOC', 'MASTER_PICA'] as $kode) {
            $insertPerm('KOORDINATOR', $kode, 'view', 'all');
        }
        $insertPerm('KOORDINATOR', 'HELP_VIEW', 'view', 'all');

        // USER: hanya BA/PICA sendiri
        $insertPerm('USER', 'BA_DASHBOARD', 'view', 'own');
        $insertPerm('USER', 'BA_LIST',      'view', 'own');
        $insertPerm('USER', 'BA_VIEW',      'view', 'own');
        $insertPerm('USER', 'BA_CREATE',    'view', 'all');
        $insertPerm('USER', 'BA_CREATE',    'create', 'all');
        $insertPerm('USER', 'BA_EDIT',      'view', 'own');
        $insertPerm('USER', 'BA_EDIT',      'edit', 'own');
        $insertPerm('USER', 'PICA_DASHBOARD', 'view', 'participant');
        $insertPerm('USER', 'PICA_LIST',      'view', 'participant');
        $insertPerm('USER', 'PICA_CREATE',    'view', 'all');
        $insertPerm('USER', 'PICA_CREATE',    'create', 'all');
        $insertPerm('USER', 'PICA_DISCUSS',   'view', 'participant');
        $insertPerm('USER', 'PICA_DISCUSS',   'edit', 'participant');
        $insertPerm('USER', 'PICA_DISCUSS',   'sign', 'participant');
        $insertPerm('USER', 'HELP_VIEW',      'view', 'all');

        // -- Map existing users.role text → users.level_id --
        DB::statement("UPDATE users SET level_id = ? WHERE LOWER(role) IN ('admin','super_admin','superadmin','administrator')", [$levelIds['ADMIN']]);
        DB::statement("UPDATE users SET level_id = ? WHERE LOWER(role) = 'koordinator'", [$levelIds['KOORDINATOR']]);
        DB::statement("UPDATE users SET level_id = ? WHERE LOWER(role) = 'guest' OR level_id IS NULL", [$levelIds['USER']]);
    }

    public function down()
    {
        if (Schema::hasColumn('users', 'level_id')) {
            Schema::table('users', function (Blueprint $t) {
                try { $t->dropIndex(['level_id']); } catch (\Throwable $e) {}
                $t->dropColumn('level_id');
            });
        }
        Schema::dropIfExists('ms_user_level_panel_action');
        Schema::dropIfExists('ms_action');
        Schema::dropIfExists('ms_panel');
        Schema::dropIfExists('ms_user_level');
    }
};
