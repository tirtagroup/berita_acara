# ADR-003: SOP Module — Tier 2 Standalone

**Status**: 🟡 Proposed (target Phase 2 roadmap)
**Date**: 2026-05-24
**Decider**: user

## Context

BA-PICA selama ini **reaktif** — mencatat kejadian setelah terjadi + RCA. Tidak ada sistem yang mencatat **apa yang seharusnya** (Standard Operating Procedure). Pain point yang diangkat user: "bagaimana untuk dokumentasi SOP?"

SOP adalah **preventif counterpart** dari BA-PICA: BA mencatat pelanggaran SOP, PICA action sering menghasilkan "update SOP" — tapi SOP itu sendiri tidak ada di sistem.

Sudah ada infrastruktur partial: **help center** (`ms_doc_workflow`, commit 91ce8e1) — viewer + admin CRUD untuk dokumentasi cara pakai aplikasi.

## Decision

Bangun **SOP module standalone Tier 2** (Layer A + Layer B):

- **Layer A — Content**: viewer + CRUD admin
- **Layer B — Lifecycle**: DRAFT → REVIEW → APPROVED → PUBLISHED → REVISI → ARCHIVED + versioning + ack tracking

**Estimasi**: ~1.5–2 bulan. **Schedule**: Phase 2 roadmap (Agustus–Oktober 2026).

**Schema baru** (jangan reuse `ms_doc_workflow`):
- `ms_sop_category` — struktur folder
- `ms_sop_doc` — header: nomor SOP, judul, owner, status, effective_date
- `ms_sop_version` — isi rich text + lampiran per versi
- `tr_sop_acknowledgment` — siapa baca SOP-X versi-Y kapan

**Reviewer + approver via permission system existing** (4 tabel permission, commit f616af7) — jangan bikin role baru.

**Layer C (integrasi BA/PICA)** ditunda ke Phase 3:
- Kolom `linked_sop_codes[]` di BA (SOP yang dilanggar)
- Kolom `target_sop_code` di PICA Action ("action = update SOP-X")
- Report "SOP yang paling sering dilanggar"

**Tier 4 (training + quiz + competency)** **out of scope** 12 bulan. Re-evaluasi Q3 2027.

## Alternatives Considered

- **Tier 1 (viewer + CRUD only)** — rejected: SOP butuh nomor formal + approval workflow yang sulit ditambahkan retroactive.
- **Extension help center** (tambah `is_sop` flag di `ms_doc_workflow`) — rejected: audience & semantik beda. Help = cara pakai app, SOP = proses bisnis. Mencampur bikin user trust turun.
- **Tier 4 langsung** (LMS-style dengan quiz) — rejected: over-engineering, validasi adoption dulu.
- **Buy off-the-shelf SOP/wiki tool** (Notion, Confluence) — rejected: sudah punya app internal, butuh integrasi langsung ke BA/PICA.

## Consequences

- ✅ Plus: SOP punya nomor formal, ada audit trail acknowledgment, lifecycle approval jelas, bisa di-link langsung ke BA/PICA nanti
- ❌ Minus: 1.5–2 bulan effort, lebih besar dari Tier 1 (~3 minggu)
- ⚠️ Risks:
  - Lifecycle terlalu kompleks untuk user → mitigasi: design sprint Phase 1 wajib validasi mockup dengan 2–3 real user sebelum coding
  - Adoption rendah → mitigasi: notifikasi re-ack saat revisi + integrasi ke help center inline button

## Implementation

**Status**: Belum mulai. Schedule design sprint Phase 1 (Juni–Juli 2026), implementation Phase 2 (Aug–Okt 2026).

**Editor & viewer**: boleh borrow infrastruktur dari help center (rich text component, attachment uploader) — **tapi tabel & controller terpisah**.

**Tier 3 (Phase 3, Nov 2026+)** — integrasi BA/PICA:
- `linked_sop_codes[]` di BA
- `target_sop_code` di PICA Action
- Report SOP-yang-paling-sering-dilanggar

## Related

- Memory: `project_sop_module_decision.md`
- Roadmap: Phase 2 ([ROADMAP.md](../ROADMAP.md))
- Help center existing: `ms_doc_workflow` (commit 91ce8e1)
- Permission system: 4 tabel (commit f616af7)
