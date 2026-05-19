# Report Security & Lain-lain

Tabel untuk laporan security, memo, dan dashboard agregat.

Sumber: database `tirt3038_HR_Worksheet` (kecuali disebut lain).

---

### `tr_report_security_main` — ~2 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  |  |  |
| `Tr_report_security_main_code` | `varchar(50)` | YES |  |  |  |
| `Ms_ReportType_Code` | `varchar(50)` | YES |  |  |  |
| `Ms_User_Code` | `varchar(50)` | YES |  |  |  |
| `ms_divisi` | `varchar(50)` | YES |  |  |  |
| `ms_lokasi` | `varchar(50)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `tr_report_temuan` — ~2 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  |  |  |
| `Ms_User_Code` | `varchar(50)` | YES |  |  |  |
| `ms_divisi` | `varchar(50)` | YES |  |  |  |
| `Tr_Report_temuan_code` | `varchar(50)` | YES |  |  |  |
| `Tr_report_temuan_main_code` | `varchar(50)` | YES |  |  |  |
| `nama_temuan` | `varchar(50)` | YES |  |  |  |
| `Ms_ReportType_Code` | `varchar(50)` | YES |  |  |  |
| `nama_penemu` | `varchar(50)` | YES |  |  |  |
| `tanggal_ditemukan` | `varchar(50)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `tr_reportmemos` — ~3 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `bigint(20)` | NO |  |  |  |
| `Tr_ReportMemo` | `varchar(50)` | YES |  |  |  |
| `Tr_report_main_code` | `varchar(50)` | YES |  |  |  |
| `Ms_User_Code` | `varchar(50)` | YES |  |  |  |
| `rec_comcode` | `varchar(50)` | YES |  |  |  |
| `rec_areacode` | `varchar(50)` | YES |  |  |  |
| `ms_divisi` | `varchar(50)` | YES |  |  |  |
| `Ms_ReportType_Code` | `varchar(50)` | YES |  |  |  |
| `Memo` | `varchar(5000)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `report_laka`

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `created_at` | `timestamp` | NO |  |  |  |
| `rec_comcode` | `varchar(100)` | NO |  |  |  |
| `rec_areacode` | `varchar(100)` | NO |  |  |  |
| `no_armada` | `varchar(50)` | YES |  |  |  |
| `ms_jenis_laka` | `varchar(50)` | YES |  |  |  |
| `ms_faktor_laka` | `varchar(50)` | YES |  |  |  |
| `ms_klasifikasi_laka` | `varchar(50)` | YES |  |  |  |
| `ms_dampak_laka` | `varchar(50)` | YES |  |  |  |
| `type_laka` | `varchar(50)` | YES |  |  |  |
| `fatality` | `varchar(50)` | YES |  |  |  |
| `nama` | `varchar(50)` | YES |  |  |  |
| `posisi` | `varchar(50)` | YES |  |  |  |
| `penguji` | `varchar(50)` | YES |  |  |  |

### `report_hrd_weekly` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `year` | `int(11)` | YES |  |  |  |
| `week` | `int(11)` | YES |  |  |  |
| `lowongan` | `varchar(100)` | YES |  |  |  |
| `total_lamar` | `double` | YES |  |  |  |
| `total_panggil` | `bigint(21)` | YES |  |  |  |
| `total_interview` | `bigint(21)` | YES |  |  |  |
| `total_ok_calls` | `bigint(21)` | YES |  |  |  |
| `total_ok_interview` | `decimal(22,0)` | YES |  |  |  |

### `reportclosing` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Ms_User_Code` | `varchar(50)` | YES |  |  |  |
| `ms_divisi` | `varchar(50)` | YES |  |  |  |
| `ms_lokasi` | `varchar(50)` | YES |  |  |  |
| `total_open` | `double` | YES |  |  |  |
| `total_panggil` | `bigint(21)` | YES |  |  |  |
| `total_interview` | `bigint(21)` | YES |  |  |  |
| `total_interview_diterima` | `bigint(21)` | YES |  |  |  |
| `tanggal_main` | `date` | YES |  |  |  |

### `AllHistoryPerWeek` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_report_hrd_main_code` | `varchar(50)` | YES |  |  |  |
| `year` | `int(4)` | YES |  |  |  |
| `week` | `int(2)` | YES |  |  |  |
| `MS_Jabatan_Code` | `varchar(100)` | YES |  |  |  |
| `total_lamar` | `double` | YES |  |  |  |
| `tanggal_main` | `date` | YES |  |  |  |

### `AllHostoryPerDay` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `lowongan` | `varchar(100)` | YES |  |  |  |
| `tanggal_main` | `date` | YES |  |  |  |
| `total_lamar` | `double` | YES |  |  |  |
| `total_panggil` | `bigint(21)` | YES |  |  |  |
| `total_interview` | `bigint(21)` | YES |  |  |  |
| `total_ok_calls` | `bigint(21)` | YES |  |  |  |
| `total_ok_interview` | `decimal(22,0)` | YES |  |  |  |

### `allhistoryperweeknew` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `year` | `int(4)` | YES |  |  |  |
| `week` | `int(2)` | YES |  |  |  |
| `lowongan` | `varchar(100)` | YES |  |  |  |
| `total_lamar` | `bigint(21)` | YES |  |  |  |
| `total_panggil` | `bigint(21)` | YES |  |  |  |
| `total_interview` | `bigint(21)` | YES |  |  |  |
| `total_panggilan_terhubung` | `bigint(21)` | YES |  |  |  |
| `total_lolos_call` | `bigint(21)` | YES |  |  |  |
| `total_datang_interview` | `bigint(21)` | YES |  |  |  |
| `total_lolos_training` | `bigint(21)` | YES |  |  |  |
| `total_cv_masuk` | `bigint(21)` | YES |  |  |  |

### `allhostory_perday` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `lowongan` | `varchar(100)` | YES |  |  |  |
| `tanggal_main` | `date` | YES |  |  |  |
| `total_lamar` | `bigint(21)` | YES |  |  |  |
| `total_panggil` | `bigint(21)` | YES |  |  |  |
| `total_interview` | `bigint(21)` | YES |  |  |  |
| `total_ok_calls` | `bigint(21)` | YES |  |  |  |
| `total_ok_interview` | `bigint(21)` | YES |  |  |  |

### `allhostoryperweek` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `year` | `int(4)` | YES |  |  |  |
| `week` | `int(2)` | YES |  |  |  |
| `lowongan` | `varchar(100)` | YES |  |  |  |
| `total_lamar` | `bigint(21)` | YES |  |  |  |
| `total_panggil` | `bigint(21)` | YES |  |  |  |
| `total_interview` | `bigint(21)` | YES |  |  |  |
| `total_ok_calls` | `bigint(21)` | YES |  |  |  |
| `total_ok_interview` | `bigint(21)` | YES |  |  |  |

### `allhostorypermonth` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `year` | `int(4)` | YES |  |  |  |
| `month` | `int(2)` | YES |  |  |  |
| `lowongan` | `varchar(100)` | YES |  |  |  |
| `total_lamar` | `bigint(21)` | YES |  |  |  |
| `total_panggil` | `bigint(21)` | YES |  |  |  |
| `total_interview` | `bigint(21)` | YES |  |  |  |
| `total_panggilan_terhubung` | `bigint(21)` | YES |  |  |  |
| `total_lolos_call` | `bigint(21)` | YES |  |  |  |
| `total_datang_interview` | `bigint(21)` | YES |  |  |  |
| `total_lolos_training` | `bigint(21)` | YES |  |  |  |
| `total_cv_masuk` | `bigint(21)` | YES |  |  |  |

### `babydivisi`

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Division_Code` | `varchar(50)` | YES |  |  |  |
| `total_ba` | `bigint(21)` | NO | 0 |  |  |

### `babydivisi_perday`

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Division_Code` | `varchar(50)` | NO |  |  |  |
| `total_ba` | `bigint(21)` | NO | 0 |  |  |

### `babydivisi_permonth`

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Division_Code` | `varchar(50)` | YES |  |  |  |
| `total_ba` | `bigint(21)` | NO | 0 |  |  |

### `total_all_ba_by_user`

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `User_Code` | `varchar(50)` | YES |  |  |  |
| `Division_Code` | `varchar(50)` | YES |  |  |  |
| `total_ba` | `bigint(21)` | NO | 0 |  |  |

### `total_ba_by_user_by_week`

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Division_Code` | `varchar(50)` | YES |  |  |  |
| `User_Code` | `varchar(50)` | YES |  |  |  |
| `week` | `int(3)` | YES |  |  |  |
| `total_ba` | `bigint(21)` | NO | 0 |  |  |

### `total_ba_last2month_by_user`

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `User_Code` | `varchar(50)` | YES |  |  |  |
| `Division_code` | `varchar(50)` | YES |  |  |  |
| `total_ba` | `bigint(21)` | NO | 0 |  |  |

### `total_ba_lastmonth_by_user`

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `User_Code` | `varchar(50)` | YES |  |  |  |
| `Division_code` | `varchar(50)` | YES |  |  |  |
| `total_ba` | `bigint(21)` | NO | 0 |  |  |

### `tr_case_all` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_Case_all_Code` | `varchar(50)` | NO |  |  |  |
| `Date_Case` | `date` | NO |  |  |  |
| `Case_Type_Code` | `varchar(50)` | NO |  |  |  |
| `Case_Text` | `text` | NO |  |  |  |
| `Ms_user_Code` | `varchar(50)` | NO |  |  |  |
| `Ms_Admin_Cde` | `varchar(50)` | NO |  |  |  |
| `Ms_location_Code` | `varchar(50)` | NO |  |  |  |
| `Ms_Company_Code` | `varchar(50)` | NO |  |  |  |
| `Ms_Jabatan_Code` | `varchar(50)` | NO |  |  |  |
| `Ms_Div_Code` | `varchar(50)` | NO |  |  |  |
| `BA_Code` | `varchar(50)` | NO |  |  |  |
| `Fraud_Indication` | `smallint(6)` | NO |  |  |  |

### `tr_job_assesment_all` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_Job_Assesment_all` | `varchar(50)` | NO |  |  |  |
| `Date_Job_Assesement` | `date` | NO |  |  |  |
| `User_Code` | `int(11)` | NO |  |  |  |
| `Atasan_Code` | `int(11)` | NO |  |  |  |
| `Atasan2_Code` | `int(11)` | NO |  |  |  |
| `HRD_Code` | `int(11)` | NO |  |  |  |
| `InisiativeUser` | `int(11)` | NO |  |  |  |
| `Reliable` | `int(11)` | NO |  |  |  |
| `Communication` | `int(11)` | NO |  |  |  |
| `Highlite` | `text` | NO |  |  |  |
| `LowLIte` | `text` | NO |  |  |  |
| `Completeness` | `int(11)` | NO |  |  |  |
| `InisiatifAtasan` | `int(11)` | NO |  |  |  |
| `InisiatiffAtasan2` | `int(11)` | NO |  |  |  |

### `view_applicant_by_company` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_report_lowongan_code_h` | `varchar(50)` | YES |  |  |  |
| `Ms_Perusahaan_Code` | `varchar(100)` | YES |  |  |  |
| `Qty` | `varchar(100)` | YES |  |  |  |
| `Total_opening_HGS` | `varchar(10)` | YES |  |  |  |
| `Total_opening_TGF` | `varchar(10)` | YES |  |  |  |
| `Total_opening_TGU` | `varchar(10)` | YES |  |  |  |
| `Total_opening` | `varchar(10)` | YES |  |  |  |

### `view_applicant_by_date` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_report_lowongan_code_h` | `varchar(50)` | YES |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `Qty` | `varchar(100)` | YES |  |  |  |
| `Total_opening_HGS` | `varchar(10)` | YES |  |  |  |
| `Total_opening_TGF` | `varchar(10)` | YES |  |  |  |
| `Total_opening_TGU` | `varchar(10)` | YES |  |  |  |
| `Total_opening` | `varchar(10)` | YES |  |  |  |

### `view_applicant_by_media` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_report_lowongan_code_h` | `varchar(50)` | YES |  |  |  |
| `Ms_Media_Code` | `varchar(100)` | YES |  |  |  |
| `Qty` | `varchar(100)` | YES |  |  |  |
| `Total_opening_HGS` | `varchar(10)` | YES |  |  |  |
| `Total_opening_TGF` | `varchar(10)` | YES |  |  |  |
| `Total_opening_TGU` | `varchar(10)` | YES |  |  |  |
| `Total_opening` | `varchar(10)` | YES |  |  |  |

### `view_applicant_by_position` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_report_lowongan_code_h` | `varchar(50)` | YES |  |  |  |
| `MS_Jabatan_Code` | `varchar(100)` | YES |  |  |  |
| `Qty` | `varchar(100)` | YES |  |  |  |
| `Total_opening_HGS` | `varchar(10)` | YES |  |  |  |
| `Total_opening_TGF` | `varchar(10)` | YES |  |  |  |
| `Total_opening_TGU` | `varchar(10)` | YES |  |  |  |
| `Total_opening` | `varchar(10)` | YES |  |  |  |

### `view_applicant_by_position_by_date` — ~0 rows

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

### `dashboard_pw` — ~9 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `user` | `varchar(255)` | YES |  |  |  |
| `username` | `varchar(255)` | NO |  | PRI |  |
| `password` | `varchar(255)` | YES |  |  |  |
| `created_at` | `datetime` | YES |  |  |  |
| `created_by` | `varchar(255)` | YES |  |  |  |

### `DW_history` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `DW_Code` | `int(11)` | NO |  |  |  |
| `DW_time` | `int(11)` | NO |  |  |  |
| `DW_tbl` | `int(11)` | NO |  |  |  |
| `DW_SP` | `int(11)` | NO |  |  |  |

