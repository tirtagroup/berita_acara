# Dokumentasi BA-PICA

Index dokumentasi project. Untuk overview project & stack, lihat [README.md di root](../README.md).

> **AI agent?** Mulai dari [CLAUDE.md di root](../CLAUDE.md) — entry point khusus untuk Claude Code, Cursor, dll.

## Dokumen Utama

| File | Isi |
|---|---|
| [setup.md](setup.md) | Prasyarat, install PHP 8.2 portable, composer & npm install, konfigurasi `.env`. |
| [running.md](running.md) | Cara menjalankan PHP dev server, asset watcher, artisan maintenance. |
| [routes.md](routes.md) | Daftar route per modul (Berita Acara, PICA, Asasmen, SP, Rekrutmen, Master Data), API. |
| [database.md](database.md) | Schema database, konvensi penamaan tabel, relasi domain, daftar model. |
| [conventions.md](conventions.md) | Konvensi UI & coding: default date range, naming, query DB, PDF, frontend. |
| [caveats.md](caveats.md) | Hal yang harus diketahui (.env tercommit, PHP 8.3 inkompatibel, dll.) + troubleshooting. |
| **[SAFETY.md](SAFETY.md)** | 🛑 Operasi yang TIDAK BOLEH tanpa konfirmasi + dangerous patterns + sensitive areas. |
| **[GLOSSARY.md](GLOSSARY.md)** | Istilah domain Tirta: BA, PICA, konteks, pelaku, dewan, dll. |
| [categories.md](categories.md) | ✅ Sistem kategori BA — konteks, kategori, opsi (verifikasi via `docs:check-schema`). |
| [ui-design.md](ui-design.md) | 🟡 Rancangan UI — Wizard (create) + Tab (edit) untuk Form BA, layout per step/tab, komponen yang dipakai. |
| **[ROADMAP.md](ROADMAP.md)** | Roadmap 12 bulan (Juni 2026 – Mei 2027). |
| **[decisions/](decisions/)** | Architecture Decision Records (ADR) — kenapa kita pilih X. |

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

---

## 🎯 Modul Aplikasi — Quick Map

Lihat fungsi apa di docs mana:

| Modul | Workflow | Schema | ADR / Notes |
|---|---|---|---|
| **Berita Acara — general** (Kejadian-Temuan) | [workflows/berita-acara.md](workflows/berita-acara.md) | [tables/berita-acara.md](tables/berita-acara.md) | [ADR-001](decisions/001-ba-multi-kategori-pivot.md), [ADR-006](decisions/006-konteks-renamed-from-bu.md) |
| **Laka** (BA truk) | (sub-workflow BA) | tables/berita-acara | Konteks `LAKA` di [categories.md](categories.md) |
| **Request Revisi** (7-level approval) | (sub-workflow BA) | tables/berita-acara | Approval chain di [GLOSSARY §B](GLOSSARY.md) |
| **PICA** v2 + legacy | [workflows/pica.md](workflows/pica.md) | [tables/pica.md](tables/pica.md) | [ADR-002](decisions/002-pica-v2-design.md) |
| **SP (Surat Peringatan)** SP 1/2/3 | [workflows/surat-peringatan.md](workflows/surat-peringatan.md) | [tables/surat-peringatan.md](tables/surat-peringatan.md) | [GLOSSARY §J](GLOSSARY.md) |
| **Assessment** | [workflows/assessment.md](workflows/assessment.md) | [tables/assessment.md](tables/assessment.md) | — |
| **Rekrutmen** (kandidat → shortlist) | [workflows/rekrutmen.md](workflows/rekrutmen.md) | [tables/rekrutmen.md](tables/rekrutmen.md) | 31 tabel — domain terbesar selain BA |
| **Login Company** (multi-tenant) | [workflows/login-company.md](workflows/login-company.md) | tables/master-data | 32 route, scoping `rec_comcode`/`rec_areacode` |
| **Permission System** | (admin UI di `/master/permission-matrix`) | tables/master-data | 4 tabel, [GLOSSARY §G](GLOSSARY.md), commit f616af7 |
| **Help Center In-App** | (admin UI di `/master/doc-workflow`) | `ms_doc_workflow` | Inline help button di 12 page, commit 91ce8e1, f4579bf |
| **Master Kategori BA** (baru) | — | [categories.md](categories.md) | [ADR-006](decisions/006-konteks-renamed-from-bu.md) |
| **SOP** (future) | — | — | [ADR-003](decisions/003-sop-module-tier2.md), Phase 2 |
| **Scheduling Resto** (future) | — | — | [ADR-005](decisions/005-scheduling-resto-phase3.md), Phase 3 |
| **AI Augmentation** (parked) | — | — | [ADR-004](decisions/004-ai-workstream-parked.md) |

---

## 🛠️ Tooling Dokumentasi

| Command | Fungsi |
|---|---|
| `php artisan docs:check-schema` | Verifikasi `docs/categories.md` vs schema DB actual. Flag drift. |
