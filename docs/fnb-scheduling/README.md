# FnB Scheduling Resto — Module Docs

**Status**: 🟡 Design phase (T1 roster only)
**Phase**: 3 (November 2026 – Februari 2027)
**Domain prefix**: `fnb` (lihat [conventions.md §10](../conventions.md#10-domain-prefix-naming-fnb-dst))
**ADR**: [005 — Scheduling Resto T1+T3](../decisions/005-scheduling-resto-phase3.md), [007 — Staff source](../decisions/007-fnb-scheduling-staff-source.md)

---

## Tujuan modul

Bangun sistem jadwal kerja staff FnB (resto) Tirta Group, mengganti spreadsheet manual yang dipakai manager outlet saat ini. T1 (Roster) adalah scope design dokumen ini. T3 (Clock-in + auto-trigger BA `DISIPLIN_OPERASIONAL`) di-defer ke iterasi berikutnya.

### Outcome T1

- Manager outlet membuat jadwal mingguan via UI (drag-drop calendar grid)
- Jadwal melewati approval flow (DRAFT → PENDING_APPROVAL → PUBLISHED) sebelum visible ke staff
- Staff lihat jadwal sendiri minimal 4 minggu ke depan
- HR & BOD lihat semua jadwal cross-outlet untuk monitoring
- Export PDF/Excel per outlet per minggu

### Bukan scope T1

- ❌ Clock-in / clock-out (= T3, defer)
- ❌ Auto-trigger BA Disiplin saat staff telat (= T3, defer)
- ❌ Payroll calculation (= T4, out of 12-bulan roadmap)
- ❌ Mobile native app (= Phase 4 PWA, sinergi belakangan)
- ❌ Swap request / time-off request workflow (= T2, defer)

---

## File di folder ini

| File | Isi |
|---|---|
| [README.md](README.md) (file ini) | Entry point + overview |
| [workflow.md](workflow.md) | Actor, state machine, main flows, validation rules, notification, UI surfaces, integration future |
| [schema.md](schema.md) | 8 tabel DB lengkap dengan kolom, FK, index, seed plan |
| [permissions.md](permissions.md) | Permission codes baru yang harus diregistrasi di `ms_panel_permission_matrix` |
| [open-questions.md](open-questions.md) | TBD items — perlu konfirmasi user sebelum implementation |

---

## Naming convention untuk modul ini

Modul FnB Scheduling mengikuti [Domain Prefix Naming](../conventions.md#10-domain-prefix-naming-fnb-dst):

| Layer | Convention | Contoh |
|---|---|---|
| DB tables | `ms_fnb_*` / `tr_fnb_*` | `ms_fnb_outlet`, `tr_fnb_jadwal_h` |
| PHP namespace | `App\Models\Fnb\*` | `App\Models\Fnb\Outlet`, `App\Models\Fnb\JadwalHeader` |
| Controllers | `App\Http\Controllers\Fnb\*` | `App\Http\Controllers\Fnb\JadwalController` |
| Routes | `/fnb/scheduling/*` atau `/fnb/master/*` | `/fnb/scheduling/jadwal/{id}/edit` |
| Permission | `fnb.scheduling.*` atau `fnb.master.*` | `fnb.scheduling.jadwal.approve` |
| Blade views | `resources/views/fnb/...` | `resources/views/fnb/scheduling/jadwal/edit.blade.php` |
| JS | `resources/js/fnb/...` | `resources/js/fnb/scheduling/calendar.js` |
| CSS class | `.fnb-*` | `.fnb-jadwal-status-published` |
| Docs | `docs/fnb-scheduling/` | (folder ini) |

---

## Schema overview (8 tabel)

```
ms_fnb_outlet                 (master outlet/gerai FnB)
ms_fnb_posisi                 (master posisi: Cook, Server, Cashier, dst — list TBD)
ms_fnb_kategori_jam_kerja     (master kategori durasi: JAM_1..JAM_12 + kelompok PART_TIME/FULL_TIME dst)
ms_fnb_shift_template         (shift definitions: kode, nama, jam_mulai, jam_selesai, kategori_jam_id FK)
ms_fnb_staff                  (mapping staff FnB → Ms_User_Emp di ERP, cross-DB; lihat ADR-007)
tr_fnb_jadwal_h               (header jadwal: outlet + periode mingguan + status approval)
tr_fnb_jadwal_d               (detail assignment: staff × tanggal × shift × posisi; split-shift allowed)
tr_fnb_jadwal_h_log           (audit trail transisi status header)
```

Detail kolom + FK + index → [schema.md](schema.md).

---

## State machine ringkasan

```
DRAFT ─submit─► PENDING_APPROVAL ─approve─► PUBLISHED ─archive(cron)─► ARCHIVED
  ▲                    │
  │  edit              │ reject
  │                    ▼
  └────────────── REJECTED ─resubmit─► PENDING_APPROVAL
```

5 status di `tr_fnb_jadwal_h.status`. Detail behavior, transition rules, dan audit di [workflow.md](workflow.md).

---

## Konteks BA

Modul ini terhubung secara konteks ke `ms_konteks` id=2 (`FNB`). Setiap `ms_fnb_outlet` punya `konteks_id` default = FNB. Integrasi otomatis ke kategori BA `DISIPLIN_OPERASIONAL` (#14, lihat [docs/categories.md](../categories.md#kategori-14--disiplin-operasional-6-opsi)) **dipersiapkan schema-nya** tapi **tidak di-implement di T1** — itu T3 scope.

---

## Cross-references

- [ADR-005](../decisions/005-scheduling-resto-phase3.md) — keputusan tier (T1+T3 skip T2), schedule Phase 3
- [ADR-007](../decisions/007-fnb-scheduling-staff-source.md) — keputusan staff source via mapping table di app DB
- [ROADMAP.md Phase 3](../ROADMAP.md#phase-3--integration--dashboard--scheduling-mvp-november-2026--februari-2027-m6m9) — capacity & paralelisasi
- [conventions.md §10](../conventions.md#10-domain-prefix-naming-fnb-dst) — naming rule project-wide
- [categories.md kategori #14](../categories.md#kategori-14--disiplin-operasional-6-opsi) — integrasi BA Disiplin Operasional (T3 future)
- [database.md](../database.md) — konvensi DB project, 2 connection (`mysql` + `mysql_new`)

---

## Status & next step

- ✅ Design dokumen ini (workflow + schema + permissions + open questions) — **selesai 2026-05-25**
- ⏳ Validate dengan user pilot outlet (FnB ops lead) — sebelum coding
- ⏳ Lengkapi [open-questions.md](open-questions.md) — perlu jawaban user
- ⏳ Migration + seed (saat Phase 3 dimulai November 2026)
- ⏳ UI implementation
- ⏳ T3 design (clock-in + BA trigger) — diskusi terpisah
