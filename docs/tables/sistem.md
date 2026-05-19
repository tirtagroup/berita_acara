# Sistem & Autentikasi

Tabel teknis: user, session, queue, audit log.

Sumber: database `tirt3038_HR_Worksheet` (kecuali disebut lain).

---

### `users` — ~170 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | NO |  | PRI |  |
| `username` | `varchar(100)` | YES |  |  |  |
| `name` | `varchar(255)` | NO |  |  |  |
| `ms_divisi` | `varchar(50)` | YES |  |  |  |
| `sub_divisi` | `varchar(50)` | YES |  |  |  |
| `ms_company` | `varchar(50)` | YES |  |  |  |
| `ms_branch` | `varchar(50)` | YES |  |  |  |
| `role` | `varchar(50)` | YES |  |  |  |
| `BD_satus` | `varchar(255)` | YES |  |  |  |
| `activate` | `int(1)` | YES |  |  |  |
| `verify_key` | `varchar(100)` | YES |  |  |  |
| `email` | `varchar(255)` | NO |  |  |  |
| `email_verified_at` | `timestamp` | YES |  |  |  |
| `password` | `varchar(255)` | NO |  |  |  |
| `two_factor_secret` | `text` | YES |  |  |  |
| `two_factor_recovery_codes` | `text` | YES |  |  |  |
| `two_factor_confirmed_at` | `timestamp` | YES |  |  |  |
| `remember_token` | `varchar(100)` | YES |  |  |  |
| `current_team_id` | `varchar(50)` | NO |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | NO |  | PRI |  |
| `phone` | `varchar(255)` | YES |  |  |  |
| `user_akses` | `bit(1)` | YES | b'0' |  |  |

### `users_copy1` — ~887 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | NO |  | PRI |  |
| `username` | `varchar(100)` | YES |  |  |  |
| `name` | `varchar(255)` | NO |  |  |  |
| `ms_divisi` | `varchar(50)` | YES |  |  |  |
| `sub_divisi` | `varchar(50)` | YES |  |  |  |
| `ms_company` | `varchar(50)` | YES |  |  |  |
| `ms_branch` | `varchar(50)` | YES |  |  |  |
| `role` | `varchar(50)` | YES |  |  |  |
| `activate` | `int(11)` | YES |  |  |  |
| `verify_key` | `varchar(100)` | YES |  |  |  |
| `email` | `varchar(255)` | NO |  |  |  |
| `email_verified_at` | `timestamp` | YES |  |  |  |
| `password` | `varchar(255)` | NO |  |  |  |
| `two_factor_secret` | `text` | YES |  |  |  |
| `two_factor_recovery_codes` | `text` | YES |  |  |  |
| `two_factor_confirmed_at` | `timestamp` | YES |  |  |  |
| `remember_token` | `varchar(100)` | YES |  |  |  |
| `current_team_id` | `varchar(50)` | NO |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `users_copy2` — ~1021 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | NO |  | PRI |  |
| `username` | `varchar(100)` | YES |  |  |  |
| `name` | `varchar(255)` | NO |  |  |  |
| `ms_divisi` | `varchar(50)` | YES |  |  |  |
| `sub_divisi` | `varchar(50)` | YES |  |  |  |
| `ms_company` | `varchar(50)` | YES |  |  |  |
| `ms_branch` | `varchar(50)` | YES |  |  |  |
| `role` | `varchar(50)` | YES |  |  |  |
| `BD_satus` | `varchar(255)` | YES |  |  |  |
| `activate` | `int(1)` | YES |  |  |  |
| `verify_key` | `varchar(100)` | YES |  |  |  |
| `email` | `varchar(255)` | NO |  |  |  |
| `email_verified_at` | `timestamp` | YES |  |  |  |
| `password` | `varchar(255)` | NO |  |  |  |
| `two_factor_secret` | `text` | YES |  |  |  |
| `two_factor_recovery_codes` | `text` | YES |  |  |  |
| `two_factor_confirmed_at` | `timestamp` | YES |  |  |  |
| `remember_token` | `varchar(100)` | YES |  |  |  |
| `current_team_id` | `varchar(50)` | NO |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | NO |  | PRI |  |
| `phone` | `varchar(255)` | YES |  |  |  |
| `user_akses` | `bit(1)` | YES | b'0' |  |  |

### `tb_user` — ~3 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `user_id` | `bigint(20) unsigned` | NO |  |  |  |
| `name` | `varchar(255)` | NO |  |  |  |
| `username` | `varchar(255)` | NO |  |  |  |
| `password` | `varchar(255)` | NO |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `team_invitations` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | NO |  |  |  |
| `team_id` | `bigint(20) unsigned` | NO |  |  |  |
| `email` | `varchar(255)` | NO |  |  |  |
| `role` | `varchar(255)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `team_user` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | NO |  |  |  |
| `team_id` | `bigint(20) unsigned` | NO |  |  |  |
| `user_id` | `bigint(20) unsigned` | NO |  |  |  |
| `role` | `varchar(255)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `teams` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | NO |  |  |  |
| `user_id` | `bigint(20) unsigned` | NO |  |  |  |
| `name` | `varchar(255)` | NO |  |  |  |
| `personal_team` | `tinyint(1)` | NO |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `sessions` — ~340 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `varchar(255)` | NO |  |  |  |
| `user_id` | `bigint(20) unsigned` | YES |  |  |  |
| `ip_address` | `varchar(45)` | YES |  |  |  |
| `user_agent` | `text` | YES |  |  |  |
| `payload` | `longtext` | NO |  |  |  |
| `last_activity` | `int(11)` | NO |  |  |  |

### `password_resets` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `email` | `varchar(255)` | NO |  |  |  |
| `token` | `varchar(255)` | NO |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |

### `personal_access_tokens` — ~155 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | NO |  |  |  |
| `tokenable_type` | `varchar(255)` | NO |  |  |  |
| `tokenable_id` | `bigint(20) unsigned` | NO |  |  |  |
| `name` | `varchar(255)` | NO |  |  |  |
| `token` | `varchar(64)` | NO |  |  |  |
| `abilities` | `text` | YES |  |  |  |
| `last_used_at` | `timestamp` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `failed_jobs` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | NO |  |  |  |
| `uuid` | `varchar(255)` | NO |  |  |  |
| `connection` | `text` | NO |  |  |  |
| `queue` | `text` | NO |  |  |  |
| `payload` | `longtext` | NO |  |  |  |
| `exception` | `longtext` | NO |  |  |  |
| `failed_at` | `timestamp` | NO | current_timestamp() |  |  |

### `migrations` — ~11 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(10) unsigned` | NO |  | PRI |  |
| `migration` | `varchar(255)` | NO |  |  |  |
| `batch` | `int(11)` | NO |  |  |  |

### `tr_employees_note` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `emp_id` | `varchar(255)` | NO |  |  |  |
| `note_id` | `varchar(50)` | NO |  | PRI | {tahunbulan}-{tanggal}-{emp_id}-{index} |
| `subject` | `varchar(255)` | YES |  |  |  |
| `notes` | `longtext` | YES |  |  |  |
| `is_urgent` | `int(11)` | NO | 0 |  |  |
| `created_at` | `datetime` | YES |  |  |  |
| `created_by` | `varchar(255)` | YES |  |  |  |

### `tr_import_data` — ~428 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(10)` | NO |  |  |  |
| `full_name` | `varchar(100)` | NO |  |  |  |
| `email` | `varchar(100)` | YES |  |  |  |
| `address` | `varchar(100)` | YES |  |  |  |
| `location` | `varchar(100)` | YES |  |  |  |
| `cell_phone` | `varchar(100)` | YES |  |  |  |
| `gender` | `varchar(100)` | YES |  |  |  |
| `birthdate` | `varchar(100)` | YES |  |  |  |
| `current_sallary` | `varchar(100)` | YES |  |  |  |
| `current_sallary2` | `varchar(100)` | YES |  |  |  |
| `expected_sallary` | `varchar(100)` | YES |  |  |  |
| `last_job` | `varchar(100)` | YES |  |  |  |
| `last_company` | `varchar(100)` | YES |  |  |  |
| `last_education` | `varchar(100)` | YES |  |  |  |
| `last_major` | `varchar(100)` | YES |  |  |  |
| `last_school` | `varchar(100)` | YES |  |  |  |
| `efset` | `varchar(100)` | YES |  |  |  |
| `communication_test` | `varchar(100)` | YES |  |  |  |
| `interest_test` | `varchar(100)` | YES |  |  |  |
| `tld_1` | `varchar(100)` | YES |  |  |  |
| `orvi` | `varchar(100)` | YES |  |  |  |
| `apply_at` | `varchar(100)` | YES |  |  |  |
| `matched` | `varchar(100)` | YES |  |  |  |
| `shortlisted` | `varchar(100)` | YES |  |  |  |
| `not_matched` | `varchar(100)` | YES |  |  |  |
| `orvi2` | `varchar(100)` | YES |  |  |  |
| `interview1` | `varchar(100)` | YES |  |  |  |
| `interview2` | `varchar(100)` | YES |  |  |  |
| `interview3` | `varchar(100)` | YES |  |  |  |
| `mcu` | `varchar(100)` | YES |  |  |  |
| `tld2` | `varchar(100)` | YES |  |  |  |
| `offered` | `varchar(100)` | YES |  |  |  |
| `hired` | `varchar(100)` | YES |  |  |  |
| `failed` | `varchar(100)` | YES |  |  |  |
| `image` | `varchar(100)` | YES |  |  |  |
| `applied_position` | `varchar(100)` | NO |  |  |  |
| `last_gpa` | `varchar(100)` | YES |  |  |  |
| `keterangan` | `varchar(100)` | YES |  |  |  |
| `created_at` | `varchar(50)` | NO |  |  |  |
| `updated_at` | `varchar(50)` | YES |  |  |  |

### `events` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | NO |  | PRI |  |
| `title` | `varchar(255)` | NO |  |  |  |
| `start` | `datetime` | NO |  |  |  |
| `end` | `datetime` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `imageuploader` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  |  |  |
| `path` | `varchar(252)` | NO |  |  |  |
| `description` | `varchar(252)` | NO |  |  |  |

### `o_t_p_s` — ~4 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `phone_number` | `varchar(255)` | YES |  |  |  |
| `otp_code` | `varchar(255)` | YES |  |  |  |
| `expires_at` | `timestamp` | YES |  |  |  |

### `Tr_Training_QA_d` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_QA_Code_d` | `varchar(255)` | YES |  |  |  |
| `Ms_QA` | `varchar(255)` | YES |  |  |  |
| `Answer_Essay` | `varchar(255)` | YES |  |  |  |
| `Ms_Candidate_code` | `varchar(0)` | YES |  |  |  |

### `Ms_Training_QA_Essay` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Ms_Training_QA` | `varchar(255)` | YES |  |  |  |
| `Q_Desc` | `varchar(255)` | YES |  |  |  |
| `Ms_Training_Category` | `varchar(255)` | YES |  |  |  |

### `_DOC_Proses_Kerja` — ~4 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Proses` | `varchar(50)` | NO |  |  |  |
| `Keterangan` | `text` | NO |  |  |  |
| `DateCreate` | `date` | NO |  |  |  |
| `DateEdit` | `date` | NO |  |  |  |

### `_doc_frontEnd` — ~2 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Front` | `varchar(50)` | NO |  |  |  |
| `Keterangan` | `text` | NO |  |  |  |

### `master_employees_back` — ~708 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `rec_usercreated` | `varchar(255)` | YES |  |  |  |
| `rec_userupdate` | `varchar(255)` | YES |  |  |  |
| `rec_datecreated` | `varchar(255)` | YES |  |  |  |
| `rec_dateupdate` | `varchar(255)` | YES |  |  |  |
| `rec_status` | `varchar(255)` | YES |  |  |  |
| `emp_id` | `varchar(255)` | YES |  |  |  |
| `emp_iddivision` | `varchar(255)` | YES |  |  |  |
| `emp_name` | `varchar(255)` | YES |  |  |  |
| `emp_inactive` | `varchar(255)` | YES |  |  |  |
| `emp_subdivision` | `varchar(255)` | YES |  |  |  |
| `emp_upahpokok` | `varchar(255)` | YES |  |  |  |
| `emp_tunjangan` | `varchar(255)` | YES |  |  |  |
| `emp_datejoin` | `varchar(255)` | YES |  |  |  |
| `emp_dateresign` | `varchar(255)` | YES |  |  |  |
| `emp_born` | `varchar(255)` | YES |  |  |  |
| `emp_nokontrak` | `varchar(255)` | YES |  |  |  |
| `emp_expdatekontrak` | `varchar(255)` | YES |  |  |  |
| `emp_numkontrak` | `varchar(255)` | YES |  |  |  |
| `emp_npwp` | `varchar(255)` | YES |  |  |  |
| `emp_bank` | `varchar(255)` | YES |  |  |  |
| `emp_norek` | `varchar(255)` | YES |  |  |  |
| `emp_address` | `varchar(255)` | YES |  |  |  |
| `emp_idktp` | `varchar(255)` | YES |  |  |  |
| `emp_kotalahir` | `varchar(255)` | YES |  |  |  |
| `emp_childno` | `varchar(255)` | YES |  |  |  |
| `emp_namaistri` | `varchar(255)` | YES |  |  |  |
| `emp_jamsostek` | `varchar(255)` | YES |  |  |  |
| `emp_includepajak` | `varchar(255)` | YES |  |  |  |
| `emp_telp` | `varchar(255)` | YES |  |  |  |
| `emp_lastedu` | `varchar(255)` | YES |  |  |  |
| `emp_lastcom` | `varchar(255)` | YES |  |  |  |
| `emp_telplastcom` | `varchar(255)` | YES |  |  |  |
| `emp_lastjabatan` | `varchar(255)` | YES |  |  |  |
| `emp_lastsalary` | `varchar(255)` | YES |  |  |  |
| `emp_cutitotal` | `varchar(255)` | YES |  |  |  |
| `emp_com` | `varchar(255)` | YES |  |  |  |
| `emp_status` | `varchar(255)` | YES |  |  |  |
| `emp_religion` | `varchar(255)` | YES |  |  |  |
| `emp_citizen` | `varchar(255)` | YES |  |  |  |
| `emp_desc` | `varchar(255)` | YES |  |  |  |
| `emp_levelclass` | `varchar(255)` | YES |  |  |  |
| `emp_leveljabatan` | `varchar(255)` | YES |  |  |  |
| `emp_lastjobdesk` | `varchar(255)` | YES |  |  |  |
| `emp_apprlast` | `varchar(255)` | YES |  |  |  |
| `emp_gender` | `varchar(255)` | YES |  |  |  |
| `emp_typepayroll` | `varchar(255)` | YES |  |  |  |
| `emp_reason_nonactive` | `varchar(255)` | YES |  |  |  |
| `emp_aksesuser` | `varchar(255)` | YES |  |  |  |
| `emp_email` | `varchar(255)` | YES |  |  |  |
| `emp_statuskaryawan` | `varchar(255)` | YES |  |  |  |

### `Tr_Ba_Main_New_test` — ~7358 rows

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

