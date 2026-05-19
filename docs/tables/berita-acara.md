# Berita Acara (BA)

Tabel untuk modul Berita Acara — laporan kejadian internal termasuk kecelakaan kerja (laka), revisi, validasi multi-level, dan dokumen pendukung.

Sumber: database `tirt3038_HR_Worksheet` (kecuali disebut lain).

---

### `Tr_Ba_Main_New` — ~19122 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | UNI |  |
| `Tr_BA_Main_Code` | `varchar(100)` | NO |  | PRI | Emp+Jenis+Week+year+auto |
| `Ms_BA_type_Code` | `varchar(100)` | NO |  |  |  |
| `Ms_Emp_Code` | `varchar(100)` | NO |  |  | Siapa subjectnya |
| `Ms_Emp_Div` | `varchar(100)` | NO |  |  |  |
| `Ms_Pelapor_Code` | `varchar(100)` | NO |  |  | Siapa yg lapor/nulis |
| `Ms_Pelapor_Div` | `varchar(100)` | NO |  |  |  |
| `Date_BA` | `date` | NO |  |  | Tgl BA |
| `BA_Desc` | `varchar(500)` | NO |  |  | Ceritanya apa |
| `CekPelanggaran` | `tinyint(4)` | NO |  |  |  |
| `CekKerusakan` | `tinyint(4)` | NO |  |  |  |
| `CekFraud` | `tinyint(4)` | NO |  |  |  |
| `CekRevisi` | `tinyint(4)` | NO |  |  |  |
| `CekDisiplin` | `tinyint(4)` | NO |  |  |  |
| `CekSalahIsi` | `tinyint(4)` | NO |  |  |  |
| `CekNoClosing` | `tinyint(4)` | NO |  |  |  |
| `CekLaka` | `tinyint(4)` | NO |  |  |  |
| `CekPembelian` | `tinyint(4)` | NO |  |  |  |
| `CekKehilangan` | `tinyint(4)` | NO |  |  |  |
| `CekPerubahanSOP` | `tinyint(4)` | NO |  |  |  |
| `Ms_Kasus` | `varchar(100)` | NO |  |  |  |
| `MS_Detail_Kasus` | `varchar(100)` | NO |  |  |  |
| `Tr_EmpPeriod_Code` | `varchar(100)` | NO |  |  |  |
| `rec_usercreated` | `varchar(100)` | NO |  |  |  |
| `rec_userupdate` | `varchar(100)` | YES |  |  |  |
| `rec_datecreated` | `datetime` | NO |  |  |  |
| `rec_dateupdate` | `datetime` | YES |  |  |  |
| `rec_comcode` | `varchar(100)` | NO |  |  |  |
| `rec_areacode` | `varchar(100)` | NO |  |  |  |
| `rec_status` | `int(11)` | NO |  |  |  |
| `created_at` | `timestamp` | NO |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |
| `Kronologi_Desc` | `varchar(255)` | YES |  |  |  |

### `Tr_BA_Comment` — ~1555 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `Tr_BA_Comment_Code` | `varchar(100)` | NO |  | UNI |  |
| `Tr_BA_Main_Code` | `varchar(100)` | NO |  |  |  |
| `Ms_User` | `varchar(100)` | NO |  |  |  |
| `Comment` | `varchar(1000)` | YES |  |  |  |
| `created_at` | `timestamp` | NO |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |
| `web_db` | `bit(1)` | NO | b'0' |  |  |
| `send_to` | `varchar(255)` | YES |  |  |  |
| `is_read` | `varchar(255)` | YES |  |  |  |

### `Tr_BA_Revisi` — ~2250 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_BA_Revisi_Code` | `varchar(100)` | NO |  | PRI |  |
| `Tr_BA_Main_Code` | `varchar(100)` | NO |  |  | diambil dari ba code |
| `Code_Transaction` | `varchar(100)` | NO |  |  |  |
| `FieldSalah` | `varchar(100)` | NO |  |  |  |
| `FieldSeharusnya` | `varchar(100)` | NO |  |  |  |
| `ValueFieldSalah` | `varchar(100)` | NO |  |  |  |
| `Cek_Koor_Approval` | `tinyint(4)` | YES |  |  |  |
| `Date_Koor_Approved` | `datetime` | YES |  |  |  |
| `Koor_Code` | `varchar(100)` | YES |  |  |  |
| `Koor_Note` | `text` | YES |  |  |  |
| `ValueFieldSeharusnya` | `varchar(100)` | NO |  |  |  |
| `Cek_Spv_Approval` | `tinyint(4)` | YES |  |  |  |
| `Date_SPV_Approved` | `datetime` | YES |  |  |  |
| `Spv_Code` | `varchar(100)` | YES |  |  |  |
| `Spv_Note` | `varchar(1000)` | YES |  |  |  |
| `Cek_HR_Approval` | `tinyint(4)` | YES |  |  |  |
| `Date_HR_Approved` | `datetime` | YES |  |  |  |
| `HR_Code` | `varchar(100)` | YES |  |  |  |
| `HR_Note` | `varchar(1000)` | YES |  |  |  |
| `CeK_Mgt_Approval` | `tinyint(4)` | YES |  |  |  |
| `Mgt_Date` | `datetime` | YES |  |  |  |
| `Mgt_Code` | `varchar(100)` | NO |  |  |  |
| `Mgt_Note` | `varchar(1000)` | YES |  |  |  |
| `Cek_Finance_Approval` | `tinyint(4)` | YES |  |  |  |
| `Finance_Note` | `varchar(1000)` | YES |  |  |  |
| `Finance_Date` | `datetime` | YES |  |  |  |
| `Finance_Code` | `varchar(100)` | YES |  |  |  |
| `CeK_Gm_Approval` | `tinyint(4)` | YES | 0 |  |  |
| `Gm_Date` | `datetime` | YES |  |  |  |
| `Gm_Code` | `varchar(100)` | NO |  |  |  |
| `Gm_Note` | `text` | YES |  |  |  |
| `CeK_It_Approval` | `tinyint(4)` | NO | 0 |  |  |
| `It_Date` | `datetime` | YES |  |  |  |
| `It_Code` | `varchar(100)` | NO |  |  |  |
| `It_Note` | `text` | NO |  |  |  |
| `CeK_Bod_Approval` | `tinyint(4)` | YES |  |  |  |
| `Bod_Date` | `datetime` | YES |  |  |  |
| `Bod_Code` | `int(100)` | YES |  |  |  |
| `Bod_Note` | `text` | YES |  |  |  |
| `Reason` | `tinyint(4)` | YES |  |  |  |
| `created_at` | `timestamp` | NO |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `Tr_BA_Status` — ~3 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_BA_Main_Code` | `varchar(255)` | NO |  |  |  |
| `Tr_BA_Main_Code_d` | `varchar(255)` | NO |  |  |  |
| `Is_close` | `bit(1)` | YES |  |  |  |
| `created_at` | `datetime` | NO | 0000-00-00 00:00:00 |  |  |
| `created_by` | `varchar(255)` | NO |  |  |  |
| `note` | `longtext` | YES |  |  |  |
| `updated_at` | `datetime` | YES |  |  |  |
| `updated_by` | `varchar(255)` | YES |  |  |  |

### `Tr_BA_Priority_Status_h` — ~3 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_BA_Main_Code` | `varchar(255)` | NO |  | PRI |  |
| `priority_status` | `int(11)` | YES |  |  | 1 tinggi, 0 rendah |
| `updated_at` | `datetime` | YES |  |  |  |
| `updated_by` | `varchar(255)` | YES |  |  |  |
| `created_at` | `datetime` | YES |  |  |  |
| `created_by` | `varchar(255)` | YES |  |  |  |

### `Tr_BA_Priority_Status_d` — ~12 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_BA_Main_Code` | `varchar(255)` | YES |  |  |  |
| `Tr_BA_Main_Code_d` | `varchar(255)` | NO |  | PRI |  |
| `note` | `varchar(255)` | YES |  |  |  |
| `created_at` | `datetime` | YES |  |  |  |
| `created_by` | `varchar(255)` | YES |  |  |  |
| `updated_at` | `datetime` | YES |  |  |  |
| `updated_by` | `varchar(255)` | YES |  |  |  |

### `Tr_BA_assignment` — ~19 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_BA_Main_Code` | `varchar(255)` | YES |  |  |  |
| `Tr_BA_Main_Code_d` | `varchar(255)` | NO |  | PRI |  |
| `BA_assessment` | `longtext` | YES |  |  |  |
| `created_at` | `datetime` | YES |  |  |  |
| `created_by` | `varchar(255)` | YES |  |  |  |
| `web_db` | `bit(1)` | NO | b'0' |  |  |
| `send_to` | `varchar(255)` | YES |  |  |  |
| `is_read` | `bit(1)` | YES |  |  |  |

### `tr_ba_kronologi` — ~20268 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `tr_ba_kronologi_code` | `varchar(100)` | YES |  |  |  |
| `tr_ba_main_code` | `varchar(100)` | YES |  |  |  |
| `kronlogi` | `varchar(2000)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `tr_ba_main` — ~5630 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `Tr_BA_Code` | `varchar(50)` | NO |  | UNI |  |
| `BA_Type_Code` | `varchar(50)` | YES |  |  |  |
| `BA_Admin` | `varchar(50)` | YES |  |  |  |
| `BA_Admin_Update` | `varchar(50)` | YES |  |  |  |
| `Admin_Div` | `varchar(50)` | YES |  |  |  |
| `User_Code` | `varchar(50)` | YES |  |  |  |
| `note_koord` | `varchar(500)` | YES |  |  |  |
| `note2` | `varchar(500)` | YES |  |  |  |
| `note3` | `varchar(500)` | YES |  |  |  |
| `note4` | `varchar(500)` | YES |  |  |  |
| `note5` | `varchar(500)` | YES |  |  |  |
| `note6` | `varchar(500)` | YES |  |  |  |
| `note_it` | `varchar(500)` | YES |  |  |  |
| `mengetahui_koord` | `varchar(50)` | YES |  |  |  |
| `mengetahui1` | `varchar(50)` | YES |  |  |  |
| `mengetahui2` | `varchar(50)` | YES |  |  |  |
| `mengetahui3` | `varchar(50)` | YES |  |  |  |
| `mengetahui4` | `varchar(50)` | YES |  |  |  |
| `mengetahui5` | `varchar(50)` | YES |  |  |  |
| `mengetahui_it` | `varchar(50)` | YES |  |  |  |
| `ba_bod` | `varchar(50)` | YES |  |  |  |
| `note_bod` | `varchar(500)` | YES |  |  |  |
| `Date_BA` | `datetime` | YES |  |  |  |
| `Division_Code` | `varchar(50)` | YES |  |  |  |
| `Position_Code` | `varchar(50)` | YES |  |  |  |
| `ms_fraud` | `tinyint(1)` | YES |  |  |  |
| `Category_Code` | `varchar(50)` | YES |  |  |  |
| `ba_status` | `varchar(50)` | YES |  |  |  |
| `jenis` | `varchar(50)` | YES |  |  |  |
| `ms_kasus` | `varchar(100)` | YES |  |  |  |
| `BA_Note` | `varchar(1000)` | YES |  |  |  |
| `Location_Code` | `varchar(50)` | YES |  |  |  |
| `Company_Code` | `varchar(50)` | YES |  |  |  |
| `ba_numbering` | `varchar(50)` | YES |  |  |  |
| `atasan1` | `varchar(50)` | YES |  |  |  |
| `atasan2` | `varchar(50)` | YES |  |  |  |
| `perlu_approval` | `varchar(10)` | YES |  |  |  |
| `user_created` | `varchar(50)` | YES |  |  |  |
| `user_updated` | `varchar(50)` | YES |  |  |  |
| `rec_status` | `int(11)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |
| `DW_time` | `date` | YES |  |  |  |
| `DW_Code` | `varchar(50)` | YES |  |  |  |
| `DW_tbl` | `varchar(50)` | YES |  |  |  |

### `tr_ba_request_revisi` — ~1691 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `user_created` | `varchar(50)` | NO |  |  |  |
| `user_updated` | `varchar(50)` | NO |  |  |  |
| `rec_status` | `int(11)` | NO |  |  |  |
| `rec_datecreated` | `datetime` | YES |  |  |  |
| `rec_dateupdate` | `datetime` | YES |  |  |  |
| `tr_ba_request_revisi_code` | `varchar(50)` | NO |  |  |  |
| `tr_ba_main_code` | `varchar(50)` | NO |  |  |  |
| `note` | `varchar(1000)` | NO |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `tr_ba_salah_isi_detail` — ~2995 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `tr_ba_code_main` | `varchar(50)` | YES |  |  |  |
| `tr_ba_code_request` | `varchar(50)` | YES |  |  |  |
| `code_ba` | `varchar(50)` | YES |  |  |  |
| `code_doc` | `varchar(50)` | YES |  |  |  |
| `field_salah` | `varchar(50)` | YES |  |  |  |
| `value_salah` | `varchar(50)` | YES |  |  |  |
| `field_benar` | `varchar(50)` | YES |  |  |  |
| `value_benar` | `varchar(50)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `tr_ba_laka_h` — ~150 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `tr_ba_laka_code` | `varchar(50)` | YES |  |  |  |
| `tr_ba_main_code` | `varchar(100)` | YES |  |  |  |
| `ms_jenis_laka` | `varchar(50)` | YES |  |  |  |
| `ms_faktor_laka` | `varchar(50)` | YES |  |  |  |
| `ms_klasifikasi_laka` | `varchar(50)` | YES |  |  |  |
| `ms_dampak_laka` | `varchar(50)` | YES |  |  |  |
| `type_laka` | `varchar(50)` | YES |  |  |  |
| `fatality` | `varchar(50)` | YES |  |  |  |
| `pool` | `varchar(50)` | YES |  |  |  |
| `dispatcher` | `varchar(50)` | YES |  |  |  |
| `spk` | `varchar(50)` | YES |  |  |  |
| `no_armada` | `varchar(50)` | YES |  |  |  |
| `jam_keluar` | `varchar(50)` | YES |  |  |  |
| `jam_kejadian` | `varchar(50)` | YES |  |  |  |
| `rallying` | `varchar(50)` | YES |  |  |  |
| `speed` | `varchar(50)` | YES |  |  |  |
| `in_pool` | `varchar(50)` | YES |  |  |  |
| `out_pool` | `varchar(50)` | YES |  |  |  |
| `rute` | `varchar(50)` | YES |  |  |  |
| `bengkel_terakhir` | `varchar(50)` | YES |  |  |  |
| `lokasi_kejadian` | `varchar(50)` | YES |  |  |  |
| `date_laka` | `timestamp` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `tr_ba_laka_d` — ~157 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `tr_ba_laka_code_h` | `varchar(50)` | YES |  |  |  |
| `posisi` | `varchar(50)` | YES |  |  |  |
| `nama` | `varchar(50)` | YES |  |  |  |
| `usia` | `varchar(50)` | YES |  |  |  |
| `penguji` | `varchar(50)` | YES |  |  |  |
| `avg_income` | `varchar(50)` | YES |  |  |  |
| `istirahat_last` | `varchar(50)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `ba_document` — ~20861 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `ba_main_code` | `varchar(100)` | YES |  |  |  |
| `file_path` | `varchar(100)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `ba_document2` — ~20868 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `ba_main_code` | `varchar(50)` | NO |  |  |  |
| `file_path2` | `varchar(100)` | NO |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `ba_updated_record` — ~16 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `ba_main_code` | `varchar(255)` | NO |  | PRI |  |
| `ba_main_code_r` | `varchar(255)` | YES |  |  |  |
| `pelaku` | `varchar(255)` | YES |  |  |  |
| `deskripsi` | `varchar(255)` | YES |  |  |  |
| `ms_kasus` | `varchar(255)` | YES |  |  |  |
| `ms_kasus_detail` | `varchar(255)` | YES |  |  |  |
| `created_by` | `varchar(255)` | YES |  |  |  |
| `created_at` | `datetime` | NO |  | PRI |  |
| `ba_date` | `date` | YES |  |  |  |
| `akses_dari` | `varchar(255)` | YES |  |  |  |

### `tr_approval_ba_tracking` — ~8144 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `rec_comcode` | `varchar(50)` | NO |  |  |  |
| `approval_ba_code` | `varchar(50)` | NO |  |  |  |
| `approval_ba_main_code` | `varchar(50)` | NO |  |  |  |
| `approval_ba_tracking` | `int(11)` | NO |  |  |  |
| `approval_ba_desc` | `varchar(50)` | NO |  |  |  |
| `pic` | `varchar(50)` | NO |  |  |  |
| `note` | `varchar(500)` | YES |  |  |  |
| `status_approve` | `varchar(50)` | YES |  |  |  |
| `approval_ba_divisi` | `varchar(50)` | NO |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `total_ba_by_jenis` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `jenis` | `varchar(50)` | YES |  |  |  |
| `total_ba` | `bigint(21)` | YES |  |  |  |

