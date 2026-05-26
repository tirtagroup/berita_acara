# FnB Scheduling — Permission Matrix

**Last updated**: 2026-05-25
**Status**: Design draft
**Sistem permission existing**: 4 tabel (User Level × Panel × Permission Matrix + user-level mapping) — lihat [docs/tables/master-data.md](../tables/master-data.md) + GLOSSARY §G + commit `f616af7`.

---

## Permission codes baru (6 buah)

Semua mengikuti pattern `fnb.<sub-module>.<resource>.<action>` (lihat [conventions.md §10](../conventions.md#10-domain-prefix-naming-fnb-dst)).

| # | Permission code | Scope | Untuk role siapa |
|---|---|---|---|
| 1 | `fnb.master.manage` | CRUD semua master FnB: outlet, posisi, kategori jam kerja, shift template, staff FnB | Admin Scheduling, IT/Super Admin |
| 2 | `fnb.scheduling.jadwal.create` | Create + edit DRAFT/REJECTED + submit + recall jadwal sendiri | Manager Outlet |
| 3 | `fnb.scheduling.jadwal.approve` | Approve / reject jadwal yang `PENDING_APPROVAL`. Tidak boleh approve jadwal sendiri (enforced di app). | Area Manager FnB, Supervisor FnB, HRD |
| 4 | `fnb.scheduling.jadwal.amend` | Request amendment ke jadwal yang sudah PUBLISHED (kembali ke PENDING_APPROVAL flow) | Manager Outlet (advanced), atau super admin |
| 5 | `fnb.scheduling.jadwal.view_all` | View semua jadwal cross-outlet (read-only) | HR, BOD, Audit, Super Admin |
| 6 | `fnb.scheduling.jadwal.view_own` | View jadwal sendiri (PUBLISHED only, 4 minggu ahead + history) | Semua staff FnB |

---

## Role × Permission matrix (proposed default)

| Role | (1) master.manage | (2) jadwal.create | (3) jadwal.approve | (4) jadwal.amend | (5) view_all | (6) view_own |
|---|:---:|:---:|:---:|:---:|:---:|:---:|
| **Super Admin / IT** | ✅ | ✅ | ✅ | ✅ | ✅ | — |
| **Admin Scheduling** | ✅ | — | — | — | ✅ | — |
| **Area Manager FnB** | — | — | ✅ | — | ✅ | — |
| **Supervisor FnB** | — | — | ✅ | — | ✅ | — |
| **HRD** | — | — | ✅ | — | ✅ | — |
| **Manager Outlet** | — | ✅ | — | ✅ | (own outlet) | — |
| **BOD** | — | — | — | — | ✅ | — |
| **Audit** | — | — | — | — | ✅ | — |
| **Staff FnB** | — | — | — | — | — | ✅ |

> "(own outlet)" — Manager Outlet hanya view jadwal outlet dia sendiri, di-enforce via scope filter di controller. Tidak ada permission code terpisah — pakai filter logic.

> Final assignment per-user dilakukan via UI `ms_panel_permission_matrix` admin page existing.

---

## Enforcement points

### 1. Route middleware

Setiap route prefix `/fnb/scheduling/*` dan `/fnb/master/*` (untuk modul ini) di-protect dengan permission check:

```php
// routes/web.php (example)
Route::prefix('fnb/scheduling/jadwal')->middleware(['auth', 'permission:fnb.scheduling.jadwal.create'])->group(function () {
    Route::get('/create', [Fnb\JadwalController::class, 'create'])->name('fnb.scheduling.jadwal.create');
    Route::post('/store', [Fnb\JadwalController::class, 'store'])->name('fnb.scheduling.jadwal.store');
    // ...
});
```

Middleware `permission:*` perlu di-buat (atau reuse middleware existing kalau sudah ada untuk permission system).

### 2. Controller-level scope filter (Manager Outlet)

```php
// Manager outlet hanya bisa list jadwal outlet-nya sendiri
public function index(Request $request)
{
    $user = auth()->user();
    $query = JadwalHeader::query();

    if ($user->hasPermission('fnb.scheduling.jadwal.view_all')) {
        // HR/BOD: lihat semua
    } elseif ($user->hasPermission('fnb.scheduling.jadwal.create')) {
        // Manager: hanya outlet yang manager-nya = user
        $query->whereHas('outlet', fn($q) => $q->where('manager_emp_code', $user->emp_code));
    } elseif ($user->hasPermission('fnb.scheduling.jadwal.view_own')) {
        // Staff: hanya yang ada assignment-nya
        $query->whereHas('details', fn($q) => $q->where('emp_code', $user->emp_code))
              ->where('status', 'PUBLISHED');
    } else {
        abort(403);
    }
    // ...
}
```

### 3. Action-level checks (segregation of duties)

```php
// Approve action: cek approver != submitter
public function approve(int $jadwalId)
{
    $jadwal = JadwalHeader::findOrFail($jadwalId);
    if (!auth()->user()->hasPermission('fnb.scheduling.jadwal.approve')) abort(403);
    if ($jadwal->submitted_by === auth()->user()->username) {
        return back()->withErrors(['msg' => 'Tidak boleh approve jadwal yang Anda submit sendiri.']);
    }
    // ... transition logic
}
```

### 4. View-level conditional rendering

Blade template show/hide tombol based on permission:

```blade
@can('fnb.scheduling.jadwal.approve')
    @if($jadwal->status === 'PENDING_APPROVAL' && $jadwal->submitted_by !== auth()->user()->username)
        <button class="btn btn-success" data-action="approve">Approve</button>
        <button class="btn btn-danger" data-action="reject">Reject</button>
    @endif
@endcan
```

---

## Migration: register permissions

Saat akan create migration nanti (Phase 3), include migration terakhir untuk INSERT permission codes ke `ms_panel_permission_matrix`. Contoh skeleton:

```php
// 2026_XX_XX_XXXXXX_register_fnb_scheduling_permissions.php

public function up()
{
    DB::table('ms_panel_permission_matrix')->insert([
        ['permission_code' => 'fnb.master.manage',          'nama' => 'Kelola Master FnB',          'modul' => 'FnB Scheduling', 'aktif' => 1, 'created_at' => now(), 'created_by' => 'system'],
        ['permission_code' => 'fnb.scheduling.jadwal.create','nama' => 'Buat Jadwal FnB',           'modul' => 'FnB Scheduling', 'aktif' => 1, 'created_at' => now(), 'created_by' => 'system'],
        ['permission_code' => 'fnb.scheduling.jadwal.approve','nama' => 'Approve Jadwal FnB',       'modul' => 'FnB Scheduling', 'aktif' => 1, 'created_at' => now(), 'created_by' => 'system'],
        ['permission_code' => 'fnb.scheduling.jadwal.amend', 'nama' => 'Amend Jadwal FnB PUBLISHED','modul' => 'FnB Scheduling', 'aktif' => 1, 'created_at' => now(), 'created_by' => 'system'],
        ['permission_code' => 'fnb.scheduling.jadwal.view_all','nama' => 'View Semua Jadwal FnB',   'modul' => 'FnB Scheduling', 'aktif' => 1, 'created_at' => now(), 'created_by' => 'system'],
        ['permission_code' => 'fnb.scheduling.jadwal.view_own','nama' => 'View Jadwal Sendiri',     'modul' => 'FnB Scheduling', 'aktif' => 1, 'created_at' => now(), 'created_by' => 'system'],
    ]);
}

public function down()
{
    DB::table('ms_panel_permission_matrix')
      ->where('permission_code', 'LIKE', 'fnb.%')
      ->delete();
}
```

> ⚠️ Verify kolom-kolom actual `ms_panel_permission_matrix` sebelum migration (mis. mungkin `kode_permission` vs `permission_code`). Check via `php artisan docs:check-schema` atau query langsung.

---

## Help center registration

Setiap permission yang user-facing punya entry di `ms_doc_workflow` untuk inline help button (pattern existing, commit `91ce8e1`):

| Permission | Help doc topic |
|---|---|
| `fnb.scheduling.jadwal.create` | "Cara buat jadwal mingguan outlet" |
| `fnb.scheduling.jadwal.approve` | "Cara review & approve jadwal" |
| `fnb.scheduling.jadwal.amend` | "Cara revisi jadwal yang sudah dipublish" |
| `fnb.scheduling.jadwal.view_own` | "Cara lihat jadwal kerja saya" |
| `fnb.master.manage` | "Setup outlet, posisi, shift FnB" |

Konten doc di-author saat fitur shipped, bukan di design phase.

---

## Cross-references

- [docs/tables/master-data.md](../tables/master-data.md) — schema sistem permission existing
- [docs/GLOSSARY.md §G](../GLOSSARY.md) — domain term untuk User Level × Panel × Permission Matrix
- [workflow.md §1](workflow.md#1-actor--responsibility) — actor mapping yang reference permission
- [schema.md migration #9](schema.md#migration-order) — migration register permissions
- [open-questions.md](open-questions.md) — pertanyaan terkait scoping permission (mis. apakah Manager Outlet butuh permission `view_all` untuk outlet sendiri)
