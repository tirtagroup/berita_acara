# Architecture Decision Records (ADR)

Capture **kenapa** kita ambil keputusan tertentu — bukan hanya **apa**. Setiap ADR adalah snapshot kondisi & rationale pada satu titik waktu.

## Index

| # | Title | Status | Date | Topik |
|---|---|---|---|---|
| [001](001-ba-multi-kategori-pivot.md) | BA Multi-Kategori — Migrasi ke Pivot | 🟡 Proposed | 2026-05-19 | BA schema |
| [002](002-pica-v2-design.md) | PICA v2 — Forum Q&A Multi-Participant | 🟢 Accepted (partial impl) | 2026-05-22 | PICA workflow |
| [003](003-sop-module-tier2.md) | SOP Module — Tier 2 Standalone | 🟡 Proposed (target Phase 2) | 2026-05-24 | SOP module |
| [004](004-ai-workstream-parked.md) | AI Workstream — Parked Pending Compliance | 🔴 Parked | 2026-05-24 | AI strategy |
| [005](005-scheduling-resto-phase3.md) | Scheduling Resto — T1+T3 di Phase 3 | 🟡 Proposed (target Phase 3) | 2026-05-25 | New module |
| [006](006-konteks-renamed-from-bu.md) | Konteks — Renamed from Business Unit | 🟢 Accepted (live) | 2026-05-21 | Kategori system |

**Legend**: 🟢 Accepted (live) · 🟡 Proposed / partial implementation · 🔴 Parked / Superseded

---

## Template ADR

Untuk ADR baru, ikuti format ini:

```markdown
# ADR-NNN: Title

**Status**: Proposed / Accepted / Parked / Superseded by ADR-XXX
**Date**: YYYY-MM-DD
**Decider**: nama / tim

## Context
Apa situasi dan problem yang memicu keputusan ini? Constraint apa yang ada?

## Decision
Apa yang diputuskan? Pilihan mana yang dipilih?

## Alternatives Considered
Pilihan lain yang dipertimbangkan dan kenapa ditolak.

## Consequences
- ✅ Plus: keuntungan
- ❌ Minus: trade-off / kompromi
- ⚠️ Risks: risk yang harus di-mitigasi

## Implementation
Status implementasi (jika applicable). Pointer ke commit / migration / file.

## Related
- Memory: [[memory-slug]]
- ADR: [ADR-XXX](xxx.md)
- Code: `path/to/file.php`
- Docs: `docs/...`
```

## Naming convention

`NNN-kebab-case-title.md` — 3 digit, hyphen-separated. NNN unique, increment forward.

## Lifecycle

- **Proposed** — keputusan dibuat, belum (semua) diimplementasi
- **Accepted** — sudah live di production
- **Parked** — keputusan ditunda menunggu input eksternal (mis. compliance)
- **Superseded by ADR-XXX** — keputusan diganti, link ke pengganti

Jangan delete ADR yang sudah obsolete — ubah status ke Superseded supaya historical context tetap ada.
