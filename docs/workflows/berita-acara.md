# Workflow: Berita Acara (BA)

## Tujuan
Mencatat laporan kejadian internal di perusahaan — pelanggaran, kecelakaan kerja (laka), kesalahan operasional, fraud — untuk ditindaklanjuti dengan validasi berjenjang sebelum di-closing.

> 📌 **Catatan domain**: Satu BA bisa punya **multi-kategori, multi-jenis, multi-kasus** sekaligus (semua setara, tidak ada primary). Schema saat ini masih single-value — rencana migrasi ke pivot table didokumentasikan di [`docs/database.md → Planned Change`](../database.md#-planned-change-multi-category-berita-acara).

## Aturan Validasi per Kategori

| Kategori | Aturan wajib |
|---|---|
| **LAKA** | Wajib punya minimal 1 entry di `tr_ba_kronologi` (link via `tr_ba_main_code` → `Tr_BA_Main_Code`). Form input LAKA tidak boleh bisa di-submit tanpa kronologi. |

Aturan-aturan ini perlu di-enforce di:
1. **Application validation** (controller + Form Request) — primary defense.
2. **UI** (form field required + disable submit) — UX preventif.
3. **DB constraint/trigger** — opsional, defense in depth.

## Role yang Terlibat 🟡 ASUMSI

| Role | Peran |
|---|---|
| **Reporter** (karyawan/SPV/HRD lokasi) | Membuat BA |
| **Koordinator** | Validasi level 1 — verifikasi data dasar |
| **Manager** | Validasi level 2 — keputusan tindakan |
| **GM** | Validasi level 3 — approval untuk kasus berat |
| **BOD** | Validasi level 4 — final approval kasus berat/fraud |
| **IT** | Validasi khusus untuk kasus terkait sistem |

## Alur Utama 🟡 ASUMSI

```
[Reporter]
    │
    │ 1. Input BA (form: jenis_ba, lokasi, pelaku, kronologi, dokumen)
    ▼
┌──────────────────┐
│  BA: DRAFT       │
└──────────────────┘
    │
    │ 2. Submit
    ▼
┌──────────────────┐
│  BA: PENDING     │ ──→ trigger email ke Koordinator
│  validasi_koord  │
└──────────────────┘
    │
    │ 3. Koordinator review
    ├─→ Setuju ──→ status PENDING validasi_manager
    ├─→ Minta Revisi ──→ status REVISI (reporter edit ulang)
    └─→ Tolak ──→ status REJECTED
    │
    ▼
┌──────────────────┐
│  PENDING_MANAGER │ ──→ trigger email Manager
└──────────────────┘
    │
    │ 4. Manager review
    ├─→ Setuju + tingkat ringan ──→ APPROVED (selesai)
    ├─→ Eskalasi ──→ PENDING_GM
    ├─→ Minta Revisi ──→ REVISI
    └─→ Tolak ──→ REJECTED
    │
    ▼
┌──────────────────┐
│  PENDING_GM      │ ──→ trigger email GM
└──────────────────┘
    │
    │ 5. GM review (untuk kasus berat / fraud)
    ├─→ Setuju ──→ APPROVED atau PENDING_BOD
    └─→ Minta Revisi / Tolak
    │
    ▼
┌──────────────────┐
│  PENDING_BOD     │ ──→ trigger email BOD
└──────────────────┘
    │
    │ 6. BOD final approval
    ├─→ Setuju ──→ CLOSED
    └─→ Tolak ──→ REJECTED

(Cabang khusus IT untuk kasus terkait sistem)
```

## Status BA (nilai di kolom `Status_BA` / `Tr_BA_Status`) 🟡 ASUMSI

Perlu diisi setelah cek nilai aktual di kolom `Tr_BA_Status` di DB produksi.

## Sub-Alur: BA Kecelakaan Kerja (Laka)

Tabel dedicated: `tr_ba_laka_h` (header) + `tr_ba_laka_d` (detail per pelaku/korban).

Field tambahan: `dampak_laka`, `faktor_laka`, `jenis_laka`, `klasifikasi_laka` (referensi ke master `ms_*_laka`).

## Sub-Alur: Salah Isi

Tabel: `tr_ba_salah_isi_detail`. Workflow lebih ringkas — biasanya hanya koord + manager approval.

## Revisi

- Status `REVISI` mengembalikan BA ke reporter dengan field `Tr_BA_Revisi.alasan_revisi`.
- Reporter edit, submit ulang → mulai validasi level 1 lagi (atau kembali ke level yang minta revisi, tergantung policy).
- Tracking di `tr_approval_ba_tracking`.

## Tabel yang Ter-update

Lihat detail kolom di [docs/tables/berita-acara.md](../tables/berita-acara.md).

| Tabel | Saat | Operasi |
|---|---|---|
| `Tr_Ba_Main_New` | Reporter submit BA | INSERT |
| `Tr_Ba_Main_New` | Tiap level validasi | UPDATE (status, validator, timestamp) |
| `tr_ba_kronologi` | Reporter isi kronologi kejadian | INSERT |
| `ba_document` / `ba_document2` | Upload bukti/dokumen pendukung | INSERT |
| `Tr_BA_Comment` | Tiap validator memberikan komentar | INSERT |
| `Tr_BA_Revisi` | Validator minta revisi | INSERT |
| `tr_approval_ba_tracking` | Setiap perpindahan level | INSERT (audit trail) |
| `Tr_BA_Status` | Lookup status | (read-only master) |
| `tr_ba_laka_h` / `tr_ba_laka_d` | Sub-form laka | INSERT (bila tipe laka) |
| `tr_ba_salah_isi_detail` | Sub-form salah isi | INSERT (bila tipe salah isi) |
| `ba_updated_record` | Audit perubahan field | INSERT |

## Route & Controller

Lihat [docs/routes.md → Berita Acara](../routes.md#berita-acara-62-route--modul-terbesar).

Controller: `BeritaAcaraController` (62 method/route).

Key endpoints:
- `GET /beritaacara/create` — form input
- `POST /beritaacara/store` — simpan BA
- `GET /detail_validasi/{id}` — halaman validasi (dengan variant per role: `_koord`, `_manager`, `_gm`, `_bod`, `_it`)
- `POST /store_validasi/koord` (dan 4 lainnya) — submit validasi
- `GET /print_ba/{id}` — cetak PDF
- `GET /dashboard_revisi` — daftar BA yang sedang revisi

## Email / Notifikasi 🟡 ASUMSI

Template di `resources/views/berita_acara/email_ba.blade.php` dan `email_ba_salah_isi.blade.php`. SMTP via `absensi.tirtagroup.net:465`.

Trigger pengiriman email perlu ditelusuri lebih lanjut — kemungkinan saat status berpindah ke level validator berikutnya.

## Edge Case 🟡 ASUMSI

- **Revisi berulang**: tidak ada batas? Perlu konfirmasi.
- **Validator tidak respond**: tidak ada timeout / reminder otomatis? Perlu konfirmasi.
- **BA ter-edit setelah CLOSED**: perlu approval BOD?

---

## v2 Implementation Notes (2026-05-20)

**Modul BA v2** sudah live dengan fitur:

### Konteks (sebelumnya "Business Unit" / "BU")
- 4 konteks: `LAKA`, `FNB`, `OP_HR`, `REVISI` (tabel `ms_konteks`).
- Rename DB+code dari `ms_business_unit`/`bu_kode` ke `ms_konteks`/`konteks_kode` di migration `2026_05_20_180000`.

### Multi-kategori
- Pivot `tr_ba_kategori_d` (BA × kategori, opsional + opsi_id).
- 14 kategori universal (`ms_ba_kategori`), 35 opsi unik (`ms_ba_kategori_opsi`) N:M via `ms_kategori_opsi_mapping`.
- Konteks × kategori mapping di `ms_konteks_kategori_mapping` (**boolean** — row present = available). Kolom `level` lama di-drop per [ADR-008](../decisions/008-drop-konteks-kategori-level.md).
- Opsi langsung tag ke konteks: `ms_opsi_konteks_mapping`.

### Wizard Create 6-step
1. Konteks (radio cards)
2. Data umum (pelaku, tanggal, lokasi, company, deskripsi, **kronologi**, ms_kasus legacy)
3. Kategori Umum (multi-select, semua opsional — pre-ADR-008 dulu "level-aware" dengan auto-check wajib)
4. Kategori FnB (skip otomatis bila bukan FNB)
5. Kategori LAKA (skip otomatis bila bukan LAKA)
6. Salah Admin / Revisi (skip otomatis bila bukan REVISI) — termasuk `tr_ba_request_revisi` + `tr_ba_salah_isi_detail`
7. Review & Submit

### Edit BA (Fase 4)
- URL: `/beritaacara/v2/edit?kode=BA-XXX`
- Permission:
  - User dengan `users.role` = `admin` / `super_admin` → SELALU bisa edit
  - Creator (Rec_UserCreated) → bisa edit BILA `Tr_Ba_Main_New.edit_allowed = true`
- Admin toggle `edit_allowed` via tombol di show page (`POST /beritaacara/v2/{kode}/toggle-edit-allowed`)
- Migration `2026_05_20_190000` tambah kolom `edit_allowed BOOLEAN DEFAULT 0`
- Show page menampilkan badge "Edit terbuka" ketika `edit_allowed=true`
- Field editable: tanggal, lokasi, company, pelaku, divisi, deskripsi, kategori_ids, kronologi
- Field NOT editable: kode BA, konteks, pelapor, Cek* flags (audit trail)

### Migrasi Cek* Legacy → Kategori v2 (Fase 5)

Tabel mapping admin: `ms_cek_flag_mapping` (migration `2026_05_20_200000`).

URL admin CRUD: `/master/cek-mapping` — admin bisa adjust mapping `CekPelanggaran → PELANGGARAN_SOP`, `CekLaka → LAKA_PENYEBAB`, dst.

Artisan command:
```bash
php artisan ba:migrate-cek-flags --dry-run    # preview: ~19498 BA, ~21703 rows
php artisan ba:migrate-cek-flags --force      # eksekusi
```

Karakteristik:
- Skip BA yang sudah punya kategori_d rows (anti-duplicate).
- Multi-kategori per BA didukung (1 BA bisa punya CekFraud + CekPerubahanSOP → 2 rows).
- Hanya mapping `active=true` yang dipakai.
- `opsi_id` di kategori_d = NULL (legacy tidak ada opsi).

### Integrasi dengan PICA v2

Detail BA show menampilkan section **"PICA Terkait"** dengan tombol "Buat PICA dari BA ini" (`/pica/v2/create?ba_code=X`). PICA prefill BA induk di step 2 wizard.

---

> **Action item**: Tim HR/IT mohon review & koreksi alur di atas, terutama bagian yang ditandai 🟡 ASUMSI.
