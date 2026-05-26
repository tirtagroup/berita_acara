# Glossary — Istilah Tirta & BA-PICA

Definisi terpusat istilah domain BA-PICA. AI agent: gunakan ini sebagai source-of-truth saat ketemu istilah unfamiliar.

---

## A. Modul & Konsep Utama

### BA — Berita Acara
Laporan formal kejadian internal. Header tabel: **`Tr_Ba_Main_New`** (suffix `_New` karena ada versi lama yang sudah deprecated). Workflow: draft → validasi multi-level → closed. Lihat [workflows/berita-acara.md](workflows/berita-acara.md).

### PICA — Problem Identification & Corrective Action
Modul root-cause analysis collaborative. PICA bisa **standalone** atau **tindak-lanjut BA** (`ba_link_code` nullable). Workflow v4: **DRAFT → PREPARING → MEETING → FINALIZED → DONE**. Lihat [workflows/pica.md](workflows/pica.md) + [ADR-002](decisions/002-pica-v2-design.md).

### SP — Surat Peringatan
Workflow disipliner formal (peringatan resmi ke karyawan). Tabel di `tables/surat-peringatan.md`.

### Assessment
Penilaian karyawan periodik (basic, leadership, kedisiplinan). Tabel di `tables/assessment.md`.

### Rekrutmen
CV kandidat, interview, jadwal, jobportal, shortlist. Workflow: intake → CV → panggilan → interview → shortlist. 31 tabel domain.

### Laka
Sub-modul BA khusus untuk **kecelakaan kendaraan operasional** (truk). Punya form input, dashboard, dan report tersendiri (`/ba_laka`, `/dashboard_ba_laka`, `/report_laka`). Konteks utama: `LAKA` di `ms_konteks`.

### Request Revisi
BA standalone untuk **permintaan revisi data/dokumen** — bukan kejadian operasional, tapi pengajuan formal yang butuh approval. Konteks: `REVISI` di `ms_konteks`. Punya **workflow approval 7-level berurutan** (lihat §B).

### Kejadian-Temuan
Sub-modul BA general untuk pelaporan kejadian / temuan operasional di luar laka & revisi. Endpoint utama `/input_berita_acara_spv`, `/dashboard_ba`, `/action_temuan`.

### SOP (future, lihat ADR-003)
**S**tandard **O**perating **P**rocedure module. **Belum diimplementasi**, target Phase 2 roadmap (Aug–Okt 2026). Tier 2 standalone (viewer + lifecycle + versioning + ack). Lihat [ADR-003](decisions/003-sop-module-tier2.md).

### Scheduling Resto (future, lihat ADR-005)
Modul jadwal staff restoran. **Belum diimplementasi**, target Phase 3 (Nov 2026–Feb 2027). T1 (roster) + T3 (clock-in/out + auto-trigger BA Disiplin). Lihat [ADR-005](decisions/005-scheduling-resto-phase3.md).

---

## B. Role & Aktor

### Pelaku
Orang yang menjadi **subjek** BA atau PICA. Pegawai yang dilaporkan/diaudit. Kolom: `Ms_Emp_Code` (di BA), `pelaku_emp_code` (di PICA).

### Pelapor
Orang yang **submit** BA. Kolom: `Ms_Pelapor_Code`.

### PIC PICA
**Person In Charge** PICA tertentu. Creator + facilitator PICA. **Per-PICA, bukan role global** — siapa pun yang create PICA jadi PIC-nya. Lihat [ADR-002](decisions/002-pica-v2-design.md) rule 1.

### Dewan
Reviewer panel PICA — multiple orang (N), dipilih oleh PIC saat wizard. Bisa add komentar/pertanyaan di Q&A forum. Lihat [ADR-002](decisions/002-pica-v2-design.md) rule 2.

### Mentor
Pegawai senior yang membimbing pelaku (di konteks BA). Optional role.

### Approval Chain (Request Revisi) — 7 level
Workflow approval berurutan untuk Request Revisi:
1. **Supervisor** (`/validasi_ba`) — atasan langsung pelapor
2. **HRD** (`/validasi_ba2`)
3. **Manager Finance** (`/validasi_ba3`)
4. **Manager Operasional** (`/validasi_manager`)
5. **General Manager / GM** (`/validasi_gm`)
6. **IT** (`/validasi_it`)
7. **BOD** (Board of Directors, `/validasi_bod`)

Setiap level harus approve dulu sebelum naik ke level berikutnya. Reject di level mana pun mengembalikan ke pelapor.

---

## C. Sistem Kategori BA (CRITICAL — schema actual ≠ migration awal)

### Konteks (sebelumnya "Business Unit")
**Scope tagging** untuk kategori BA. Tabel: `ms_konteks` (renamed dari `ms_business_unit`). 5 row saat ini:
| ID | Kode | Untuk |
|---|---|---|
| 1 | LAKA | LAKA Truck — kecelakaan kendaraan operasional |
| 2 | FNB | Food & Beverage — gerai/restoran |
| 3 | OP_HR | Operation / HR — kantor pusat |
| 4 | REVISI | Permintaan Revisi (standalone) |
| 5 | FMCG | Fast-Moving Consumer Goods |

Lihat [ADR-006](decisions/006-konteks-renamed-from-bu.md) untuk konteks rename history.

### Kategori
Klasifikasi tipe kejadian BA. Tabel: `ms_ba_kategori`. 14 kategori saat ini (Laka Penyebab, Pelanggaran SOP, Fraud, Temuan Kasus, Indisipliner/Etika, Menolak Tugas, Kerusakan/Kehilangan, Kriminal, Komplain Customer, Kesalahan Admin, Logistik, Kualitas Makanan, Pelayanan, Disiplin Operasional). Detail di [categories.md](categories.md).

### Opsi (Sub-kategori / Kasus)
Pilihan konkret dalam suatu kategori. Tabel: **`ms_ba_kategori_opsi` (global, `deskripsi` UNIQUE)**. Opsi yang sama bisa di-share antar kategori (mis. "None", "Salah kirim", "Salah order"). 42+ opsi saat ini.

### Junction tables (CRITICAL)
- **`ms_kategori_opsi_mapping`** — kategori × opsi (N:N, dengan `kode` + `sort_order` per kategori).
- **`ms_konteks_kategori_mapping`** — konteks × kategori (**boolean**: row present = available di konteks itu). Kolom `level` ENUM dulu ada, di-drop per [ADR-008](decisions/008-drop-konteks-kategori-level.md).
- **`ms_opsi_konteks_mapping`** — opsi × konteks (filter opsi tertentu hanya muncul di konteks tertentu).

⚠️ Migration awal `2026_05_19_200000_create_ba_kategori_system.php` **tidak match** dengan schema actual. Selalu query DB sebelum trust docs. Run `php artisan docs:check-schema`.

### Visibility Kategori per Konteks (boolean)
Di `ms_konteks_kategori_mapping`:
- **Row ada** — kategori muncul di form BA untuk konteks itu (opsional, user pilih bebas)
- **Row tidak ada** — kategori hidden di form BA untuk konteks itu

> 📌 **History**: dulu ada kolom `level` ENUM(wajib/disarankan/opsional) yang me-define behavior auto-check & UX highlight. Di-drop per [ADR-008](decisions/008-drop-konteks-kategori-level.md) (2026-05-25). Sekarang semua kategori yang muncul = opsional. Kalau perlu enforce "wajib pilih kategori X di konteks Y", pakai validasi bisnis di app layer, bukan di mapping.

---

## D. BA — Konsep Internal

### Kronologi
Narrative event di BA (timeline kejadian). Tabel: **`tr_ba_kronologi`**.
⚠️ **Kolom legacy typo**: nama kolomnya `kronlogi` (BUKAN `kronologi`). Jangan rename — banyak query existing pakai nama lama. Reference: commit 148608c.

### Cek\* flags (legacy)
Boolean kolom di `Tr_Ba_Main_New`: `CekPelanggaran`, `CekKerusakan`, `CekFraud`, `CekRevisi`, `CekDisiplin`, `CekSalahIsi`, `CekNoClosing`, `CekLaka`, `CekPembelian`, `CekKehilangan`, `CekPerubahanSOP`. **Akan deprecated** setelah BA multi-kategori migration ([ADR-001](decisions/001-ba-multi-kategori-pivot.md)) — diganti pivot tables.

### Tr_BA_Comment
Komentar / diskusi pada BA. Tracking siapa sudah lihat BA.

### Date_BA vs created_at
- `Date_BA` — tanggal kejadian sebenarnya (manual input pelapor)
- `created_at` — timestamp record dibuat di sistem

### Tr_BA_Main_Code
Primary key BA (string, format Tirta). Cross-reference dari PICA via `ba_link_code`.

---

## E. PICA — Konsep Internal

### Item types
Per [ADR-002](decisions/002-pica-v2-design.md) rule 5:
- **Pertanyaan** — dijawab dengan text bebas
- **Pernyataan** — di-ack dengan Setuju/Tidak Setuju + reasoning

### Sources pertanyaan
Per [ADR-002](decisions/002-pica-v2-design.md) rule 6:
- **`wajib_universal`** — master, auto-include semua PICA
- **`bantuan`** — master, PIC pilih saat wizard
- **`bebas`** — ad-hoc, semua participant boleh tambah selama PREPARING/discussion

### wajib_jawab (flag)
Tanda di item PICA bahwa pelaku **WAJIB jawab** sebelum PICA bisa CLOSED. Default ON untuk `wajib_universal`, opsional untuk yang lain. Hanya PIC yang bisa override.

### is_final (flag jawaban)
Tanda bahwa jawaban pelaku sudah final (bukan draft). Hanya bisa di-set saat status `WAITING_PELAKU`. Locked dari edit setelah `signed_at`.

### Workflow status (v4, lihat [ADR-002](decisions/002-pica-v2-design.md))
- **DRAFT** — wizard belum selesai
- **PREPARING** — "PICA Plan" — persiapan asynchronous. PIC siapkan agenda + pertanyaan; Dewan bantu; Pelaku siapkan draft jawaban
- **MEETING** — live meeting (fisik / WA call / video). 3 tab: Q&A Forum, Catatan Meeting, Pernyataan Pelaku
- **FINALIZED** — post-meeting, susun corrective + preventive action
- **DONE** — closed permanent, read-only kecuali admin DB

(Naming lama: ACTION_PLANNING → FINALIZED; CLOSED → DONE.)

### Hasil Meeting
Kolom `Tr_PICA_Emp_h.hasil_meeting_pic` — diisi PIC saat MEETING. Wajib untuk gate ke FINALIZED.

### Catatan Pelaku
Kolom `Tr_PICA_Emp_h.catatan_pelaku` — paralel dengan hasil meeting PIC, diisi pelaku independen.

### Pernyataan Pelaku
Formal statement pelaku, ditandatangani digital (`pernyataan_signed_at` + `signed_by`). Lock dari edit setelah signed (kecuali PIC unlock emergency).

### Corrective vs Preventive Action
- **Corrective** (`Tr_PICA_Action`) — apa yang dilakukan untuk fix incident yang sudah terjadi
- **Preventive** (`Tr_PICA_Preventive_Action`) — apa yang dilakukan supaya tidak terulang di future

---

## F. Tabel Konvensi

### Prefix nama
- **`Ms_*` / `ms_*`** — master data (referensi tetap)
- **`Tr_*` / `tr_*`** — transactional (data operasional)

### Suffix `_h` + `_d`
Master-detail pair. `*_h` = header (1 row per entity), `*_d` = detail (N row per header).

### Suffix `_New`
Tabel hasil rewrite/upgrade dari versi lama. Contoh: `Tr_Ba_Main_New` (ada `Tr_Ba_Main` versi lama yang sudah tidak dipakai).

---

## G. Permission & Identity

### Ms_User
Master user table.

### Ms_Emp / master_employees
Master karyawan. `Ms_Emp_Code` = primary identifier karyawan. `Ms_Emp_Div` = divisi.

### rec_comcode, rec_areacode
Tags per row: company code & area code. Filter scoping multi-tenant.

### Multi-company (Login per Perusahaan / LoginCompany)
Login terpisah untuk mitra/anak perusahaan. Controller: `LoginCompanyController` (32 route — domain terbesar setelah BA). Workflow di [workflows/login-company.md](workflows/login-company.md). Dashboard per-company dengan scoping data via `rec_comcode`/`rec_areacode`.

### User Level
Komponen permission system (commit f616af7). Klasifikasi role user (mis. supervisor, HRD, manager, dll.). Master tabel: `ms_user_level` (di `tables/master-data.md`).

### Panel
Komponen permission system. Mewakili unit akses fungsional di aplikasi (mis. "BA Dashboard", "PICA Wizard", "SP Approval"). Master tabel: `ms_panel`.

### Permission Matrix
UI admin di `/master/permission-matrix` untuk konfigurasi mapping **User Level × Panel** (siapa boleh akses panel apa). Salah satu dari 4 tabel permission system.

---

## H. Help Center & Documentation In-App

### ms_doc_workflow
Tabel master untuk help center in-app (commit 91ce8e1). Setiap halaman utama punya inline help button yang link ke entry di tabel ini. CRUD admin di `/master/doc-workflow`.

### Inline Help Button
Tombol "?" di 12 halaman BA + PICA + Master (commit f4579bf). Otomatis lookup ke `ms_doc_workflow` by page slug.

---

## J. SP (Surat Peringatan)

### SP 1 / SP 2 / SP 3
Eskalasi tingkat surat peringatan disipliner formal:
- **SP 1** — Peringatan pertama (paling ringan)
- **SP 2** — Eskalasi kedua
- **SP 3** — Peringatan terakhir, biasanya prelude ke PHK

Workflow di [workflows/surat-peringatan.md](workflows/surat-peringatan.md).

### Type SP
Master data jenis-jenis SP yang berlaku di Tirta. Master tabel `ms_type_sp`. CRUD di `/sp/master_type`. Controller: `MS_Type_SP_Controller`.

### SP vs BA
- **BA** = laporan kejadian (factual record)
- **SP** = sanksi disipliner formal (consequence)
- Satu BA bisa berujung pada SP (atau tidak), tapi keduanya **modul terpisah** dengan workflow & dokumentasi sendiri.

---

## K. Database Connections

### `mysql` (Default)
Connection utama, database `tirt3038_HR_Worksheet`. Berisi **mayoritas tabel modul**: BA, PICA, SP, Assessment, Rekrutmen, Master kategori, Permission, dll. Most controller pakai `DB::connection('mysql')` atau default.

### `mysql_new` (Secondary)
Connection ke database `tirt3038_ERP`. Berisi **data master ERP/HR core** (mis. master karyawan global, struktur organisasi). 11 tabel dokumentasi di `tables/erp.md`.

### Cross-connection
Banyak query agregat join dari `mysql` ke `mysql_new` — selalu sebutkan connection eksplisit kalau cross-DB. Lihat [conventions.md#4-query-database](conventions.md#4-query-database).

---

## I. Glossary Quick Lookup

| Istilah | Ringkasan | Detail |
|---|---|---|
| BA | Berita Acara | §A |
| PICA | Problem ID + Corrective Action | §A |
| SP | Surat Peringatan | §A |
| Laka | BA khusus kecelakaan truk | §A |
| Request Revisi | BA standalone untuk minta revisi data | §A |
| Kejadian-Temuan | BA general (non-laka, non-revisi) | §A |
| Pelaku | Subjek BA/PICA | §B |
| Pelapor | Submitter BA | §B |
| PIC PICA | Per-PICA facilitator | §B |
| Dewan | PICA reviewer panel | §B |
| Approval Chain | 7-level approval Request Revisi (Spv→HRD→MgrFin→MgrOps→GM→IT→BOD) | §B |
| Konteks | Scope kategori (LAKA/FNB/OP_HR/REVISI/FMCG) | §C |
| Kategori | Tipe kejadian (14) | §C |
| Opsi | Sub-kategori konkret | §C |
| ~~W/D/O~~ | ~~Wajib/Disarankan/Opsional level~~ (dropped per [ADR-008](decisions/008-drop-konteks-kategori-level.md)) | §C |
| Kronologi | Narrative event BA (kolom `kronlogi` typo) | §D |
| Cek* | Legacy boolean flags BA | §D |
| wajib_jawab | PICA item must-answer flag | §E |
| is_final | PICA jawaban final flag | §E |
| DRAFT/PREPARING/MEETING/FINALIZED/DONE | PICA v4 workflow | §E |
| Corrective/Preventive | PICA action types | §E |
| Ms_*/Tr_* | Master / Transactional table prefix | §F |
| *_h/_d | Header / Detail table pair | §F |
| _New suffix | Rewrite versi baru | §F |
| User Level | Klasifikasi role user (permission system) | §G |
| Panel | Unit akses fungsional (permission system) | §G |
| Permission Matrix | UI mapping User Level × Panel | §G |
| Login Company | Multi-tenant login mitra (32 route) | §G |
| SP 1/2/3 | Eskalasi tingkat surat peringatan | §J |
| Type SP | Master jenis SP | §J |
| mysql / mysql_new | DB connection HR Worksheet vs ERP | §K |
