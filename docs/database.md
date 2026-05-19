# Database Schema

## ⚠️ Catatan Penting

**Migration di `database/migrations/` minim (hanya 8 file)** — kebanyakan adalah scaffolding Laravel/Jetstream (`users`, `password_resets`, `failed_jobs`, `personal_access_tokens`, `sessions`).

**Tabel bisnis (BA, PICA, Assessment, dll.) TIDAK ada di migration** — schema-nya hanya ada di **database produksi `tirt3038_HR_Worksheet`** dan `tirt3038_ERP`.

Konsekuensi:
- `php artisan migrate` di database kosong **tidak akan** membuat tabel bisnis.
- Untuk environment baru, perlu **dump schema** dari DB produksi.

---

## Database yang Dipakai

| Connection | Host | Database | Purpose |
|---|---|---|---|
| `mysql` (default) | `absensi.tirtagroup.net` | `tirt3038_HR_Worksheet` | Modul utama: BA, PICA, Asasmen, SP |
| `mysql_new` | `absensi.tirtagroup.net` | `tirt3038_ERP` | Data master karyawan/ERP |

Konfigurasi di `.env` (`DB_*` dan `DB_*_NEW`).

---

## Tabel di Migration (Authentication & Sistem)

| Tabel | Tujuan | Kolom kunci |
|---|---|---|
| `users` | User aplikasi (Jetstream + 2FA) | `id`, `email`, `password`, `current_team_id`, `two_factor_secret` |
| `tb_user` | User legacy/alternatif | `user_id`, `username`, `password`, `name` |
| `password_resets` | Token reset password | `email`, `token`, `created_at` |
| `sessions` | Sesi user | `id`, `user_id`, `ip_address`, `payload`, `last_activity` |
| `personal_access_tokens` | API token Sanctum (polymorphic) | `tokenable_id`, `tokenable_type`, `token`, `abilities` |
| `failed_jobs` | Queue gagal | `uuid`, `connection`, `queue`, `exception`, `failed_at` |

---

## Konvensi Penamaan Tabel di Produksi

Dari nama model di `app/Models/`:

| Prefix | Arti | Contoh |
|---|---|---|
| `Ms_` / `ms_` | **Master data** (referensi) | `Ms_Company`, `Ms_BA_Kasus`, `ms_divisi`, `ms_jenis_laka` |
| `Tr_` / `tr_` | **Transactional** (data operasional) | `Tr_BA_Main_New`, `Tr_PICA_Emp_h`, `Tr_SP_H`, `tr_candidate` |
| `BA_` | **Berita Acara** specific | `BA_Main`, `BA_docs`, `BA_laka_header`, `BA_laka_detail`, `BA_Salah_Isi_d` |
| `*_h`, `*_d` | **Header / Detail** (master-detail) | `Tr_SP_H` + `Tr_SP_D`, `Tr_PICA_Emp_h` + `Tr_Pica_Emp_D` |
| `tb_` | Tabel custom (di luar konvensi Laravel) | `tb_user` |

---

## Relasi Domain Penting

(Berdasarkan nama model dan kode di controller — tidak ada FK di migration, jadi ini deduksi dari kode aplikasi.)

```
ms_company ──┬─→ ms_divisi ──→ MasterEmployee
             ├─→ MsBranch
             └─→ MsLocation

MasterEmployee (HR) ──┬─→ Tr_BA_Main_New ──┬─→ Tr_BA_Comment
                      │                     ├─→ Tr_BA_Kronologi
                      │                     ├─→ Tr_BA_Revisi
                      │                     └─→ BA_docs / BA_docs2
                      │
                      ├─→ Tr_PICA_Emp_h ──┬─→ Tr_Pica_Emp_D
                      │                    ├─→ Tr_PICA_Pertanyaan
                      │                    ├─→ Tr_PICA_Action
                      │                    └─→ Tr_PICA_Preventive_Action
                      │
                      ├─→ tr_emp_assesment ──→ tr_emp_asses_*_result
                      │                        (basic / advance / discipline)
                      │
                      ├─→ Tr_SP_H ──→ Tr_SP_D
                      │
                      └─→ Tr_Review_EmpPeriod_h ──┬─→ Basic_Reviewer
                                                    └─→ Task_Reviewer

tr_candidate ──┬─→ CurriculumVitae
               ├─→ Jadwal_Interview
               ├─→ InterviewHRD / InterviewUser
               └─→ candidate_photos
```

---

## Daftar Model (sample)

`app/Models/` berisi **136 file model**. Pengelompokan tematik:

### Berita Acara
- `BA_Main`, `BA_Salah_Isi_d`, `BA_docs`, `BA_docs2`
- `BA_laka_header`, `BA_laka_detail` (kecelakaan kerja)
- `Tr_BA_Main_New`, `Tr_BA_Comment`, `Tr_BA_Kronologi`, `Tr_BA_Revisi`
- `Ms_BA_Category`, `Ms_BA_Detail_Kasus`, `Ms_BA_Kasus`, `Ms_Case_Category`, `Ms_Jenis_BA`

### PICA
- `Tr_PICA_Emp_h`, `Tr_Pica_Emp_D`
- `Tr_PICA_Pertanyaan`, `Tr_PICA_Action`, `Tr_PICA_Preventive_Action`

### Assessment
- `tr_emp_assesment`, `tr_emp_assesor`
- `tr_emp_asses_basic_result`, `tr_emp_asses_advance_result`, `tr_emp_asses_discipline_result`
- `tr_emp_asses_note`
- `Tr_Review_EmpPeriod_h`, `Tr_Review_EmpPeriod_Basic_Reviewer`, `Tr_Review_EmpPeriod_Task_Reviewer`
- `tr_Period_emp_assesor_main`

### Surat Peringatan
- `Tr_SP_H`, `Tr_SP_D`, `Tr_SP_Main`
- `Ms_type_sp`

### Recruitment / HR
- `tr_candidate`, `tr_candidate_jobportal`, `Tr_candidate_header`
- `CurriculumVitae`, `Pendidikan`, `Pengalaman`, `Pengalaman2`, `Pengalaman3`
- `Skill`, `Skill2`, `SocialMedia`, `SocialMedia2`
- `Keluarga`, `Keluarga2`, `Organisasi`, `Organisasi2`
- `Jadwal_Interview`, `InterviewHRD`, `InterviewUser`, `Tr_Call_H`
- `PostLoker`, `OpeningLowongan_H`
- `candidate_photos`, `MasterEmployee`, `HR`

### Master Data
- `Ms_Company`, `MsBranch`, `MsDivisi`, `MsLocation`, `ms_divisi`
- `ms_apps`, `ms_dampak_laka`, `ms_faktor_laka`, `ms_jenis_laka`, `ms_klasifikasi_laka`
- `ms_kode_interview`, `ms_recruit_from`, `Ms_fraud`, `Ms_Kasus`, `Ms_Status_Short`

### Report & Dashboard
- `Main_reportHRD`, `Main_reportSecurity`
- `DashboardAllCandidates`, `Dashboard_belum_shortlist`
- `Report_Memo`, `Report_OpeningHRD`, `Report_TemuanSecurity`
- `AllHostoryPerDay`, `babydivisi`, `babydivisi_perday`, `babydivisi_permonth`
- `total_ba_by_jenis`, `reportclosing`

---

## Catatan

- Beberapa file di `app/Models/` adalah **duplikat / salah penempatan** (mis. `MsLocationController.php` adalah controller, bukan model). Lihat [docs/caveats.md](caveats.md#file-duplikat-di-repo).
- Saat menambah migration baru, prefix `Ms_` untuk master data, `Tr_` untuk transactional.

---

## 📌 Planned Change: Multi-Category Berita Acara

**Latar belakang**: Berita Acara di dunia nyata sering merepresentasikan kejadian yang **overlap beberapa kategori sekaligus** — mis. *kecelakaan kerja akibat kelalaian SOP yang juga melibatkan unsur fraud*.

### Schema Saat Ini

Sistem punya **dua tabel** untuk BA:

**1. `tr_ba_main` (LEGACY, ~5.630 rows)** — masih single-value:

```
Category_Code  varchar(50)   ← satu kategori
jenis          varchar(50)   ← satu jenis
ms_kasus       varchar(100)  ← satu kasus
ms_fraud       tinyint(1)    ← flag fraud (boolean)
```

**2. `Tr_Ba_Main_New` (AKTIF, ~19.122 rows)** — sudah multi-kategori via **bitfield boolean flags**:

```
PK: Tr_BA_Main_Code varchar(100)     ← format: Emp+Jenis+Week+year+auto

Multi-category (boolean tinyint):
  CekPelanggaran    CekKerusakan       CekFraud
  CekRevisi         CekDisiplin        CekSalahIsi
  CekNoClosing      CekLaka            CekPembelian
  CekKehilangan     CekPerubahanSOP

Single-value FK (sub-klasifikasi):
  Ms_BA_type_Code   varchar(100)
  Ms_Kasus          varchar(100)
  MS_Detail_Kasus   varchar(100)
```

Catatan: tabel aktif **sudah mendukung multi-kategori** — tapi pakai pola **bitfield** (11 kolom boolean) alih-alih pivot table. Masing-masing punya trade-off:

| Aspek | Bitfield `Cek*` | Pivot Table |
|---|---|---|
| Tambah kategori baru | `ALTER TABLE ADD COLUMN CekX` (DDL) | INSERT row di master (DML) |
| Query agregat | `WHERE CekX=1` — fast, no JOIN | `JOIN` pivot, group by |
| Validasi nilai | Hanya bool 0/1, tidak ada FK | FK enforced ke master |
| Metadata per kategori (priority, color, label) | Tidak (kategori = nama kolom) | Bisa di master |
| Jumlah kategori | Hardcoded di schema | Unlimited |
| Refactor risk | Banyak `Cek*` di kode = banyak titik perubahan | Single source of truth |

### Apa yang Masih Single & Perlu Dimigrasi

Di `Tr_Ba_Main_New`, kolom yang masih **single-value** padahal idealnya multi:

- `Ms_BA_type_Code` (tipe BA)
- `Ms_Kasus` (kasus utama — referensi ke `ms_kasus.ms_kasus_code`, 694 nilai)
- `MS_Detail_Kasus` (detail kasus)

### Arsitektur yang Disepakati: Universal Categories + BU Mapping

Setelah diskusi domain, arsitektur final:

```
ms_business_unit          (BU: LAKA, FNB, OP_HR, ...)
        │
        │ N:N
ms_bu_kategori_mapping    (BU × kategori, dengan level: wajib/disarankan/opsional)
        │
        │ N:N
ms_ba_kategori            (master semua kategori, UNIVERSAL — tidak partition per BU)
        │
        │ 1:N
ms_ba_<kategori>          (tabel opsi/kasus per kategori, universal)
```

**Prinsip**:
1. **Semua kategori universal** — bisa attach ke BA mana saja (multi-kategori).
2. **BU = helper/preset**: memandu user kategori mana yang **wajib/disarankan/opsional**, tapi user tetap punya kebebasan.
3. **Naming**: `ms_ba_<kategori>` tanpa prefix BU (sebelumnya sempat dirancang dengan prefix `fnb_*` — sudah di-revisi).
4. **`Cek*` flags existing**: belum diputuskan — pilihan deprecate (gunakan pivot baru) atau dipakai sebagai cache.

Lihat [`docs/categories.md`](categories.md) untuk daftar lengkap BU, kategori, opsi, dan draft mapping.

### Tabel Baru yang Akan Dibuat

| Tabel | Tujuan | Status data |
|---|---|---|
| `ms_business_unit` | Master BU (LAKA, FNB, OP_HR, …) | 3 BU draft, perlu validasi |
| `ms_ba_kategori` | Master semua kategori universal | 14 kategori, kode tercatat di categories.md |
| `ms_bu_kategori_mapping` | Pivot BU × Kategori dengan kolom `level` | Draft, perlu validasi user |
| `ms_ba_laka_penyebab` | Opsi sub-LAKA | ✅ 7 opsi |
| `ms_ba_pelanggaran_sop` | Opsi SOP | ✅ 5 opsi |
| `ms_ba_logistik` | Opsi Logistik (FnB) | ✅ 7 opsi |
| `ms_ba_kualitas_makanan` | Opsi Kualitas Makanan | ✅ 5 opsi |
| `ms_ba_pelayanan` | Opsi Pelayanan | ✅ 10 opsi |
| `ms_ba_disiplin_operasional` | Opsi Disiplin operasional | ✅ 6 opsi |
| `ms_ba_kerusakan_kehilangan` | Opsi Kerusakan/Kehilangan | ⏳ FnB-starter (alat rusak, alat hilang); global TBD |
| `ms_ba_fraud` | Opsi Fraud | ⏳ |
| `ms_ba_temuan_kasus` | Opsi Temuan Kasus | ⏳ |
| `ms_ba_indisipliner_etika` | Opsi Indisipliner/Etika | ⏳ |
| `ms_ba_menolak_tugas` | Opsi Menolak Tugas | ⏳ |
| `ms_ba_kriminal` | Opsi Kriminal | ⏳ |
| `ms_ba_komplain_customer` | Opsi Komplain Customer | ⏳ |
| `ms_ba_kesalahan_admin` | Opsi Kesalahan Admin | ⏳ |

### Yang Belum Diputuskan

1. **Hubungan ke `Tr_Ba_Main_New`** — pivot tabel `tr_ba_kategori_d` (BA × kategori dengan opsi_kode) belum dirancang. Bisa hadir saat refactor `Cek*` flags.
2. **Konsolidasi master LAKA legacy** (`ms_jenis_laka`, `ms_faktor_laka`, dll.) — diabsorb ke kategori universal atau dipertahankan?
3. **Mapping BU × Kategori draft** — perlu validasi user sebelum di-seed.

### Status

✅ **Migration file dibuat**: [`database/migrations/2026_05_19_200000_create_ba_kategori_system.php`](../database/migrations/2026_05_19_200000_create_ba_kategori_system.php) (5 tabel + seed). **Belum di-run** — `php artisan migrate` harus dijalankan manual di environment yang dipilih.

### Tabel yang Dibuat (Schema Final)

```
ms_business_unit               id PK, kode UQ, nama, deskripsi, active
ms_ba_kategori                 id PK, kode UQ, nama, parent_id (self FK), active
ms_bu_kategori_mapping         bu_id FK, kategori_id FK, level ENUM (UQ bu+kat)
ms_ba_kategori_opsi            id PK, kategori_id FK, kode, deskripsi, sort_order
tr_ba_kategori_d               id PK, tr_ba_main_code, kategori_id FK, opsi_id FK
```

### Data ter-seed

| Tabel | Rows |
|---|---|
| `ms_business_unit` | 3 (LAKA, FNB, OP_HR) |
| `ms_ba_kategori` | 14 kategori universal |
| `ms_bu_kategori_mapping` | 35 mapping (draft level wajib/disarankan/opsional) |
| `ms_ba_kategori_opsi` | 43 opsi (untuk 7 kategori yang sudah ada data) |
| `tr_ba_kategori_d` | 0 (diisi runtime saat user submit BA) |

### Catatan Implementasi

7 kategori (`Fraud`, `Temuan Kasus`, `Indisipliner_Etika`, `Menolak_Tugas`, `Kriminal`, `Komplain_Customer`, `Kesalahan_Admin`) sengaja **tanpa opsi awal** — admin isi via UI master kategori nanti.

Foreign key cascading:
- Hapus BU → cascade hapus mapping
- Hapus kategori → cascade hapus mapping & opsi
- Hapus opsi → set null di pivot
- Hapus kategori dengan pivot aktif → RESTRICT (tidak bisa hapus)
