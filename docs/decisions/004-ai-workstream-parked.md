# ADR-004: AI Workstream — Parked Pending Compliance

**Status**: 🔴 Parked
**Date**: 2026-05-24
**Decider**: user

## Context

Roadmap 12 bulan punya potensi tinggi untuk AI augmentation di area BA, PICA, dan SOP. Use case high-value yang ter-identifikasi:
1. Auto-suggest kategori BA dari kronologi (mendukung migrasi multi-kategori)
2. Generate draft kronologi dari bullet
3. Suggest pertanyaan probing PICA berdasar kategori BA
4. Cek kelengkapan jawaban pelaku (substantif vs dangkal)
5. Draft corrective + preventive action dari hasil meeting
6. Extract SOP dari PDF/Word legacy
7. AI chatbot Q&A SOP (RAG)
8. Gap analysis SOP (BA recurring → SOP belum ada → suggest)
9. Trend narrative di dashboard exec

**Tapi**: BA berisi data sensitif (nama pegawai, laka kerja, fraud, NIK). User menjawab "tidak boleh ke eksternal" terkait data residency.

User pilih Claude API + Gemini sebagai provider preferensi — tapi keduanya secara teknis kirim data ke server Anthropic/Google. Ada konflik antara preferensi provider dan constraint data residency.

## Decision

**AI workstream PARKED**, menunggu clearance compliance soal data residency yang konkret.

Roadmap (Phase 2–4) didesain dengan AI sebagai **optional layer**:
- Setiap fase ada slot AI yang **conditional**
- Kalau clearance keluar positive selama Phase 1 → AI feature mulai Phase 2 PoC
- Kalau negative → drop AI workstream, isi slot dengan Risk Register lebih awal

## Alternatives Considered

- **Commit AI Tier B (public enterprise API)** sekarang — rejected: bertentangan dengan "tidak boleh eksternal" yang dipilih user
- **Drop AI sama sekali** — rejected: roadmap user lihat AI sebagai differentiator strategis, jangan ditutup permanen
- **Self-hosted only (Tier D)** — premature commitment: model open-source untuk Indonesian text reasoning belum jelas mature; cost hardware GPU > cost API. Keputusan ini menunggu eksplorasi.

## Consequences

- ✅ Plus: tidak ada commit feature AI yang bisa berakibat compliance violation
- ❌ Minus: timeline AI delay, ada uncertainty
- ⚠️ Risks:
  - Clearance lama → roadmap geser; mitigasi: isi slot dengan Risk Register kalau confirmed negative
  - Tetap dianggap "in progress" tanpa output → mitigasi: hard checkpoint end of Phase 1, decision must be made

## Implementation

**Status**: Tidak ada implementasi AI di codebase saat ini. Tidak boleh commit AI feature (UI / promise) sebelum clearance.

**Checklist Phase 1 (Juni–Juli 2026)**:
- ☐ Compliance/legal/IT Tirta validate tier akses (B/C/D)
- ☐ Pilih provider (Claude/Gemini/OpenAI/local)
- ☐ Budget cap per bulan
- ☐ Prompt management strategy (`ms_ai_prompt` table dengan versioning)

**Tier akses kandidat:**
- **Tier B** — API publik enterprise (Anthropic / Gemini direct) + DPA + no-training. Cost terjangkau, fitur full.
- **Tier C** — Managed cloud private (AWS Bedrock Claude, GCP Vertex Gemini) dengan data residency regional. Cost ~2x. Biasanya diterima compliance enterprise Indonesia.
- **Tier D** — Self-hosted local (Ollama + Llama 3.1 / Mistral). Hardware GPU mahal, model lebih lemah untuk reasoning, latency tinggi. **Kalau hanya Tier D, kurangi ambisi AI** — drop use case 3, 4, 7, 8 (yang butuh reasoning).

**Use case yang BISA jalan di Tier D (kategorisasi, summarization sederhana):**
- #1 Auto-suggest kategori BA
- #2 Generate draft kronologi dari bullet
- #6 Extract SOP dari PDF/Word

## Related

- Memory: `project_ai_workstream_parked.md`
- Roadmap: AI slot conditional di setiap fase ([ROADMAP.md](../ROADMAP.md))
- Safety: [SAFETY.md](../SAFETY.md) — JANGAN commit AI feature ke user sebelum clearance
