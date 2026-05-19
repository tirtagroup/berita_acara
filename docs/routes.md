# Routes & Modul Fungsional

Peta route dan controller di project BA-PICA. Codebase berisi **167 controller** — sebagian besar adalah demo template Sneat/Materio dan **tidak dipakai**. Yang relevan untuk produksi ada di **root `app/Http/Controllers/`**.

---

## Authentication

| Method | URI | Action |
|---|---|---|
| GET | `/` | `LoginController@login` — halaman login |
| POST | `/actionlogin` | `LoginController@actionlogin` |
| GET | `/actionlogout` | `LoginController@actionlogout` |
| GET | `/ForgotPassword` | `ForgotPasswordController@index` |
| POST | `/ForgotPassword/action` | kirim email reset |
| GET | `/forgotpassword/update/{verifykey}` | form reset password |
| GET | `/register-employee-hgs` | `RegisterController@register` |
| POST | `/register/action` | `RegisterController@actionregister` |
| GET | `/register/verify/{verify_key}` | konfirmasi email |
| GET | `/home` | `HomeController@index` (middleware: `auth`) |

---

## Berita Acara (62 route — modul terbesar)

| Method | URI (pola) | Keterangan |
|---|---|---|
| GET | `/dashboard_ba` | Dashboard ringkasan BA |
| GET | `/berita_acara_all` | List semua BA |
| GET | `/beritaacara/create` | Form input BA baru |
| POST | `/beritaacara/store` | Simpan BA |
| GET | `/detail_validasi/{id}` | Detail validasi (per level: koord/manager/gm/bod/it) |
| POST | `/store_validasi/...` | Submit validasi (4 endpoint untuk tiap role validator) |
| GET | `/print_ba/{id}` | Cetak BA (HTML + PDF) |
| GET | `/ba_laka/...` | Sub-modul Berita Acara Kecelakaan Kerja |
| GET | `/search_report_ba` | Pencarian laporan |
| GET | `/dashboard_revisi` | Daftar BA yang minta revisi |

**Controller**: `BeritaAcaraController` (62 route, file terbesar di project)

---

## PICA — Problem Identification & Corrective Action

| Method | URI | Keterangan |
|---|---|---|
| GET | `/dashboard_pica` | Dashboard PICA (default: data 1 bulan terakhir) |
| POST | `/search_report_pica` | Filter PICA per tanggal |
| GET | `/detail_check_pica/{id}` | Detail PICA per kode |
| GET | `/reprint_pica/{id}` | Cetak PDF PICA |

**Controller**: `Tr_PICA_Controller`

---

## Assessment / Asasmen (26 route)

| Method | URI (pola) | Keterangan |
|---|---|---|
| GET | `/assasmen_basic` | Form penilaian basic |
| GET | `/assasmen_basic_edit_hrd` | Edit oleh HRD |
| GET | `/assasmen_basic_edit_spv` | Edit oleh Supervisor |
| GET | `/add_target` | Tambah target karyawan |
| GET | `/history_asasmen` | Riwayat |
| GET | `/print_asasmen/{id}` | Cetak hasil assessment (basic / HRD / SPV) |
| GET | `/report_asesmen_data` | Report data |
| GET | `/report_asesmen_nilai` | Report nilai |

**Controller**: `Tr_AssasmenController`

---

## Surat Peringatan (SP)

**Controller**: `Tr_Sp_Controller`, `MS_Type_SP_Controller` (master tipe SP)

URL pattern: `/sp/*`, `/ms_type_sp/*`

---

## Rekrutmen / Kandidat (23 + 24 route)

| Method | URI (pola) | Keterangan |
|---|---|---|
| GET | `/isi_kandidat` | Form input kandidat baru |
| POST | `/store_cv` | Upload CV |
| POST | `/store_cv_driver` | Upload CV (kategori driver) |
| GET | `/detail_kandidat_progress` | Progress kandidat |
| GET | `/shortlist` | Daftar shortlist |
| POST | `/shortlistPost` | Update status shortlist |
| GET | `/lihat_jadwal` | Jadwal interview |
| POST | `/post_interview_jobportal` | Submit hasil interview job portal |
| GET | `/report_call` | Report panggilan |
| GET | `/report_interview` | Report interview |
| GET | `/CandidateRegister` | Registrasi kandidat |
| GET | `/list_report_daily` / `_weekly` / `_monthly` | Periodik HRD |

**Controller**: `tr_candidateController` (23 route), `Report_HRD_Controller` (24 route)

---

## Login per Perusahaan (32 route)

Khusus user dari anak perusahaan / mitra:

| Method | URI (pola) | Keterangan |
|---|---|---|
| GET | `/kandidat_belum_interview` | Daftar kandidat menunggu interview |
| GET | `/detail_kandidat_belum_interview/{id}` | Detail kandidat |
| GET | `/detail_kandidat_tidak_terhubung/{id}` | Daftar kandidat yang tidak terhubung |

**Controller**: `LoginCompanyController`

---

## Master Data

| URI (pola) | Controller | Resource |
|---|---|---|
| `/ms_company/*` | `MS_Company_Controller` | Perusahaan |
| `/ms_location/*` | `MsLocationController` | Lokasi |
| `/ms_type_sp/*` | `MS_Type_SP_Controller` | Tipe SP |
| `/kategori_ba/*` | `Kategori_BA_Controller` | Kategori BA |
| `/kasus_head/*` | `Kasus_Head_Controller` | Header kasus |
| `/detail_kasus/*` | `Detail_Kasus_Controller` | Detail kasus |
| `/master_multidetail/*` | `Master_MultiDetailKasus_Controller` | Multi detail kasus |

---

## Modul Lain

- `MentoringController` — modul Mentoring
- `PutusHubunganKerjaController` — modul PHK
- `ReportController`, `Report_HRD_Controller`, `ReportSecurityController` — laporan agregat
- `PDFController` — generator PDF generik
- `import_dataController` — import data Excel

---

## API Routes (`routes/api.php`)

Saat ini API hampir kosong — hanya endpoint user Sanctum default:

```php
Route::middleware('auth:sanctum')->get('/user', fn(Request $r) => $r->user());
```

**Tidak ada REST API** untuk modul bisnis. Semua interaksi data dilakukan via route `web.php` (form POST + redirect).

---

## Jumlah Route per Controller (top 10)

Hasil grep `routes/web.php`:

| Controller | Jumlah route |
|---|---|
| BeritaAcaraController | 62 |
| LoginCompanyController | 32 |
| Tr_AssasmenController | 26 |
| Report_HRD_Controller | 24 |
| tr_candidateController | 23 |
| UserssController | 7 |
| Tr_Sp_Controller | 4 |
| MsLocationController | 4 |
| MS_Type_SP_Controller | 4 |
| MS_Company_Controller | 4 |
