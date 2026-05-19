# BA-PICA — Sistem Manajemen HR Tirta Group

Aplikasi web internal **PT Tirta Group** untuk pengelolaan **Berita Acara** (BA), **PICA** (Problem Identification & Corrective Action), **Assessment Karyawan**, **Surat Peringatan (SP)**, **Rekrutmen**, dan modul HR lainnya. Dibangun di atas Laravel 9 dengan template admin Sneat/Materio (Bootstrap 5).

---

## Dokumentasi

| Topik | File |
|---|---|
| Setup & instalasi (PHP 8.2, composer, npm, .env) | [docs/setup.md](docs/setup.md) |
| Cara menjalankan aplikasi | [docs/running.md](docs/running.md) |
| Daftar route & modul fungsional | [docs/routes.md](docs/routes.md) |
| Skema database & relasi domain | [docs/database.md](docs/database.md) |
| **Schema per tabel** (~174 tabel, dump dari DB produksi) | [docs/tables/](docs/tables/) |
| **Alur bisnis per modul** (BA, PICA, Asasmen, SP, Rekrutmen) | [docs/workflows/](docs/workflows/) |
| **Kategori BA & mapping BU** (working inventory) | [docs/categories.md](docs/categories.md) |
| Konvensi UI & coding | [docs/conventions.md](docs/conventions.md) |
| Caveats & troubleshooting | [docs/caveats.md](docs/caveats.md) |

→ Lihat [docs/](docs/) untuk daftar lengkap.

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

| Modul | Singkat | Controller |
|---|---|---|
| **Berita Acara** | Pelaporan kejadian internal — termasuk kecelakaan kerja (laka), validasi multi-level | `BeritaAcaraController` (62 route) |
| **PICA** | Analisis akar masalah & tindakan korektif/preventif | `Tr_PICA_Controller` |
| **Assessment** | Penilaian karyawan periodik: basic, leadership, kedisiplinan | `Tr_AssasmenController` (26 route) |
| **Surat Peringatan** | Workflow disipliner | `Tr_Sp_Controller`, `MS_Type_SP_Controller` |
| **Rekrutmen** | CV kandidat, interview, jadwal, jobportal, shortlist | `tr_candidateController`, `Report_HRD_Controller` |
| **Login per Perusahaan** | Dashboard mitra/anak perusahaan | `LoginCompanyController` (32 route) |
| **Master Data** | Company, Location, Divisi, Kategori BA, Jenis Kasus | `MS_Company_Controller`, `MsLocationController`, dll. |
| **Report & PDF** | Laporan agregat + export PDF | `ReportController`, `PDFController` |

Detail per modul → [docs/routes.md](docs/routes.md).

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

---

## Repository

https://github.com/tirtagroup/berita_acara
