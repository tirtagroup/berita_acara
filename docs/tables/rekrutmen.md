# Rekrutmen & Kandidat

Tabel untuk modul rekrutmen: kandidat, CV lengkap (pendidikan, pengalaman, skill, keluarga, organisasi, sosmed), interview, jobportal, shortlist.

Sumber: database `tirt3038_HR_Worksheet` (kecuali disebut lain).

---

### `tr_candidate` — ~2542 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  |  |  |
| `rec_status` | `int(11)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |
| `deleted_at` | `timestamp` | YES |  |  |  |
| `Tr_report_hrd_main_code` | `varchar(100)` | YES |  |  |  |
| `ms_short_status` | `varchar(50)` | YES |  |  |  |
| `Name` | `varchar(100)` | YES |  |  |  |
| `nama_panggilan` | `varchar(50)` | YES |  |  |  |
| `masa_berlaku_ktp` | `varchar(50)` | YES |  |  |  |
| `alamat_ktp` | `varchar(100)` | YES |  |  |  |
| `masa_berlaku_sim` | `varchar(50)` | YES |  |  |  |
| `umur` | `varchar(50)` | YES |  |  |  |
| `nama_ibu` | `varchar(50)` | YES |  |  |  |
| `Email` | `varchar(100)` | YES |  |  |  |
| `Ktp` | `varchar(100)` | YES |  |  |  |
| `domisili` | `varchar(100)` | YES |  |  |  |
| `CityBirth` | `varchar(100)` | YES |  |  |  |
| `Birthdate` | `timestamp` | YES |  |  |  |
| `status` | `varchar(100)` | YES |  |  |  |
| `jenis_kelamin` | `varchar(100)` | YES |  |  |  |
| `agama` | `varchar(100)` | YES |  |  |  |
| `Handphone` | `varchar(100)` | YES |  |  |  |
| `pengajuan_gaji` | `varchar(100)` | YES |  |  |  |
| `info_lowongan` | `varchar(100)` | YES |  |  |  |
| `Position_aplly1` | `varchar(100)` | YES |  |  |  |
| `ketersediaan` | `varchar(100)` | YES |  |  |  |
| `layak` | `varchar(100)` | YES |  |  |  |
| `tanggal_ketesediaan` | `varchar(100)` | YES |  |  |  |
| `pasfoto` | `varchar(100)` | YES |  |  |  |
| `ms_candidate_type_code` | `varchar(100)` | YES |  |  |  |
| `patner` | `varchar(100)` | YES |  |  |  |
| `CekShorlist` | `varchar(100)` | YES |  |  |  |
| `status_shortlist` | `varchar(100)` | YES |  |  |  |
| `alasan_shortlist` | `varchar(100)` | YES |  |  |  |
| `DateShorlist` | `varchar(100)` | YES |  |  |  |
| `PICShortlist` | `varchar(100)` | YES |  |  |  |
| `CekCall` | `varchar(100)` | YES |  |  |  |
| `PICCall` | `varchar(100)` | YES |  |  |  |
| `DateCall` | `timestamp` | YES |  |  |  |
| `Cek_Sambung` | `varchar(100)` | YES |  |  |  |
| `alasan_sambung` | `varchar(100)` | YES |  |  |  |
| `jadwal_interview` | `varchar(100)` | YES |  |  |  |
| `CekInterview` | `varchar(100)` | YES |  |  |  |
| `PICInterview` | `varchar(100)` | YES |  |  |  |
| `DateInterview` | `timestamp` | YES |  |  |  |
| `status_interview` | `varchar(100)` | YES |  |  |  |
| `alasan_interview` | `varchar(500)` | YES |  |  |  |
| `ms_kode_interview1` | `varchar(100)` | YES |  |  |  |
| `CekInterview2` | `varchar(100)` | YES |  |  |  |
| `PICInterview2` | `varchar(100)` | YES |  |  |  |
| `DateInterview2` | `varchar(100)` | YES |  |  |  |
| `status_interview2` | `varchar(100)` | YES |  |  |  |
| `alasan_interview2` | `varchar(100)` | YES |  |  |  |
| `ms_kode_interview2` | `varchar(100)` | YES |  |  |  |
| `CekInterview3` | `varchar(100)` | YES |  |  |  |
| `PICInterview3` | `varchar(100)` | YES |  |  |  |
| `DateInterview3` | `varchar(100)` | YES |  |  |  |
| `status_interview3` | `varchar(100)` | YES |  |  |  |
| `alasan_interview3` | `varchar(100)` | YES |  |  |  |
| `ms_kode_interview3` | `varchar(100)` | YES |  |  |  |
| `CekCandidateRespond` | `int(1)` | YES |  |  |  |
| `CekCV` | `varchar(50)` | YES |  |  |  |
| `CekBio` | `int(1)` | YES |  |  |  |
| `CekWA` | `int(1)` | YES |  |  |  |
| `area_minat` | `varchar(100)` | YES |  |  |  |
| `no_sim` | `varchar(100)` | YES |  |  |  |
| `type_sim` | `varchar(100)` | YES |  |  |  |
| `Position_aplly2` | `varchar(100)` | YES |  |  |  |
| `riwayat_penyakit` | `varchar(100)` | YES |  |  |  |

### `tr_candidate_alll` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_Candidate_all` | `varchar(50)` | NO |  |  |  |
| `Media_Code` | `varchar(50)` | YES |  |  |  |
| `Date_Open` | `timestamp` | YES |  |  |  |
| `Sort` | `varchar(10)` | NO |  |  |  |
| `Called` | `varchar(10)` | NO |  |  |  |
| `Interview` | `varchar(10)` | NO |  |  |  |

### `tr_candidate_jobportal` — ~450 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  |  |  |
| `rec_status` | `int(11)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |
| `deleted_at` | `timestamp` | YES |  |  |  |
| `Tr_report_hrd_main_code` | `varchar(100)` | YES |  |  |  |
| `ms_short_status` | `varchar(50)` | YES |  |  |  |
| `Name` | `varchar(100)` | YES |  |  |  |
| `Ktp` | `varchar(100)` | YES |  |  |  |
| `domisili` | `varchar(100)` | YES |  |  |  |
| `CityBirth` | `varchar(100)` | YES |  |  |  |
| `Birthdate` | `timestamp` | YES |  |  |  |
| `status` | `varchar(100)` | YES |  |  |  |
| `jenis_kelamin` | `varchar(100)` | YES |  |  |  |
| `agama` | `varchar(100)` | YES |  |  |  |
| `Handphone` | `varchar(100)` | YES |  |  |  |
| `Email` | `varchar(100)` | YES |  |  |  |
| `pengajuan_gaji` | `varchar(100)` | YES |  |  |  |
| `info_lowongan` | `varchar(100)` | YES |  |  |  |
| `Position_aplly1` | `varchar(100)` | YES |  |  |  |
| `ketersediaan` | `varchar(100)` | YES |  |  |  |
| `layak` | `varchar(100)` | YES |  |  |  |
| `tanggal_ketesediaan` | `varchar(100)` | YES |  |  |  |
| `pasfoto` | `varchar(100)` | YES |  |  |  |
| `ms_candidate_type_code` | `varchar(100)` | YES |  |  |  |
| `patner` | `varchar(100)` | YES |  |  |  |
| `CekShorlist` | `varchar(100)` | YES |  |  |  |
| `status_shortlist` | `varchar(20)` | YES |  |  |  |
| `alasan_shortlist` | `varchar(100)` | YES |  |  |  |
| `DateShorlist` | `varchar(100)` | YES |  |  |  |
| `PICShortlist` | `varchar(100)` | YES |  |  |  |
| `CekCall` | `varchar(100)` | YES |  |  |  |
| `PICCall` | `varchar(100)` | YES |  |  |  |
| `DateCall` | `timestamp` | YES |  |  |  |
| `Cek_Sambung` | `varchar(100)` | YES |  |  |  |
| `alasan_sambung` | `varchar(100)` | YES |  |  |  |
| `jadwal_interview` | `varchar(100)` | YES |  |  |  |
| `CekInterview` | `varchar(100)` | YES |  |  |  |
| `PICInterview` | `varchar(100)` | YES |  |  |  |
| `DateInterview` | `timestamp` | YES |  |  |  |
| `status_interview` | `varchar(100)` | YES |  |  |  |
| `alasan_interview` | `varchar(500)` | YES |  |  |  |
| `CekCandidateRespond` | `int(1)` | YES |  |  |  |
| `CekCV` | `varchar(50)` | YES |  |  |  |
| `CekBio` | `int(1)` | YES |  |  |  |
| `CekWA` | `int(1)` | YES |  |  |  |
| `area_minat` | `varchar(100)` | YES |  |  |  |
| `no_sim` | `varchar(100)` | YES |  |  |  |
| `type_sim` | `varchar(100)` | YES |  |  |  |
| `Position_aplly2` | `varchar(100)` | YES |  |  |  |
| `riwayat_penyakit` | `varchar(100)` | YES |  |  |  |

### `tr_candidate_call` — ~4211 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  |  |  |
| `Ms_User_Code` | `varchar(50)` | YES |  |  |  |
| `Ms_UserUpdate` | `varchar(50)` | YES |  |  |  |
| `ms_divisi` | `varchar(50)` | YES |  |  |  |
| `Tr_Report_Lowongan_Call` | `varchar(100)` | YES |  |  |  |
| `Tr_report_hrd_main_code` | `varchar(50)` | YES |  |  |  |
| `Ms_ReportType_Code` | `varchar(50)` | YES |  |  |  |
| `Nama_kandidat` | `varchar(100)` | YES |  |  |  |
| `Ms_Media_Code` | `varchar(100)` | YES |  |  |  |
| `NamaLowongan` | `varchar(100)` | YES |  |  |  |
| `Ms_Perusahaan_Code` | `varchar(50)` | YES |  |  |  |
| `Telepon` | `varchar(100)` | YES |  |  |  |
| `Ms_Status` | `varchar(100)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |
| `Tr_Candidate_Sort_Code` | `varchar(50)` | YES |  |  |  |
| `Tr_status_interview` | `varchar(10)` | YES |  |  |  |
| `DateInt` | `date` | YES |  |  |  |
| `TimeInt` | `time` | YES |  |  |  |
| `RuangInt` | `varchar(20)` | YES |  |  |  |
| `ms_candidate_code` | `varchar(50)` | YES |  |  |  |

### `tr_candidate_call_h` — ~965 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  |  |  |
| `tr_candidate_call_code_h` | `varchar(50)` | YES |  |  |  |
| `Ms_Caller_code` | `varchar(50)` | YES |  |  |  |
| `Date_Call` | `timestamp` | YES |  |  |  |
| `Total_Call_HGS` | `varchar(10)` | YES |  |  |  |
| `Total_Call_TGU` | `varchar(10)` | YES |  |  |  |
| `Total_Call_TGF` | `varchar(10)` | YES |  |  |  |
| `Total_Call` | `varchar(10)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `tr_candidate_sorted` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_Candidate_Sorted_Code` | `varchar(50)` | NO |  |  |  |
| `Candidate_name` | `varchar(50)` | NO |  |  |  |
| `Media_Code` | `varchar(50)` | NO |  |  |  |
| `Jabatan_Code` | `varchar(50)` | NO |  |  |  |

### `candidate_cv` — ~2925 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | NO |  |  |  |
| `id_tr_candidate` | `int(11)` | YES |  |  |  |
| `Ktp` | `varchar(255)` | YES |  |  |  |
| `file_cv` | `varchar(255)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `candidate_photos` — ~3047 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | NO |  |  |  |
| `id_tr_candidate` | `int(11)` | YES |  |  |  |
| `Ktp` | `varchar(255)` | YES |  |  |  |
| `file_path` | `varchar(255)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `candidate_pendidikanya` — ~3148 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | NO |  |  |  |
| `ktp` | `varchar(255)` | NO |  |  |  |
| `jenjang` | `varchar(255)` | YES |  |  |  |
| `sekolah` | `varchar(255)` | YES |  |  |  |
| `jurusan` | `varchar(100)` | YES |  |  |  |
| `tahunmasuk` | `varchar(255)` | YES |  |  |  |
| `tahunlulus` | `varchar(255)` | YES |  |  |  |
| `alamat` | `varchar(255)` | YES |  |  |  |
| `ipk` | `varchar(255)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `candidate_pengalaman` — ~3063 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | NO |  |  |  |
| `Ktp` | `varchar(255)` | NO |  |  |  |
| `Perusahaan` | `varchar(255)` | YES |  |  |  |
| `Posisi` | `varchar(255)` | YES |  |  |  |
| `Lama_kerja` | `varchar(255)` | YES |  |  |  |
| `Gaji` | `varchar(255)` | YES |  |  |  |
| `No_hp` | `varchar(255)` | YES |  |  |  |
| `alasan_keluar` | `varchar(255)` | YES |  |  |  |
| `komentar` | `varchar(500)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `candidate_pengalaman2` — ~3168 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | NO |  |  |  |
| `Ktp` | `varchar(250)` | YES |  |  |  |
| `Perusahaan2` | `varchar(250)` | YES |  |  |  |
| `Posisi2` | `varchar(250)` | YES |  |  |  |
| `Lama_kerja2` | `varchar(250)` | YES |  |  |  |
| `Gaji2` | `varchar(250)` | YES |  |  |  |
| `No_hp2` | `varchar(250)` | YES |  |  |  |
| `alasan_keluar2` | `varchar(250)` | YES |  |  |  |
| `komentar2` | `varchar(500)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `candidate_pengalaman3` — ~3139 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | NO |  |  |  |
| `Ktp` | `varchar(50)` | YES |  |  |  |
| `Perusahaan3` | `varchar(250)` | YES |  |  |  |
| `Posisi3` | `varchar(250)` | YES |  |  |  |
| `Lama_kerja3` | `varchar(50)` | YES |  |  |  |
| `Gaji3` | `varchar(50)` | YES |  |  |  |
| `No_hp3` | `varchar(50)` | YES |  |  |  |
| `alasan_keluar3` | `varchar(250)` | YES |  |  |  |
| `komentar3` | `varchar(500)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `candidate_skill` — ~3115 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | NO |  |  |  |
| `Ktp` | `varchar(255)` | YES |  |  |  |
| `Skill` | `varchar(255)` | YES |  |  |  |
| `tingkat` | `varchar(255)` | YES |  |  |  |
| `sertifikasi` | `varchar(100)` | YES |  |  |  |
| `siap_tes` | `varchar(255)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `candidate_skill2` — ~3135 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | NO |  |  |  |
| `Ktp` | `varchar(200)` | YES |  |  |  |
| `Skill2` | `varchar(200)` | YES |  |  |  |
| `tingkat2` | `varchar(200)` | YES |  |  |  |
| `sertifikasi2` | `varchar(200)` | YES |  |  |  |
| `siap_tes2` | `varchar(200)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `candidate_sosmed` — ~3135 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | NO |  |  |  |
| `Ktp` | `varchar(255)` | YES |  |  |  |
| `sosmed` | `varchar(255)` | YES |  |  |  |
| `nickname` | `varchar(255)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `candidate_sosmed2` — ~3135 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | NO |  |  |  |
| `Ktp` | `varchar(200)` | YES |  |  |  |
| `sosmed2` | `varchar(200)` | YES |  |  |  |
| `nickname2` | `varchar(200)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `candidate_keluarga` — ~3247 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | NO |  |  |  |
| `Ktp` | `varchar(255)` | NO |  |  |  |
| `hubungan` | `varchar(255)` | NO |  |  |  |
| `namanya` | `varchar(255)` | NO |  |  |  |
| `pendidikan` | `varchar(255)` | NO |  |  |  |
| `pekerjaan` | `varchar(255)` | NO |  |  |  |
| `tempat` | `varchar(255)` | NO |  |  |  |
| `no_hp_aktif` | `varchar(50)` | YES |  |  |  |
| `alamat` | `varchar(100)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `candidate_keluarga2` — ~3133 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | NO |  |  |  |
| `Ktp` | `varchar(200)` | YES |  |  |  |
| `hubungan2` | `varchar(200)` | YES |  |  |  |
| `namanya2` | `varchar(200)` | YES |  |  |  |
| `pendidikan2` | `varchar(200)` | YES |  |  |  |
| `pekerjaan2` | `varchar(200)` | YES |  |  |  |
| `tempat2` | `varchar(200)` | YES |  |  |  |
| `no_hp_aktif2` | `varchar(50)` | YES |  |  |  |
| `alamat2` | `varchar(100)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `candidate_organisasi` — ~3139 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | NO |  |  |  |
| `Ktp` | `varchar(255)` | YES |  |  |  |
| `Nama_organisasi` | `varchar(255)` | YES |  |  |  |
| `Jabatan` | `varchar(255)` | YES |  |  |  |
| `Periode` | `varchar(255)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `candidate_organisasi2` — ~3139 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | NO |  |  |  |
| `Ktp` | `varchar(200)` | YES |  |  |  |
| `Nama_organisasi2` | `varchar(200)` | YES |  |  |  |
| `Jabatan2` | `varchar(200)` | YES |  |  |  |
| `Periode2` | `varchar(200)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `tr_int_sched` — ~504 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  |  |  |
| `tr_int_sched_Code` | `varchar(50)` | NO |  |  |  |
| `Date_int` | `text` | NO |  |  |  |
| `Time_int` | `time` | NO |  |  |  |
| `Interviewer` | `varchar(50)` | NO |  |  |  |
| `Lokasi` | `varchar(50)` | NO |  |  |  |
| `Ms_Candidate_Code` | `varchar(50)` | NO |  |  |  |
| `Int_model` | `varchar(50)` | NO |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `tr_shortlist_tracking` — ~7 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  |  |  |
| `rec_usercreated` | `varchar(50)` | NO |  |  |  |
| `rec_userupdate` | `varchar(50)` | NO |  |  |  |
| `rec_datecreated` | `datetime` | YES |  |  |  |
| `rec_dateupdate` | `datetime` | YES |  |  |  |
| `rec_status` | `int(11)` | YES |  |  |  |
| `tracking_code` | `varchar(50)` | NO |  |  |  |
| `ms_status_short` | `varchar(50)` | NO |  |  |  |
| `kandidat` | `varchar(50)` | NO |  |  |  |
| `no_hp` | `varchar(50)` | NO |  |  |  |
| `email` | `varchar(50)` | NO |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `tr_report_lowongan_h` — ~578 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  |  |  |
| `Tr_report_lowongan_code_h` | `varchar(50)` | NO |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |
| `Ms_operator` | `varchar(50)` | YES |  |  |  |
| `Date_lowongan` | `timestamp` | YES |  |  |  |
| `Total_opening` | `varchar(10)` | YES |  |  |  |
| `Total_opening_HGS` | `varchar(10)` | YES |  |  |  |
| `Total_opening_TGF` | `varchar(10)` | YES |  |  |  |
| `Total_opening_TGU` | `varchar(10)` | YES |  |  |  |

### `tr_report_lowongan_d` — ~2256 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  |  |  |
| `Ms_User_Code` | `varchar(50)` | YES |  |  |  |
| `ms_divisi` | `varchar(50)` | YES |  |  |  |
| `Tr_ReportLowongan_Code` | `varchar(100)` | YES |  |  |  |
| `Tr_report_hrd_main_code` | `varchar(50)` | NO |  |  |  |
| `Ms_Media_Code` | `varchar(100)` | YES |  |  |  |
| `Ms_ReportType_Code` | `varchar(50)` | YES |  |  |  |
| `Ms_Perusahaan_Code` | `varchar(100)` | YES |  |  |  |
| `MS_Jabatan_Code` | `varchar(100)` | YES |  |  |  |
| `Qty` | `varchar(100)` | YES |  |  |  |
| `tr_Lowongan_Code_H` | `varchar(100)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `tr_report_lowongan_interview` — ~3272 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  |  |  |
| `Ms_User_Code` | `varchar(50)` | YES |  |  |  |
| `Ms_UserUpdate` | `varchar(50)` | YES |  |  |  |
| `ms_divisi` | `varchar(50)` | YES |  |  |  |
| `tr_lowongan_Interview` | `varchar(100)` | YES |  |  |  |
| `Tr_report_hrd_main_code` | `varchar(50)` | NO |  |  |  |
| `Ms_ReportType_Code` | `varchar(50)` | YES |  |  |  |
| `Ms_Media_Code` | `varchar(50)` | YES |  |  |  |
| `Ms_Perusahaan_Code` | `varchar(50)` | YES |  |  |  |
| `NamaLowongan` | `varchar(100)` | YES |  |  |  |
| `userinterview` | `varchar(50)` | YES |  |  |  |
| `NamaCandidate` | `varchar(100)` | YES |  |  |  |
| `Telepon` | `varchar(50)` | YES |  |  |  |
| `latar_belakang` | `varchar(50)` | YES |  |  |  |
| `pengalaman_kerja` | `varchar(50)` | YES |  |  |  |
| `rincian_pekrjaan` | `varchar(50)` | YES |  |  |  |
| `alasan_keluar` | `varchar(50)` | YES |  |  |  |
| `referensi` | `varchar(50)` | YES |  |  |  |
| `alasan_melamar` | `varchar(50)` | YES |  |  |  |
| `fisik` | `varchar(50)` | YES |  |  |  |
| `sopan_santun` | `varchar(50)` | YES |  |  |  |
| `pendidikan_kerja` | `varchar(50)` | YES |  |  |  |
| `prestasi` | `varchar(50)` | YES |  |  |  |
| `penyampaian_pendapat` | `varchar(50)` | YES |  |  |  |
| `komunikasi` | `varchar(50)` | YES |  |  |  |
| `daya_tangkap` | `varchar(50)` | YES |  |  |  |
| `analis` | `varchar(50)` | YES |  |  |  |
| `percaya_diri` | `varchar(50)` | YES |  |  |  |
| `stabilitas_emosi` | `varchar(50)` | YES |  |  |  |
| `motivasi` | `varchar(50)` | YES |  |  |  |
| `user` | `varchar(100)` | YES |  |  |  |
| `hasil_interview` | `varchar(100)` | YES |  |  |  |
| `Tr_status_interview` | `varchar(100)` | YES |  |  |  |
| `lanjut_tidaklanjut` | `varchar(20)` | YES |  |  |  |
| `priority` | `varchar(20)` | YES |  |  |  |
| `langsungBD` | `varchar(20)` | YES |  |  |  |
| `drive` | `int(11)` | YES |  |  |  |
| `notedrive` | `varchar(500)` | YES |  |  |  |
| `skill` | `int(11)` | YES |  |  |  |
| `noteskill` | `varchar(500)` | YES |  |  |  |
| `solving` | `int(11)` | YES |  |  |  |
| `notesolving` | `varchar(500)` | YES |  |  |  |
| `leadership` | `int(11)` | YES |  |  |  |
| `noteleadership` | `varchar(500)` | YES |  |  |  |
| `initiative` | `int(11)` | YES |  |  |  |
| `noteinitiative` | `varchar(500)` | YES |  |  |  |
| `attitude` | `int(11)` | YES |  |  |  |
| `noteattitude` | `varchar(500)` | YES |  |  |  |
| `note` | `varchar(500)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `tr_report_lowongan_interview_kedua` — ~2 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  |  |  |
| `rec_usercreated` | `varchar(50)` | YES |  |  |  |
| `rec_userupdate` | `varchar(50)` | YES |  |  |  |
| `ms_divisi` | `varchar(50)` | YES |  |  |  |
| `tr_interview_code` | `varchar(50)` | YES |  |  |  |
| `Tr_report_hrd_main_code` | `varchar(50)` | YES |  |  |  |
| `Ms_ReportType_Code` | `varchar(50)` | YES |  |  |  |
| `Ms_Media_Code` | `varchar(50)` | YES |  |  |  |
| `Ms_Perusahaan_Code` | `varchar(50)` | YES |  |  |  |
| `NamaLowongan` | `varchar(50)` | YES |  |  |  |
| `userinterview` | `varchar(100)` | YES |  |  |  |
| `NamaCandidate` | `varchar(100)` | YES |  |  |  |
| `Telepon` | `varchar(50)` | YES |  |  |  |
| `skill` | `varchar(50)` | YES |  |  |  |
| `attitude` | `varchar(50)` | YES |  |  |  |
| `leadership` | `varchar(50)` | YES |  |  |  |
| `inisiative` | `varchar(50)` | YES |  |  |  |
| `problem_solve` | `varchar(50)` | YES |  |  |  |
| `drive` | `varchar(50)` | YES |  |  |  |
| `pengalaman_dengan_posisi` | `varchar(50)` | YES |  |  |  |
| `jam_kerja` | `varchar(50)` | YES |  |  |  |
| `prestasi` | `varchar(50)` | YES |  |  |  |
| `soft_skill` | `varchar(50)` | YES |  |  |  |
| `hasil_interview` | `varchar(50)` | YES |  |  |  |
| `Tr_status_interview` | `varchar(50)` | YES |  |  |  |
| `user` | `varchar(50)` | YES |  |  |  |
| `note` | `varchar(500)` | YES |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `all_kandidats` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Name` | `varchar(100)` | YES |  |  |  |
| `domisili` | `varchar(100)` | YES |  |  |  |
| `Birthdate` | `timestamp` | NO | current_timestamp() |  |  |
| `umur` | `int(5)` | YES |  |  |  |
| `jenis_kelamin` | `varchar(100)` | YES |  |  |  |
| `agama` | `varchar(100)` | YES |  |  |  |
| `Handphone` | `varchar(100)` | YES |  |  |  |
| `Position_aplly1` | `varchar(100)` | YES |  |  |  |
| `created_at` | `timestamp` | NO | 0000-00-00 00:00:00 |  |  |
| `Perusahaan` | `varchar(255)` | YES |  |  |  |
| `Ktp` | `varchar(100)` | YES |  |  |  |
| `PICShortlist` | `varchar(100)` | YES |  |  |  |
| `CekShorlist` | `varchar(100)` | YES |  |  |  |
| `CekCall` | `varchar(100)` | YES |  |  |  |
| `Cek_Sambung` | `varchar(100)` | YES |  |  |  |
| `CekInterview` | `varchar(100)` | YES |  |  |  |

### `hrd_main` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(50)` | YES |  |  |  |
| `Tr_report_hrd_main_code` | `varchar(50)` | YES |  |  |  |
| `Ms_ReportType_Code` | `varchar(50)` | YES |  |  |  |
| `Ms_User_Code` | `varchar(50)` | YES |  |  |  |
| `Ms_UserUpdate` | `varchar(50)` | YES |  |  |  |
| `ms_divisi` | `varchar(50)` | YES |  |  |  |
| `ms_lokasi` | `varchar(50)` | YES |  |  |  |
| `Ms_Perusahaan_Code_main` | `varchar(50)` | YES |  |  |  |
| `Tr_status_interview` | `varchar(50)` | YES |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | NO | 0000-00-00 00:00:00 |  |  |

### `hrd_main_belum_shortlist` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Name` | `varchar(100)` | YES |  |  |  |
| `domisili` | `varchar(100)` | YES |  |  |  |
| `Birthdate` | `timestamp` | NO | current_timestamp() |  |  |
| `umur` | `int(5)` | YES |  |  |  |
| `jenis_kelamin` | `varchar(100)` | YES |  |  |  |
| `agama` | `varchar(100)` | YES |  |  |  |
| `Handphone` | `varchar(100)` | YES |  |  |  |
| `Position_aplly1` | `varchar(100)` | YES |  |  |  |
| `created_at` | `timestamp` | NO | 0000-00-00 00:00:00 |  |  |
| `Perusahaan` | `varchar(255)` | YES |  |  |  |
| `Ktp` | `varchar(100)` | YES |  |  |  |
| `PICShortlist` | `varchar(100)` | YES |  |  |  |
| `CekShorlist` | `varchar(100)` | YES |  |  |  |
| `CekCall` | `varchar(100)` | YES |  |  |  |
| `Cek_Sambung` | `varchar(100)` | YES |  |  |  |
| `CekInterview` | `varchar(100)` | YES |  |  |  |

### `tr_report_hrd_main` — ~6508 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(50)` | NO |  |  |  |
| `Tr_report_hrd_main_code` | `varchar(50)` | YES |  |  |  |
| `Ms_ReportType_Code` | `varchar(50)` | YES |  |  |  |
| `Ms_User_Code` | `varchar(50)` | YES |  |  |  |
| `Ms_UserUpdate` | `varchar(50)` | YES |  |  |  |
| `ms_divisi` | `varchar(50)` | YES |  |  |  |
| `ms_lokasi` | `varchar(50)` | YES |  |  |  |
| `Ms_Perusahaan_Code_main` | `varchar(50)` | YES |  |  |  |
| `Tr_status_interview` | `varchar(50)` | YES |  |  |  |
| `posisi1` | `varchar(100)` | YES |  |  |  |
| `posisi2` | `varchar(100)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `opening_last_date` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_report_lowongan_code_h` | `varchar(50)` | YES |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `MS_Jabatan_Code` | `varchar(100)` | YES |  |  |  |
| `Ms_Media_Code` | `varchar(100)` | YES |  |  |  |
| `Ms_Perusahaan_Code` | `varchar(100)` | YES |  |  |  |
| `Qty` | `varchar(100)` | YES |  |  |  |
| `Total_opening_HGS` | `varchar(10)` | YES |  |  |  |
| `Total_opening_TGF` | `varchar(10)` | YES |  |  |  |
| `Total_opening_TGU` | `varchar(10)` | YES |  |  |  |
| `Total_opening` | `varchar(10)` | YES |  |  |  |

