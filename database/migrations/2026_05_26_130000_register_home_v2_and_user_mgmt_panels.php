<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Register 2 panel baru di permission system existing:
 *
 *   1. HOME_V2          — landing page /home-v2 (semua level dapat view 'all')
 *   2. USER_MGMT_USERS  — panel User Management → assign user-level + toggle active
 *                         (SUPER_ADMIN dapat view/create/edit/delete 'all'; lainnya manual)
 *
 * Permission system schema (lihat migration 2026_05_25_100000):
 *   ms_panel                  — definisi panel
 *   ms_user_level_panel_action — grant per (level, panel, action, scope)
 *
 * ADR-007 (FnB Scheduling) permission codes belum di-register di sini —
 * akan ditambah saat Phase 3 implementation.
 */
return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        // ============ PANELS ============
        $panels = [
            [
                'kode'      => 'HOME_V2',
                'nama'      => 'Home Dashboard (V2)',
                'modul'     => 'HOME',
                'url'       => '/home-v2',
                'icon'      => 'bx-home-circle',
                'scopable'  => false,
                'urutan'    => 1,
            ],
            [
                'kode'      => 'USER_MGMT_USERS',
                'nama'      => 'User Management — Users',
                'modul'     => 'MASTER',
                'url'       => '/user-management/users',
                'icon'      => 'bx-user',
                'scopable'  => false,
                'urutan'    => 39, // setelah MASTER_PERM (38)
            ],
        ];

        foreach ($panels as $p) {
            // Skip kalau panel sudah ada (idempotent)
            $exists = DB::table('ms_panel')->where('kode', $p['kode'])->exists();
            if ($exists) continue;

            DB::table('ms_panel')->insert(array_merge($p, [
                'parent_id'        => null,
                'supported_scopes' => null,
                'active'           => true,
                'created_at'       => $now,
                'updated_at'       => $now,
            ]));
        }

        // ============ GRANT DEFAULTS ============
        $panelIds  = DB::table('ms_panel')->whereIn('kode', ['HOME_V2', 'USER_MGMT_USERS'])->pluck('id', 'kode');
        $levelIds  = DB::table('ms_user_level')->pluck('id', 'kode');
        $actionIds = DB::table('ms_action')->pluck('id', 'kode');

        $insertPerm = function ($levelKode, $panelKode, $actionKode, $scope) use ($levelIds, $panelIds, $actionIds, $now) {
            if (!isset($levelIds[$levelKode]) || !isset($panelIds[$panelKode]) || !isset($actionIds[$actionKode])) {
                return;
            }
            $exists = DB::table('ms_user_level_panel_action')
                ->where('level_id',  $levelIds[$levelKode])
                ->where('panel_id',  $panelIds[$panelKode])
                ->where('action_id', $actionIds[$actionKode])
                ->exists();
            if ($exists) return;

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

        // HOME_V2 — view all levels
        if (isset($panelIds['HOME_V2'])) {
            foreach (['SUPER_ADMIN', 'ADMIN', 'KOORDINATOR', 'USER'] as $lv) {
                $insertPerm($lv, 'HOME_V2', 'view', 'all');
            }
        }

        // USER_MGMT_USERS — SUPER_ADMIN full, ADMIN view+edit only
        if (isset($panelIds['USER_MGMT_USERS'])) {
            foreach (['view', 'create', 'edit', 'delete'] as $act) {
                $insertPerm('SUPER_ADMIN', 'USER_MGMT_USERS', $act, 'all');
            }
            foreach (['view', 'edit'] as $act) {
                $insertPerm('ADMIN', 'USER_MGMT_USERS', $act, 'all');
            }
        }
    }

    public function down(): void
    {
        // Hapus grants dulu (FK dependency), lalu panels
        $panelIds = DB::table('ms_panel')->whereIn('kode', ['HOME_V2', 'USER_MGMT_USERS'])->pluck('id');
        if ($panelIds->isNotEmpty()) {
            DB::table('ms_user_level_panel_action')->whereIn('panel_id', $panelIds)->delete();
            DB::table('ms_panel')->whereIn('id', $panelIds)->delete();
        }
    }
};
