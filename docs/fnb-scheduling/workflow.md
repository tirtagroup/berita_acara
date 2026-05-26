# FnB Scheduling — Workflow Spec

**Scope**: T1 (Roster). T3 (clock-in + BA-trigger) di-defer.
**Last updated**: 2026-05-25
**Status**: Design draft

---

## 1. Actor & Responsibility

| Actor | Tanggung jawab | Permission anchor |
|---|---|---|
| **Admin Scheduling** | CRUD master: outlet, posisi, kategori jam kerja, shift template, mapping staff FnB ke outlet | `fnb.master.manage` |
| **Manager Outlet** | Bikin DRAFT jadwal mingguan; assign staff × shift × posisi; submit untuk approval; recall sebelum diapprove; edit DRAFT/REJECTED; request amendment jadwal PUBLISHED | `fnb.scheduling.jadwal.create` |
| **Approver** (siapa pun dengan permission, biasanya Area Manager / Supervisor FnB / HRD) | Review jadwal PENDING_APPROVAL; approve atau reject (dengan alasan). **Tidak boleh approve jadwal yang dia sendiri submit** (segregation of duties, enforced di app layer) | `fnb.scheduling.jadwal.approve` |
| **HR / BOD / Audit** | View semua jadwal cross-outlet untuk monitoring & audit | `fnb.scheduling.jadwal.view_all` |
| **Staff FnB** | View jadwal sendiri (PUBLISHED only), 4 minggu ke depan + history sendiri | `fnb.scheduling.jadwal.view_own` |

---

## 2. State Machine — `tr_fnb_jadwal_h.status`

```
                  submit                approve
   ┌──────────────────────►PENDING_APPROVAL─────────►PUBLISHED
   │                              │                      │
DRAFT                       reject (with reason)         │ period_selesai < today
   ▲                              │                  (cron archive)
   │ edit                         ▼                      ▼
   └──────────────────────────REJECTED              ARCHIVED
                                  │
                                  │ resubmit (after edit)
                                  ▼
                          PENDING_APPROVAL
```

**5 status**: `DRAFT`, `PENDING_APPROVAL`, `REJECTED`, `PUBLISHED`, `ARCHIVED`.

| Status | Editable | Visible ke staff? | Action tersedia | Catatan |
|---|---|---|---|---|
| **DRAFT** | Manager creator + admin | No | edit, submit, delete | Initial state setelah create |
| **PENDING_APPROVAL** | No (locked) | No | recall (manager creator), approve / reject (approver) | Notifikasi ke approver |
| **REJECTED** | Manager creator + admin | No | edit, resubmit, delete | Punya `reject_reason` wajib, notifikasi ke creator |
| **PUBLISHED** | No (locked) | **Yes** | request_amendment (kembali ke PENDING_APPROVAL), archive | Locked, staff bisa melihat |
| **ARCHIVED** | No (locked) | View-only (history) | clone-as-template (create DRAFT baru dari jadwal lama) | Cron job pindahkan otomatis saat `periode_selesai < today` |

**Audit trail**: setiap transisi status dicatat di `tr_fnb_jadwal_h_log` dengan `from_status`, `to_status`, `by_user_id`, `at`, `reason` (optional, mandatory untuk REJECTED).

---

## 3. Main Flows

### 3a. Happy path — Create & Publish

```
Manager Outlet                    System                     Approver           Staff
     │                              │                          │                │
     ├─ Pilih outlet + week ───────►│                          │                │
     │  (default: minggu ini)        ├─ Validasi UNIQUE         │                │
     │                              │  (outlet+periode_mulai)  │                │
     │                              ├─ Optional: clone last    │                │
     │                              │  week jadwal             │                │
     │◄── DRAFT created ────────────┤                          │                │
     │                              │                          │                │
     ├─ Loop: assign staff × ──────►│                          │                │
     │  shift × posisi              ├─ Validate overlap        │                │
     │◄── Warn/OK ──────────────────┤  (warn-allow)            │                │
     │                              ├─ Validate kategori jam   │                │
     │                              │  threshold (warn-allow)  │                │
     │                              │                          │                │
     ├─ Submit ────────────────────►│                          │                │
     │                              ├─ Status → PENDING_APPROVAL                │
     │                              ├─ Log transition          │                │
     │                              ├─ Notify approver(s) ───►│                 │
     │                              │                          │                │
     │                              │                  Approver review          │
     │                              │◄─ Approve ───────────────┤                │
     │                              ├─ Cek: approver_id ≠ submitter_id          │
     │                              ├─ Status → PUBLISHED      │                │
     │                              ├─ Log transition          │                │
     │◄── Notify success ───────────┤                          │                │
     │                              ├─ Notify staff terkait ────────────────────►
```

### 3b. Reject path

```
Approver         System                       Manager
   │              │                              │
   ├─ Reject ────►│                              │
   │  (input      │                              │
   │  reject_reason  REQUIRED)                   │
   │              ├─ Status → REJECTED           │
   │              ├─ Save reject_reason          │
   │              ├─ Log transition w/ reason    │
   │              ├─ Notify creator ────────────►│
   │              │                              │
   │              │           Manager edit + resubmit
   │              │◄─ Edit + Submit ─────────────┤
   │              ├─ Status → PENDING_APPROVAL   │
   │              ├─ Log (REJECTED→PENDING)      │
   │              ├─ Notify approver(s)          │
```

### 3c. Recall path (manager batalkan sebelum diapprove)

```
Manager (creator)        System                    Approver
     │                     │                          │
     ├─ Recall ────────────►│                          │
     │  (only allowed       │                          │
     │   for own DRAFT      │                          │
     │   that became        │                          │
     │   PENDING_APPROVAL)  │                          │
     │                     ├─ Status → DRAFT          │
     │                     ├─ Log (PENDING→DRAFT)     │
     │                     ├─ Notify approver(s) ─────►
     │                     │  "recalled by submitter" │
```

### 3d. Amendment path (jadwal PUBLISHED perlu diubah)

Kasus: staff cancel last-minute, perlu swap shift, dst.

```
Manager           System                     Approver           Staff
   │                │                          │                 │
   ├─ Request ─────►│                          │                 │
   │  amendment      ├─ Cek: status=PUBLISHED  │                 │
   │  (catatan       ├─ Set `amendment_pending=1` (kolom flag)   │
   │   alasan)       ├─ Status TETAP PUBLISHED (snapshot terjaga)│
   │                ├─ Buat working-copy override di              │
   │                │  tr_fnb_jadwal_d_amendment (atau pakai      │
   │                │  versioning via tr_fnb_jadwal_h_history)    │
   │◄── Edit mode ──┤                          │                 │
   │                │                          │                 │
   ├─ Edit + ──────►│                          │                 │
   │  Submit        ├─ Status → PENDING_APPROVAL                 │
   │                ├─ Staff masih lihat versi terakhir PUBLISHED│
   │                ├─ Notify approver ────────►                 │
   │                │                          │                 │
   │                │◄─ Approve ───────────────┤                 │
   │                ├─ Merge amendment ke jadwal master           │
   │                ├─ Status → PUBLISHED                        │
   │                ├─ Save snapshot lama ke tr_fnb_jadwal_h_history
   │                ├─ Notify staff terdampak ────────────────────►
```

> ⚠️ Implementasi amendment butuh tabel history snapshot (`tr_fnb_jadwal_h_history` atau pattern soft-versioning). Detail di [schema.md](schema.md#tabel-7--tr_fnb_jadwal_h_log--audit-trail). **Open trade-off**: pakai versi flag-based vs full snapshot. Default proposal: snapshot full saat amendment di-approve, archive ke history. Lihat [open-questions.md](open-questions.md).

---

## 4. Validation Rules

| # | Rule | Behavior | Saat |
|---|---|---|---|
| 1 | UNIQUE (`outlet_id`, `periode_mulai`) di `tr_fnb_jadwal_h` | **BLOCK** duplicate jadwal outlet+week | Create |
| 2 | `tr_fnb_jadwal_d` overlap jam shift untuk staff yang sama di hari yang sama | **WARN**, manager confirm untuk lanjut (split-shift legit) | Save assignment |
| 3 | Coverage shift kosong (mis. shift pagi tanpa cook) | **WARN at submit**, optional override | Submit |
| 4 | `approved_by_user_id != submitted_by_user_id` (segregation of duties) | **BLOCK** self-approval | Approve action |
| 5 | Staff assigned ke jadwal di outlet yang dia tidak terdaftar di `ms_fnb_staff` | **WARN**, manager bisa override (mis. cover sementara) | Save assignment |
| 6 | Submit jadwal yang `periode_selesai < today` | **BLOCK** (tidak guna approve jadwal lampau) | Submit |
| 7 | Kategori jam kerja shift punya `max_per_minggu_jam` filled → total jam staff per minggu di outlet melebihi limit | **WARN**, override allowed (manager confirm dengan catatan) | Save assignment |
| 8 | Reject tanpa `reject_reason` (minimum 10 karakter) | **BLOCK** | Reject action |
| 9 | Edit jadwal yang bukan status DRAFT atau REJECTED (kecuali via amendment flow) | **BLOCK** | Save assignment / edit header |
| 10 | Periode jadwal harus Senin–Minggu (7 hari kalendar) | **BLOCK** kalau `periode_mulai` bukan Senin atau `periode_selesai` bukan Minggu | Create |

**Override mechanism**: untuk WARN rules (2, 3, 5, 7), UI tampilkan modal konfirmasi dengan teks alasan opsional. Override action dicatat di `tr_fnb_jadwal_h_log` dengan flag `is_override` + alasan.

---

## 5. Notification Points

> ⚠️ Sistem notifikasi existing di repo perlu di-verify. Kalau belum ada infrastruktur in-app, perlu bangun (atau pakai email-only). Detail di [open-questions.md](open-questions.md).

| # | Trigger | Recipient | Channel | Payload |
|---|---|---|---|---|
| 1 | Manager submit jadwal (DRAFT → PENDING_APPROVAL) | Semua user dengan permission `fnb.scheduling.jadwal.approve` | In-app + email | Link ke `/fnb/scheduling/jadwal/{id}/review` |
| 2 | Approver approve (PENDING → PUBLISHED) | Manager submitter + semua staff yang terlibat di jadwal | In-app + email | Link ke `/fnb/my-schedule` untuk staff, `/fnb/scheduling/jadwal/{id}` untuk manager |
| 3 | Approver reject (PENDING → REJECTED) | Manager submitter saja | In-app + email | Link + `reject_reason` |
| 4 | Manager recall (PENDING → DRAFT) | Semua approver yang sudah ter-notify | In-app | "Jadwal recalled by submitter" |
| 5 | Amendment di-publish | Staff yang assignment-nya berubah dibanding versi sebelumnya | In-app | Diff: "Shift Selasa kamu: Pagi → Siang" |
| 6 | H-1 sebelum shift mulai | Staff terkait | In-app + push (kalau ada) | "Besok shift Pagi 07:00 di outlet X" |
| 7 | Jadwal di-archive otomatis | (none — silent) | — | Hanya log |

---

## 6. UI Surfaces (T1)

### 6a. Master pages (admin)

| Route | Halaman | Default state |
|---|---|---|
| `/fnb/master/outlet` | List + CRUD outlet | List all aktif |
| `/fnb/master/posisi` | List + CRUD posisi resto | List all aktif, sort by `sort_order` |
| `/fnb/master/kategori-jam-kerja` | List + CRUD kategori durasi | List all aktif, sort by `durasi_jam` |
| `/fnb/master/shift-template` | List + CRUD shift template | Filter per outlet (default: global) |
| `/fnb/master/staff` | List staff FnB + assign ke outlet | Filter outlet + status aktif |

### 6b. Scheduling pages

| Route | Halaman | Untuk | Default state |
|---|---|---|---|
| `/fnb/scheduling/jadwal` | Index list jadwal | Manager + Approver + HR | Filter: outlet (all), status (semua kecuali ARCHIVED), week (**minggu ini Senin–Minggu**) |
| `/fnb/scheduling/jadwal/create` | Form create jadwal baru | Manager | Pilih outlet + minggu + opsional "clone from last week" |
| `/fnb/scheduling/jadwal/{id}/edit` | Calendar grid editor | Manager (DRAFT/REJECTED creator) | Grid 7-hari × staff-list dari `ms_fnb_staff` outlet itu |
| `/fnb/scheduling/jadwal/{id}/review` | Read-only + approve/reject buttons | Approver (PENDING_APPROVAL) | Same grid, no edit |
| `/fnb/scheduling/jadwal/{id}` | Read-only view | All authorized | Same grid view |
| `/fnb/scheduling/jadwal/{id}/export` | Generate PDF/Excel | Manager + HR | PDF default A4 landscape, Excel format same |

### 6c. Staff page

| Route | Halaman | Default state |
|---|---|---|
| `/fnb/my-schedule` | View own published schedule | Default: 4 minggu ke depan (Senin minggu ini sampai Minggu 4 minggu lagi) + tab "history" untuk past |

### 6d. Default date range

Sesuai [conventions.md §1](../conventions.md#1-default-date-range-untuk-filter): semua filter tanggal default **awal-bulan → hari ini**.

**Pengecualian untuk modul ini**: filter "week" pakai default **minggu ini Senin–Minggu** (bukan bulan), karena unit kerja jadwal adalah minggu. Tabel jadwal `tr_fnb_jadwal_h.periode_mulai` selalu hari Senin, `periode_selesai` selalu hari Minggu — helper PHP `\App\Helpers\WeekHelper::currentWeek()` returns `['mulai' => 'YYYY-MM-DD Senin', 'selesai' => 'YYYY-MM-DD Minggu']`.

Filter date range "create date" dan "history" tetap pakai default awal-bulan → hari ini.

---

## 7. Integration & Future-Proofing

### 7a. T3 future (clock-in + BA-trigger)

- `tr_fnb_jadwal_d.jadwal_d_id` (PK) → akan jadi FK target untuk `tr_fnb_attendance` nanti
- `tr_fnb_attendance` (future) punya `clock_in_at`, `clock_out_at`, `late_minutes`, `is_no_show`
- Logic auto-trigger BA `DISIPLIN_OPERASIONAL` (kategori #14 di [categories.md](../categories.md#kategori-14--disiplin-operasional-6-opsi)):
  - `late_minutes > 15` → trigger opsi id=31 "Terlambat lebih dari 15 menit"
  - `is_no_show=1` → trigger opsi id=33 "Tidak masuk tanpa kabar"
  - Threshold configurable di master kategori (future)
- **Schema T1 sudah siap** untuk T3. Tidak ada migration tambahan untuk integration point.

### 7b. Konteks FNB

- Setiap `ms_fnb_outlet` punya kolom `konteks_id` FK ke `ms_konteks` → default `FNB` (id=2).
- Future: kalau ada modul scheduling untuk konteks lain (mis. operasional kantor pusat), bisa reuse schema dengan `konteks_id` yang beda — tapi naming `fnb_*` tetap menyiratkan FnB-scope. **Rekomendasi**: kalau scheduling diperluas ke non-FnB, rename ke universal (`ms_scheduling_*`) via ADR — jangan stretch `fnb_` prefix.

### 7c. Help center

Setiap halaman scheduling **wajib** terdaftar di `ms_doc_workflow` dengan inline help button (pattern existing, lihat [commit 91ce8e1, f4579bf](../../README.md)). Konten help di-author saat fitur shipped.

### 7d. Permission system

Permission baru (lihat [permissions.md](permissions.md)) wajib registered di `ms_panel_permission_matrix` lewat migration. Hooked ke existing user-level mapping.

### 7e. Audit trail global

`tr_fnb_jadwal_h_log` ikuti pattern audit yang sama dengan modul lain (mis. log di Request Revisi). Tidak buat sistem audit terpisah.

---

## Cross-references

- [schema.md](schema.md) — detail kolom 8 tabel
- [permissions.md](permissions.md) — list 6 permission baru
- [open-questions.md](open-questions.md) — TBD items yang perlu klarifikasi user
- [ADR-005](../decisions/005-scheduling-resto-phase3.md) — keputusan tier & phase
- [ADR-007](../decisions/007-fnb-scheduling-staff-source.md) — keputusan staff source
- [conventions.md §10](../conventions.md#10-domain-prefix-naming-fnb-dst) — naming rule
- [categories.md](../categories.md) — kategori BA (untuk T3 future integration)
