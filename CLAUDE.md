# CLAUDE.md — AI Agent Entry Point

**Project**: BA-PICA — Aplikasi web internal PT Tirta Group untuk Berita Acara, PICA (Problem Identification & Corrective Action), Assessment, SP, Rekrutmen, dan modul HR lainnya.
**Stack**: Laravel 9 · PHP 8.2 (jangan 8.3 — lihat [caveats](docs/caveats.md#php-83-tidak-kompatibel)) · Bootstrap 5.2.3 (pinned) · Laravel Mix · MySQL (2 koneksi).
**Status**: Production daily-ops tool. Treat `.env` `DB_HOST=absensi.tirtagroup.net` as **LIVE DATA**.

> Untuk human onboarding, mulai dari [README.md](README.md). Dokumen ini ditulis untuk AI agent (Claude Code, Cursor, dll).

---

## 🛑 Golden Rules (BACA SEBELUM EKSEKUSI APA PUN)

1. **JANGAN jalankan migration/seed ke production DB tanpa konfirmasi user eksplisit.** `DB_HOST=absensi.tirtagroup.net` = LIVE. Setiap `php artisan migrate`, `db:seed`, `tinker → DB::insert/update/delete` di environment ini menyentuh data Tirta yang sebenarnya.
2. **JANGAN edit `.env`**. File ini ter-commit ke repo dan berisi kredensial produksi. Sentuh hanya kalau user instruksi spesifik.
3. **JANGAN DROP/TRUNCATE tabel atau ALTER kolom existing** tanpa cek `docs/tables/` dulu dan minta konfirmasi. Schema bisnis ada di DB produksi, **tidak fully di-mirror di migrations folder**.
4. **JANGAN force push, git reset --hard, atau git checkout --** tanpa user instruksi eksplisit. Lihat [SAFETY.md](docs/SAFETY.md).
5. **JANGAN bypass hooks** (`--no-verify`, `--no-gpg-sign`). Investigasi root cause kalau hook gagal.
6. **JANGAN tambah dependency npm/composer** tanpa user setuju — beberapa pinned (Bootstrap 5.2.3, PHP 8.2) karena alasan kompatibilitas.
7. **SELALU pakai pola plan-then-confirm** untuk perubahan menulis: kasih plan singkat → minta konfirmasi user → eksekusi. (User preference, tercatat di memory.)
8. **SELALU pakai prepared statement** (`?` + bindings) untuk SQL baru. Existing code banyak yang masih string interpolation — jangan tiru. [Detail](docs/conventions.md#4-query-database).
9. **SELALU cek `docs/caveats.md` + `docs/SAFETY.md` sebelum kerja di area existing**.
10. **VERIFY sebelum trust docs**: schema docs bisa drift. Run `php artisan docs:check-schema` atau query DB langsung sebelum claim "table X punya kolom Y".

---

## 🗺️ Peta Dokumentasi

| Topik | File | Untuk |
|---|---|---|
| **Domain glossary** (istilah Tirta) | [docs/GLOSSARY.md](docs/GLOSSARY.md) | Selalu konsultasi saat ketemu istilah BA, PICA, konteks, pelaku, dewan, dll. |
| **Safety rails** (apa yang JANGAN) | [docs/SAFETY.md](docs/SAFETY.md) | Sebelum operasi berisiko |
| Konvensi code (naming, SQL, frontend) | [docs/conventions.md](docs/conventions.md) | Saat tulis code baru |
| Caveats + troubleshooting | [docs/caveats.md](docs/caveats.md) | Saat ketemu error atau quirk |
| Setup environment | [docs/setup.md](docs/setup.md) | Saat onboarding/install |
| Cara menjalankan | [docs/running.md](docs/running.md) | `artisan serve`, `npm run watch`, dll |
| Daftar route per modul | [docs/routes.md](docs/routes.md) | Cari endpoint |
| Skema DB overview | [docs/database.md](docs/database.md) | Konvensi DB, relasi |
| Schema per tabel (174 tabel) | [docs/tables/](docs/tables/) | Reference detail tabel |
| Alur bisnis per modul | [docs/workflows/](docs/workflows/) | Memahami flow BA/PICA/SP/dll. |
| **Kategori BA** | [docs/categories.md](docs/categories.md) | **Verifikasi dengan `docs:check-schema` sebelum trust** |
| **Decision Records (ADR)** | [docs/decisions/](docs/decisions/) | Konteks "kenapa kita pilih X" |
| Roadmap 12 bulan | [docs/ROADMAP.md](docs/ROADMAP.md) | Initiative & prioritas |
| UI design pattern | [docs/ui-design.md](docs/ui-design.md) | Saat bikin/edit form |

---

## 🎯 Task Routing

Saat user minta kerja di area X, dokumen yang **wajib dibaca** sebelum eksekusi:

| Kerja di… | Wajib baca |
|---|---|
| **Modul BA (umum)** | `docs/workflows/berita-acara.md` + `docs/tables/berita-acara.md` + `docs/categories.md` + [ADR-001](docs/decisions/001-ba-multi-kategori-pivot.md) + [ADR-006](docs/decisions/006-konteks-renamed-from-bu.md) |
| **Sub-modul Laka** (truk) | BA docs di atas + konteks `LAKA` di `docs/categories.md`. Controller route `/ba_laka`, `/dashboard_ba_laka`, `/report_laka` |
| **Sub-modul Request Revisi** (7-level approval) | BA docs + GLOSSARY §B "Approval Chain" + routes `/validasi_*` (7 endpoint). Konteks `REVISI` |
| **Modul PICA** | `docs/workflows/pica.md` + `docs/tables/pica.md` + [ADR-002](docs/decisions/002-pica-v2-design.md) |
| **Modul SP (Surat Peringatan)** | `docs/workflows/surat-peringatan.md` + `docs/tables/surat-peringatan.md`. SP 1/2/3 eskalasi, master di `ms_type_sp` |
| **Modul Assessment** | `docs/workflows/assessment.md` + `docs/tables/assessment.md` (21 tabel) |
| **Modul Rekrutmen** | `docs/workflows/rekrutmen.md` + `docs/tables/rekrutmen.md` (31 tabel, domain terbesar selain BA) |
| **Modul Login Company** (multi-tenant) | `docs/workflows/login-company.md` (`LoginCompanyController`, 32 route). Scoping via `rec_comcode`/`rec_areacode` |
| **Permission System** | `docs/tables/master-data.md` + GLOSSARY §G (User Level × Panel × Permission Matrix, 4 tabel). Commit f616af7 |
| **Help / dokumentasi in-app** | `ms_doc_workflow` tabel + inline help button (12 page). Commit 91ce8e1, f4579bf |
| **Modul SOP** (future) | `docs/ROADMAP.md` Phase 2 + [ADR-003](docs/decisions/003-sop-module-tier2.md) |
| **FnB Scheduling Resto** (design phase, target Phase 3) | [docs/fnb-scheduling/](docs/fnb-scheduling/) (README → workflow → schema → permissions → open-questions) + [ADR-005](docs/decisions/005-scheduling-resto-phase3.md) + [ADR-007](docs/decisions/007-fnb-scheduling-staff-source.md). **Naming**: `ms_fnb_*` / `tr_fnb_*` (DB), `fnb.*` (code/route/permission) — lihat [conventions.md §10](docs/conventions.md#10-domain-prefix-naming-fnb-dst) |
| **Modul FnB lain** (resep, inventory, dll. — future) | Wajib baca [conventions.md §10 Domain Prefix](docs/conventions.md#10-domain-prefix-naming-fnb-dst) untuk naming `ms_fnb_*` / `fnb.*` |
| **AI feature** | [ADR-004](docs/decisions/004-ai-workstream-parked.md) — **TIDAK BOLEH commit AI feature** sebelum compliance clearance |
| **Migration / schema** | `docs/database.md` + `docs/tables/` + `docs/caveats.md#db-produksi--live-data` + `docs/SAFETY.md` |
| **Route baru** | `docs/routes.md` + `docs/conventions.md#2-struktur-controller` |
| **Filter tanggal di UI** | `docs/conventions.md#1-default-date-range` — DEFAULT: awal bulan → hari ini |
| **Kategori BA / opsi** | `docs/categories.md` + `php artisan docs:check-schema` untuk verify |
| **Cross-DB query** (`mysql` ↔ `mysql_new`) | GLOSSARY §K + `docs/conventions.md#4-query-database`. Selalu sebut connection eksplisit |

---

## ⚡ Common Commands

```powershell
# Run server (port 8000 sering kena blok di Windows, pakai 9876+)
php artisan serve --port=9876

# Asset watcher (Laravel Mix, bukan Vite)
npm run watch

# Tinker untuk query exploratif
php artisan tinker

# Verifikasi schema docs vs actual DB (custom command)
php artisan docs:check-schema

# Clear cache setelah edit config/env
php artisan config:clear
php artisan view:clear
php artisan route:clear

# List routes
php artisan route:list | findstr <pattern>
```

---

## 🔑 Domain Quick Reference

Definisi lengkap di [docs/GLOSSARY.md](docs/GLOSSARY.md). Ringkasan:

- **BA** (Berita Acara) — laporan formal kejadian. Header tabel: `Tr_Ba_Main_New` (`_New` karena ada versi lama). 3 sub-modul: **Kejadian-Temuan** (general), **Laka** (truk), **Request Revisi** (standalone, 7-level approval).
- **PICA** — Problem Identification & Corrective Action. RCA collaborative.
- **SP** — Surat Peringatan disipliner formal, 3 tingkat (SP 1/2/3). Berbeda dari BA.
- **Konteks** (dulu "Business Unit") — scope kategori BA: LAKA, FNB, OP_HR, REVISI, FMCG. Lihat [ADR-006](docs/decisions/006-konteks-renamed-from-bu.md).
- **Pelaku** — subjek BA/PICA (orang yang dilaporkan).
- **Pelapor** — orang yang submit BA.
- **PIC PICA** — creator + facilitator PICA (per-PICA, bukan role global).
- **Dewan** — reviewer panel PICA (N orang, dipilih PIC).
- **Approval Chain** (Request Revisi) — 7-level berurutan: Supervisor → HRD → Manager Finance → Manager Operasional → GM → IT → BOD.
- **Login Company** — login multi-tenant untuk mitra/anak perusahaan (`LoginCompanyController`, 32 route).
- **Permission System** — 4 tabel: User Level × Panel × Permission Matrix + user-level mapping. Commit f616af7.
- **Cek\* flags** — boolean legacy di `Tr_Ba_Main_New` (CekFraud, CekLaka, dll). **Akan deprecated** setelah BA multi-kategori migration ([ADR-001](docs/decisions/001-ba-multi-kategori-pivot.md)).
- **2 DB connections**: `mysql` (HR Worksheet, modul utama) + `mysql_new` (ERP, master karyawan global).

---

## 🧠 Memory (Persistent, Cross-Conversation)

User punya memory system di `C:\Users\user\.claude\projects\c--ProjectSoftwareCWU-BA-PICA\memory\`. Beberapa entry penting yang AI agent **wajib hormati**:

- **plan-then-confirm**: selalu kasih plan singkat & minta konfirmasi user sebelum eksekusi yang menulis/mengubah.
- **default date-range UI**: filter tanggal default awal bulan → hari ini.
- **BA multi-kategori**: BA bisa multi-kategori/jenis/kasus setara. Saat tambah feature BA, design untuk multi-relasi.
- **PICA v2 design**: PICA = forum Q&A multi-participant. Pelaku **wajib jawab** sebelum CLOSED.

Detail full → `MEMORY.md` di memory directory.

---

## 🚨 Recently Important

- **2026-05-24**: Roadmap 12 bulan disusun ([docs/ROADMAP.md](docs/ROADMAP.md)).
- **2026-05-25**: Skema kategori BA actual ≠ migration awal — gunakan `ms_konteks` + junction tables (`ms_kategori_opsi_mapping`, `ms_opsi_konteks_mapping`), bukan `ms_business_unit` + per-kategori tables. Lihat [ADR-006](docs/decisions/006-konteks-renamed-from-bu.md).
- **2026-05-25**: Scheduling Resto module di-add ke Phase 3 roadmap. Auto-trigger BA Disiplin saat clock-in telat. [ADR-005](docs/decisions/005-scheduling-resto-phase3.md).
- **2026-05-25**: FnB Scheduling T1 (Roster) design dokumen selesai — lihat [docs/fnb-scheduling/](docs/fnb-scheduling/). 8 tabel proposed (`ms_fnb_*` / `tr_fnb_*`), 6 permission baru, 5-state approval flow (DRAFT→PENDING_APPROVAL→PUBLISHED). Staff source via mapping `ms_fnb_staff` cross-DB ke ERP — [ADR-007](docs/decisions/007-fnb-scheduling-staff-source.md).
- **2026-05-25**: Domain prefix naming convention ditambah ke [conventions.md §10](docs/conventions.md#10-domain-prefix-naming-fnb-dst) — `fnb` prefix wajib untuk artifact FnB-specific. Berlaku untuk modul baru saja (existing BA/PICA/SP tidak retroaktif).
- **2026-05-25**: Kolom `level` (W/D/O: wajib/disarankan/opsional) di `ms_konteks_kategori_mapping` **akan di-drop** — mapping jadi boolean murni. Migration siap (`2026_05_25_120000_drop_level_from_ms_konteks_kategori_mapping.php`) tapi **belum di-run** (user yang execute setelah backup). Code change **selesai** di 3 model + 2 controller + 5 view + 1 console command — semua referensi `level`/`LEVELS`/`pivot->level` di code path kategori sudah dihilangkan. Lihat [ADR-008](docs/decisions/008-drop-konteks-kategori-level.md). Behavior "Wajib auto-check" + "Disarankan highlight" hilang setelah migration jalan.
