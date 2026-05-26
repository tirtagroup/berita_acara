# ADR-006: Konteks — Renamed from Business Unit + Migrasi Opsi ke Pattern N:N

**Status**: 🟢 Accepted, live di production
**Date**: 2026-05-21 (live deploy), 2026-05-25 (ADR documented)
**Decider**: Tim BA-PICA

## Context

Migration awal sistem kategori BA (`2026_05_19_200000_create_ba_kategori_system.php`) mendefinisikan struktur:
- `ms_business_unit` (3 BU: LAKA, FNB, OP_HR)
- `ms_ba_kategori` (14 kategori)
- `ms_ba_kategori_opsi` dengan `kategori_id` (opsi terikat ke 1 kategori, 1:N)
- `ms_bu_kategori_mapping` (BU × Kategori dengan level)
- `tr_ba_kategori_d` (BA × Kategori pivot)

**Problem yang muncul setelah deploy:**

1. **"Business Unit" terlalu sempit** — saat dibutuhkan kategori untuk **konteks non-BU** (mis. permintaan revisi standalone, FMCG sebagai divisi yang lebih luas dari sekedar BU operasional), istilah BU jadi misleading.

2. **Opsi 1:N tidak fleksibel** — banyak opsi seperti "None", "Salah kirim", "Salah order" yang **sama persis** dipakai di kategori berbeda (mis. "Salah kirim" di Kualitas Makanan + Pelayanan). Pattern 1:N memaksa duplikasi data.

3. **Opsi context-specific tidak terhandle** — opsi "Customer tidak order" hanya relevan untuk konteks FMCG, tapi kategori induknya (Temuan Kasus) bisa muncul di konteks lain juga. Tidak ada cara menyatakan "opsi ini hanya untuk konteks X".

## Decision

**3 perubahan schema dari migration awal:**

### 1. Rename `ms_business_unit` → `ms_konteks`

Tambah 2 konteks baru:
- `REVISI` (2026-05-20) — untuk BA standalone permintaan revisi
- `FMCG` (2026-05-21) — untuk divisi FMCG

Total konteks: **5** (LAKA, FNB, OP_HR, REVISI, FMCG).

### 2. Opsi global + junction kategori-opsi

`ms_ba_kategori_opsi` direstruktur:
- **Hapus** kolom `kategori_id`, `kode`, `sort_order`
- **Tambah** UNIQUE constraint pada `deskripsi`
- Opsi sekarang **global** — bisa dipakai oleh multiple kategori

Junction baru: **`ms_kategori_opsi_mapping`** (`kategori_id`, `opsi_id`, `kode`, `sort_order`).

### 3. Opsi-konteks filtering

Junction baru: **`ms_opsi_konteks_mapping`** (`opsi_id`, `konteks_id`).

Logika: opsi yang punya entry di tabel ini hanya muncul untuk konteks yang ter-map. Opsi tanpa entry → tampil/tidak tergantung implementasi frontend.

### 4. Junction konteks-kategori

`ms_bu_kategori_mapping` → **`ms_konteks_kategori_mapping`** (kolom rename: `bu_id` → `konteks_id`).

## Alternatives Considered

- **Pertahankan BU naming + tambah BU baru** — rejected: "BU" tidak akurat secara semantik untuk REVISI (bukan unit bisnis, tapi tipe BA standalone)
- **Pertahankan opsi 1:N** — rejected: duplikasi data signifikan, tidak konsisten naming
- **Polymorphic opsi** (tabel opsi per kategori) — rejected: tidak scalable, kategori baru = tabel baru
- **JSON column untuk opsi-konteks filter** — rejected: query-tidak-friendly, tidak ada referential integrity

## Consequences

- ✅ Plus: schema lebih fleksibel, mendukung opsi sharable + context-filtering, naming lebih akurat
- ✅ Plus: bisa tambah konteks baru tanpa schema change
- ❌ Minus: lebih banyak join untuk query opsi (3 tabel: kategori_opsi_mapping + ms_ba_kategori_opsi + opsi_konteks_mapping)
- ❌ Minus: **migration awal jadi outdated** — docs perlu refresh
- ⚠️ Risks:
  - Developer baca migration file expect single source of truth → mitigasi: ADR ini + [categories.md](../categories.md) ditandai "source of truth: DB query"
  - Drift docs vs DB tidak terdeteksi → mitigasi: `php artisan docs:check-schema` command

## Implementation

**Status**: Live di production sejak 2026-05-21. Skema actual:

```
ms_konteks (5)  ─── ms_konteks_kategori_mapping ─── ms_ba_kategori (14)
                            (level: W/D/O)                  │
                                                            │
ms_konteks ─── ms_opsi_konteks_mapping ─── ms_ba_kategori_opsi (42+, deskripsi UNIQUE)
                                                            │
                                          ms_kategori_opsi_mapping (50+)
                                              (kode + sort_order)
```

**Migration `2026_05_19_200000_create_ba_kategori_system.php` SUDAH OUTDATED.**

Apakah perlu di-archive atau rewrite supaya mencerminkan state actual? **Open question.**

**Tindakan yang sudah diambil**:
- 2026-05-21: schema live dengan 5 konteks
- 2026-05-25: ADR ini dibuat untuk capture history
- 2026-05-25: [docs/categories.md](../categories.md) refresh ke schema actual

## Related

- Memory: `project_ba_multi_kategori.md` (related — BA multi-kategori)
- Docs: [docs/categories.md](../categories.md), [docs/GLOSSARY.md §C](../GLOSSARY.md)
- Migration: `database/migrations/2026_05_19_200000_create_ba_kategori_system.php` (OUTDATED)
- Verifikasi: `php artisan docs:check-schema`
