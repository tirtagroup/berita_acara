# ADR-002: PICA v2 — Forum Q&A Multi-Participant

**Status**: 🟢 Accepted, partially implemented (fase 1+2 done, fase 3 next)
**Date**: 2026-05-22 (v4 — revisi terakhir status workflow)
**Decider**: Tim BA-PICA + user

## Context

PICA legacy adalah modul tunggal yang dilakukan oleh satu role global "PIC PICA". Saat ini Tirta ingin PICA lebih kolaboratif:
- Pelaku (subjek) tidak bisa "lolos" dengan jawab seadanya
- Multi-participant agar dewan & PIC bisa probing
- Pelaku **wajib jawab** pertanyaan substantif sebelum PICA bisa di-close

PICA v2 dirancang sebagai modul **baru** yang berjalan paralel dengan PICA legacy (legacy tetap dipakai untuk PICA yang sudah jalan).

## Decision

PICA v2 = **forum Q&A multi-participant dengan close-gate pada jawaban pelaku.**

**13 aturan domain (ringkasan):**

1. **PIC** = creator wizard (self-assign), bukan role global.
2. **Roles per PICA**: pelaku (1), PIC (1, = creator), dewan (N, dipilih PIC saat wizard).
3. **PICA TIDAK BISA close** sebelum pelaku jawab semua **pertanyaan & pernyataan** yang ditandai `wajib_jawab`.
4. **Forum-style**: PIC + Dewan + Pelaku semua bisa add komentar/pertanyaan. Tapi `is_final=true` hanya untuk jawaban pelaku, saat status WAITING_PELAKU.
5. **Item types**: `pertanyaan` (jawab text) atau `pernyataan` (ack: Setuju/Tidak Setuju + reasoning).
6. **Sources pertanyaan**: `wajib_universal` (master, auto-include), `bantuan` (master, PIC pilih), `bebas` (ad-hoc).
7. **Flag `wajib_jawab`**: PIC kontrol penuh. Dewan boleh set saat tambah pertanyaannya sendiri (default off).
8. **Workflow v4**: DRAFT → **PREPARING** (PICA Plan) → **MEETING** → **FINALIZED** → **DONE**.
9. **Fase PREPARING ("PICA Plan")**: persiapan async sebelum meeting. PIC siapkan agenda + pertanyaan; Dewan bantu; Pelaku siapkan draft jawaban. Kronologi BA induk read-only.
10. **Fase MEETING (live)**: dokumentasi saat meeting fisik/WA/video. 3 tab: Q&A Forum, Catatan Meeting (PIC + Pelaku paralel), Pernyataan Pelaku (signed with `pernyataan_signed_at`).
11. **Gate MEETING → FINALIZED**: semua wajib_jawab is_final + hasil_meeting_pic tidak kosong + pernyataan signed.
12. **Fase FINALIZED**: PIC + Dewan susun corrective + preventive action (sections A-G).
13. **Gate FINALIZED → DONE**: ≥1 corrective + ≥1 preventive + closure_date + pernyataan signed. Set `done_at + done_by`. Setelah DONE seluruh PICA read-only permanent.

**BA Link opsional**: PICA bisa standalone atau tindak-lanjut BA (`ba_link_code` nullable).

## Alternatives Considered

- **Pertahankan PICA legacy** — rejected: single-PIC tidak collaborative, pelaku bisa "lolos" tanpa jawaban substantif.
- **Workflow linear strict** (DRAFT → MEETING → CLOSED tanpa fase PREPARING) — rejected: meeting fisik butuh persiapan async dulu, kalau tidak meeting jadi tidak produktif.
- **Pelaku editable post-DONE** — rejected: PICA = formal RCA dengan legal-sensitivity, tidak boleh diedit setelah closed.

## Consequences

- ✅ Plus: kualitas RCA naik (probing multi-participant), audit trail kuat (signed statements), pelaku tidak bisa "lolos"
- ❌ Minus: UI lebih kompleks (3 tab di MEETING), butuh sosialisasi user
- ⚠️ Risks:
  - User legacy resist switch — mitigasi: PICA v2 paralel, tidak force migrate
  - Discussion page belum selesai (fase 3) → mitigasi: target Phase 1 roadmap

## Implementation

**Status**: Fase 1 (skema + master) + Fase 2 (wizard) **done & deployed** (commit 8fc3148). Fase 3 (discussion page) target Phase 1 roadmap (Juni–Juli 2026).

**Tabel**:
- Master: `ms_pica_kategori`, `ms_pica_pertanyaan_master`
- Transactional: `tr_pica_participants`, `tr_pica_jawaban`, `tr_pica_kategori_d`, `tr_pica_pertanyaan_d`
- Reuse legacy: `Tr_PICA_Emp_h`, `Tr_PICA_Action`, `Tr_PICA_Preventive_Action`

**Discussion page (fase 3)** punya 2 mode UX:
- Mode PREPARING (semua boleh tambah pertanyaan + komentar, pelaku belum jawab is_final)
- Mode MEETING/WAITING_PELAKU (pelaku jawab is_final, gate ke FINALIZED aktif)

**Naming change**: ACTION_PLANNING → FINALIZED, CLOSED → DONE (commit f7c672d).

## Related

- Memory: `project_pica_v2_design.md`
- Docs: [workflows/pica.md](../workflows/pica.md), [tables/pica.md](../tables/pica.md)
- Roadmap: Phase 1 ([ROADMAP.md](../ROADMAP.md))
- Glossary: PICA terms di [GLOSSARY.md §E](../GLOSSARY.md)
