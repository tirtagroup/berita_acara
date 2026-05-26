# ADR-007: FnB Scheduling — Staff Source via Mapping Table

**Status**: 🟡 Proposed (design phase, Phase 3 target)
**Date**: 2026-05-25
**Decider**: user (Charles)

## Context

Modul FnB Scheduling Resto T1 (lihat [ADR-005](005-scheduling-resto-phase3.md) + [docs/fnb-scheduling/](../fnb-scheduling/)) butuh "pool staff yang bisa di-assign ke jadwal" — sebut staff FnB.

Sumber data karyawan global Tirta ada di `mysql_new.Ms_User_Emp` (1478 row, 3 company code: HGS / TGF / TGU). Tabel ini adalah master ERP yang juga dipakai modul existing lain (BA, PICA, SP, Assessment, Rekrutmen).

**Problem yang perlu diselesaikan:**

1. **Filter "siapa staff FnB"** — `Ms_User_Emp` tidak punya flag eksplisit "FnB" atau "Resto". Kandidat field: `Ms_Company_Code` (mungkin `TGF` = FnB), `emp_division`, `emp_subdivision`, `job_desc`. Belum dikonfirmasi.

2. **Field FnB-specific** — staff FnB butuh data tambahan yang tidak ada di ERP: home outlet (tempat utama kerja), posisi utama resto, default kategori jam kerja, tanggal join FnB ops (beda dari tanggal kontrak), catatan operasional.

3. **Tidak boleh modify `Ms_User_Emp`** — tabel ini di mysql_new (ERP), dipakai sistem ERP terpisah. Mengubah schema-nya berisiko break sistem ERP + butuh koordinasi tim ERP.

4. **Cross-DB constraint tidak mungkin** — `mysql` ↔ `mysql_new` adalah 2 koneksi DB terpisah di host yang sama. MySQL FK constraint cross-database technically possible (same host) tapi BA-PICA pattern existing tidak pakai (lihat [docs/database.md](../database.md)). Konsisten: cross-DB reference via string ID + manual JOIN.

## Decision

**Buat tabel `ms_fnb_staff` di koneksi `mysql` (app DB) sebagai mapping/extension table.**

Schema:
```
ms_fnb_staff
  staff_id PK
  emp_code VARCHAR(50) UNIQUE   ← cross-DB ref ke Ms_User_Emp.Ms_Emp_Code, no FK
  home_outlet_id FK             ← ms_fnb_outlet
  posisi_utama_id FK            ← ms_fnb_posisi
  kategori_jam_default_id FK    ← ms_fnb_kategori_jam_kerja
  tanggal_join_fnb DATE
  tanggal_exit_fnb DATE          ← NULL = aktif
  catatan TEXT
  aktif TINYINT(1)
  + audit kolom standar
```

**Prinsip operasional:**

1. **`ms_fnb_staff` = sumber kebenaran untuk "siapa staff FnB"** — hanya `emp_code` yang ada di sini boleh di-assign ke `tr_fnb_jadwal_d`.
2. **Identitas dasar (nama, NIK, kontak) tetap ambil dari `Ms_User_Emp`** via cross-DB query saat display. `ms_fnb_staff` tidak duplikasi nama/NIK/dll.
3. **Bulk import awal** — saat go-live, admin run query satu kali ke ERP (filter by criteria yang nanti dikonfirmasi, lihat [open-questions Q3](../fnb-scheduling/open-questions.md#q3-cara-identify-staff-fnb-di-erp-ms_user_emp)) → INSERT ke `ms_fnb_staff`.
4. **Add/remove staff FnB** — admin UI di `/fnb/master/staff` untuk pilih dari list `Ms_User_Emp` (yang belum ada di `ms_fnb_staff`) + tambah field FnB-specific. Soft-delete via `tanggal_exit_fnb` + `aktif=0`.
5. **Sync drift** — kalau ERP staff resign / pindah company code, `ms_fnb_staff` tidak auto-update. Manager outlet bisa report "staff X sudah keluar" → admin set `aktif=0`. Future: cron job nightly cek validity `emp_code` di ERP, flag yang missing.

## Alternatives Considered

### Opsi A: Tambah kolom flag `is_fnb_staff` di `Ms_User_Emp` (ERP)
- ❌ Rejected: Modify table di ERP yang dipakai sistem lain. Butuh approval tim ERP. Tidak punya tempat untuk field FnB-specific (home_outlet, posisi_utama, dll.) tanpa banyak kolom baru.

### Opsi B: Pakai filter dinamis (no mapping table)
- mis. "staff FnB" = `Ms_User_Emp WHERE Ms_Company_Code='TGF' AND aktif=1`
- ❌ Rejected:
  - Tidak fleksibel — bagaimana kalau staff dengan company TGU pindah kerja di outlet FnB?
  - Tidak ada tempat untuk field FnB-specific
  - Implicit dependency pada nilai field ERP yang bisa berubah

### Opsi C: Master table baru lengkap (duplikasi semua field)
- `ms_fnb_staff` punya nama, NIK, kontak, alamat — semua duplikasi dari `Ms_User_Emp`
- ❌ Rejected:
  - Data duplikasi → drift risk
  - Update di ERP harus propagate ke `ms_fnb_staff`
  - Berlawanan dengan single-source-of-truth principle

### Opsi D: Junction table tanpa field tambahan
- `ms_fnb_staff` hanya `(emp_code, aktif)` — field FnB-specific (home_outlet, posisi) di tabel terpisah
- ❌ Rejected: Over-normalized untuk T1, query lebih kompleks tanpa benefit signifikan.

## Consequences

### Plus ✅
- ERP `Ms_User_Emp` tidak terganggu — koordinasi minimal dengan tim ERP
- Field FnB-specific punya tempat eksplisit dengan FK ke master FnB
- Cross-DB pattern konsisten dengan existing (BA, PICA, SP — semua ref `emp_code` string ke ERP tanpa FK)
- Bulk import & maintenance jelas (1 tabel, 1 admin UI)
- Soft-delete via `aktif=0` + `tanggal_exit_fnb` — auditable

### Minus ❌
- Tidak ada referential integrity DB-level antar `emp_code` di `ms_fnb_staff` dengan `Ms_User_Emp.Ms_Emp_Code`. Bisa drift (staff dihapus di ERP, masih ada di mapping).
- Display nama staff butuh JOIN cross-DB di setiap query (overhead, mitigated dengan caching atau prefetch).
- Bulk import butuh script khusus (sekali jalan, OK).

### Risks ⚠️

| Risk | Mitigasi |
|---|---|
| Staff resign di ERP, tidak ke-cleanup di `ms_fnb_staff` → muncul di scheduling sebagai pilihan invalid | Cron job nightly cek validity `emp_code` di ERP, flag missing → admin review |
| Bulk import awal salah filter (mis. miss staff Resto Bandung) | Validation step manual oleh ops lead sebelum mass-publish; UI list "staff FnB" punya kolom asal company + division untuk visual cek |
| Performance cross-DB JOIN besar saat tampil 50+ staff di calendar | Cache `Ms_User_Emp` row yang relevan (per request); kalau perlu, denormalize `emp_name` snapshot di `ms_fnb_staff` (tapi default tidak — single source of truth) |
| Konflik nama field — `Ms_User_Emp.emp_division` (jabatan struktural) vs `ms_fnb_posisi` (posisi operasional resto) | Naming explicit: `posisi_utama_id` = posisi resto operasional, bukan rank ERP |

## Implementation

**Status**: Design phase. Implementation Phase 3 (November 2026 – Februari 2027).

### Bulk import strategy (saat go-live)

1. Tentukan kriteria filter ERP final (lihat [Q3](../fnb-scheduling/open-questions.md#q3-cara-identify-staff-fnb-di-erp-ms_user_emp)) — kandidat: `Ms_Company_Code='TGF'` atau `emp_division IN (...)`.
2. Run dry-run query: count expected rows, show sample list.
3. Validate manual oleh FnB ops lead.
4. Run actual INSERT ke `ms_fnb_staff` dengan `home_outlet_id=NULL` (admin assign belakangan), `posisi_utama_id=NULL` (admin assign), `tanggal_join_fnb=COALESCE(start_date_contract, today)`.

```sql
-- Sample bulk import (adjust filter setelah Q3 dijawab)
INSERT INTO mysql.ms_fnb_staff (emp_code, tanggal_join_fnb, aktif, created_at, created_by)
SELECT
  Ms_Emp_Code,
  COALESCE(start_date_contract, CURRENT_DATE),
  1,
  NOW(),
  'system-import'
FROM mysql_new.Ms_User_Emp
WHERE Ms_Company_Code = 'TGF'      -- TBD: confirm filter
  AND Status_Active = 1
  AND Ms_Emp_Code NOT IN (SELECT emp_code FROM mysql.ms_fnb_staff);
```

### Cross-DB JOIN pattern (untuk display)

```php
// app/Http/Controllers/Fnb/JadwalController.php
public function edit(int $id)
{
    $jadwal = JadwalHeader::with(['outlet', 'details.shift', 'details.posisi'])->findOrFail($id);

    // Get list staff yang home_outlet = outlet jadwal ini
    $staffMapping = DB::connection('mysql')
        ->table('ms_fnb_staff')
        ->where('home_outlet_id', $jadwal->outlet_id)
        ->where('aktif', 1)
        ->get();

    $empCodes = $staffMapping->pluck('emp_code')->toArray();

    // Cross-DB fetch ke ERP untuk nama
    $empData = DB::connection('mysql_new')
        ->table('Ms_User_Emp')
        ->whereIn('Ms_Emp_Code', $empCodes)
        ->select('Ms_Emp_Code', 'Emp_Name', 'NIK', 'emp_division', 'job_desc')
        ->get()
        ->keyBy('Ms_Emp_Code');

    // Merge in PHP
    $staffList = $staffMapping->map(function ($row) use ($empData) {
        $erp = $empData[$row->emp_code] ?? null;
        return (object) [
            'staff_id'    => $row->staff_id,
            'emp_code'    => $row->emp_code,
            'nama'        => $erp->Emp_Name ?? '(tidak ditemukan di ERP)',
            'nik'         => $erp->NIK ?? null,
            'posisi_utama_id' => $row->posisi_utama_id,
            'is_missing_in_erp' => $erp === null,
        ];
    });

    return view('fnb.scheduling.jadwal.edit', compact('jadwal', 'staffList'));
}
```

### Cleanup / drift detection

Future cron job (Phase 3 or 4):

```php
// app/Console/Commands/FnbStaffCleanupCommand.php
public function handle()
{
    $stale = DB::connection('mysql')
        ->table('ms_fnb_staff as s')
        ->whereNotExists(function ($q) {
            $q->select(DB::raw(1))
              ->from('mysql_new.Ms_User_Emp as e')
              ->whereColumn('e.Ms_Emp_Code', 's.emp_code')
              ->where('e.Status_Active', 1);
        })
        ->where('s.aktif', 1)
        ->get();

    foreach ($stale as $row) {
        Log::warning("FnB staff stale: emp_code={$row->emp_code} not active in ERP. Flagging.");
        // Optional: auto-set aktif=0, atau cuma flag untuk admin review
    }
}
```

## Related

- ADR: [005-scheduling-resto-phase3.md](005-scheduling-resto-phase3.md) — keputusan parent (tier T1+T3)
- Schema: [docs/fnb-scheduling/schema.md §Tabel 5](../fnb-scheduling/schema.md#tabel-5--ms_fnb_staff-mapping-staff-fnb)
- Open question: [docs/fnb-scheduling/open-questions.md Q3](../fnb-scheduling/open-questions.md#q3-cara-identify-staff-fnb-di-erp-ms_user_emp)
- Convention: [docs/conventions.md §10](../conventions.md#10-domain-prefix-naming-fnb-dst) — `ms_fnb_*` naming
- DB pattern: [docs/database.md](../database.md) — cross-DB connection pattern, no FK cross-DB
