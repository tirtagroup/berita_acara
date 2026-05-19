# Assessment / Penilaian Karyawan

Tabel untuk penilaian periodik karyawan: basic, leadership, kedisiplinan, dengan reviewer dan target.

Sumber: database `tirt3038_HR_Worksheet` (kecuali disebut lain).

---

### `tr_emp_assesment` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `rec_usercreated` | `varchar(50)` | YES |  |  |  |
| `rec_userupdate` | `varchar(50)` | YES |  |  |  |
| `rec_datecreated` | `datetime` | YES |  |  |  |
| `rec_dateupdate` | `datetime` | YES |  |  |  |
| `rec_status` | `int(11)` | YES |  |  |  |
| `Date_Asses` | `datetime` | YES |  |  |  |
| `Tr_Emp_Asses_Code` | `varchar(50)` | NO |  | UNI |  |
| `Ms_Emp_Code` | `varchar(50)` | NO |  |  |  |
| `Ms_Emp_Div` | `varchar(50)` | YES |  |  |  |
| `Ms_type_asses` | `varchar(50)` | YES |  |  |  |
| `Ms_record_asses` | `varchar(50)` | YES |  |  |  |
| `ms_periode` | `varchar(50)` | YES |  |  |  |
| `proggress` | `int(11)` | YES |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `tr_emp_assesor` — ~66 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id_emp_accessor` | `varchar(50)` | NO |  | PRI |  |
| `rec_usercreated` | `varchar(50)` | YES |  |  |  |
| `rec_userupdate` | `varchar(50)` | YES |  |  |  |
| `rec_datecreated` | `datetime` | YES |  |  |  |
| `rec_dateupdate` | `datetime` | YES |  |  |  |
| `rec_status` | `int(11)` | YES |  |  |  |
| `Tr_Emp_Asses_Code` | `varchar(100)` | NO |  |  |  |
| `Ms_Emp_Assessor_Code` | `varchar(50)` | NO |  |  |  |
| `Ms_record_asses` | `varchar(50)` | NO |  |  |  |
| `Date_Asses` | `datetime` | YES |  |  |  |
| `Ms_emp_code` | `varchar(50)` | NO |  |  |  |
| `Ms_Emp_Div` | `varchar(50)` | YES |  |  |  |
| `Ms_type_asses` | `varchar(50)` | YES |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `tr_emp_asses_advance_result` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id_adv_rst` | `varchar(50)` | NO |  |  |  |
| `Tr_Emp_Asses_Code` | `varchar(50)` | NO |  |  |  |
| `Ms_Emp_Assessor_Code` | `varchar(50)` | YES |  |  |  |
| `mengarahkan_value` | `int(11)` | YES |  |  |  |
| `mengarahkan_comment` | `varchar(100)` | YES |  |  |  |
| `problem_solving_value` | `int(11)` | YES |  |  |  |
| `problem_solving_comment` | `varchar(100)` | YES |  |  |  |
| `planning_value` | `int(11)` | YES |  |  |  |
| `planning_comment` | `varchar(100)` | YES |  |  |  |
| `analisa_value` | `int(11)` | YES |  |  |  |
| `analisa_comment` | `varchar(100)` | YES |  |  |  |
| `kualitas_komunikasi_value` | `int(11)` | YES |  |  |  |
| `kualitas_komunikasi_comment` | `varchar(100)` | YES |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `tr_emp_asses_discipline_result` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id_dcpn_rst` | `varchar(50)` | NO |  |  |  |
| `id_emp_asses` | `varchar(255)` | YES |  |  |  |
| `tr_emp_asses_discipline_result_code` | `varchar(50)` | YES |  |  |  |
| `Tr_Emp_Asses_Code` | `varchar(255)` | YES |  |  |  |
| `Ms_Emp_Assessor_Code` | `varchar(255)` | YES |  |  |  |
| `absensi_value` | `int(11)` | YES |  |  |  |
| `absensi_comment` | `varchar(255)` | YES |  |  |  |
| `report_value` | `int(11)` | YES |  |  |  |
| `report_comment` | `varchar(255)` | YES |  |  |  |
| `kerajinan_value` | `int(11)` | YES |  |  |  |
| `kerajinan_comment` | `varchar(255)` | YES |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | NO | current_timestamp() |  |  |

### `tr_emp_asses_note` — ~42 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `id_accessor_nt` | `varchar(50)` | NO |  |  |  |
| `Tr_Emp_Asses_Code` | `varchar(50)` | YES |  |  |  |
| `Ms_Emp_Assessor_Code` | `varchar(50)` | YES |  |  |  |
| `note` | `varchar(500)` | YES |  |  |  |
| `ms_type` | `varchar(50)` | YES |  |  |  |
| `rating` | `varchar(10)` | YES |  |  |  |
| `deadline` | `datetime` | YES |  |  |  |
| `status` | `varchar(50)` | YES |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `tr_ass_h` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `rec_usercreated` | `varchar(255)` | YES |  |  |  |
| `rec_userupdate` | `varchar(255)` | YES |  |  |  |
| `rec_datecreated` | `datetime` | YES |  |  |  |
| `rec_dateupdate` | `datetime` | YES |  |  |  |
| `rec_status` | `varchar(1)` | YES |  |  |  |
| `id` | `int(11)` | NO |  |  |  |
| `tr_assessment_code_h` | `varchar(255)` | NO |  |  |  |
| `Ass_desc` | `varchar(255)` | YES |  |  |  |
| `Ass_periode` | `varchar(255)` | YES |  |  |  |
| `Ass_date` | `datetime` | YES |  |  |  |
| `Ass_assestcode` | `varchar(255)` | YES |  |  |  |
| `Ass_div` | `varchar(255)` | YES |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `tr_ass_d_basic` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  |  |  |
| `tr_assestment_code_h` | `varchar(255)` | NO |  |  |  |
| `tr_assestment_code_d` | `varchar(255)` | NO |  |  |  |
| `ass_employeecode` | `varchar(255)` | YES |  |  |  |
| `ass_trust` | `varchar(255)` | YES |  |  |  |
| `ass_Drive` | `varchar(255)` | YES |  |  |  |
| `ass_basic` | `varchar(255)` | YES |  |  |  |
| `ass_inisiatif` | `varchar(255)` | YES |  |  |  |
| `ass_hasil` | `varchar(255)` | YES |  |  |  |
| `ass_skill` | `varchar(255)` | YES |  |  |  |
| `ass_note` | `varchar(255)` | YES |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `tr_period_asssement` — ~62 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `tr_code_main_assessment` | `varchar(500)` | NO |  |  |  |
| `Tr_period_assement` | `varchar(50)` | NO |  | PRI |  |
| `tugas` | `varchar(500)` | NO |  |  |  |
| `start_date` | `datetime` | NO |  |  |  |
| `EndDate` | `datetime` | NO |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `tr_period_emp` — ~59 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `tr_period_emp_code` | `varchar(100)` | NO |  | PRI |  |
| `start_date` | `datetime` | NO |  |  |  |
| `ms_emp_code` | `varchar(100)` | NO |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `tr_period_emp_task` — ~67 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `tr_code_main_assessment` | `varchar(100)` | NO |  |  | header ke tr_period_emp_main |
| `Tr_period_emp_task_code` | `varchar(100)` | NO |  | PRI |  |
| `Task` | `varchar(1000)` | NO |  |  |  |
| `Ms_Order_giver` | `varchar(100)` | NO |  |  |  |
| `Tr_period_emp_Code` | `varchar(50)` | NO |  |  |  |
| `initiative` | `varchar(10)` | NO |  |  |  |
| `mentoring` | `varchar(10)` | NO |  |  |  |
| `ms_type` | `varchar(50)` | NO |  |  |  |
| `status` | `varchar(50)` | NO |  |  |  |
| `konsisten` | `varchar(10)` | NO |  |  |  |
| `akurasi` | `varchar(10)` | NO |  |  |  |
| `tepatwaktu` | `varchar(10)` | NO |  |  |  |
| `quality` | `varchar(10)` | NO |  |  |  |
| `start_date` | `date` | YES |  |  |  |
| `end_date` | `date` | YES |  |  |  |
| `Date` | `datetime` | NO |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `tr_period_emp_assesor_main_backup` — ~58 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id_period_emp_assesor` | `varchar(100)` | NO |  | PRI | id=Period-Emp-assesor (period = Q12023) |
| `rec_usercreated` | `varchar(50)` | YES |  |  |  |
| `rec_userupdate` | `varchar(50)` | YES |  |  |  |
| `rec_datecreated` | `datetime` | YES |  |  |  |
| `rec_dateupdate` | `datetime` | YES |  |  |  |
| `rec_status` | `int(11)` | YES |  |  |  |
| `Date_Asses` | `datetime` | YES |  |  |  |
| `Tr_Emp_Asses_Code` | `varchar(50)` | NO |  |  |  |
| `Ms_Emp_Code` | `varchar(50)` | NO |  |  | kode dari yg di asses |
| `Ms_Emp_Div` | `varchar(50)` | YES |  |  |  |
| `Ms_type_asses` | `varchar(50)` | YES |  |  |  |
| `Ms_record_asses` | `varchar(50)` | YES |  |  |  |
| `ms_periode` | `varchar(50)` | YES |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |
| `MS_Assesor_Code` | `varchar(50)` | NO |  |  | hilangkan - krn ada di detail |
| `Period` | `varchar(50)` | NO |  |  | q1-2023 |
| `Tr_Period_Emp_Code` | `varchar(50)` | NO |  |  | q1-2023-emp |

### `Tr_Review_EmpPeriod_h` — ~258 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_Review_EmpPeriod_Code_h` | `varchar(100)` | NO |  | PRI | (Emp_Period).kode header utk review emp per Q. !period=2023Q1 |
| `Ms_Emp_Code` | `varchar(50)` | NO |  |  | kode dari yg di asses |
| `Ms_Emp_Div` | `varchar(50)` | YES |  |  |  |
| `Ms_Periode` | `varchar(50)` | YES |  |  | Q1,Q2,Q3,Q4 (baru) |
| `Year_Desc` | `varchar(4)` | NO |  |  | tahun - isi free dulu |
| `Date_Asses` | `datetime` | YES |  |  |  |
| `Period` | `varchar(50)` | NO |  |  | 2023Q1(tahun+MsPeriod) |
| `rec_usercreated` | `varchar(50)` | YES |  |  |  |
| `rec_userupdate` | `varchar(50)` | YES |  |  |  |
| `rec_datecreated` | `datetime` | YES |  |  |  |
| `rec_dateupdate` | `datetime` | YES |  |  |  |
| `rec_status` | `int(11)` | YES |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `Tr_Review_EmpPeriod_Basic_Reviewer` — ~296 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_Review_EmpPeriod_Basic_Reviewer_Code` | `varchar(100)` | NO |  | PRI | Tr_Emp_Period_Code+B(asic)+reviewer - 
 id_bsc_rst |
| `Tr_Review_EmpPeriod_Code_h` | `varchar(500)` | NO |  |  | Tr_Emp_Asses_Code(tadinya) - ambil dari header |
| `DateReviewBasic` | `date` | NO |  |  | Baru21.02,24 |
| `Ms_Reviewer_Code` | `varchar(500)` | YES |  |  | Ms_Emp_Assessor_Code(tadinya) - yg review |
| `Trust_value` | `int(11)` | YES |  |  |  |
| `trust_comment` | `varchar(500)` | YES |  |  |  |
| `trust_suggestion` | `varchar(500)` | YES |  |  |  |
| `TrustHigh` | `varchar(500)` | NO |  |  |  |
| `TrustLow` | `varchar(500)` | NO |  |  |  |
| `drive_value` | `int(11)` | YES |  |  |  |
| `drive_comment` | `varchar(500)` | YES |  |  |  |
| `drive_suggestion` | `varchar(500)` | YES |  |  |  |
| `DriveHigh` | `varchar(500)` | NO |  |  |  |
| `DriveLow` | `varchar(500)` | NO |  |  |  |
| `inisiative_value` | `int(11)` | YES |  |  |  |
| `inisiatif_comment` | `varchar(500)` | YES |  |  |  |
| `inisiative_suggestion` | `varchar(500)` | YES |  |  |  |
| `InisiativeHigh` | `varchar(500)` | NO |  |  |  |
| `InisitativeLow` | `varchar(500)` | NO |  |  |  |
| `Reliable_value` | `int(11)` | YES |  |  |  |
| `reliable_comment` | `varchar(500)` | YES |  |  |  |
| `Reliable_suggestion` | `varchar(500)` | YES |  |  |  |
| `ReliableHigh` | `varchar(500)` | NO |  |  |  |
| `ReliableLow` | `varchar(500)` | NO |  |  |  |
| `result` | `int(11)` | YES |  |  | Reslut - salah tulis tadinya- jadi result |
| `result_comment` | `varchar(500)` | YES |  |  |  |
| `result_suggestion` | `varchar(500)` | YES |  |  |  |
| `ResultHigh` | `varchar(500)` | NO |  |  |  |
| `ResultLow` | `varchar(500)` | NO |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `Tr_Review_EmpPeriod_Task_Reviewer` — ~253 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_Review_EmpPeriod_Task_Reviewer_Code` | `varchar(100)` | NO |  | PRI | ditambah Task(txt)+Reviewer+autoNumber |
| `Tr_Review_EmpPeriod_Code_h` | `varchar(100)` | NO |  |  | Diambil dari header |
| `TaskDesc` | `varchar(100)` | NO |  |  | Tugasnya apa |
| `DateTask` | `date` | NO |  |  | Kapan dikasih |
| `Ms_Reviewer_Code` | `varchar(100)` | NO |  |  | Siapa yg kasih |
| `ResultDesc` | `varchar(500)` | NO |  |  | bagaimana hasilnya |
| `ResultHigh` | `varchar(500)` | NO |  |  | Adakah catatan baik |
| `ResultLow` | `varchar(500)` | NO |  |  | Adakah catatan kurang |
| `SugestReviewer` | `varchar(500)` | NO |  |  | Catatan dari reviewer |
| `SuggestMgt` | `text` | NO |  |  | Kalau ada catatan dari Mgt |
| `Suggest_BOD` | `varchar(500)` | NO |  |  |  |
| `Ms_Task_Status` | `varchar(50)` | NO |  |  | NotStart-Progress-Finish-Fail |
| `Quality` | `int(11)` | NO |  |  | 1-5 kualitas kerjaan |
| `Solutif` | `int(11)` | NO |  |  | Progress/Pending/Finish/Fail |
| `Inisiatif` | `int(11)` | NO |  |  |  |
| `Tuntas` | `int(11)` | NO |  |  |  |
| `Kualitas` | `int(11)` | NO |  |  |  |
| `Kecepatan` | `int(11)` | NO |  |  |  |
| `Update` | `int(11)` | NO |  |  |  |
| `Hasil` | `int(11)` | NO |  |  |  |
| `Konsisten` | `int(11)` | NO |  |  |  |
| `Tanggap` | `int(11)` | NO |  |  |  |
| `created_at` | `timestamp` | NO |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `Tr_Review_EmpPeriod_Adv_Reviewer_h` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_Review_EmpPeriod_Adv_Reviewer_Code_d` | `varchar(50)` | NO |  |  | Blk tambah auto number |
| `Tr_Review_EmpPeriod_Code_h` | `varchar(50)` | NO |  |  | EmpPeriod+Adv |
| `Ms_Reviewr_Code` | `varchar(50)` | NO |  |  |  |

### `Tr_Review_EmpPeriod_Adv_Reviewer_d` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_Review_EmpPeriod_Adv_Reviewer_Code_d` | `varchar(100)` | NO |  | PRI | Utk penilaian yg pakai ms. belakang tambah autonum |
| `Tr_Review_EmpPeriod_Code_h` | `varchar(50)` | NO |  |  |  |
| `Ms_Review_Code` | `varchar(100)` | NO |  |  |  |
| `Review_Result` | `int(11)` | NO |  |  | 1-5 |
| `ReviewHIgh` | `varchar(50)` | NO |  |  | penilaain bagusnya |
| `ReviewLow` | `varchar(50)` | NO |  |  | Penilaian kurangnya |
| `ReviewNote` | `varchar(50)` | NO |  |  | Keterangan |
| `MgtReviewNote` | `text` | NO |  |  | Kalau ada dari komentar dari mgt |
| `Tr_Review_EmpPeriod_Adv_Reviewer_Code_h` | `varchar(50)` | NO |  |  |  |

### `Tr_Review_EmpPeriod_BA` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_Review_EmpPeriod_BA_Code` | `varchar(50)` | NO |  | PRI |  |
| `Tr_Review_EmpPeriod_Code_h` | `varchar(50)` | NO |  |  |  |
| `BA` | `int(11)` | NO |  |  | Jumlah BA utk Q ini |
| `BA_Prev` | `int(11)` | NO |  |  | BA Q sebelumnya |
| `BA_Total` | `int(11)` | NO |  |  | total BA |
| `SP` | `int(11)` | NO |  |  | Jumlah SP |

### `tr_task_result` — ~69 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `tr_code_main_assessment` | `varchar(100)` | NO |  |  |  |
| `tr_period_emp_task` | `varchar(50)` | NO |  |  |  |
| `tr_period_emp_task_assesor` | `varchar(50)` | NO |  | PRI |  |
| `ms_assesor_code` | `varchar(50)` | NO |  |  |  |
| `Jobs` | `varchar(500)` | NO |  |  |  |
| `ResultNote` | `varchar(1000)` | NO |  |  |  |
| `ScoreResult` | `int(11)` | NO |  |  |  |
| `Date` | `datetime` | NO |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `tr_q1_user_assesor_h` — ~55 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_Q1_User_Assesor_H_Code` | `varchar(100)` | NO |  |  |  |
| `Tr_Assessment_Main_Code` | `varchar(100)` | NO |  |  |  |
| `Ms_periode` | `varchar(100)` | NO |  |  |  |
| `Ms_Employee` | `varchar(100)` | NO |  |  |  |
| `Ms_Assessor` | `varchar(100)` | NO |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `ms_periode_assessment` — ~5 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Ms_Periode_Assessment_Code` | `varchar(100)` | NO |  |  |  |
| `Ms_Periode_Assessment_Desc` | `varchar(100)` | NO |  |  |  |
| `rec_status` | `int(11)` | NO |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `ms_rating_asasmen_basic` — ~5 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `id` | `int(11)` | NO |  | PRI |  |
| `rec_datecreated` | `datetime` | YES |  |  |  |
| `rec_dateupdate` | `datetime` | YES |  |  |  |
| `rec_usercreated` | `varchar(50)` | YES |  |  |  |
| `rec_userupdate` | `varchar(50)` | YES |  |  |  |
| `rec_status` | `int(11)` | YES |  |  |  |
| `ms_rating_asasmen_basic_code` | `varchar(50)` | YES |  | UNI |  |
| `desciption` | `varchar(100)` | YES |  |  |  |
| `created_at` | `timestamp` | NO | current_timestamp() |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

