# Workflow: Login per Perusahaan (Mitra / Anak Perusahaan)

## Tujuan
Memberikan akses terbatas kepada **user dari anak perusahaan / mitra** untuk melihat & melakukan tindakan terhadap kandidat / BA yang relevan dengan perusahaan mereka, tanpa membuka akses penuh ke aplikasi HR utama.

## Role 🟡 ASUMSI

| Role | Peran |
|---|---|
| **HRD Pusat** | Set kredensial login per perusahaan, alokasikan kandidat |
| **User Anak Perusahaan** | Login → lihat kandidat assigned → beri feedback / interview |

## Alur Login 🟡 ASUMSI

```
[User mitra]
    │ Akses URL login khusus
    ▼
┌────────────────────────┐
│ LoginCompanyController │ ── auth via tabel terpisah / flag di users
└────────────────────────┘
    │
    │ Authenticated
    ▼
┌─────────────────────────────────┐
│ Dashboard Perusahaan            │
│   ├─ Kandidat belum interview   │
│   ├─ Kandidat sudah interview   │
│   └─ Kandidat tidak terhubung   │
└─────────────────────────────────┘
```

## Endpoint yang Tersedia

Controller `LoginCompanyController` punya 32 route. Endpoint utama:

| URI | Tujuan |
|---|---|
| `/kandidat_belum_interview` | Daftar kandidat menunggu interview di perusahaan ini |
| `/detail_kandidat_belum_interview/{id}` | Detail per kandidat |
| `/detail_kandidat_tidak_terhubung/{id}` | Kandidat yang sudah dipanggil tapi tidak respons |

## Akses Data 🟡 ASUMSI

Filter data kemungkinan berdasarkan `ms_company.company_code` yang di-bind ke user mitra. Setiap query di controller harus filter `WHERE company_code = <user_company>`.

> **Penting**: pastikan ada **filter authorization** yang ketat — user mitra hanya boleh lihat kandidat yang assigned ke perusahaan mereka, tidak boleh akses data perusahaan lain.

## Hubungan dengan Rekrutmen

User mitra menerima kandidat hasil **shortlist** dari HRD pusat, kemudian melakukan interview tahap user. Hasilnya tercatat di `tr_report_lowongan_interview_kedua`.

Lihat [rekrutmen.md → Tahap 4](rekrutmen.md#tahap-4--interview).

## Edge Case 🟡 ASUMSI

- **User mitra mengakses URL kandidat perusahaan lain**: harus di-reject dengan 403.
- **Beberapa user di satu perusahaan**: bisa? Akses identik atau ada role-level?
- **Audit log**: aksi user mitra (kandidat dilihat, interview disubmit) ter-record di mana?

---

> **Action item**: Cek implementasi filter `company_code` di setiap method `LoginCompanyController` untuk memastikan tidak ada bypass authorization.
