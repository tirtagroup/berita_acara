# BA-PICA Roadmap — Juni 2026 → Mei 2027

**Status**: Draft (disusun 2026-05-24)
**Horizon**: 12 bulan
**Team**: 2 dev (~1.7x kapasitas solo, akun overhead koordinasi)

---

## Vision

BA-PICA bergerak dari **reaktif** (mencatat kejadian + RCA) menjadi sistem operational risk yang juga **preventif** (SOP sebagai kontrol) dan akhirnya **proaktif** (AI assist untuk pattern detection & kualitas RCA).

Tiga lapis nilai yang dibangun bertahap:

| Lapis | Modul | Fokus |
|---|---|---|
| Reaktif (sudah ada) | BA, PICA | Catat kejadian → akar masalah → corrective action |
| Preventif (target 2026) | **SOP** | Kontrol yang seharusnya dijalankan, terhubung ke BA/PICA |
| Proaktif (target 2027) | AI augmentation, Risk Register | Bantu kategorisasi, suggest pertanyaan, gap analysis |

---

## Strategic themes

1. **Tutup yang belum kelar** — BA multi-kategori migration, PICA v2 fase 3 (discussion page)
2. **Ekspansi preventif** — SOP module Tier 2 (full lifecycle), Dashboard executive, Risk Register
3. **AI augmentation (PARKED)** — pending clearance compliance soal data residency. Slot disiapkan, deliverable tidak commit sampai clearance dapat.

---

## Phase breakdown

### Phase 1 — Foundation (Juni–Juli 2026, M1–M2)

| Initiative | Deliverable | Effort | Owner |
|---|---|---|---|
| PICA v2 fase 3 — Discussion page | UI 3 tab (Q&A Forum, Catatan Meeting, Pernyataan Pelaku); gating PREPARING → MEETING → FINALIZED → DONE | ~6 minggu | Dev A |
| SOP module — design sprint | Schema final (`ms_sop_category`, `ms_sop_doc`, `ms_sop_version`, `tr_sop_acknowledgment`); mockup UI; spec lifecycle DRAFT→REVIEW→APPROVED→PUBLISHED→REVISI→ARCHIVED | ~2 minggu | Dev B |
| AI compliance clearance | Putusan tier akses (B publik enterprise / C managed cloud / D self-hosted); checklist diajukan ke IT/legal Tirta | ~3 minggu (paralel) | Dev B + manajemen |

**Exit criteria phase 1**: PICA v2 fase 3 live di production, SOP design ter-approve internal, jawaban compliance AI ada hitam-putihnya.

---

### Phase 2 — SOP MVP + BA pivot (Agustus–Oktober 2026, M3–M5)

| Initiative | Deliverable | Effort | Owner |
|---|---|---|---|
| **SOP Tier 2 — Layer A+B** | Viewer + CRUD admin; lifecycle approval (DRAFT→REVIEW→APPROVED→PUBLISHED); versioning; `tr_sop_acknowledgment` (siapa sudah baca v-X); notifikasi re-ack saat revisi | ~8 minggu | Dev A |
| **BA multi-kategori migration** | Pivot tables (`Tr_BA_Category_Mapping`, `Tr_BA_Jenis_Mapping`, `Tr_BA_Kasus_Mapping`); migrasi data lama; UI multi-select; report aggregasi yang benar | ~6 minggu | Dev B |
| (Opsional) AI PoC #1 — auto-suggest kategori BA | Hanya jika compliance clear di Phase 1. Suggest 1+ kategori dari kronologi, user tetap edit. | ~3 minggu | Dev B (kalau slot ada) |

**Exit criteria phase 2**: SOP module Tier 2 production-ready, BA migrasi ke pivot sudah deploy + data lama ter-migrasi tanpa loss.

---

### Phase 3 — Integration + Dashboard (November 2026 – Februari 2027, M6–M9)

| Initiative | Deliverable | Effort | Owner |
|---|---|---|---|
| **SOP ↔ BA/PICA integration** | Kolom `linked_sop_codes[]` di BA (SOP yang dilanggar/relevan); kolom `target_sop_code` di PICA Action ("action = update SOP-X"); report "SOP yang paling sering dilanggar" | ~6 minggu | Dev A |
| **Dashboard executive** | KPI cards (incident count, PICA closure rate, avg time-to-close); chart tren per kategori; filter periode (default awal-bulan→hari ini) | ~5 minggu | Dev B |
| (Opsional) AI features #3+#5 | Suggest pertanyaan probing PICA dari kategori BA; draft corrective + preventive action dari hasil meeting. Conditional on compliance. | ~8 minggu | Dev A/B |

**Exit criteria phase 3**: SOP terhubung dua arah ke BA & PICA; dashboard exec live; minimal 1 fitur AI live kalau clearance dapat.

---

### Phase 4 — Polish + advanced (Maret–Mei 2027, M10–M12)

| Initiative | Deliverable | Effort | Owner |
|---|---|---|---|
| **Risk register** | Tabel `ms_risk` + `tr_risk_assessment`; UI register dengan link ke SOP/control; tampil di dashboard sebagai "risk vs incident overlay" | ~5 minggu | Dev A |
| **Mobile / PWA** | PWA installable; form input BA dari HP; foto langsung dari kamera; offline draft | ~6 minggu | Dev B |
| (Opsional) AI chatbot SOP | RAG Q&A on SOP corpus — "apa SOP untuk situasi X?" — conditional on compliance + cost discipline | ~4 minggu | Dev A/B |

**Exit criteria phase 4**: Risk register live; mobile PWA dipakai untuk minimal 1 modul input lapangan; iterasi feedback dari user terkumpul.

---

## Capacity & buffer

- Total kapasitas asumsi: **~17 person-weeks per dev × 2 dev × 12 bulan = ~1700 person-hours**, dikurangi 25% untuk maintenance ongoing, code review, dan urgent bug fix → **~1275 jam productive feature work**.
- Buffer 15% per phase sudah dimasukkan dalam estimasi.
- Asumsi tidak ada turnover, tidak ada extended leave, tidak ada inisiatif kejutan dari management.

---

## Cross-cutting concerns

| Aspek | Komitmen |
|---|---|
| **Maintenance ongoing** | ~25% kapasitas reserved untuk bug fix, support user, request kecil |
| **Security review** | 1× per akhir phase, fokus modul baru yang ship di phase itu |
| **Performance baseline** | Dashboard exec wajib < 2 detik load di Phase 3; SOP viewer < 1 detik |
| **Test coverage** | Modul baru target ≥ 50% unit + integration test untuk critical path |
| **Help center update** | Setiap fitur user-facing baru → update `ms_doc_workflow` + inline help button |
| **Permission matrix** | Setiap modul baru wajib registered di permission system existing |

---

## Risks & dependencies

| Risk | Mitigasi |
|---|---|
| **AI compliance clearance tidak keluar / negatif** | Roadmap sudah didesain AI sebagai optional. Phase 2–4 tetap deliverable tanpa AI. Kalau benar-benar negatif untuk semua tier, drop AI workstream + isi slot dengan Risk Register lebih awal. |
| **BA pivot migration — data lama corrupt** | Backup penuh sebelum migrasi; staging environment test dulu; rollback plan dengan downtime ≤ 1 jam |
| **Capacity tergerus support/maintenance > 25%** | Tracking ticket support per minggu; kalau > 30% selama 4 minggu berturut, re-plan phase berikutnya |
| **SOP Tier 2 lifecycle terlalu kompleks untuk user** | Phase 1 design sprint harus include validasi mockup dengan 2–3 real user sebelum coding |
| **Dependency turnover dev** | Dokumentasi tiap fitur di `docs/workflows/`; pair review semua PR besar |

---

## Decisions parked

| Decision | Status | Re-evaluasi |
|---|---|---|
| AI provider tier (B/C/D) | Pending compliance check | End of Phase 1 |
| Mobile native vs PWA | Pending | Awal Phase 4 |
| SOP Tier 4 (training + quiz/competency tracking) | Out of scope 12 bulan | Q3 2027 |
| Multi-tenant (kalau ada anak perusahaan Tirta lain pakai) | Out of scope | TBD |
| Integrasi HR system | Out of scope | TBD |

---

## Roadmap pada satu halaman

```
2026                                                       2027
 J   J   A   S   O   N   D   J   F   M   A   M
 ├───┴───┼───┴───┴───┼───┴───┴───┴───┼───┴───┴───┤
 │ Ph 1  │  Phase 2  │   Phase 3     │  Phase 4  │
 │ Found │ SOP + BA  │ Integr + Dash │ Risk+Mob  │
 │       │   pivot   │               │           │
 │       │           │               │           │
 │ PICA  │ SOP T2    │ SOP↔BA/PICA   │ Risk reg  │
 │ v2 f3 │ BA pivot  │ Dashboard exe │ Mobile    │
 │ SOP   │ [AI PoC]  │ [AI sugst]    │ [AI chat] │
 │ design│           │               │           │
 │ AI    │           │               │           │
 │ check │           │               │           │
```

`[...]` = conditional pada compliance clearance.
