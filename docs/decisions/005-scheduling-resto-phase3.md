# ADR-005: Scheduling Resto — T1+T3 di Phase 3

**Status**: 🟡 Proposed (target Phase 3 roadmap)
**Date**: 2026-05-25
**Decider**: user

## Context

User minta tambahan modul untuk jadwal staff restoran (FnB). Cek DB existing: **belum ada** tabel `schedule`/`shift`/`jadwal`/`roster`/`absen` di kedua connection (`mysql` + `mysql_new`). Berarti fresh build dari nol.

Hostname DB host adalah `absensi.tirtagroup.net` — mungkin ada sistem absensi terpisah, tapi user confirm **tidak ada absensi existing untuk staff resto**.

Pain point yang menarik: kategori BA `DISIPLIN_OPERASIONAL` (#14) yang tracks "Terlambat > 15 menit", "Tidak ada di station", "Tidak masuk tanpa kabar" — selama ini **diisi manual**, error-prone dan tidak konsisten. Kalau ada clock-in yang otomatis trigger BA, data jadi otomatis & akurat.

## Decision

Bangun **Scheduling Resto Tier 1 + Tier 3** (skip T2 dulu).

- **T1 (Roster)**: shift template (pagi/siang/malam), manager assign staff per minggu, calendar view per outlet/staff, export jadwal
- **T3 (Attendance + BA link)**: clock-in/out (web + simple mobile), real-time on-duty view, **auto-trigger BA kategori `DISIPLIN_OPERASIONAL` saat telat / tidak masuk tanpa kabar**

**Estimasi**: ~10 person-week. **Schedule**: Phase 3 roadmap (November 2026 – Februari 2027).

**Skema baru:**
- `ms_outlet` — daftar outlet/gerai
- `ms_shift_template` — definisi shift (kode, nama, jam mulai, jam selesai, hari aktif)
- `tr_jadwal_d` — pivot staff × tanggal × shift × outlet
- `tr_attendance` — clock-in/out actual (linked ke `tr_jadwal_d`)

Wajib registered di permission system existing.

## Alternatives Considered

- **T1 saja (roster, no clock-in)** — rejected: kehilangan killer feature integrasi BA Disiplin
- **T1+T2+T3 (full WFM dengan swap & request)** — rejected: ~4 bulan effort, validasi adoption belum ada. Defer T2 sampai T1+T3 confirmed dipakai
- **T4 (payroll + forecasting + AI)** — out of scope 12 bulan
- **Buy off-the-shelf** (When I Work, Deputy, dll.) — rejected: butuh integrasi langsung ke BA, integrasi cross-system kompleks
- **Replace sistem absensi existing** — rejected: out of scope, fresh build saja untuk resto

## Consequences

- ✅ Plus: data BA Disiplin Operasional akurat & otomatis (kategori #14 diisi otomatis dari clock-in), tidak ada lagi spreadsheet manual jadwal, real-time visibility on-duty
- ❌ Minus: Phase 3 jadi padat (21 person-week vs 24 productive — AI features harus di-shift ke Phase 4)
- ⚠️ Risks:
  - Clock-in adoption rendah di staff lapangan → mitigasi: validasi mockup dengan 2 outlet pilot di awal Phase 3, UI dead-simple (1 tap, tanpa login ulang)
  - Phase 3 over-loaded → mitigasi: AI shifted, monitor weekly, willing to drop T3 dari Phase 3 (deliver T1 saja) kalau perlu
  - Integration BA Disiplin trigger duplicate / false positive → mitigasi: threshold (mis. > 15 menit) configurable di master, double-check before create BA

## Implementation

**Status**: Belum mulai. Schedule Phase 3.

**Integration point dengan BA existing**:
- `tr_attendance` punya kolom `late_minutes` + `is_no_show` → trigger otomatis create BA baru dengan kategori `DISIPLIN_OPERASIONAL` + opsi sesuai:
  - id 31: "Terlambat lebih dari 15 menit"
  - id 32: "Tidak ada di station"
  - id 33: "Tidak masuk tanpa kabar"
- Threshold (mis. > 15 menit) configurable di master.
- Schema integrasi pakai junction system kategori actual (`ms_kategori_opsi_mapping`) — **bukan** `Cek*` flags legacy.

**Sinergi Phase 4 Mobile/PWA**: clock-in juga jalan via PWA — bonus.

**Konteks**: natural fit dengan konteks `FNB` (`ms_konteks` id=2).

## Related

- Memory: `project_scheduling_resto_decision.md`
- Roadmap: Phase 3 ([ROADMAP.md](../ROADMAP.md))
- BA kategori system: [ADR-006](006-konteks-renamed-from-bu.md), [docs/categories.md](../categories.md)
- BA multi-kategori: [ADR-001](001-ba-multi-kategori-pivot.md)
