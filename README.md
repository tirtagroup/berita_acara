# BA-PICA — Sistem Manajemen HR Tirta Group

Aplikasi web internal **PT Tirta Group** untuk pengelolaan **Berita Acara** (BA), **PICA** (Problem Identification & Corrective Action), **Assessment Karyawan**, **Surat Peringatan (SP)**, **Rekrutmen**, dan modul HR lainnya. Dibangun di atas Laravel 9 dengan template admin Sneat/Materio (Bootstrap 5).

---

## Dokumentasi

> **AI agent / Claude Code?** Mulai dari [CLAUDE.md](CLAUDE.md) — entry point dengan golden rules + peta dokumentasi.

| Topik | File |
|---|---|
| Setup & instalasi (PHP 8.2, composer, npm, .env) | [docs/setup.md](docs/setup.md) |
| Cara menjalankan aplikasi | [docs/running.md](docs/running.md) |
| Daftar route & modul fungsional | [docs/routes.md](docs/routes.md) |
| Skema database & relasi domain | [docs/database.md](docs/database.md) |
| **Schema per tabel** (~174 tabel, dump dari DB produksi) | [docs/tables/](docs/tables/) |
| **Alur bisnis per modul** (BA, PICA, Asasmen, SP, Rekrutmen) | [docs/workflows/](docs/workflows/) |
| **Kategori BA — konteks, opsi** (sistem actual) | [docs/categories.md](docs/categories.md) |
| **Glossary domain** (BA, PICA, konteks, dll.) | [docs/GLOSSARY.md](docs/GLOSSARY.md) |
| **Safety rails** (operasi yang JANGAN) | [docs/SAFETY.md](docs/SAFETY.md) |
| **Decision Records (ADR)** — kenapa kita pilih X | [docs/decisions/](docs/decisions/) |
| **Roadmap 12 bulan** | [docs/ROADMAP.md](docs/ROADMAP.md) |
| Konvensi UI & coding | [docs/conventions.md](docs/conventions.md) |
| Caveats & troubleshooting | [docs/caveats.md](docs/caveats.md) |

→ Lihat [docs/](docs/) untuk daftar lengkap + quick map modul.

---

## Quick Start

```powershell
# 1. Clone
git clone https://github.com/tirtagroup/berita_acara.git
cd berita_acara

# 2. Install dependency (butuh PHP 8.2 + Composer + Node 18+)
composer install
npm install

# 3. Buat folder storage (gitignored)
mkdir -p storage/framework/cache/data storage/framework/sessions `
         storage/framework/views storage/framework/testing `
         storage/app/public storage/logs bootstrap/cache

# 4. Konfigurasi .env (sudah ada di repo — sesuaikan DB_HOST)

# 5. Jalankan
php artisan serve --port=9876
npm run watch    # di terminal lain
```

Akses: **http://127.0.0.1:9876**

Detail lengkap → [docs/setup.md](docs/setup.md).

---

## Modul Utama

| Modul | Singkat | Controller / Catatan |
|---|---|---|
| **Berita Acara (Kejadian-Temuan)** | Pelaporan kejadian operasional general — 14 kategori (Pelanggaran SOP, Fraud, Logistik, Pelayanan, dll.) | `BeritaAcaraController` (62 route) |
| **Berita Acara — Laka** | Sub-modul khusus kecelakaan truk: form, dashboard, report tersendiri | Konteks `LAKA` di `ms_konteks` |
| **Berita Acara — Request Revisi** | Pengajuan revisi data/dokumen dengan **7-level approval** (Spv → HRD → MgrFin → MgrOps → GM → IT → BOD) | Konteks `REVISI`, route `/validasi_*` |
| **PICA** | Analisis akar masalah (RCA) + corrective/preventive action. v2 forum Q&A multi-participant | `Tr_PICA_Controller` + PICA v2 controllers |
| **Assessment** | Penilaian karyawan periodik: basic, leadership, kedisiplinan | `Tr_AssasmenController` (26 route) |
| **Surat Peringatan (SP)** | Workflow disipliner formal, 3 tingkat (SP 1/2/3) | `Tr_Sp_Controller`, `MS_Type_SP_Controller` |
| **Rekrutmen** | CV kandidat, interview, jadwal, jobportal, shortlist (31 tabel — domain terbesar selain BA) | `tr_candidateController`, `Report_HRD_Controller` |
| **Login per Perusahaan** | Multi-tenant login mitra/anak perusahaan, scoping data per company | `LoginCompanyController` (32 route) |
| **Permission System** | User Level × Panel × Permission Matrix — 4 tabel, admin UI di `/master/permission-matrix` | Commit f616af7 |
| **Help Center In-App** | Dokumentasi cara pakai aplikasi, inline help button "?" di 12 halaman utama | `ms_doc_workflow`, commit 91ce8e1 / f4579bf |
| **Master Data** | Company, Lokasi, Type SP, Sistem kategori BA (konteks/kategori/opsi), User Level, Panel | `MS_Company_Controller`, `MsLocationController`, dll. |
| **Report & PDF** | Laporan agregat + export PDF (mPDF + DomPDF) | `ReportController`, `PDFController` |

Detail per modul → [docs/routes.md](docs/routes.md). Quick map fungsi ke dokumen → [docs/README.md](docs/README.md#-modul-aplikasi--quick-map).

---

## Stack Teknologi

**Backend**: Laravel 9 · PHP 8.2 · Jetstream · Sanctum · Livewire · DomPDF · mPDF · Maatwebsite/Excel

**Frontend**: Bootstrap 5.2.3 (pinned) · Laravel Mix · jQuery + DataTables/Select2/Flatpickr · ApexCharts · SweetAlert2

**Database**: MySQL (2 koneksi: `mysql` untuk worksheet, `mysql_new` untuk ERP)

---

## ⚠️ Penting

- File `.env` ter-commit ke repo dengan kredensial asli — perlu rotasi & gitignore. [Detail](docs/caveats.md#env-ter-commit-di-repo)
- PHP 8.3 tidak kompatibel — pakai 8.2. [Detail](docs/caveats.md#php-83-tidak-kompatibel)
- Bootstrap di-pin 5.2.3 — jangan upgrade. [Detail](docs/caveats.md#bootstrap-pin-di-523)
- Migration minim — schema bisnis ada di DB produksi, tidak di repo. [Detail](docs/database.md#-catatan-penting)
- **Sebelum operasi berisiko (migration prod, DROP/TRUNCATE, force push)** — baca [docs/SAFETY.md](docs/SAFETY.md).

---

## Repository

https://github.com/tirtagroup/berita_acara
