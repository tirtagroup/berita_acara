# Master Data

Tabel referensi: perusahaan, lokasi, divisi, karyawan, kategori kasus, dll.

Sumber: database `tirt3038_HR_Worksheet` (kecuali disebut lain).

---

### `ms_company` — ~4 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `company_code` | `varchar(50)` | NO |  |  |  |
| `description` | `varchar(100)` | NO |  |  |  |
| `rec_status` | `int(11)` | NO |  |  |  |
| `user_created` | `varchar(50)` | NO |  |  |  |
| `user_updated` | `varchar(50)` | NO |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `ms_branch` — ~2 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `branch_code` | `varchar(50)` | NO |  |  |  |
| `description` | `varchar(50)` | NO |  |  |  |
| `rec_status` | `int(11)` | NO |  |  |  |
| `user_created` | `varchar(50)` | NO |  |  |  |
| `user_updated` | `varchar(50)` | NO |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `ms_division` — ~2 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `rec_usercreated` | `varchar(50)` | NO |  |  |  |
| `rec_userupdate` | `varchar(50)` | NO |  |  |  |
| `rec_datecreated` | `timestamp` | NO | current_timestamp() |  |  |
| `rec_dateupdate` | `timestamp` | YES |  |  |  |
| `rec_status` | `int(11)` | NO |  |  |  |
| `div_code` | `varchar(50)` | NO |  |  |  |
| `div_desc` | `varchar(50)` | NO |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `ms_divisi` — ~43 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `subbdiv_code` | `varchar(100)` | YES |  |  |  |
| `subbdiv_desc` | `varchar(100)` | YES |  |  |  |
| `user_created` | `varchar(100)` | YES |  |  |  |
| `user_updated` | `varchar(100)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `ms_subdivision` — ~48 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `rec_usercreated` | `varchar(50)` | YES |  |  |  |
| `rec_userupdate` | `varchar(50)` | YES |  |  |  |
| `rec_datecreated` | `datetime` | YES |  |  |  |
| `rec_dateupdate` | `datetime` | YES |  |  |  |
| `rec_status` | `int(11)` | NO |  |  |  |
| `subdiv_code` | `varchar(50)` | NO |  |  |  |
| `subdiv_desc` | `varchar(50)` | NO |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `ms_lokasi` — ~27 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `lokasi_code` | `varchar(100)` | YES |  |  |  |
| `lokasi_desc` | `varchar(100)` | YES |  |  |  |
| `lokasi_kota` | `varchar(100)` | YES |  |  |  |
| `no_hp` | `varchar(100)` | YES |  |  |  |
| `area_code` | `varchar(100)` | YES |  |  |  |
| `company_code` | `varchar(100)` | YES |  |  |  |
| `user_created` | `varchar(100)` | YES |  |  |  |
| `user_updated` | `varchar(100)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `ms_employee` — ~612 rows

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

### `master_employees` — ~9389 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `user_created` | `varchar(255)` | YES |  |  |  |
| `user_updated` | `varchar(255)` | YES |  |  |  |
| `rec_datecreated` | `datetime` | YES |  |  |  |
| `rec_dateupdate` | `datetime` | YES |  |  |  |
| `rec_status` | `int(11)` | YES |  |  |  |
| `emp_id` | `varchar(255)` | NO |  |  |  |
| `emp_iddivision` | `varchar(255)` | YES |  |  |  |
| `emp_name` | `varchar(255)` | YES |  | UNI |  |
| `emp_inactive` | `varchar(255)` | YES |  |  |  |
| `emp_subdivision` | `varchar(255)` | YES |  |  |  |
| `emp_upahpokok` | `varchar(255)` | YES |  |  |  |
| `emp_tunjangan` | `varchar(255)` | YES |  |  |  |
| `emp_datejoin` | `datetime` | YES |  |  |  |
| `emp_dateresign` | `datetime` | YES |  |  |  |
| `emp_born` | `datetime` | YES |  |  |  |
| `emp_nokontrak` | `varchar(255)` | YES |  |  |  |
| `emp_expdatekontrak` | `datetime` | YES |  |  |  |
| `emp_numkontrak` | `varchar(50)` | YES |  |  |  |
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
| `emp_levelclass` | `varchar(50)` | YES |  |  |  |
| `emp_leveljabatan` | `varchar(50)` | YES |  |  |  |
| `emp_lastjobdesk` | `varchar(100)` | YES |  |  |  |
| `emp_apprlast` | `varchar(100)` | YES |  |  |  |
| `emp_gender` | `varchar(255)` | YES |  |  |  |
| `emp_typepayroll` | `varchar(255)` | YES |  |  |  |
| `emp_reason_nonactive` | `text` | YES |  |  |  |
| `emp_aksesuser` | `varchar(50)` | YES |  |  |  |
| `emp_email` | `varchar(255)` | YES |  |  |  |
| `emp_statuskaryawan` | `varchar(50)` | YES |  |  |  |
| `created_at` | `timestamp` | YES |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `ms_kasus` — ~694 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `ms_kasus_code` | `varchar(50)` | NO |  | UNI |  |
| `ms_kasus_head1` | `varchar(11)` | NO |  |  |  |
| `description` | `varchar(500)` | NO |  | UNI |  |
| `rec_status` | `int(11)` | NO |  |  |  |
| `rec_usercreated` | `varchar(100)` | YES |  |  |  |
| `rec_userupdate` | `varchar(100)` | YES |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `ms_kasus_head` — ~197 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `ms_type` | `varchar(50)` | YES |  |  |  |
| `ms_jenis_ba_code` | `varchar(50)` | NO |  | UNI |  |
| `description` | `varchar(50)` | NO |  |  |  |
| `rec_usercreated` | `varchar(50)` | NO |  |  |  |
| `rec_userupdate` | `varchar(50)` | NO |  |  |  |
| `rec_status` | `int(11)` | NO |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `Ms_Kasus_Detail` — ~1 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `Ms_Kasus_Detail_Code` | `varchar(255)` | NO |  |  |  |
| `Detail_Desc` | `varchar(255)` | YES |  |  |  |
| `Cek_Revisi` | `tinyint(255)` | YES |  |  |  |
| `Cek_Fraud` | `tinyint(255)` | YES |  |  |  |
| `Cek_Pelanggaran_SOP` | `tinyint(255)` | YES |  |  |  |
| `Cek_Disiplin` | `tinyint(255)` | YES |  |  |  |
| `Cek_Laka` | `tinyint(255)` | YES |  |  |  |
| `Cek_Kerusakan` | `tinyint(255)` | YES |  |  |  |
| `Cek_Approval` | `tinyint(255)` | YES |  |  |  |
| `Cek_Tolak_Tugas` | `tinyint(4)` | YES |  |  |  |
| `Cek_Barang_hilang` | `tinyint(11)` | NO |  |  |  |
| `Cek_Salah_Isi` | `tinyint(4)` | NO |  |  |  |
| `rec_usercreated` | `varchar(100)` | YES |  |  |  |
| `rec_userupdate` | `varchar(100)` | YES |  |  |  |
| `created_at` | `timestamp` | NO |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `ms_case_category` — ~10 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Ms_BA_category_Code` | `varchar(50)` | NO |  |  |  |
| `BA_Type_Desc` | `varchar(50)` | NO |  |  |  |

### `ms_status_short` — ~3 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  |  |  |
| `status_code` | `varchar(50)` | NO |  |  |  |
| `status_desc` | `varchar(50)` | NO |  |  |  |
| `rec_status` | `int(11)` | NO |  |  |  |
| `user_created` | `varchar(50)` | NO |  |  |  |
| `user_updated` | `varchar(50)` | NO |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `ms_dampak_laka` — ~5 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `ms_dampak_laka_code` | `varchar(50)` | NO |  |  |  |
| `description` | `varchar(100)` | NO |  |  |  |
| `rec_usercreated` | `varchar(50)` | YES |  |  |  |
| `rec_userupdate` | `varchar(50)` | YES |  |  |  |
| `rec_status` | `int(11)` | NO |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `ms_faktor_laka` — ~4 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `ms_faktor_laka_code` | `varchar(50)` | NO |  |  |  |
| `description` | `varchar(100)` | NO |  |  |  |
| `rec_usercreated` | `varchar(50)` | YES |  |  |  |
| `rec_userupdate` | `varchar(50)` | YES |  |  |  |
| `rec_status` | `int(11)` | NO |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `ms_jenis_laka` — ~3 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `ms_jenis_code` | `varchar(50)` | NO |  | UNI |  |
| `description` | `varchar(100)` | NO |  | UNI |  |
| `rec_usercreated` | `varchar(50)` | YES |  |  |  |
| `rec_userupdate` | `varchar(50)` | YES |  |  |  |
| `rec_status` | `int(11)` | NO |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `ms_klasifikasi_laka` — ~12 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `ms_klasifikasi_laka_code` | `varchar(50)` | NO |  | UNI |  |
| `description` | `varchar(100)` | NO |  |  |  |
| `rec_usercreated` | `int(11)` | YES |  |  |  |
| `rec_userupdate` | `int(11)` | YES |  |  |  |
| `rec_status` | `int(11)` | NO |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `ms_kode_interview` — ~4 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |
| `rec_usercreated` | `varchar(100)` | YES |  |  |  |
| `rec_userupdate` | `varchar(100)` | YES |  |  |  |
| `rec_status` | `int(11)` | YES |  |  |  |
| `ms_kode_interview_code` | `varchar(100)` | NO |  |  |  |
| `desciption` | `varchar(100)` | NO |  |  |  |

### `ms_fraud` — ~2 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `ms_fraud_code` | `varchar(50)` | NO |  | UNI |  |
| `ms_fraud_desc` | `varchar(50)` | NO |  |  |  |
| `rec_usercreated` | `varchar(50)` | YES |  |  |  |
| `rec_userupdate` | `varchar(50)` | YES |  |  |  |
| `rec_status` | `int(11)` | NO |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `ms_BAAction` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_Action_BA_Code` | `varchar(255)` | YES |  |  |  |
| `Action_Desc` | `varchar(255)` | YES |  |  |  |
| `Ms_Action_Code` | `varchar(255)` | YES |  |  |  |
| `Date_Action` | `datetime` | YES |  |  |  |
| `Executed_By` | `varchar(255)` | YES |  |  |  |
| `Tr_BA_Code` | `varchar(255)` | YES |  |  |  |

### `ms_akses` — ~91 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `divisi` | `varchar(255)` | YES |  |  |  |
| `subdivisi` | `varchar(255)` | YES |  |  |  |
| `tgu_sales_dan_biaya` | `bit(1)` | YES |  |  |  |
| `tgu_penjualan_persales` | `bit(1)` | YES |  |  |  |
| `tgu_pod_lastmile` | `bit(1)` | YES |  |  |  |
| `tgu_pod_invoice_sisa` | `bit(1)` | YES |  |  |  |
| `tgu_chart_Heinz` | `bit(1)` | YES |  |  |  |
| `tgu_chart_Agriaku` | `bit(1)` | YES |  |  |  |
| `tgu_chart_Gaji` | `bit(1)` | YES |  |  |  |
| `tgf_sales_dan_biaya` | `bit(1)` | YES |  |  |  |
| `tgf_top_sales_food` | `bit(1)` | YES |  |  |  |
| `tgf_top_sales_drink` | `bit(1)` | YES |  |  |  |
| `tgf_report_item_selling` | `bit(1)` | YES | b'0' |  |  |
| `tgf_sales_permenu` | `bit(1)` | YES |  |  |  |
| `tgf_sales_chart` | `bit(1)` | YES |  |  |  |
| `tgf_service_charge` | `bit(1)` | YES |  |  |  |
| `tgf_biaya_perlengkapan_resto` | `bit(1)` | YES |  |  |  |
| `tgf_biaya_perlengkapan_kantor` | `bit(1)` | YES |  |  |  |
| `tgf_biaya_bahan_baku` | `bit(1)` | YES |  |  |  |
| `tgf_chart_gaji` | `bit(1)` | YES |  |  |  |
| `hgs_sales_dan_biaya` | `bit(1)` | YES |  |  |  |
| `hgs_spk_gantung` | `bit(1)` | YES |  |  |  |
| `hgs_co_report` | `bit(1)` | YES |  |  |  |
| `hgs_biaya_gaji` | `bit(1)` | YES |  |  |  |
| `hgs_biaya_driver` | `bit(1)` | YES |  |  |  |
| `hgs_biaya_helper` | `bit(1)` | YES |  |  |  |
| `hgs_chart_biaya_driver_helper` | `bit(1)` | YES |  |  |  |
| `hgs_top_10_truck_dengan_biaya_terbesar` | `bit(1)` | YES |  |  |  |
| `hgs_sales_vs_biaya` | `bit(1)` | YES |  |  |  |
| `hgs_report_pemakaian_per_vehicle` | `bit(1)` | YES |  |  |  |
| `hgs_report_rastio` | `bit(1)` | YES |  |  |  |
| `hgs_chart_Danone` | `bit(1)` | YES |  |  |  |
| `hgs_chart_Agriaku` | `bit(1)` | YES |  |  |  |
| `hgs_chart_SHN` | `bit(1)` | YES |  |  |  |
| `hgs_chart_SMU` | `bit(1)` | YES |  |  |  |
| `hgs_chart_TGU` | `bit(1)` | YES |  |  |  |
| `hgs_chart_TUA` | `bit(1)` | YES |  |  |  |
| `hgs_chart_TVIP` | `bit(1)` | YES |  |  |  |
| `hgs_chart_Gaji` | `bit(1)` | YES |  |  |  |
| `hgs_chart_opr` | `bit(1)` | YES |  |  |  |
| `operasional_co_plan_report` | `bit(1)` | YES | b'0' |  |  |
| `operasional_co_tracking_report` | `bit(1)` | YES | b'0' |  |  |
| `operasional_report_Posisi_Truck` | `bit(1)` | YES | b'0' |  |  |
| `operasional_absensi_mitra` | `bit(1)` | YES | b'0' |  |  |
| `operasional_report_POD` | `bit(1)` | YES | b'0' |  |  |
| `employee_report` | `bit(1)` | YES | b'0' |  |  |
| `dashboard_ba` | `bit(1)` | YES | b'0' |  |  |
| `dashboard_ba_employee_detail` | `bit(1)` | YES | b'0' |  |  |
| `hr_absensi_karyawan` | `bit(1)` | YES | b'0' |  |  |
| `hr_absensi_mitra` | `bit(1)` | YES | b'0' |  |  |
| `hr_report_interview` | `bit(1)` | YES | b'0' |  |  |
| `hr_report_training_mitra` | `bit(1)` | YES | b'0' |  |  |
| `operasional_purchase_order` | `bit(1)` | YES |  |  |  |
| `tgm_sales_dan_biaya` | `bit(1)` | YES | b'0' |  |  |
| `PNL_report` | `bit(1)` | YES | b'0' |  |  |
| `balance_sheet_report` | `bit(1)` | YES | b'0' |  |  |
| `opening_closing_Warehouse` | `bit(1)` | YES | b'0' |  |  |
| `opening_closing_Kasir` | `bit(1)` | YES | b'0' |  |  |
| `opening_closing_Fleet` | `bit(1)` | YES | b'0' |  |  |
| `opening_closing_Purchasing` | `bit(1)` | YES | b'0' |  |  |
| `opening_closing_Lastmile` | `bit(1)` | YES | b'0' |  |  |
| `opening_closing_firstmile` | `bit(1)` | YES | b'0' |  |  |
| `sales_pjp_call_ec_report` | `bit(1)` | YES | b'0' |  |  |
| `sales_noo_report` | `bit(1)` | YES | b'0' |  |  |
| `trucking_Report_SPK_Gantung_Belum_Trans_Final_Kurang_dari_24_Jam` | `bit(1)` | YES | b'0' |  |  |
| `trucking_Report_SPK_Lebih_24_Jam` | `bit(1)` | YES | b'0' |  |  |
| `trucking_Report_POD_Gantung` | `bit(1)` | YES | b'0' |  |  |
| `trucking_Report_Truck_Tidak_Jalan` | `bit(1)` | YES | b'0' |  |  |
| `trucking_Report_Perbaikan_Truck` | `bit(1)` | YES | b'0' |  |  |
| `trucking_Report_Storing` | `bit(1)` | YES | b'0' |  |  |
| `trucking_Report_Part_Out_to_Vehicle` | `bit(1)` | YES | b'0' |  |  |
| `Finance_Report_Pembelian_Ban` | `bit(1)` | YES | b'0' |  |  |
| `Finance_Report_Pembelian_Sparepart` | `bit(1)` | YES | b'0' |  |  |
| `Finance_Pembelian_Sparepart_RO_x_PO_x_Part_In` | `bit(1)` | YES | b'0' |  |  |
| `Finance_Report_Pembelian_Accu` | `bit(1)` | YES | b'0' |  |  |
| `Finance_Report_Pembelian_Rachet` | `bit(1)` | YES | b'0' |  |  |
| `Finance_Report_Pembelian_Kopling` | `bit(1)` | YES | b'0' |  |  |
| `Finance_Report_Pembayaran_BBM` | `bit(1)` | YES | b'0' |  |  |
| `Finance_Report_Pemakaian_Ban` | `bit(1)` | YES | b'0' |  |  |
| `Finance_Report_Pemakaian_Sparepart` | `bit(1)` | YES | b'0' |  |  |
| `Finance_Report_Transit_Cheque` | `bit(1)` | YES | b'0' |  |  |
| `Finance_Report_Cheque_Gantung` | `bit(1)` | YES | b'0' |  |  |
| `Finance_Report_CPK_Ban` | `bit(1)` | YES | b'0' |  |  |
| `Finance_Report_KM_Naik_Turun` | `bit(1)` | YES | b'0' |  |  |
| `Finance_Report_Ban_Naik_Turun` | `bit(1)` | YES | b'0' |  |  |

### `Ms_category` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Ms_Kasus_Category` | `varchar(255)` | YES |  |  |  |
| `Category_Desc` | `varchar(255)` | YES |  |  |  |

### `Ms_Manual_Penjelasan` — ~2 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Ms_Subject_Code` | `varchar(50)` | NO |  |  |  |
| `SubjectType` | `varchar(50)` | NO |  |  |  |
| `SubjectDesc` | `text` | NO |  |  |  |

### `Ms_QA` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Ms_Training_QA_Multi` | `varchar(255)` | YES |  |  |  |
| `Q_Desc` | `varchar(255)` | YES |  |  |  |
| `Yes` | `varchar(255)` | YES |  |  |  |
| `No` | `varchar(255)` | YES |  |  |  |
| `Ragu` | `varchar(255)` | YES |  |  |  |

### `Ms_Review` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Ms_Review_Code` | `int(11)` | NO |  | PRI |  |
| `ReviewDesc` | `varchar(50)` | NO |  |  | misalnya kompetensi,tuntas,disiplin |
| `NonAktif` | `tinyint(4)` | NO |  |  |  |

### `Ms_Emp_Authority` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Ms_Emp_Access_Code` | `varchar(50)` | NO |  | PRI |  |
| `Ms_Reviewer_Code` | `varchar(50)` | NO |  |  |  |
| `Ms_Emp_Code` | `varchar(50)` | NO |  |  |  |
| `Allowed` | `tinyint(4)` | NO |  |  |  |

