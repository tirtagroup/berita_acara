# Workflow: PICA v2 (Problem Identification & Corrective Action)

## Tujuan
Modul untuk **analisis akar masalah multi-participant** dengan Q&A forum-style. PICA bisa standalone atau tindak-lanjut BA. Pelaku **wajib** menjawab semua pertanyaan/pernyataan yang ditandai `wajib_jawab` sebelum PICA bisa diteruskan ke action planning & closed.

> 📌 **Status doc**: Design plan v2. Implementasi terpisah dari modul PICA legacy (yang ada `Tr_PICA_Controller`). Modul baru akan parallel di path `/pica/v2/*`.

## Arsitektur HYBRID

**Dua fase**:

| Fase | Tabel | Tujuan |
|---|---|---|
| **Working / Discussion** | `tr_pica_pertanyaan_d` + `tr_pica_jawaban` | Multi-participant Q&A. Pelaku/PIC/dewan diskusi, jawab pertanyaan, kasih komentar. |
| **Compiled Report** | `tr_pica_reports` + `tr_pica_report_why` + `tr_pica_report_action` | Output formal terstruktur, mengikuti standar investigasi (sections A-G). |

PIC compile jawaban dari Q&A ke dokumen final structured. Q&A boleh tetap berlangsung selagi compile.

### Sections Structured Report (A-G)

| Section | Isi | Storage |
|---|---|---|
| A. Identification | 5W + 2H (What/When/Where/Who/Why awal/How/HowMuch) — text narrative per dimensi | Kolom inline di `tr_pica_reports` |
| B. 4M + 1E Analysis | Narrative per faktor (Man/Machine/Material/Method/Environment) | Kolom inline di `tr_pica_reports` |
| C. 5 Why | Dynamic rows (bisa lebih atau kurang dari 5). Tiap row: pertanyaan + jawaban | `tr_pica_report_why` (multi-row) |
| D. Corrective Action | Multi-row: deskripsi, PIC, deadline, status | `tr_pica_report_action` (tipe=corrective) |
| E. Preventive Action | Multi-row: deskripsi, PIC, deadline, status | `tr_pica_report_action` (tipe=preventive) |
| F. Verification | KPI, review schedule, audit result | Kolom inline |
| G. Closure | Approver, closure date, pelajaran, dokumentasi path | Kolom inline |

---

## Konsep Inti

**Forum-style multi-participant** (working phase):
- **PIC** = facilitator yang setup PICA (otomatis = user yang create)
- **Pelaku** = subject masalah (1 orang, harus jawab semua wajib)
- **Dewan** = member observer/contributor (banyak, bisa kasih komentar/pertanyaan tambahan)

**Pertanyaan & Pernyataan**:
- **Pertanyaan** (question) — pelaku menjawab dengan text
- **Pernyataan** (statement) — pelaku ack: Setuju / Tidak Setuju + reasoning

**Source pertanyaan**:
- **Wajib Universal** — master pertanyaan yang auto-include di semua PICA
- **Bantuan** — master library, PIC pilih saat setup
- **Bebas** — diketik ad-hoc, bisa ditambah oleh:
  - PIC saat setup wizard
  - **Semua participant** (pelaku/PIC/dewan) selama fase discussion
  - Tapi flag `wajib_jawab` hanya boleh di-toggle oleh **PIC** (karena affects close gate)
- Setiap pertanyaan tercatat `created_by` (user_id) — track siapa yang nambah

**Aturan close**:
- PICA tidak bisa naik ke status `ACTION_PLANNING` sebelum semua pertanyaan/pernyataan `wajib_jawab` sudah dijawab pelaku.
- PICA tidak bisa `CLOSED` sebelum action plan disusun & disetujui.

---

## Data Model

### Master (baru)

```
ms_pica_kategori
├── id, kode, nama, deskripsi
└── active, timestamps

ms_pica_pertanyaan_master
├── id, kode, pertanyaan, urutan
├── tipe: 'pertanyaan' | 'pernyataan'
├── scope: 'wajib_universal' | 'bantuan'
└── active, timestamps
```

### Header & Detail (extend existing)

```
Tr_PICA_Emp_h (existing — extend kolom)
├── Tr_Pica_Emp_h_Code (PK), Emp_Code (pelaku)
├── Problem_Note, Kapan_Terjadi
├── Status_PICA: 'DRAFT' | 'WAITING_PELAKU' | 'ACTION_PLANNING' | 'CLOSED'
├── ba_link_code (FK nullable ke Tr_Ba_Main_New)
└── ...

tr_pica_kategori_d (NEW pivot)
├── tr_pica_main_code (FK)
└── kategori_id (FK ms_pica_kategori)

tr_pica_participants (NEW)
├── tr_pica_main_code (FK)
├── user_id (FK users)
└── role: 'pelaku' | 'pic' | 'dewan'

Tr_PICA_Pertanyaan (existing — extend)
├── id, Tr_Pica_emp_h_Code (FK)
├── pertanyaan_master_id (FK ms_pica_pertanyaan_master, nullable bila bebas)
├── pertanyaan (text — salinan atau custom)
├── tipe: 'pertanyaan' | 'pernyataan'
├── wajib_jawab (bool)
└── urutan

tr_pica_jawaban (NEW — forum thread)
├── id, pertanyaan_id (FK Tr_PICA_Pertanyaan)
├── user_id (FK users)
├── jawaban (text) atau ack ('setuju' | 'tidak_setuju') + reasoning
├── is_final (bool — jawaban final dari pelaku)
└── timestamp

Tr_PICA_Action (existing) — corrective action
Tr_PICA_Preventive_Action (existing) — preventive action
Tr_PICA_Comment (existing) — comments
```

### Reuse

- `ms_business_unit` (konteks LAKA/FNB/OP_HR/REVISI) — shared dengan BA v2.
- `master_employees` (untuk pick pelaku, dewan).

---

## Workflow & Status

```
[PIC create wizard] 
    │
    ↓
DRAFT (wizard belum submit)
    │ Submit wizard
    ↓
PREPARING  ← baru: fase persiapan pertanyaan oleh Dewan
    │ Dewan tambah pertanyaan (toggle wajib_jawab default off, PIC bisa override)
    │ Pelaku boleh lihat & kasih komentar (belum is_final)
    │ Trigger transisi: PIC klik "Lock & kirim ke pelaku" ATAU Pelaku klik "Saya siap menjawab"
    ↓
WAITING_PELAKU
    │ Pelaku jawab semua wajib_jawab (is_final=true)
    │ Dewan/PIC kasih komentar/follow-up
    ↓ (validasi: semua wajib_jawab terisi)
ACTION_PLANNING
    │ PIC + dewan susun corrective + preventive action
    ↓
CLOSED
```

**Permission per fase:**

| Fase | PIC | Dewan | Pelaku |
|---|---|---|---|
| PREPARING | tambah Q, toggle wajib bebas, komentar, **trigger ke WAITING_PELAKU** | tambah Q (wajib default off), komentar | lihat read-only, komentar, **trigger ke WAITING_PELAKU** (self-start) |
| WAITING_PELAKU | komentar, tambah Q follow-up | komentar, tambah Q follow-up | **jawab is_final**, komentar |
| ACTION_PLANNING | susun action, klik CLOSED | susun action | komentar |
| CLOSED | read-only | read-only | read-only |

---

## Wizard Create PICA (6 step)

```
1.BU/Konteks  →  2.BA Link  →  3.Data Umum  →  4.Participants  →  5.Setup Q  →  6.Submit
```

| Step | Isi |
|---|---|
| 1. BU/Konteks | Pilih LAKA/FNB/OP_HR/REVISI (reuse `ms_business_unit`) |
| 2. BA Link | Opsional: pilih BA induk (Select2 AJAX `/api/ba/search`) |
| 3. Data Umum | Pelaku (Select2 emp), Tanggal, Problem note, Kategori PICA (multi-select) |
| 4. Participants | PIC auto = creator. Pick Dewan members (multi-select karyawan) |
| 5. Setup Q | Wajib universal auto-include (locked). Pick Bantuan (checklist dari master). Tambah Bebas (form). Per item: toggle `wajib_jawab` |
| 6. Submit | Review & create. Status → **PREPARING**. Redirect ke discussion page (mode PREPARING — Dewan boleh tambah pertanyaan dulu sebelum pelaku mulai jawab) |

---

## Halaman PICA Discussion (post-create)

URL: `/pica/v2/discussion?kode=X`

Forum-style — semua participant bisa interact:

```
┌──────────────────────────────────────────────────────────┐
│ PICA #PICA-XXX  | Status: WAITING_PELAKU                 │
│ BA Induk: BA-XXX  |  Pelaku: Budi  PIC: Andi             │
│ Dewan: Citra, Dewi                                       │
├──────────────────────────────────────────────────────────┤
│                                                          │
│ Q1 (WAJIB) — Mengapa terjadi?                           │
│   ★ Pelaku (Budi): "Karena saya lupa cek SOP..."         │
│   💬 PIC: "Kapan terakhir baca SOP?"                     │
│   💬 Dewan (Citra): "Apakah SOP terbaru sudah ada?"      │
│   [+ Tambah jawaban/komentar]                            │
│                                                          │
│ Pernyataan 1 (WAJIB) — Pelaku terbukti melanggar SOP    │
│   ★ Pelaku (Budi): ○ Setuju  ● Tidak Setuju             │
│     "Karena saya pikir SOP lama yang berlaku..."         │
│   💬 PIC: "Kami akan cek versi SOP saat itu"             │
│                                                          │
│ Q2 (BEBAS, wajib_jawab) — Kondisi alat saat itu?         │
│   [⏳ Menunggu pelaku jawab]                              │
│                                                          │
│ [Tambah pertanyaan baru ←PIC/Dewan]                      │
│                                                          │
│ Status Pelaku: 2/3 wajib_jawab terisi                   │
│ [Lanjut ke Action Plan →]  (disabled bila belum lengkap)│
└──────────────────────────────────────────────────────────┘
```

**Permission**:
- Semua participant bisa **add comment** per pertanyaan
- Semua participant bisa **add pertanyaan baru** (PIC mark `wajib_jawab` bila perlu)
- Hanya **Pelaku** yang bisa `is_final=true` (jawaban akhir)
- Hanya **PIC** yang bisa toggle status PICA ke next phase

---

## Halaman PICA Action

URL: `/pica/v2/action?kode=X`

Setelah status `ACTION_PLANNING`:
- List corrective actions (PIC, deadline, status pelaksanaan)
- List preventive actions
- Tombol "Tutup PICA → CLOSED" (validate: ada minimal 1 action + 1 preventive)

---

## Admin Master

| URL | Fungsi |
|---|---|
| `/master/pica/kategori` | CRUD ms_pica_kategori |
| `/master/pica/pertanyaan` | CRUD ms_pica_pertanyaan_master (set tipe & scope) |

Admin bisa atur:
- Tipe: pertanyaan vs pernyataan
- Scope: wajib_universal (auto di semua PICA) vs bantuan (PIC pilih)

---

## Dashboard PICA v2

URL: `/pica/v2/dashboard` (mirip dashboard BA, 5-tab konteks).

**Cards**: Total PICA per status (Draft/Waiting/Action/Closed)
**Charts**:
- Donut: PICA per konteks
- Line: trend daily
- Bar: top kategori PICA
- Bar: top root cause (dari pertanyaan analysis)

**Recent PICA table** dengan link ke detail.

---

## Integrasi BA v2 ↔ PICA v2

Di **detail BA v2** (`/beritaacara/v2/show?kode=X`):
- Tampilkan section "PICA terkait" — list PICA yang ba_link_code = BA kode ini
- Tombol "[+ Buat PICA dari BA ini]" → redirect ke `/pica/v2/create?ba_code=X` (auto-fill step 2)

Di **detail PICA**: tampilkan link balik ke BA induk (bila ada).

---

## Roadmap Implementasi

| Fase | Scope | Effort |
|---|---|---|
| 1 | Migration (5 tabel baru) + master kategori PICA & pertanyaan + admin UI | Sedang (3-4 hari) |
| 2 | Wizard create PICA (6-step) | Sedang (3 hari) |
| 3 | Discussion page (forum Q&A) — utama | Besar (4-5 hari) |
| 4 | Action page + close workflow | Sedang (2 hari) |
| 5 | Dashboard + list + detail page | Sedang (2-3 hari) |
| 6 | Integrasi BA-PICA + memberitahu participants (notifikasi) | Kecil (1-2 hari) |

---

## Aturan Domain (Project Memory)

1. **PIC = creator** (self-assign saat create wizard).
2. **PICA tidak bisa close** sebelum pelaku jawab semua pertanyaan/pernyataan `wajib_jawab`.
3. **Pertanyaan wajib_universal** auto-include di semua PICA (tidak bisa dihapus oleh PIC).
4. **Multi-participant Q&A**: semua boleh kasih komentar, tapi **jawaban final adalah dari pelaku** (flag `is_final`).
5. **Dewan dipilih per-PICA** — bukan role global.
