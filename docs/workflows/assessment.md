# Workflow: Assessment / Penilaian Karyawan

## Tujuan
Penilaian karyawan periodik dengan beberapa dimensi: **basic competency**, **advance/leadership**, **kedisiplinan**, serta penyusunan **target task** per periode.

## Role 🟡 ASUMSI

| Role | Peran |
|---|---|
| **HRD** | Set periode, set target karyawan, validasi final |
| **SPV / Atasan langsung** | Penilaian basic & kedisiplinan, set task target |
| **Reviewer 1..N** | Penilaian advance/leadership (multi-reviewer) |
| **Karyawan** | Subject penilaian — bisa self-assessment di tahap awal? |

## Alur Utama 🟡 ASUMSI

```
[HRD]
    │ 1. Buka periode assessment baru
    ▼
┌──────────────────────────┐
│ ms_periode_assessment    │  ── periode_code, tahun, kuartal
└──────────────────────────┘
    │
    │ 2. Set target/task per karyawan
    ▼
┌──────────────────────────┐
│ tr_period_emp            │  ── enroll karyawan ke periode
│ tr_period_emp_task       │  ── target task tertulis
└──────────────────────────┘
    │
    │ 3. SPV / Atasan input penilaian
    ▼
┌──────────────────────────────────┐
│ tr_emp_assesment (header)        │
│   ├─ tr_emp_asses_basic_result   │  ← penilaian basic
│   ├─ tr_emp_asses_advance_result │  ← penilaian advance
│   ├─ tr_emp_asses_discipline_*   │  ← kedisiplinan
│   └─ tr_emp_asses_note           │  ← catatan kualitatif
└──────────────────────────────────┘
    │
    │ 4. Multi-reviewer untuk advance/leadership
    ▼
┌──────────────────────────────────┐
│ Tr_Review_EmpPeriod_h            │
│   ├─ Basic_Reviewer              │
│   ├─ Task_Reviewer               │
│   ├─ Adv_Reviewer_h + _d         │
│   └─ Tr_Review_EmpPeriod_BA      │  ← review BA history?
└──────────────────────────────────┘
    │
    │ 5. Result aggregation (basic + advance + discipline)
    ▼
┌──────────────────────────┐
│ tr_task_result           │  ── nilai akhir per task
└──────────────────────────┘
    │
    │ 6. HRD finalisasi & print
    ▼
[PDF assessment per karyawan]
```

## Variant Assessment

| Tipe | Form Edit | Tabel Result |
|---|---|---|
| **Basic** | `assasmen_basic.blade.php` | `tr_emp_asses_basic_result` (legacy: `tr_ass_d_basic`) |
| **Basic - HRD review** | `assasmen_besic_edit_hrd.blade.php` | UPDATE basic result |
| **Basic - SPV review** | `assasmen_besic_edit_spv.blade.php` | UPDATE basic result |
| **Advance / Leadership** | `create_asasmen_leadership[1-4].blade.php` | `tr_emp_asses_advance_result` |
| **Kedisiplinan** | `create_asasmen_kedisiplinan[1-4].blade.php` | `tr_emp_asses_discipline_result` |

> Catatan: folder `resources/views/asasmen_lama/` adalah versi **legacy** — yang aktif di `resources/views/asasmen/`.

## Rating Master

`ms_rating_asasmen_basic` — referensi nilai/rating yang valid (mis. A, B, C, D atau 1-5). Cek nilai aktual di DB.

## Tabel yang Ter-update

Lihat detail kolom di [docs/tables/assessment.md](../tables/assessment.md).

## Route & Controller

Controller: `Tr_AssasmenController` (26 method).

Endpoint utama:
- `GET /assasmen_basic` — form input basic
- `GET /assasmen_basic_edit_hrd` — review oleh HRD
- `GET /assasmen_basic_edit_spv` — review oleh SPV
- `GET /add_target` — set task target
- `GET /history_asasmen` — riwayat penilaian per karyawan
- `GET /print_asasmen/{id}` — cetak PDF (variant: `_hrd`, `_spv`)
- `GET /report_asesmen_data` — report data agregat
- `GET /report_asesmen_nilai` — report nilai numerik

## Edge Case 🟡 ASUMSI

- **Karyawan resign mid-periode**: assessment partial dilanjut atau dibatalkan?
- **Reviewer absent**: bypass atau extend deadline?
- **Self-assessment**: ada tahapan karyawan menilai diri sendiri?
- **Banding**: bila karyawan tidak setuju dengan hasil, ada mekanisme review?

---

> **Action item**: Tim HRD mohon konfirmasi tahapan, urutan reviewer, dan rumus aggregasi nilai akhir.
