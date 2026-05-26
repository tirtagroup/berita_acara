# ADR-001: BA Multi-Kategori — Migrasi ke Pivot

**Status**: 🟡 Proposed (belum diimplementasi)
**Date**: 2026-05-19
**Decider**: Tim BA-PICA + user

## Context

Satu Berita Acara (BA) di Tirta Group secara realita bisa **overlap multiple kategori, jenis, dan kasus** sekaligus. Contoh: kecelakaan kerja yang juga melibatkan fraud + pelanggaran SOP.

Schema saat ini di `Tr_Ba_Main_New` masih **single-value**:
- `Category_Code` (varchar tunggal)
- `jenis` (varchar tunggal)
- `Ms_Kasus` (varchar tunggal)

Hanya `ms_fraud` yang sudah berbentuk flag terpisah (multi-tag style). Sisanya memaksa pelapor pilih hanya satu — kalau realitas overlap, data jadi tidak akurat dan menghambat report agregat per kategori.

## Decision

**Migrasi ke 3 pivot table:**
- `Tr_BA_Category_Mapping` — BA × Kategori (N:N)
- `Tr_BA_Jenis_Mapping` — BA × Jenis (N:N)
- `Tr_BA_Kasus_Mapping` — BA × Kasus (N:N)

Tidak ada konsep *primary category* — semua kategori yang ter-attach setara.

## Alternatives Considered

- **Tambah kolom boolean flag** untuk setiap kategori (seperti `ms_fraud`) — rejected: tidak scalable, tambah 1 kategori = ALTER TABLE.
- **JSON column** untuk array kategori — rejected: tidak query-friendly untuk aggregat, sulit dijoin, dan MySQL JSON support terbatas di stack ini.
- **Pertahankan single-value** — rejected: data tidak mencerminkan realita Tirta.

## Consequences

- ✅ Plus: data akurat (multi-kategori), report agregat per kategori bisa benar, scalable untuk tambah kategori baru
- ❌ Minus: query lebih kompleks (join pivot), migrasi data lama butuh hati-hati
- ⚠️ Risks:
  - Data lama corrupt saat migrasi → mitigasi: backup penuh, staging test dulu, rollback plan ≤ 1 jam downtime
  - Existing report yang asumsi 1 BA = 1 kategori akan rusak → audit & refactor sebelum deploy

## Implementation

**Status**: Spec di [docs/database.md](../database.md), migration **belum dibuat**.

Target Phase 2 roadmap (Agustus–Oktober 2026, lihat [ROADMAP.md](../ROADMAP.md)).

**Saat develop feature baru di area BA:**
- JANGAN tambah kolom single-value kategori baru di header `Tr_Ba_Main_New`
- Endpoint baru yang baca/tulis kategori: siapkan supaya bisa di-refactor ke pivot tanpa breaking (wrap akses kolom lama lewat method di model, mis. `getCategoryCodes(): array`)
- UI dropdown kategori/jenis/kasus → bikin **multi-select** sejak awal (Select2 `multiple: true`), meski backend masih single-value
- Report agregat per kategori → jangan asumsikan 1 BA = 1 row category. Pakai pattern yang akan tetap benar setelah migrasi.

**`Cek*` flags di `Tr_Ba_Main_New`** (`CekFraud`, `CekLaka`, dll.): akan deprecated setelah migrasi. Saat ini bisa tetap dipakai sebagai cache.

## Related

- Memory: `project_ba_multi_kategori.md`
- Docs: [docs/database.md](../database.md), [docs/workflows/berita-acara.md](../workflows/berita-acara.md), [docs/categories.md](../categories.md)
- Roadmap: Phase 2 ([ROADMAP.md](../ROADMAP.md))
- Schema actual: [ADR-006](006-konteks-renamed-from-bu.md) (sistem kategori sudah evolve ke konteks pattern)
