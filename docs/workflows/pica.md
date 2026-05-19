# Workflow: PICA (Problem Identification & Corrective Action)

## Tujuan
Setelah masalah teridentifikasi (sering kali sebagai tindak lanjut BA), PICA dipakai untuk: (1) mencari **akar masalah** lewat pertanyaan investigatif, (2) menyusun **tindakan korektif** (corrective action), dan (3) menyusun **tindakan preventif** agar tidak terulang.

## Role 🟡 ASUMSI

| Role | Peran |
|---|---|
| **HRD / Supervisor** | Membuat PICA, assign ke karyawan terkait |
| **Karyawan terkait** | Mengisi pertanyaan investigatif & action plan |
| **Atasan / Reviewer** | Memberikan komentar, approve PICA |

## Alur Utama 🟡 ASUMSI

```
[Masalah teridentifikasi — biasanya dari BA atau temuan operasional]
    │
    │ 1. HRD/SPV membuat PICA header
    ▼
┌────────────────────────────┐
│ Tr_PICA_Emp_h              │
│ Status_PICA: 'OPEN'        │  ──→ assign Emp_Code (karyawan)
│ Problem_Note: deskripsi    │
│ Kapan_Terjadi: timestamp   │
└────────────────────────────┘
    │
    │ 2. Karyawan menjawab pertanyaan investigatif (Why 1..5)
    ▼
┌────────────────────────────┐
│ Tr_PICA_Pertanyaan         │  (multi-row per PICA)
└────────────────────────────┘
    │
    │ 3. Karyawan menyusun corrective action
    ▼
┌────────────────────────────┐
│ Tr_PICA_Action             │  (PIC, deadline, status)
└────────────────────────────┘
    │
    │ 4. Karyawan menyusun preventive action
    ▼
┌────────────────────────────┐
│ Tr_PICA_Preventive_Action  │
└────────────────────────────┘
    │
    │ 5. Atasan review & beri komentar
    ▼
┌────────────────────────────┐
│ Tr_PICA_Comment            │  ──→ 'sudah dilihat' flag
└────────────────────────────┘
    │
    │ 6. Approve → Status_PICA: 'CLOSED'
    │    Reject  → Status_PICA: 'REVISI'
    ▼
[Done atau Loop ke step 2]
```

## Status PICA (nilai di `Tr_PICA_Emp_h.Status_PICA`) 🟡 ASUMSI

Perlu cek nilai aktual di DB produksi:

| Status | Arti |
|---|---|
| `OPEN` | Baru dibuat, menunggu pengisian |
| `IN_PROGRESS` | Karyawan sedang mengisi |
| `REVIEW` | Menunggu approval atasan |
| `REVISI` | Atasan minta perbaikan |
| `CLOSED` | Selesai |

## Tabel yang Ter-update

Lihat detail kolom di [docs/tables/pica.md](../tables/pica.md).

| Tabel | Operasi |
|---|---|
| `Tr_PICA_Emp_h` | INSERT (saat PICA dibuat) + UPDATE (perpindahan status) |
| `Tr_Pica_Emp_D` | INSERT (detail per item, bila ada) |
| `Tr_PICA_Pertanyaan` | INSERT (per jawaban investigatif) |
| `Tr_PICA_Action` | INSERT/UPDATE (corrective action + status pelaksanaan) |
| `Tr_PICA_Preventive_Action` | INSERT/UPDATE (preventive action) |
| `Tr_PICA_Comment` | INSERT (komentar dari reviewer / "sudah dilihat" flag) |

## Route & Controller

Controller: `Tr_PICA_Controller`.

Endpoint utama:
- `GET /dashboard_pica` — dashboard (default 1 bulan terakhir, lihat [conventions.md](../conventions.md#1-default-date-range-untuk-filter))
- `POST /search_report_pica` — filter per tanggal
- `GET /detail_check_pica/{id}` — detail per kode PICA
- `GET /reprint_pica/{id}` — cetak PDF

## Generated Code (auto-number) 🟡 OBSERVED

Kode PICA dibentuk: `Comment{weekOfYear}{tahun}{random3digit}` — generated di `Tr_PICA_Controller::detail_check_pica`.

Format `Tr_Pica_Emp_h_Code` perlu dicek di kode `create_pica` (TODO trace).

## Hubungan dengan BA

PICA biasanya **dipicu** oleh BA yang sudah closed. Tracing link antara `Tr_Ba_Main_New` → `Tr_PICA_Emp_h` perlu dikonfirmasi (apakah ada `BA_Code` FK di header PICA?).

## Edge Case 🟡 ASUMSI

- **PICA tanpa BA**: bisa dibuat standalone untuk temuan operasional biasa?
- **Multiple karyawan**: satu PICA bisa assign ke beberapa karyawan? Atau satu-per-satu?
- **Deadline action**: ada reminder otomatis?

---

> **Action item**: Tim HR/IT mohon konfirmasi nilai `Status_PICA`, alur trigger (BA → PICA), dan business rule lainnya.
