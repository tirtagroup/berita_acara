# Workflow: Rekrutmen / Kandidat

## Tujuan
Mengelola seluruh siklus rekrutmen: pencatatan kandidat, CV detail, panggilan, jadwal interview, shortlist, hingga proses dengan jobportal/anak perusahaan.

## Role 🟡 ASUMSI

| Role | Peran |
|---|---|
| **HRD Recruiter** | Input kandidat, panggil, atur interview, shortlist |
| **HRD Interviewer** | Wawancara tahap HRD |
| **User Interviewer** (mis. SPV/Manager dept tujuan) | Wawancara tahap user |
| **Anak Perusahaan** (via `LoginCompanyController`) | Lihat kandidat yang dialokasikan, beri feedback |
| **Kandidat** | Mengisi data (via form publik?) atau direkam oleh HRD |

## Alur Utama 🟡 ASUMSI

```
┌─────────────────────────────────────────────────────────────┐
│ TAHAP 1 — INTAKE                                            │
└─────────────────────────────────────────────────────────────┘
[HRD]
    │ Input data dasar kandidat
    ▼
┌──────────────────┐
│ tr_candidate     │ ── nama, kontak, posisi, sumber (`ms_recruit_from`)
└──────────────────┘
    │
    │ Upload CV (driver atau non-driver)
    ▼
┌──────────────────┐
│ candidate_cv     │
│ candidate_photos │
└──────────────────┘

┌─────────────────────────────────────────────────────────────┐
│ TAHAP 2 — CV DETAIL (multi-tabel)                           │
└─────────────────────────────────────────────────────────────┘
    │ Form CV lengkap
    ▼
┌──────────────────────────┐
│ candidate_pendidikanya   │ ── riwayat pendidikan
│ candidate_pengalaman*    │ ── pengalaman kerja (v1/v2/v3)
│ candidate_skill*         │ ── skill
│ candidate_keluarga*      │ ── data keluarga
│ candidate_organisasi*    │ ── organisasi
│ candidate_sosmed*        │ ── sosial media
└──────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│ TAHAP 3 — PANGGILAN                                         │
└─────────────────────────────────────────────────────────────┘
[HRD]
    │ Panggil kandidat
    ▼
┌──────────────────────┐
│ tr_candidate_call_h  │ ── header panggilan
│ tr_candidate_call    │ ── log panggilan
└──────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│ TAHAP 4 — INTERVIEW                                         │
└─────────────────────────────────────────────────────────────┘
[HRD]
    │ Atur jadwal
    ▼
┌──────────────────────┐
│ tr_int_sched         │ ── jadwal interview
└──────────────────────┘
    │
    ├─→ Interview HRD
    │     │
    │     ▼
    │   ┌──────────────────────────┐
    │   │ tr_report_lowongan_interview │
    │   └──────────────────────────┘
    │
    └─→ Interview User (anak perusahaan / dept tujuan)
          │
          ▼
        ┌──────────────────────────────────┐
        │ tr_report_lowongan_interview_kedua │
        └──────────────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│ TAHAP 5 — SHORTLIST                                         │
└─────────────────────────────────────────────────────────────┘
[HRD]
    │ Move kandidat ke shortlist
    ▼
┌──────────────────────────┐
│ tr_shortlist_tracking    │
│ tr_candidate_sorted      │
└──────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│ ALUR PARALEL — JOBPORTAL                                    │
└─────────────────────────────────────────────────────────────┘
[Jobportal sync — sumber kandidat dari job portal eksternal]
    │
    ▼
┌──────────────────────────┐
│ tr_candidate_jobportal   │
└──────────────────────────┘
```

## Variant: Driver vs Non-Driver

Endpoint terpisah:
- `POST /store_cv` — non-driver (CV lengkap dengan pendidikan, pengalaman, dll.)
- `POST /store_cv_driver` — driver (form lebih ringkas, fokus SIM, pengalaman menyetir)

## Status Kandidat 🟡 ASUMSI

Perlu cek nilai aktual:

| Status | Arti |
|---|---|
| `BARU` | Baru masuk, belum dipanggil |
| `DIPANGGIL` | Sudah dipanggil HRD |
| `INTERVIEW_HRD` | Sudah interview tahap 1 |
| `INTERVIEW_USER` | Sudah interview tahap 2 |
| `SHORTLISTED` | Lolos ke shortlist |
| `OFFERED` | Sudah ditawari posisi |
| `HIRED` | Diterima |
| `REJECTED` | Tidak lolos |
| `BLACKLISTED` | Di-blacklist |

## Login per Perusahaan (Anak Perusahaan)

Anak perusahaan/mitra dapat login terpisah untuk melihat:
- `/kandidat_belum_interview` — kandidat yang assigned ke perusahaan mereka
- `/detail_kandidat_belum_interview/{id}` — detail kandidat
- `/detail_kandidat_tidak_terhubung/{id}` — kandidat yang tidak bisa dihubungi

Lihat [login-company.md](login-company.md).

## Tabel yang Ter-update

Lihat detail kolom di [docs/tables/rekrutmen.md](../tables/rekrutmen.md).

Tabel dashboard agregat (read-only views): `all_kandidats`, `hrd_main`, `hrd_main_belum_shortlist`, `view_applicant_by_*`.

## Route & Controller

Controller utama: `tr_candidateController` (23 route), `Report_HRD_Controller` (24 route).

Lihat [docs/routes.md → Rekrutmen](../routes.md#rekrutmen--kandidat-23--24-route).

## Edge Case 🟡 ASUMSI

- **Kandidat duplikat** (sama orang daftar lagi): dicek dengan NIK / email?
- **Kandidat dari jobportal**: auto-sync atau manual import?
- **Blacklist**: ada flag di `tr_candidate` atau tabel terpisah?
- **GDPR / privacy**: ada retention policy untuk data kandidat yang tidak diterima?

---

> **Action item**: Tim HRD recruiter mohon konfirmasi alur, nilai status, dan integrasi jobportal.
