# Dokumentasi BA-PICA

Index dokumentasi project. Untuk overview project & stack, lihat [README.md di root](../README.md).

## Dokumen Utama

| File | Isi |
|---|---|
| [setup.md](setup.md) | Prasyarat, install PHP 8.2 portable, composer & npm install, konfigurasi `.env`. |
| [running.md](running.md) | Cara menjalankan PHP dev server, asset watcher, artisan maintenance. |
| [routes.md](routes.md) | Daftar route per modul (Berita Acara, PICA, Asasmen, SP, Rekrutmen, Master Data), API. |
| [database.md](database.md) | Schema database, konvensi penamaan tabel, relasi domain, daftar model. |
| [conventions.md](conventions.md) | Konvensi UI & coding: default date range, naming, query DB, PDF, frontend. |
| [caveats.md](caveats.md) | Hal yang harus diketahui (.env tercommit, PHP 8.3 inkompatibel, dll.) + troubleshooting. |
| [categories.md](categories.md) | 🟡 Working inventory — daftar Business Unit, kategori BA, opsi per kategori, dan mapping BU × kategori. |
| [ui-design.md](ui-design.md) | 🟡 Rancangan UI — Wizard (create) + Tab (edit) untuk Form BA, layout per step/tab, komponen yang dipakai. |

## Subfolder

### 📋 [tables/](tables/) — Schema per Domain
Dump kolom & tipe dari **DB produksi** (~174 tabel), dikelompokkan per domain.

| File | Tabel |
|---|---|
| [tables/berita-acara.md](tables/berita-acara.md) | 18 tabel BA |
| [tables/pica.md](tables/pica.md) | 6 tabel PICA |
| [tables/assessment.md](tables/assessment.md) | 21 tabel assessment |
| [tables/surat-peringatan.md](tables/surat-peringatan.md) | 4 tabel SP |
| [tables/rekrutmen.md](tables/rekrutmen.md) | 31 tabel rekrutmen |
| [tables/master-data.md](tables/master-data.md) | 26 tabel master |
| [tables/meeting.md](tables/meeting.md) | 6 tabel meeting |
| [tables/report-security.md](tables/report-security.md) | 28 tabel report/dashboard |
| [tables/sistem.md](tables/sistem.md) | 23 tabel sistem |
| [tables/erp.md](tables/erp.md) | 11 tabel di `tirt3038_ERP` |

### 🔄 [workflows/](workflows/) — Alur Bisnis per Modul
Dokumen alur step-by-step, role, status, tabel yang ter-update.

| File | Modul |
|---|---|
| [workflows/berita-acara.md](workflows/berita-acara.md) | Workflow BA dari draft → validasi multi-level → closed |
| [workflows/pica.md](workflows/pica.md) | Workflow PICA: identifikasi masalah → corrective + preventive action |
| [workflows/assessment.md](workflows/assessment.md) | Workflow penilaian karyawan periodik |
| [workflows/surat-peringatan.md](workflows/surat-peringatan.md) | Workflow SP disipliner |
| [workflows/rekrutmen.md](workflows/rekrutmen.md) | Workflow kandidat: intake → CV → panggilan → interview → shortlist |
| [workflows/login-company.md](workflows/login-company.md) | Workflow login mitra/anak perusahaan |

> Bagian workflow yang masih asumsi ditandai 🟡 ASUMSI — mohon di-validasi oleh tim HR/IT.
