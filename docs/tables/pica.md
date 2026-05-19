# PICA — Problem Identification & Corrective Action

Tabel untuk modul PICA: analisis akar masalah, tindakan korektif, dan tindakan preventif.

Sumber: database `tirt3038_HR_Worksheet` (kecuali disebut lain).

---

### `Tr_PICA_Emp_h` — ~88 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_Pica_Emp_h_Code` | `varchar(50)` | NO |  | PRI |  |
| `Emp_Code` | `varchar(50)` | NO |  |  |  |
| `NoBA` | `varchar(225)` | YES |  |  |  |
| `Date_PICA` | `datetime` | YES |  |  |  |
| `SPV_Approval` | `varchar(50)` | YES |  |  |  |
| `Problem_Note` | `varchar(500)` | YES |  |  |  |
| `Kapan_Terjadi` | `datetime` | YES |  |  |  |
| `Ms_Company` | `varchar(255)` | YES |  |  |  |
| `Ms_Location` | `varchar(255)` | YES |  |  |  |
| `Apakah_Sudah_Pernah_Kejadian` | `varchar(50)` | YES |  |  |  |
| `Status_PICA` | `varchar(255)` | YES |  |  |  |
| `User_Created` | `varchar(255)` | YES |  |  |  |
| `User_Update` | `varchar(255)` | YES |  |  |  |
| `created_at` | `timestamp` | NO |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `Tr_Pica_Emp_D` — ~11 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_Pica_emp_d_Code` | `varchar(50)` | NO |  | PRI |  |
| `Tr_Pica_emp_h_Code` | `varchar(50)` | NO |  |  |  |
| `NoBA` | `varchar(100)` | YES |  |  |  |
| `ApaYangSalah` | `varchar(1000)` | YES |  |  |  |
| `MengapaTerjadi` | `varchar(1000)` | YES |  |  |  |
| `BagaimanaMenghindari` | `varchar(1000)` | YES |  |  |  |
| `ApaYangDiperhatikan` | `varchar(1000)` | YES |  |  |  |
| `Siapa_Yang_Salah` | `varchar(100)` | YES |  |  |  |
| `SPV_Comment` | `varchar(100)` | YES |  |  |  |
| `created_at` | `timestamp` | NO |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |
| `Tindakan_Korektif` | `varchar(1000)` | YES |  |  |  |
| `Date_Koreksi` | `datetime` | YES |  |  |  |

### `Tr_PICA_Pertanyaan` — ~395 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_PICA_Pertanyaan_Code` | `varchar(100)` | NO |  | PRI |  |
| `Tr_Pica_emp_h_Code` | `varchar(500)` | NO |  |  |  |
| `Tr_Pertanyaan` | `varchar(500)` | YES |  |  |  |
| `Tr_Jawaban` | `varchar(500)` | YES |  |  |  |
| `created_at` | `timestamp` | NO |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `Tr_PICA_Action` — ~196 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_Pica_Action_Code` | `varchar(100)` | NO |  | PRI |  |
| `Tr_Pica_Emp_h_Code` | `varchar(100)` | NO |  |  |  |
| `Tr_PICA_Emp_h` | `varchar(100)` | NO |  |  |  |
| `ApaYangAkanDilakukan` | `varchar(100)` | YES |  |  | 1 contoh training |
| `Kapan` | `datetime` | YES |  |  |  |
| `created_at` | `timestamp` | NO |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `Tr_PICA_Preventive_Action` — ~202 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_PICA_Preventive_Action_Code` | `varchar(100)` | NO |  | PRI |  |
| `Tr_Pica_emp_h_Code` | `varchar(100)` | NO |  |  |  |
| `Tr_Preventive` | `varchar(500)` | YES |  |  |  |
| `created_at` | `timestamp` | NO |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `Tr_PICA_Comment` — ~118 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_PICA_Comment_Code` | `varchar(100)` | NO |  | PRI |  |
| `Tr_PICA_Emp_h_Code` | `varchar(100)` | NO |  |  |  |
| `Ms_User` | `varchar(100)` | NO |  |  |  |
| `Comment` | `varchar(500)` | NO |  |  |  |
| `web_db` | `int(11)` | NO |  |  |  |
| `sent_to` | `varchar(50)` | NO |  |  |  |
| `is_read` | `varchar(50)` | NO |  |  |  |
| `created_at` | `timestamp` | NO |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

