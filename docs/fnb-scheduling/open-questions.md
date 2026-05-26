# FnB Scheduling — Open Questions

**Status**: Pending klarifikasi user — harus dijawab sebelum Phase 3 implementation dimulai.
**Last updated**: 2026-05-25

---

## High priority (block schema/migration)

### Q1. Daftar posisi resto Tirta

**Konteks**: Tabel `ms_fnb_posisi` perlu seed list awal. Placeholder list di [schema.md §Tabel 2](schema.md#tabel-2--ms_fnb_posisi-master-posisi-resto):

- COOK, SERVER, CASHIER, STEWARD, CAPTAIN, BARTENDER, DISHWASHER

**Yang perlu dijawab**:
- Apakah list di atas sudah cover semua posisi di outlet Tirta?
- Ada posisi spesifik (mis. "Grill Cook", "Sous Chef", "Floor Captain") yang perlu dipisah?
- Adakah hierarki posisi (mis. Junior Cook vs Senior Cook) yang perlu di-track?
- Apakah posisi sama di semua outlet, atau per-outlet bisa beda?

**Dampak**: Seed migration, validasi coverage shift (mis. "shift pagi minimal 1 cook"), reporting agregat.

---

### Q2. Daftar outlet FnB existing Tirta

**Konteks**: Tabel `ms_fnb_outlet` perlu seed atau bulk import dari sistem existing. Belum ada source of truth.

**Yang perlu dijawab**:
- Berapa outlet FnB Tirta sekarang?
- Apakah ada master existing di sistem lain (Excel, sistem POS, dll.) yang bisa di-import?
- Field per outlet: kode internal, alamat lengkap, kota, manager outlet (emp_code), kontak — sudah cukup atau perlu kolom lain (mis. kapasitas seat, jam buka, dll.)?

**Dampak**: Schema kolom `ms_fnb_outlet`, seed strategy, integrasi data import.

---

### Q3. Cara identify staff FnB di ERP `Ms_User_Emp`

**Konteks**: 1478 row di `Ms_User_Emp`. Hanya sebagian adalah staff FnB. Mapping `ms_fnb_staff` dibuat manual oleh admin tapi awal-awal butuh bulk import.

**Yang perlu dijawab**:
- Apakah `Ms_User_Emp.Ms_Company_Code` punya nilai khusus FnB (mis. `TGF` = Tirta Group F&B)?
- Atau pakai `emp_division` / `emp_subdivision` filter?
- Atau `job_desc` keyword matching?
- Apakah ada flag/kolom existing yang menyatakan "staff resto"?

**Dampak**: Strategy import awal staff FnB ke `ms_fnb_staff`. Lihat [ADR-007](../decisions/007-fnb-scheduling-staff-source.md).

---

## Medium priority (block UI behavior, bisa di-design dulu, validate saat coding)

### Q4. Sistem notifikasi existing

**Konteks**: Workflow butuh notifikasi (submit → approver, approve → staff, reject → manager, H-1 reminder). Belum di-verify apakah BA-PICA punya:

- In-app notification table & UI (bell icon dengan unread count)?
- Email queue (Laravel `Mail` + queue worker)?
- Push notification (PWA, mobile)?

**Yang perlu dijawab**:
- Apa infrastruktur notifikasi yang sudah ada?
- Kalau belum ada, T1 scope mau bangun atau email-only saja dulu?
- Apakah Tirta sudah ada SMTP server config? (cek `.env`)

**Dampak**: Effort estimation, [workflow.md §5](workflow.md#5-notification-points) implementation strategy.

---

### Q5. Amendment workflow — snapshot strategy

**Konteks**: Saat manager request amendment ke jadwal PUBLISHED, staff masih harus lihat versi sebelumnya sampai amendment di-approve. Implementasi punya 3 opsi:

| Opsi | Mechanism | Trade-off |
|---|---|---|
| **A: Flag + working copy** | `tr_fnb_jadwal_h.amendment_pending=1`, edits di-store di tabel terpisah `tr_fnb_jadwal_d_amendment`. Saat approve, swap ke main table. | Schema lebih kompleks (mirror table) |
| **B: Soft-versioning di main table** | Tambah `version` kolom di `tr_fnb_jadwal_d`. Saat amendment, INSERT row baru dengan `version=version+1` + `is_active=0`. Staff query `WHERE is_active=1`. Swap saat approve. | Volume row bertambah |
| **C: Snapshot history** | Saat amendment di-submit, full snapshot `tr_fnb_jadwal_h` + detail ke `tr_fnb_jadwal_h_history`. Setelah approve, update main langsung. Staff selalu query main. | Approve sementara expose perubahan ke staff (race condition micro-window) |

**Yang perlu dijawab**: Opsi mana yang dipilih? **Default proposal**: Opsi A (flag + working copy) — paling explicit, mudah audit, micro-race-condition tidak ada.

**Dampak**: Schema tambahan tabel, kompleksitas controller, migration.

---

### Q6. Approver scope — area-based vs global

**Konteks**: Permission `fnb.scheduling.jadwal.approve` saat ini global — siapa pun dengan permission ini bisa approve outlet manapun. Realistis di lapangan: Area Manager untuk area Jakarta seharusnya tidak approve outlet Bandung.

**Yang perlu dijawab**:
- Apakah perlu konsep "area" / "wilayah" untuk scope approval?
- Kalau ya, schema-nya gimana — kolom `area_code` di `ms_fnb_outlet` + di user/staff master?
- Atau biarkan dulu global (T1 simplification), refine T2?

**Dampak**: Schema area, controller scope filter, approver suggestion saat submit.

**Default proposal**: T1 global (notify semua approver), tambah area scope di T2 (saat sudah ada feedback adoption).

---

### Q7. Working hour limit defaults

**Konteks**: Kolom `ms_fnb_kategori_jam_kerja.max_per_minggu_jam` untuk validasi "warn kalau staff X total jam melebihi limit". Default nilai berapa?

**UU Ketenagakerjaan Indonesia**:
- 7 jam/hari × 6 hari = 42 jam/minggu, atau
- 8 jam/hari × 5 hari = 40 jam/minggu

**Yang perlu dijawab**:
- Tirta resto pakai 5-hari-kerja atau 6-hari-kerja?
- Default warning threshold per kategori (mis. FULL_TIME = 40, LEMBUR allow hingga 56)?
- Apakah staff resto ada yang split antar outlet dalam minggu yang sama? Limit dihitung total cross-outlet?

**Dampak**: Seed value untuk `max_per_minggu_jam`, logic validasi rule #7 di [workflow.md](workflow.md#4-validation-rules).

---

## Low priority (nice-to-clarify, tidak block design)

### Q8. Format kode outlet

`outlet_code` di `ms_fnb_outlet` (UNIQUE varchar(20)). Format?

- `JKT-001`, `BDG-002` (kota-3char + nomor sekuensial)
- `TGF-JKT-001` (company-code + kota + nomor)
- Free format admin?

**Default**: free format, admin yang tentukan saat input.

---

### Q9. Shift template per outlet vs global

Schema `ms_fnb_shift_template.outlet_id` nullable — NULL = global, filled = per-outlet.

**Yang perlu dijawab**:
- Realistic-nya outlet Tirta punya shift custom (mis. outlet 24-jam) atau semua sama Pagi/Siang/Malam?
- Kalau global, apakah outlet tertentu boleh override (mis. outlet Jakarta Pusat punya Pagi-A 06:00–14:00)?

**Default**: Allow global + per-outlet override (schema sudah support).

---

### Q10. Default approver di `ms_fnb_outlet`

Schema punya `manager_emp_code` (manager outlet) di `ms_fnb_outlet`. Belum ada kolom `approver_emp_code` (siapa default approver).

**Yang perlu dijawab**:
- Apakah perlu kolom `approver_emp_code` di outlet untuk default suggestion approver?
- Atau cukup notify semua approver (current design)?

**Default**: T1 tidak ada — notify semua approver. Tambah saat ada konsep Area Manager (Q6).

---

### Q11. Export PDF/Excel format

Workflow mention export jadwal per outlet/minggu. Belum di-design format-nya.

**Yang perlu dijawab**:
- Layout PDF — calendar grid (landscape) atau list view (portrait)?
- Excel — flat tabel atau pivot per staff?
- Branding outlet (logo, header)?

**Default**: Calendar grid A4 landscape untuk PDF, flat tabel untuk Excel. Branding minimal.

---

### Q12. Holiday/cuti bersama integration

Hari libur nasional (Idul Fitri, dll.) — apakah perlu master `ms_holiday` yang influence scheduling (mis. auto-mark OFF, atau warn untuk shift di hari libur)?

**Yang perlu dijawab**:
- Apakah Tirta resto buka di hari libur nasional? (kemungkinan iya untuk resto)
- Kalau iya, butuh tagging "shift hari libur" untuk pay-rate berbeda?

**Default**: T1 tidak handle. Tambah master `ms_holiday` + tagging di T2/T3 saat payroll integration mulai.

---

### Q13. Bulk operations untuk manager

Manager bisa: copy last week jadwal, copy template jadwal, bulk-assign (semua staff cook ke shift pagi minggu ini), bulk-edit?

**Yang perlu dijawab**: Fitur bulk mana yang prioritas di T1?

**Default**:
- ✅ "Clone from last week" (1 button)
- ❌ Template library (T2)
- ❌ Bulk-assign by role (T2)

---

### Q14. Mobile-friendly view

Staff view (`/fnb/my-schedule`) — apakah perlu responsive design penuh di T1, atau cukup desktop dulu (PWA di Phase 4)?

**Default**: Responsive (mobile-friendly) untuk staff view T1, supaya bisa cek di HP. Manager UI desktop-first.

---

### Q15. Tirta mau formalize kategori jam kerja staff?

`ms_fnb_kategori_jam_kerja.kelompok` saat ini di-seed NULL karena Tirta belum punya kategori formal (`Belum tahu / mixed informal`).

**Yang perlu dijawab**: Setelah modul running ~3 bulan, apakah Tirta mau formalize kategori PART_TIME / FULL_TIME / LEMBUR untuk:
- Compliance UU Ketenagakerjaan
- Persiapan payroll integration

**Default**: Re-evaluate at end of Phase 3 (Februari 2027).

---

## Process untuk close question ini

1. Schedule short alignment meeting (~30 menit) dengan FnB ops lead + manager outlet pilot sebelum Phase 3 implementation dimulai.
2. Jawaban masuk → update file ini (strikethrough question + tulis jawabannya) + propagate ke [schema.md](schema.md), [workflow.md](workflow.md), [permissions.md](permissions.md).
3. Kalau ada decision arsitektural (mis. amendment strategy Q5), tambah ADR baru.
