# FnB Scheduling — Schema Spec

**Status**: Design draft
**Last updated**: 2026-05-25
**Connection**: `mysql` (HR Worksheet) untuk semua tabel di modul ini
**Cross-DB reference**: `ms_fnb_staff.emp_code` → `mysql_new.Ms_User_Emp.Ms_Emp_Code` (no FK, manual JOIN di app layer)

---

## Overview — 8 tabel

```
                                 ms_konteks (id=2, FNB)
                                       │
                                       │ FK (default)
                                       ▼
ms_fnb_outlet  ────────────────────────┐
     │                                  │
     │ FK opsional (shift global vs    │
     │ shift per-outlet)                │
     │                                  │
     ▼                                  │
ms_fnb_shift_template ──── FK ──► ms_fnb_kategori_jam_kerja
     │
     │ FK
     │
     ▼
tr_fnb_jadwal_h ─── 1:N ──► tr_fnb_jadwal_d ──► FK ──► ms_fnb_posisi
     │     ▲                       │
     │     │                       │ emp_code (cross-DB ref, no FK)
     │     │                       ▼
     │     │                  Ms_User_Emp (mysql_new)
     │     │                       ▲
     │     │                       │ emp_code (cross-DB ref, no FK)
     │     │                       │
     │     │                  ms_fnb_staff ──► FK ──► ms_fnb_outlet (home outlet)
     │     │
     │ 1:N │
     ▼
tr_fnb_jadwal_h_log (audit trail)
```

> **Tidak ada hard FK cross-DB** (`mysql` ↔ `mysql_new`). Reference via `emp_code` string, JOIN dilakukan manual di PHP. Pattern existing di BA-PICA (lihat [database.md](../database.md)).

---

## Tabel 1 — `ms_fnb_outlet` (Master Outlet/Gerai)

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `outlet_id` | `bigint unsigned` | NO | AUTO_INC | PRI | Primary key |
| `outlet_code` | `varchar(20)` | NO | — | UNI | Kode outlet (mis. `JKT-001`, `BDG-002`). Manual input admin. |
| `nama` | `varchar(100)` | NO | — | — | Nama outlet (mis. "Resto Tirta Sudirman") |
| `konteks_id` | `bigint unsigned` | NO | 2 | FK | FK ke `ms_konteks.id`. Default `FNB`. |
| `alamat` | `text` | YES | NULL | — | Alamat lengkap |
| `kota` | `varchar(50)` | YES | NULL | — | Kota untuk grouping/filter |
| `kontak_telp` | `varchar(20)` | YES | NULL | — | No. telp outlet |
| `kontak_email` | `varchar(100)` | YES | NULL | — | Email outlet |
| `manager_emp_code` | `varchar(50)` | YES | NULL | — | `Ms_User_Emp.Ms_Emp_Code` manager outlet (cross-DB ref). Untuk default approver suggestion (T2 future). |
| `aktif` | `tinyint(1)` | NO | 1 | — | 1 = aktif, 0 = ditutup/dinonaktifkan |
| `rec_status` | `tinyint(1)` | NO | 1 | — | Soft delete flag (mengikuti pola existing) |
| `created_at` | `datetime` | NO | CURRENT_TIMESTAMP | — | — |
| `created_by` | `varchar(50)` | NO | — | — | username creator |
| `updated_at` | `datetime` | YES | NULL ON UPDATE CURRENT_TIMESTAMP | — | — |
| `updated_by` | `varchar(50)` | YES | NULL | — | username updater |

**Index**:
- `idx_outlet_konteks` ON `konteks_id`
- `idx_outlet_aktif` ON `aktif`

**FK**:
- `konteks_id` → `ms_konteks(id)` ON DELETE RESTRICT

**Seed plan**: Admin input outlet existing Tirta saat go-live. Tidak ada seed default.

---

## Tabel 2 — `ms_fnb_posisi` (Master Posisi Resto)

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `posisi_id` | `bigint unsigned` | NO | AUTO_INC | PRI | — |
| `posisi_code` | `varchar(20)` | NO | — | UNI | Kode posisi (mis. `COOK`, `SERVER`, `CASHIER`) |
| `nama` | `varchar(50)` | NO | — | — | Nama posisi (mis. "Cook", "Server") |
| `deskripsi` | `text` | YES | NULL | — | Optional, untuk help context |
| `sort_order` | `int` | NO | 0 | — | Urutan tampilan di dropdown |
| `aktif` | `tinyint(1)` | NO | 1 | — | — |
| `rec_status` | `tinyint(1)` | NO | 1 | — | — |
| `created_at` | `datetime` | NO | CURRENT_TIMESTAMP | — | — |
| `created_by` | `varchar(50)` | NO | — | — | — |
| `updated_at` | `datetime` | YES | NULL ON UPDATE CURRENT_TIMESTAMP | — | — |
| `updated_by` | `varchar(50)` | YES | NULL | — | — |

**Index**:
- `idx_posisi_aktif` ON `aktif`
- `idx_posisi_sort` ON `sort_order`

**Seed plan**: List posisi awal **TBD**, akan dikonfirmasi user. Lihat [open-questions.md](open-questions.md). Placeholder list:
- COOK (Cook)
- SERVER (Server / Pramusaji)
- CASHIER (Kasir)
- STEWARD (Steward / Cleaner)
- CAPTAIN (Captain)
- BARTENDER (Bartender)
- DISHWASHER (Dishwasher)

---

## Tabel 3 — `ms_fnb_kategori_jam_kerja` (Master Kategori Durasi Shift)

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `kategori_jam_id` | `bigint unsigned` | NO | AUTO_INC | PRI | — |
| `kode` | `varchar(20)` | NO | — | UNI | mis. `JAM_1`, `JAM_8`, `JAM_12` |
| `nama` | `varchar(50)` | NO | — | — | Display name (mis. "1 Jam", "8 Jam (Full Day)") |
| `durasi_jam` | `int` | NO | — | — | Exact hour count (1, 2, 3, ..., 12, dst.) |
| `kelompok` | `varchar(20)` | YES | NULL | — | Optional grouping: `PART_TIME`, `HALF_DAY`, `FULL_TIME`, `DOUBLE`, `LEMBUR`. Bisa NULL kalau Tirta belum formalize kategori. |
| `max_per_minggu_jam` | `int` | YES | NULL | — | Limit total jam staff per minggu untuk kategori ini. NULL = no limit. Validasi `WARN` di app layer. |
| `rate_multiplier` | `decimal(5,2)` | NO | 1.00 | — | Untuk payroll future. 1.00 = normal, 1.50 = lembur, dst. T1 tidak pakai. |
| `aktif` | `tinyint(1)` | NO | 1 | — | — |
| `sort_order` | `int` | NO | 0 | — | — |
| `rec_status` | `tinyint(1)` | NO | 1 | — | — |
| `created_at` | `datetime` | NO | CURRENT_TIMESTAMP | — | — |
| `created_by` | `varchar(50)` | NO | — | — | — |
| `updated_at` | `datetime` | YES | NULL ON UPDATE CURRENT_TIMESTAMP | — | — |
| `updated_by` | `varchar(50)` | YES | NULL | — | — |

**Index**:
- `idx_kategori_jam_durasi` ON `durasi_jam`
- `idx_kategori_jam_aktif` ON `aktif`

**Seed plan**: Pre-seed 12 row kategori per-1-jam (JAM_1 sampai JAM_12). `kelompok` di-kosongkan default (Tirta belum punya kategorisasi formal — lihat [ADR-005 context](../decisions/005-scheduling-resto-phase3.md)). Admin bisa edit `kelompok` dan `max_per_minggu_jam` belakangan.

```sql
INSERT INTO ms_fnb_kategori_jam_kerja
  (kode, nama, durasi_jam, kelompok, max_per_minggu_jam, rate_multiplier, sort_order, aktif, created_by)
VALUES
  ('JAM_1',  '1 Jam',  1,  NULL, NULL, 1.00, 1,  1, 'system'),
  ('JAM_2',  '2 Jam',  2,  NULL, NULL, 1.00, 2,  1, 'system'),
  ('JAM_3',  '3 Jam',  3,  NULL, NULL, 1.00, 3,  1, 'system'),
  ('JAM_4',  '4 Jam',  4,  NULL, NULL, 1.00, 4,  1, 'system'),
  ('JAM_5',  '5 Jam',  5,  NULL, NULL, 1.00, 5,  1, 'system'),
  ('JAM_6',  '6 Jam',  6,  NULL, NULL, 1.00, 6,  1, 'system'),
  ('JAM_7',  '7 Jam',  7,  NULL, NULL, 1.00, 7,  1, 'system'),
  ('JAM_8',  '8 Jam',  8,  NULL, NULL, 1.00, 8,  1, 'system'),
  ('JAM_9',  '9 Jam',  9,  NULL, NULL, 1.00, 9,  1, 'system'),
  ('JAM_10', '10 Jam', 10, NULL, NULL, 1.00, 10, 1, 'system'),
  ('JAM_11', '11 Jam', 11, NULL, NULL, 1.00, 11, 1, 'system'),
  ('JAM_12', '12 Jam', 12, NULL, NULL, 1.00, 12, 1, 'system');
```

---

## Tabel 4 — `ms_fnb_shift_template` (Master Shift)

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `shift_id` | `bigint unsigned` | NO | AUTO_INC | PRI | — |
| `shift_code` | `varchar(20)` | NO | — | UNI | Kode shift (mis. `PAGI`, `SIANG`, `MALAM`, `OFF`, `CUTI`, `PAGI-A`) |
| `nama` | `varchar(50)` | NO | — | — | Nama display |
| `outlet_id` | `bigint unsigned` | YES | NULL | FK | NULL = global (semua outlet), filled = per-outlet override |
| `kategori_jam_id` | `bigint unsigned` | YES | NULL | FK | Auto-suggested dari durasi, manager bisa override. NULL untuk shift custom. |
| `jam_mulai` | `time` | NO | — | — | mis. `07:00:00` |
| `jam_selesai` | `time` | NO | — | — | mis. `15:00:00` |
| `is_overnight` | `tinyint(1)` | NO | 0 | — | 1 kalau shift cross-midnight (mis. 22:00 → 06:00). Hitung durasi: `(24 - jam_mulai + jam_selesai)` |
| `is_non_working` | `tinyint(1)` | NO | 0 | — | 1 untuk shift OFF / CUTI / IZIN — tidak dihitung sebagai jam kerja, tidak trigger validasi overlap |
| `warna_kalender` | `varchar(7)` | YES | NULL | — | Hex color untuk UI grid (mis. `#3b82f6`) |
| `deskripsi` | `text` | YES | NULL | — | — |
| `aktif` | `tinyint(1)` | NO | 1 | — | — |
| `sort_order` | `int` | NO | 0 | — | — |
| `rec_status` | `tinyint(1)` | NO | 1 | — | — |
| `created_at` | `datetime` | NO | CURRENT_TIMESTAMP | — | — |
| `created_by` | `varchar(50)` | NO | — | — | — |
| `updated_at` | `datetime` | YES | NULL ON UPDATE CURRENT_TIMESTAMP | — | — |
| `updated_by` | `varchar(50)` | YES | NULL | — | — |

**Index**:
- `idx_shift_outlet` ON `outlet_id`
- `idx_shift_kategori` ON `kategori_jam_id`
- `idx_shift_aktif` ON `aktif`

**FK**:
- `outlet_id` → `ms_fnb_outlet(outlet_id)` ON DELETE CASCADE (kalau outlet dihapus, shift-nya juga)
- `kategori_jam_id` → `ms_fnb_kategori_jam_kerja(kategori_jam_id)` ON DELETE SET NULL

**Seed plan**: Pre-seed shift global standar:
- `PAGI` 07:00–15:00 (kategori_jam = JAM_8)
- `SIANG` 15:00–22:00 (kategori_jam = JAM_7)
- `MALAM` 22:00–06:00 next day (is_overnight=1, kategori_jam = JAM_8)
- `OFF` 00:00–00:00 (is_non_working=1, kategori_jam = NULL)
- `CUTI` 00:00–00:00 (is_non_working=1, kategori_jam = NULL)

Admin bisa tambah per-outlet override / shift custom.

---

## Tabel 5 — `ms_fnb_staff` (Mapping Staff FnB)

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `staff_id` | `bigint unsigned` | NO | AUTO_INC | PRI | — |
| `emp_code` | `varchar(50)` | NO | — | UNI | Cross-DB ref ke `mysql_new.Ms_User_Emp.Ms_Emp_Code`. UNIQUE — 1 staff = 1 row di sini. |
| `home_outlet_id` | `bigint unsigned` | YES | NULL | FK | Outlet utama tempat staff biasa kerja. NULL = belum di-assign / floating. |
| `posisi_utama_id` | `bigint unsigned` | YES | NULL | FK | Posisi utama (mis. Cook). Default saat assign di jadwal, manager bisa override per assignment. |
| `kategori_jam_default_id` | `bigint unsigned` | YES | NULL | FK | Default kategori jam (mis. FULL_TIME). Optional, untuk staff dengan kontrak fixed jam. |
| `tanggal_join_fnb` | `date` | YES | NULL | — | Tanggal mulai di operasional FnB (bukan tanggal kontrak — itu di ERP). |
| `tanggal_exit_fnb` | `date` | YES | NULL | — | Tanggal keluar dari FnB ops. NULL = masih aktif. |
| `catatan` | `text` | YES | NULL | — | Free-text (mis. "Khusus shift malam", "Bisa swing cook/server") |
| `aktif` | `tinyint(1)` | NO | 1 | — | 1 = aktif di scheduling pool |
| `rec_status` | `tinyint(1)` | NO | 1 | — | — |
| `created_at` | `datetime` | NO | CURRENT_TIMESTAMP | — | — |
| `created_by` | `varchar(50)` | NO | — | — | — |
| `updated_at` | `datetime` | YES | NULL ON UPDATE CURRENT_TIMESTAMP | — | — |
| `updated_by` | `varchar(50)` | YES | NULL | — | — |

**Index**:
- `idx_staff_emp_code` ON `emp_code` (sudah UNIQUE, redundant tapi untuk explicit)
- `idx_staff_home_outlet` ON `home_outlet_id`
- `idx_staff_aktif` ON `aktif`

**FK**:
- `home_outlet_id` → `ms_fnb_outlet(outlet_id)` ON DELETE SET NULL
- `posisi_utama_id` → `ms_fnb_posisi(posisi_id)` ON DELETE SET NULL
- `kategori_jam_default_id` → `ms_fnb_kategori_jam_kerja(kategori_jam_id)` ON DELETE SET NULL

**Tidak ada FK ke `Ms_User_Emp`** (cross-DB). Validasi `emp_code` exists di ERP dilakukan di app layer saat create/update.

**Seed plan**: Tidak ada seed. Admin manual input atau bulk import dari ERP query terpisah (kontrak operasi FnB). Lihat [ADR-007](../decisions/007-fnb-scheduling-staff-source.md).

---

## Tabel 6 — `tr_fnb_jadwal_h` (Header Jadwal Mingguan)

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `jadwal_h_id` | `bigint unsigned` | NO | AUTO_INC | PRI | — |
| `outlet_id` | `bigint unsigned` | NO | — | FK | — |
| `periode_mulai` | `date` | NO | — | — | Hari Senin awal minggu |
| `periode_selesai` | `date` | NO | — | — | Hari Minggu akhir minggu |
| `status` | `varchar(20)` | NO | `DRAFT` | — | ENUM-like: `DRAFT`, `PENDING_APPROVAL`, `REJECTED`, `PUBLISHED`, `ARCHIVED` |
| `catatan_creator` | `text` | YES | NULL | — | Catatan dari manager creator (visible ke approver) |
| `submitted_at` | `datetime` | YES | NULL | — | Saat manager submit ke PENDING_APPROVAL |
| `submitted_by` | `varchar(50)` | YES | NULL | — | Username submitter |
| `approved_at` | `datetime` | YES | NULL | — | Saat di-approve |
| `approved_by` | `varchar(50)` | YES | NULL | — | Username approver |
| `rejected_at` | `datetime` | YES | NULL | — | Saat di-reject (terakhir kali) |
| `rejected_by` | `varchar(50)` | YES | NULL | — | Username rejecter |
| `reject_reason` | `text` | YES | NULL | — | Alasan reject (terakhir kali) |
| `published_at` | `datetime` | YES | NULL | — | Saat berubah ke PUBLISHED (sama dengan approved_at biasanya) |
| `archived_at` | `datetime` | YES | NULL | — | Saat di-archive |
| `amendment_pending` | `tinyint(1)` | NO | 0 | — | 1 kalau ada amendment in-progress (status sebenarnya tetap PUBLISHED) |
| `rec_status` | `tinyint(1)` | NO | 1 | — | — |
| `created_at` | `datetime` | NO | CURRENT_TIMESTAMP | — | — |
| `created_by` | `varchar(50)` | NO | — | — | Username manager creator |
| `updated_at` | `datetime` | YES | NULL ON UPDATE CURRENT_TIMESTAMP | — | — |
| `updated_by` | `varchar(50)` | YES | NULL | — | — |

**Index**:
- `uniq_outlet_periode` UNIQUE ON (`outlet_id`, `periode_mulai`) — block duplicate
- `idx_jadwal_h_status` ON `status`
- `idx_jadwal_h_periode` ON `periode_mulai`
- `idx_jadwal_h_outlet_status` ON (`outlet_id`, `status`) — untuk filter dashboard

**FK**:
- `outlet_id` → `ms_fnb_outlet(outlet_id)` ON DELETE RESTRICT (jangan auto-delete jadwal kalau outlet di-archive)

**Constraint app-layer**:
- `periode_mulai` harus hari Senin
- `periode_selesai` = `periode_mulai + 6 hari` (Minggu)
- `approved_by != submitted_by` saat transition ke PUBLISHED

---

## Tabel 7 — `tr_fnb_jadwal_d` (Detail Assignment)

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `jadwal_d_id` | `bigint unsigned` | NO | AUTO_INC | PRI | **Target FK untuk `tr_fnb_attendance` (T3 future)** |
| `jadwal_h_id` | `bigint unsigned` | NO | — | FK | — |
| `emp_code` | `varchar(50)` | NO | — | — | Cross-DB ref ke `Ms_User_Emp.Ms_Emp_Code`. No FK. |
| `tanggal` | `date` | NO | — | — | Tanggal assignment (harus dalam range `periode_mulai..periode_selesai`) |
| `shift_id` | `bigint unsigned` | NO | — | FK | — |
| `posisi_id` | `bigint unsigned` | YES | NULL | FK | Override posisi (default dari `ms_fnb_staff.posisi_utama_id`) |
| `catatan` | `text` | YES | NULL | — | Catatan per-assignment (mis. "Cover Pak Ahmad sakit") |
| `is_override` | `tinyint(1)` | NO | 0 | — | 1 kalau assignment ini di-create dengan override validasi (overlap, working hour, dst.) |
| `override_reason` | `text` | YES | NULL | — | Alasan override (kalau `is_override=1`) |
| `rec_status` | `tinyint(1)` | NO | 1 | — | — |
| `created_at` | `datetime` | NO | CURRENT_TIMESTAMP | — | — |
| `created_by` | `varchar(50)` | NO | — | — | — |
| `updated_at` | `datetime` | YES | NULL ON UPDATE CURRENT_TIMESTAMP | — | — |
| `updated_by` | `varchar(50)` | YES | NULL | — | — |

**Index**:
- `idx_jadwal_d_h` ON `jadwal_h_id`
- `idx_jadwal_d_emp_tanggal` ON (`emp_code`, `tanggal`) — untuk "jadwal staff X minggu ini"
- `idx_jadwal_d_shift` ON `shift_id`
- `idx_jadwal_d_tanggal` ON `tanggal` — untuk "siapa kerja hari ini cross-outlet"

**FK**:
- `jadwal_h_id` → `tr_fnb_jadwal_h(jadwal_h_id)` ON DELETE CASCADE
- `shift_id` → `ms_fnb_shift_template(shift_id)` ON DELETE RESTRICT
- `posisi_id` → `ms_fnb_posisi(posisi_id)` ON DELETE SET NULL

**TIDAK ada UNIQUE constraint** `(emp_code, tanggal)` — split-shift allowed (lihat [workflow.md §4 rule 2](workflow.md#4-validation-rules)).

---

## Tabel 8 — `tr_fnb_jadwal_h_log` (Audit Trail Header)

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `log_id` | `bigint unsigned` | NO | AUTO_INC | PRI | — |
| `jadwal_h_id` | `bigint unsigned` | NO | — | FK | — |
| `from_status` | `varchar(20)` | YES | NULL | — | NULL untuk initial create |
| `to_status` | `varchar(20)` | NO | — | — | — |
| `action` | `varchar(30)` | NO | — | — | mis. `create`, `submit`, `approve`, `reject`, `recall`, `amend`, `archive`, `override_save` |
| `actor_user_id` | `bigint` | YES | NULL | — | FK ke `users.id` (Laravel auth user) |
| `actor_username` | `varchar(50)` | NO | — | — | Snapshot username (jaga-jaga kalau user dihapus) |
| `reason` | `text` | YES | NULL | — | Untuk `reject` (mandatory), `recall`, `override_save` (mandatory) |
| `is_override` | `tinyint(1)` | NO | 0 | — | 1 kalau action ini bypass validasi |
| `metadata_json` | `json` | YES | NULL | — | Diff atau context lain (mis. amendment diff) |
| `created_at` | `datetime` | NO | CURRENT_TIMESTAMP | — | — |

**Index**:
- `idx_log_jadwal_h` ON `jadwal_h_id`
- `idx_log_action` ON `action`
- `idx_log_created_at` ON `created_at`

**FK**:
- `jadwal_h_id` → `tr_fnb_jadwal_h(jadwal_h_id)` ON DELETE CASCADE

**Append-only**: tidak ada `updated_at`/`updated_by`. Setiap perubahan = INSERT row baru.

**Amendment history**: untuk T1, snapshot full jadwal sebelum amendment **belum di-implement** sebagai tabel terpisah. Kalau kebutuhan muncul nanti, tambah tabel `tr_fnb_jadwal_h_history` dengan kolom `snapshot_json` (atau full mirror schema). Untuk T1, audit log + diff di `metadata_json` cukup. Lihat [open-questions.md](open-questions.md).

---

## ER diagram (text)

```
┌──────────────────┐
│ ms_konteks       │
│ (existing)       │
└──────┬───────────┘
       │ id=2 FNB
       │ FK (default)
┌──────▼───────────┐         ┌────────────────────────┐
│ ms_fnb_outlet    │◄────────│ ms_fnb_shift_template  │
│  outlet_id PK    │  FK     │  shift_id PK           │
│  outlet_code UNI │ (opt.)  │  outlet_id FK NULL     │
│  konteks_id FK   │         │  kategori_jam_id FK    │
└──────┬───────────┘         │  jam_mulai             │
       │                     │  jam_selesai           │
       │ FK (home outlet)    │  is_overnight          │
       │                     │  is_non_working        │
┌──────▼───────────┐         └──────┬─────────────────┘
│ ms_fnb_staff     │                │ FK
│  staff_id PK     │                │
│  emp_code UNI    │                │
│  home_outlet_id FK              ┌─▼──────────────────────────┐
│  posisi_utama_id FK ────────┐    │ ms_fnb_kategori_jam_kerja │
└──────────────────┘          │    │  kategori_jam_id PK       │
                              │    │  kode UNI                 │
                              │    │  durasi_jam               │
                              │    │  kelompok                 │
                              │    │  max_per_minggu_jam       │
                              │    │  rate_multiplier          │
                              │    └───────────────────────────┘
                              │
                       ┌──────▼─────────┐
                       │ ms_fnb_posisi  │
                       │  posisi_id PK  │
                       │  posisi_code UNI│
                       └────────────────┘

┌─────────────────────┐ 1:N  ┌────────────────────────┐
│ tr_fnb_jadwal_h     │─────►│ tr_fnb_jadwal_d        │
│  jadwal_h_id PK     │      │  jadwal_d_id PK        │
│  outlet_id FK       │      │  jadwal_h_id FK        │
│  periode_mulai      │      │  emp_code (no FK)      │
│  periode_selesai    │      │  tanggal               │
│  status             │      │  shift_id FK           │
│  submitted_by       │      │  posisi_id FK          │
│  approved_by        │      │  is_override           │
│  reject_reason      │      └────────────────────────┘
│  amendment_pending  │
└────┬────────────────┘
     │ 1:N
     ▼
┌──────────────────────────┐
│ tr_fnb_jadwal_h_log      │
│  log_id PK               │
│  jadwal_h_id FK          │
│  from_status, to_status  │
│  action, actor_username  │
│  reason, is_override     │
│  metadata_json           │
└──────────────────────────┘
```

---

## Migration order

Saat akan create migration nanti (Phase 3, bukan sekarang):

1. `create_ms_fnb_outlet_table` (depend on `ms_konteks` existing)
2. `create_ms_fnb_posisi_table`
3. `create_ms_fnb_kategori_jam_kerja_table` + seed 12 row
4. `create_ms_fnb_shift_template_table` (depend on 1+3) + seed shift standar
5. `create_ms_fnb_staff_table` (depend on 1+2+3)
6. `create_tr_fnb_jadwal_h_table` (depend on 1)
7. `create_tr_fnb_jadwal_d_table` (depend on 4+6) — TANPA UNIQUE emp_code+tanggal
8. `create_tr_fnb_jadwal_h_log_table` (depend on 6)
9. `register_fnb_scheduling_permissions` — INSERT permission codes ke `ms_panel_permission_matrix`

---

## Cross-references

- [workflow.md](workflow.md) — flow + validation yang reference schema ini
- [permissions.md](permissions.md) — permission yang akan di-register di migration #9
- [open-questions.md](open-questions.md) — TBD field/decision yang belum lock-in
- [ADR-007](../decisions/007-fnb-scheduling-staff-source.md) — rationale untuk `ms_fnb_staff` cross-DB mapping
- [database.md](../database.md) — konvensi DB project, 2 connection
- [conventions.md §10](../conventions.md#10-domain-prefix-naming-fnb-dst) — naming rule
