# ERP Database (`tirt3038_ERP`)

Koneksi `mysql_new` di `.env`. Berisi master karyawan & data daily/operasional ERP.

---

### `Ms_User_ERP` — ~664 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Ms_User_Code` | `varchar(50)` | NO |  |  | Login Username Code |
| `API_Code` | `varchar(50)` | NO |  |  |  |
| `Password` | `varchar(255)` | NO |  |  | Password Login |
| `Master_Code` | `varchar(255)` | NO |  |  | TO Reset ANd Verify Guest Account |
| `Ms_Company` | `varchar(50)` | NO |  | PRI | Company Code |
| `verify_by` | `varchar(255)` | YES |  |  | Who Verify |
| `verify_at` | `datetime` | YES |  |  | When Verify |
| `emp_division` | `varchar(255)` | NO |  |  |  |
| `account_active` | `tinyint(4)` | NO |  |  | 0 is Inactive
1 is Active
 |
| `usr_email` | `varchar(255)` | NO |  | PRI |  |
| `created_at` | `datetime` | NO |  |  |  |
| `emp_name` | `varchar(255)` | NO |  |  |  |
| `updated_at` | `datetime` | YES |  |  |  |
| `updated_by` | `varchar(255)` | YES |  |  |  |
| `role` | `varchar(255)` | NO |  |  | Adminstrator : Can access all
Supervisor : Access Approval
Guest : Normal, Operasional Staff |
| `emp_subdivision` | `varchar(255)` | NO |  |  |  |
| `company_branch` | `varchar(255)` | YES |  |  | Use Able For Driver  \| Helper |
| `remember_token` | `varchar(255)` | YES |  |  |  |
| `role_web_ba` | `tinyint(1)` | YES |  |  | For Role  Web Berita Acara |

### `Ms_User_Emp` — ~1478 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Ms_Emp_Code` | `varchar(50)` | NO |  | PRI | ID Employee |
| `Emp_Name` | `varchar(50)` | NO |  |  | Nama Employees |
| `Ms_Company_Code` | `varchar(50)` | NO |  | PRI | HGS
TGF
TGU

 |
| `Email` | `varchar(50)` | NO |  |  | Email Employee |
| `Phone` | `varchar(11)` | YES |  |  |  |
| `start_date_contract` | `date` | YES |  |  |  |
| `No_Contract` | `varchar(50)` | YES |  |  |  |
| `API_Code` | `varchar(50)` | YES |  |  |  |
| `Status_Active` | `tinyint(4)` | NO |  |  | 1 is for active
0 is for Inactive
 |
| `NIK` | `varchar(50)` | YES |  |  |  |
| `Emp_Level` | `varchar(50)` | YES |  |  |  |
| `emp_division` | `varchar(255)` | YES |  |  |  |
| `emp_subdivision` | `varchar(255)` | YES |  |  |  |
| `created_at` | `datetime` | NO |  |  |  |
| `created_by` | `varchar(255)` | NO |  |  |  |
| `updated_at` | `datetime` | YES |  |  |  |
| `updated_by` | `varchar(255)` | YES |  |  |  |
| `job_desc` | `varchar(255)` | YES |  |  |  |
| `tgl_lahir` | `date` | YES |  |  |  |
| `emp_status` | `varchar(255)` | YES |  |  |  |
| `emp_gender` | `varchar(255)` | NO |  |  | Laki-Laki \|\| Perempuan |
| `emp_bank` | `varchar(255)` | YES |  |  |  |
| `emp_npwp` | `varchar(255)` | YES |  |  |  |
| `end_date_contract` | `date` | YES |  |  |  |
| `last_company` | `varchar(255)` | YES |  |  |  |
| `last_position` | `varchar(255)` | YES |  |  |  |
| `no_rek_employee` | `varchar(255)` | YES |  |  |  |
| `upah_pokok` | `varchar(255)` | YES |  |  |  |
| `tunjangan` | `varchar(255)` | YES |  |  |  |
| `resign_date_contract` | `date` | YES |  |  |  |
| `numkontrak` | `varchar(255)` | YES |  |  |  |
| `address` | `text` | YES |  |  |  |
| `city_born` | `varchar(255)` | YES |  |  |  |
| `child_no` | `int(11)` | YES |  |  |  |
| `nama_suamioristri` | `varchar(255)` | YES |  |  |  |
| `jamsostek` | `varchar(255)` | YES |  |  |  |
| `include_pajak` | `varchar(255)` | YES |  |  |  |
| `last_education` | `varchar(255)` | YES |  |  |  |
| `telp_last_comp` | `varchar(255)` | YES |  |  |  |
| `last_salary` | `varchar(255)` | YES |  |  |  |
| `cuti_total` | `varchar(255)` | YES |  |  |  |
| `emp_religion` | `varchar(255)` | YES |  |  |  |
| `emp_citizen` | `varchar(255)` | YES |  |  |  |
| `emp_typepayroll` | `varchar(255)` | YES |  |  |  |
| `emp_reason_nonactive` | `varchar(255)` | YES |  |  |  |
| `rec_status` | `int(11)` | NO |  |  |  |
| `card_id` | `varchar(25)` | YES |  |  |  |
| `emp_akn_ig` | `varchar(255)` | YES |  |  |  |
| `emp_akn_fb` | `varchar(255)` | YES |  |  |  |
| `no_drt_emp` | `varchar(255)` | YES |  |  |  |
| `name_drt_emp` | `varchar(255)` | YES |  |  |  |
| `akses_user_permission` | `varchar(255)` | YES |  |  |  |

### `d_daily` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `id_h_daily` | `int(11)` | YES |  |  |  |
| `task` | `varchar(255)` | YES |  |  |  |
| `keterangan` | `varchar(255)` | YES |  |  |  |
| `kendala` | `varchar(255)` | YES |  |  |  |
| `created_at` | `datetime` | YES |  |  |  |
| `created_by` | `varchar(255)` | YES |  |  |  |
| `updated_at` | `datetime` | YES |  |  |  |
| `updated_by` | `varchar(255)` | YES |  |  |  |
| `rec_status` | `int(11)` | NO |  |  |  |

### `h_daily` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11) unsigned zerofill` | NO |  | PRI |  |
| `emp_code` | `varchar(100)` | YES |  |  |  |
| `emp_division` | `varchar(255)` | YES |  |  |  |
| `tanggal` | `date` | YES |  |  |  |
| `lokasi` | `varchar(255)` | YES |  |  |  |
| `created_at` | `datetime` | YES |  |  |  |
| `created_by` | `varchar(255)` | YES |  |  |  |
| `updated_at` | `datetime` | YES |  |  |  |
| `updated_by` | `varchar(255)` | YES |  |  |  |
| `rec_status` | `int(11)` | NO |  |  |  |
| `no_wa` | `varchar(20)` | YES |  |  |  |

### `ms_bank` — ~24 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `rec_usercreated` | `varchar(50)` | NO |  |  |  |
| `rec_userupdate` | `varchar(50)` | NO |  |  |  |
| `rec_datecreated` | `datetime` | NO |  |  |  |
| `rec_dateupdate` | `datetime` | NO |  |  |  |
| `rec_status` | `char(1)` | NO |  |  |  |
| `Bank_Code` | `varchar(100)` | NO |  |  |  |

### `ms_cabang` — ~22 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `rec_usercreated` | `varchar(50)` | NO |  |  |  |
| `rec_userupdate` | `varchar(50)` | NO |  |  |  |
| `rec_datecreated` | `datetime` | NO |  |  |  |
| `rec_dateupdate` | `datetime` | NO |  |  |  |
| `rec_status` | `char(1)` | NO |  |  |  |
| `cab_code` | `varchar(50)` | NO |  | PRI |  |
| `cab_desc` | `varchar(50)` | YES |  |  |  |
| `cab_add` | `text` | YES |  |  |  |
| `cab_add_city` | `char(10)` | YES |  |  |  |
| `cab_pstcode` | `varchar(50)` | YES |  |  |  |
| `cab_phone` | `varchar(50)` | YES |  |  |  |
| `cab_fax` | `varchar(50)` | YES |  |  |  |
| `cab_email` | `varchar(100)` | YES |  |  |  |
| `cab_areacode` | `varchar(50)` | YES |  |  |  |
| `cab_compcode` | `varchar(50)` | YES |  |  |  |

### `ms_division` — ~17 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `rec_usercreated` | `varchar(50)` | NO |  |  |  |
| `rec_userupdate` | `varchar(50)` | YES |  |  |  |
| `rec_datecreated` | `datetime` | NO |  |  |  |
| `rec_dateupdate` | `datetime` | YES |  |  |  |
| `rec_status` | `char(1)` | NO |  |  |  |
| `id` | `int(11)` | NO |  |  |  |
| `div_id` | `varchar(50)` | NO |  | PRI |  |
| `div_desc` | `varchar(50)` | NO |  |  |  |

### `ms_driver` — ~236 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `user_created` | `varchar(100)` | NO |  |  | who created |
| `user_updated` | `varchar(100)` | YES |  |  | who updated |
| `date_created` | `datetime` | NO |  |  | date created |
| `date_updated` | `datetime` | YES |  |  | date updated |
| `rec_status` | `tinyint(4)` | NO |  |  | record status 
1 : Not Deleted
0 : Soft Deleted |
| `driver_id` | `varchar(100)` | NO |  | PRI | ID Driver |
| `driver_name` | `varchar(255)` | NO |  |  | Nama Driver |
| `driver_address` | `text` | YES |  |  | Tempat Tinggal Driver |
| `driver_branch` | `varchar(255)` | NO |  |  | Cabang Driver |
| `driver_status_active` | `tinyint(4)` | YES |  |  | Status Driver Masih aktif |
| `kota_lahir` | `varchar(255)` | YES |  |  | Kota Lahir Driver |
| `tgl_lahir` | `date` | YES |  |  | tanggal Lahir Driver |
| `start_date` | `date` | YES |  |  | Tanggal Mulai driver |
| `phone_number` | `varchar(50)` | YES |  |  | No HP Driver  |
| `license_code` | `varchar(255)` | NO |  |  | No Sim Driver |
| `license_expired` | `date` | NO |  |  | Tanggal SIM driver Expired |
| `last_education` | `varchar(255)` | YES |  |  | Pendidikan terakhir driver |
| `spv_code` | `varchar(255)` | NO |  |  | code spv driver |
| `driver_status` | `varchar(255)` | YES |  |  | status Driver Sudah Menikah atau dll |
| `child_no` | `int(11)` | YES |  |  | Anak Keberapa |
| `driver_darurat_phone` | `varchar(255)` | YES |  |  | nomor darurat driver |
| `driver_name_darurat_phone` | `varchar(255)` | YES |  |  | nama pemilik nomor darurat |
| `driver_instagram` | `varchar(255)` | YES |  |  | Instagram driver |
| `driver_facebook` | `varchar(255)` | YES |  |  | Facebook Driver |
| `driver_norek` | `varchar(255)` | YES |  |  | norek Driver |
| `driver_bank` | `varchar(255)` | YES |  |  | bank driver |
| `driver_email` | `varchar(255)` | NO |  |  | email driver |
| `end_date` | `date` | YES |  |  | Tanggal Contract stop driver |
| `driver_nik` | `varchar(255)` | NO |  |  | Nomor KTP driver |
| `driver_ranking` | `int(11)` | YES |  |  | Ranking Driver |
| `driver_gender` | `varchar(255)` | YES |  |  |  |

### `ms_helper` — ~285 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `user_created` | `varchar(255)` | NO |  |  |  |
| `user_updated` | `varchar(255)` | YES |  |  |  |
| `date_created` | `datetime` | NO |  |  |  |
| `date_updated` | `datetime` | YES |  |  |  |
| `rec_status` | `tinyint(4)` | YES |  |  |  |
| `helper_id` | `varchar(255)` | NO |  | PRI |  |
| `helper_name` | `varchar(255)` | NO |  |  |  |
| `helper_address` | `text` | YES |  |  |  |
| `helper_branch` | `varchar(255)` | YES |  |  |  |
| `helper_status_active` | `tinyint(4)` | YES |  |  |  |
| `kota_lahir` | `varchar(255)` | YES |  |  |  |
| `tgl_lahir` | `date` | YES |  |  |  |
| `start_date` | `date` | YES |  |  |  |
| `phone_number` | `varchar(50)` | YES |  |  |  |
| `license_code` | `varchar(255)` | NO |  |  |  |
| `license_expired` | `date` | NO |  |  |  |
| `last_edu` | `varchar(255)` | YES |  |  |  |
| `spv_code` | `varchar(255)` | YES |  |  |  |
| `helper_status` | `varchar(255)` | YES |  |  |  |
| `child_no` | `int(11)` | YES |  |  |  |
| `helper_darurat_phone` | `varchar(255)` | YES |  |  |  |
| `helper_name_darurat_phone` | `varchar(255)` | YES |  |  |  |
| `helper_ig` | `varchar(255)` | YES |  |  |  |
| `helper_fb` | `varchar(255)` | YES |  |  |  |
| `helper_norek` | `varchar(255)` | YES |  |  |  |
| `helper_bank` | `varchar(255)` | YES |  |  |  |
| `helper_email` | `varchar(255)` | YES |  |  |  |
| `end_date` | `date` | YES |  |  |  |
| `helper_nik` | `varchar(255)` | YES |  |  |  |
| `helper_ranking` | `varchar(255)` | YES |  |  |  |
| `helper_gender` | `varchar(255)` | YES |  |  |  |

### `ms_subdivision` — ~44 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `rec_usercreated` | `varchar(50)` | NO |  |  |  |
| `rec_userupdate` | `varchar(50)` | NO |  |  |  |
| `rec_datecreated` | `datetime` | NO |  |  |  |
| `rec_dateupdate` | `datetime` | NO |  |  |  |
| `rec_status` | `char(1)` | NO |  |  |  |
| `id` | `int(11)` | NO |  |  |  |
| `subdiv_code` | `varchar(50)` | NO |  |  |  |
| `subdiv_desc` | `varchar(50)` | YES |  |  |  |
| `created_at` | `datetime` | YES |  |  |  |
| `updated_at` | `datetime` | YES |  |  |  |

### `personal_access_tokens` — ~1243 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `bigint(20) unsigned` | NO |  | PRI |  |
| `tokenable_type` | `varchar(255)` | NO |  | MUL |  |
| `tokenable_id` | `varchar(191)` | YES |  |  |  |
| `name` | `varchar(255)` | NO |  |  |  |
| `token` | `varchar(64)` | NO |  | UNI |  |
| `abilities` | `text` | YES |  |  |  |
| `last_used_at` | `timestamp` | YES |  |  |  |
| `expires_at` | `timestamp` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

