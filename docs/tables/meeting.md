# Meeting & Action Items

Tabel untuk pencatatan rapat, action item, dan PIC.

Sumber: database `tirt3038_HR_Worksheet` (kecuali disebut lain).

---

### `Ms_Meeting` — ~5 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Ms_Meeting_Code` | `varchar(100)` | NO |  | UNI |  |
| `Meeting_Desc` | `varchar(100)` | NO |  |  |  |
| `User_Create` | `varchar(100)` | NO |  |  |  |
| `User_Update` | `varchar(100)` | NO |  |  |  |
| `created_at` | `timestamp` | NO |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |
| `id` | `int(11)` | NO |  | PRI |  |

### `Tr_Meeting_h` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_Meeting_Code` | `varchar(100)` | NO |  |  |  |
| `Ms_Company` | `varchar(100)` | NO |  |  |  |
| `Ms_Area` | `varchar(100)` | NO |  |  |  |
| `DateMeeting` | `datetime` | NO |  |  |  |
| `TimeStartMeeting` | `time` | YES |  |  |  |
| `TimeEndMeeting` | `time` | YES |  |  |  |
| `Meeting_Priority` | `varchar(50)` | NO |  |  |  |
| `Tr_Meeting_Highligh` | `varchar(500)` | YES |  |  | ini akan ikut terus sampai topik closing |
| `Meeting_Duration` | `varchar(20)` | YES |  |  |  |
| `MeetingDesc` | `varchar(500)` | NO |  |  |  |
| `Meeting_Status` | `varchar(255)` | YES |  |  |  |
| `Ms_Meeting` | `varchar(255)` | YES |  |  |  |
| `Ms_User_Create` | `varchar(100)` | NO |  |  |  |
| `Ms_User_Update` | `varchar(100)` | YES |  |  |  |
| `Ms_Divisi` | `varchar(100)` | YES |  |  |  |
| `created_at` | `timestamp` | NO |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `Tr_Meeting_Action` — ~30 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_Meeting_Action_Code` | `varchar(100)` | NO |  | PRI |  |
| `Tr_Meeting_Update_Code` | `varchar(100)` | NO |  |  |  |
| `ActionDesc` | `varchar(500)` | NO |  |  |  |
| `Date_Action` | `datetime` | NO |  |  |  |
| `created_at` | `timestamp` | NO |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `Tr_Meeting_Comment` — ~0 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_Meeting_Comment_Code` | `varchar(100)` | NO |  |  |  |
| `Tr_Meeting_Emp_h_Code` | `varchar(100)` | NO |  |  |  |
| `Ms_User` | `varchar(100)` | NO |  |  |  |
| `Comment` | `varchar(500)` | NO |  |  |  |
| `web_db` | `int(11)` | NO |  |  |  |
| `sent_to` | `varchar(100)` | NO |  |  |  |
| `is_read` | `varchar(50)` | NO |  |  |  |
| `created_at` | `timestamp` | NO |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |
| `id` | `int(11)` | NO |  |  |  |

### `Tr_Meeting_PIC` — ~9 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_Meeting_PIC_Code` | `varchar(100)` | NO |  | PRI |  |
| `Tr_Meeting_h_Code` | `varchar(100)` | NO |  |  |  |
| `MS_PIC` | `varchar(100)` | NO |  |  |  |
| `created_at` | `timestamp` | NO |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

### `Tr_Meeting_Update` — ~30 rows

| Kolom | Tipe | Null | Default | Key | Keterangan |
|---|---|---|---|---|---|
| `Tr_Meeting_Update_Code` | `varchar(100)` | NO |  | PRI |  |
| `Tr_Meeting_h_Code` | `varchar(100)` | NO |  |  |  |
| `TopicDesc` | `varchar(500)` | NO |  |  |  |
| `Ms_Meeting` | `varchar(225)` | NO |  |  |  |
| `ByUser` | `varchar(100)` | NO |  |  |  |
| `Meeting_Priority` | `varchar(100)` | YES |  |  | low high priority |
| `Status_Meeting` | `varchar(100)` | NO |  |  | sudah closing apa belum |
| `created_at` | `timestamp` | NO |  |  |  |
| `updated_at` | `timestamp` | YES |  |  |  |

