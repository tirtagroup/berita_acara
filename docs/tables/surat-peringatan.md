# Surat Peringatan (SP)

Tabel untuk workflow Surat Peringatan disipliner.

Sumber: database `tirt3038_HR_Worksheet` (kecuali disebut lain).

---

### `tr_acc_sp_main` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `rec_usercreated` | `varchar(50)` | NO |  |  |  |
| `rec_userupdate` | `varchar(50)` | YES |  |  |  |
| `rec_datecreated` | `datetime` | YES |  |  |  |
| `rec_dateupdate` | `datetime` | YES |  |  |  |
| `rec_status` | `int(11)` | NO |  |  |  |
| `sp_main_code` | `varchar(50)` | NO |  |  |  |
| `ms_company` | `varchar(50)` | NO |  |  |  |
| `ms_lokasi` | `varchar(50)` | NO |  |  |  |
| `sp_type` | `varchar(50)` | YES |  |  |  |
| `sp_jenis` | `varchar(50)` | NO |  |  |  |
| `ms_employee` | `varchar(100)` | NO |  |  |  |
| `ms_divisi` | `varchar(50)` | NO |  |  |  |
| `masa_berlaku` | `varchar(100)` | NO |  |  |  |
| `sp_desc` | `varchar(500)` | NO |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `tr_acc_sp_h` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `rec_usercreated` | `varchar(50)` | NO |  |  |  |
| `rec_userupdate` | `varchar(50)` | NO |  |  |  |
| `rec_datecreated` | `datetime` | YES |  |  |  |
| `rec_dateupdate` | `datetime` | YES |  |  |  |
| `rec_status` | `int(11)` | NO |  |  |  |
| `tr_acc_sp_h_code` | `varchar(50)` | NO |  |  |  |
| `tr_acc_sp_main_code` | `varchar(50)` | NO |  |  |  |
| `rec_comcode` | `varchar(50)` | NO |  |  |  |
| `rec_areacode` | `varchar(50)` | NO |  |  |  |
| `sp_employee` | `varchar(50)` | NO |  |  |  |
| `sp_divisi` | `varchar(50)` | NO |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `tr_acc_sp_d` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `tr_acc_sp_d_code` | `varchar(50)` | NO |  |  |  |
| `tr_acc_sp_h_code` | `varchar(50)` | NO |  |  |  |
| `sp_note` | `varchar(500)` | NO |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `ms_type_sp` — ~4 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `type_code` | `varchar(50)` | NO |  |  |  |
| `description` | `varchar(100)` | NO |  |  |  |
| `rec_status` | `int(11)` | NO |  |  |  |
| `user_created` | `varchar(100)` | NO |  |  |  |
| `user_updated` | `varchar(100)` | NO |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

