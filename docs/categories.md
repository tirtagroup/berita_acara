# Kategori BA — Sistem Tag Multi-Konteks

> **Status**: ✅ Live di production. Verifikasi schema dengan `php artisan docs:check-schema`.
> **Last verified**: 2026-05-25.
> **Source of truth**: tabel DB (lihat query verifikasi di bawah). Dokumen ini bisa **drift** — kalau ada konflik, **trust DB**.

⚠️ **Catatan penting**: skema actual **berbeda** dari migration awal `2026_05_19_200000_create_ba_kategori_system.php`. Lihat [ADR-006](decisions/006-konteks-renamed-from-bu.md) untuk history rename Business Unit → Konteks dan migrasi opsi ke pattern N:N.

🆕 **2026-05-25**: Kolom `level` (W/D/O) di `ms_konteks_kategori_mapping` **akan di-drop** — mapping jadi boolean murni (row ada = available, row tidak ada = hidden). Behavior "Wajib auto-check" + "Disarankan highlight" akan hilang. Lihat [ADR-008](decisions/008-drop-konteks-kategori-level.md). Migration file `2026_05_25_120000_drop_level_from_ms_konteks_kategori_mapping.php` siap di-run setelah code change selesai.

---

## Arsitektur (Skema Actual)

```
ms_konteks  (5 row: LAKA, FNB, OP_HR, REVISI, FMCG)
    │
    │ N:N via ms_konteks_kategori_mapping (boolean — row present = available di konteks itu)
    │  [pending migration 2026_05_25_120000 untuk drop kolom `level` lama]
    ▼
ms_ba_kategori  (14 row)
    │
    │ N:N via ms_kategori_opsi_mapping (kode + sort_order per kategori)
    ▼
ms_ba_kategori_opsi  (42+ row, deskripsi UNIQUE — opsi GLOBAL, sharable antar kategori)

ms_konteks  ─── N:N via ms_opsi_konteks_mapping ─── ms_ba_kategori_opsi
                (opsi tertentu hanya muncul untuk konteks tertentu)
```

**Prinsip:**
- Semua kategori **universal** — bisa attach ke BA mana pun, satu BA bisa multi-kategori.
- **Konteks = filter visibility**, bukan partisi data. Saat user pilih konteks di form, UI cuma tampilkan kategori yang ada di mapping. Semua kategori yang muncul = **opsional** (per [ADR-008](decisions/008-drop-konteks-kategori-level.md), tidak ada lagi level Wajib/Disarankan).
- **Opsi global**: opsi yang sama (mis. "None", "Salah kirim", "Salah order") bisa dipakai oleh multiple kategori sekaligus.
- **Opsi-konteks filter**: opsi tertentu bisa di-tag untuk konteks tertentu saja. Mis. "Customer tidak order" hanya muncul di konteks FMCG.

---

## 6 Tabel Master

| Tabel | Isi | Penting |
|---|---|---|
| **`ms_konteks`** | 5 konteks/BU | Renamed dari `ms_business_unit` |
| **`ms_ba_kategori`** | 14 kategori universal | Stable |
| **`ms_ba_kategori_opsi`** | 42+ opsi global | `deskripsi` UNIQUE — opsi sharable |
| `ms_konteks_kategori_mapping` | Junction konteks × kategori (**boolean** — kolom `level` di-drop per [ADR-008](decisions/008-drop-konteks-kategori-level.md)) | Visibility kategori per konteks |
| `ms_kategori_opsi_mapping` | Junction kategori × opsi + kode + sort_order | Mana opsi muncul di kategori mana |
| `ms_opsi_konteks_mapping` | Junction opsi × konteks | Opsi yang context-specific |

---

## Konteks (5 row)

| ID | Kode | Nama | Deskripsi | Created |
|---|---|---|---|---|
| 1 | `LAKA` | LAKA Truck | Kecelakaan kendaraan operasional — driver & truck | 2026-05-19 |
| 2 | `FNB` | FnB | Food & Beverage — gerai/restoran | 2026-05-19 |
| 3 | `OP_HR` | Operation / HR | HR pusat & operasi kantor | 2026-05-19 |
| 4 | `REVISI` | Permintaan Revisi | BA untuk permintaan revisi data/dokumen (standalone) | 2026-05-20 |
| 5 | `FMCG` | FMCG | Fast-Moving Consumer Goods (divisi konsumen) | 2026-05-21 |

---

## Kategori (14 row)

| # | Kode | Nama | Opsi terisi |
|---|---|---|---|
| 1 | `LAKA_PENYEBAB` | Laka Penyebab | ✅ 7 |
| 2 | `PELANGGARAN_SOP` | Pelanggaran SOP | ✅ 5 |
| 3 | `FRAUD` | Fraud | ⏳ 0 |
| 4 | `TEMUAN_KASUS` | Temuan Kasus | ✅ 2 (FMCG only) |
| 5 | `INDISIPLINER_ETIKA` | Indisipliner / Etika | ⏳ 0 |
| 6 | `MENOLAK_TUGAS` | Menolak Tugas | ⏳ 0 |
| 7 | `KERUSAKAN_KEHILANGAN` | Kerusakan / Kehilangan | ✅ 3 |
| 8 | `KRIMINAL` | Kriminal | ⏳ 0 |
| 9 | `KOMPLAIN_CUSTOMER` | Komplain Customer | ⏳ 0 |
| 10 | `KESALAHAN_ADMIN` | Kesalahan Admin | ✅ 5 |
| 11 | `LOGISTIK` | Logistik (FnB) | ✅ 7 |
| 12 | `KUALITAS_MAKANAN` | Kualitas Makanan | ✅ 5 |
| 13 | `PELAYANAN` | Pelayanan | ✅ 10 |
| 14 | `DISIPLIN_OPERASIONAL` | Disiplin Operasional | ✅ 6 |

> Kategori `DISIPLIN_OPERASIONAL` (#14) dan `INDISIPLINER_ETIKA` (#5) **terpisah** — #14 untuk pelanggaran ringan terukur (terlambat, absen); #5 untuk pelanggaran etika lebih luas.

---

## Konteks × Kategori Mapping (dari `ms_konteks_kategori_mapping`)

> Per [ADR-008](decisions/008-drop-konteks-kategori-level.md), kolom `level` di-drop. Mapping jadi boolean:
> - **✓** = ada di mapping (kategori muncul di konteks itu)
> - **—** = tidak ada di mapping (hidden)
>
> State pre-ADR-008 (W/D/O) ditampilkan di kolom "Pre-008" untuk reference history. Semua W & D & O akan jadi **✓** setelah migration `2026_05_25_120000` di-run.

| Kategori | LAKA | FNB | OP_HR | REVISI | FMCG | Pre-008 |
|---|:---:|:---:|:---:|:---:|:---:|:---|
| Laka Penyebab | ✓ | — | ✓ | ? | ? | LAKA=W, OP_HR=O |
| Pelanggaran SOP | ✓ | ✓ | ✓ | ? | ? | semua=D |
| Fraud | ✓ | ✓ | ✓ | ? | ? | LAKA=O, FNB=O, OP_HR=D |
| Temuan Kasus | ✓ | ✓ | ✓ | ? | ? | LAKA=O, FNB=O, OP_HR=D |
| Indisipliner / Etika | ✓ | ✓ | ✓ | ? | ? | LAKA=O, FNB=O, OP_HR=D |
| Menolak Tugas | ✓ | ✓ | ✓ | ? | ? | LAKA=O, FNB=O, OP_HR=D |
| Kerusakan / Kehilangan | ✓ | ✓ | ✓ | ? | ? | semua=D |
| Kriminal | ✓ | ✓ | ✓ | ? | ? | semua=O |
| Komplain Customer | ✓ | ✓ | ✓ | ? | ? | LAKA=O, FNB=D, OP_HR=O |
| Kesalahan Admin | ✓ | ✓ | ✓ | ? | ? | LAKA=O, FNB=O, OP_HR=D |
| Logistik | — | ✓ | ✓ | ? | ? | FNB=W, OP_HR=O |
| Kualitas Makanan | — | ✓ | — | ? | ? | FNB=W |
| Pelayanan | — | ✓ | — | ? | ? | FNB=W |
| Disiplin Operasional | ✓ | ✓ | ✓ | ? | ? | LAKA=D, FNB=W, OP_HR=O |

`?` = belum di-mapping (konteks REVISI & FMCG baru ditambahkan, perlu admin isi).

⚠️ Mapping untuk REVISI dan FMCG belum lengkap di `ms_konteks_kategori_mapping`. Konfirmasi dengan user sebelum tambah/edit.

⚠️ **Behavior change setelah ADR-008**: kategori yang sebelumnya "Wajib auto-check" (Laka Penyebab di LAKA; Logistik/Kualitas Makanan/Pelayanan/Disiplin Operasional di FNB) **tidak lagi auto-check** di form BA. Manager harus pilih manual. Kalau perlu enforce, tambah validasi bisnis di app layer (terpisah dari mapping).

---

## Catatan Opsi Per Kategori

Tabel opsi yang sudah terisi, query dari DB actual:

### Kategori 1 — Laka Penyebab (7 opsi)
None · Mengakibatkan laka · Diakibatkan pihak lain · Tabrak lari · Single vehicle / self-accident · Kontribusi bersama · Force majeure

### Kategori 2 — Pelanggaran SOP (5 opsi)
None · SOP dilanggar · SOP tidak dikerjakan · Tidak mengerti SOP · SOP terpaksa dilanggar

### Kategori 4 — Temuan Kasus (2 opsi, **FMCG only**)
- "Customer tidak order" (`OP41`) → konteks_id 5 (FMCG)
- "toko tutup" (`OP42`) → konteks_id 5 (FMCG)

⚠️ Opsi ini **tidak akan muncul** di konteks LAKA/FNB/OP_HR/REVISI karena di-filter via `ms_opsi_konteks_mapping`.

### Kategori 7 — Kerusakan / Kehilangan (3 opsi)
None · Alat rusak · Alat hilang

### Kategori 10 — Kesalahan Admin (5 opsi, **belum di-mapping ke konteks manapun**)
- Salah isi karena salah baca dokumen
- Salah isi karena tidak lihat dokumen
- Lupa isi
- Salah tulis tetapi masih mirip
- Salah isi dan jauh dari yang seharusnya

⚠️ 5 opsi ini **tidak punya entry di `ms_opsi_konteks_mapping`** — mungkin tidak tampil di mana pun (tergantung logika query frontend). Verifikasi sebelum claim "data hilang".

### Kategori 11 — Logistik (7 opsi)
None · Barang tidak datang · Barang datang rusak · Terima barang kurang · Lupa order · Kurang order · Salah order

### Kategori 12 — Kualitas Makanan (5 opsi)
None · Makanan basi · Ada serangga · Tidak enak · Salah kirim

### Kategori 13 — Pelayanan (10 opsi)
None · Makanan terlambat · Salah order · Salah buat · Salah kirim · Tumpah · Tidak ramah · Lama tidak datang ke meja · Utensil tidak bersih · Meja tidak bersih

### Kategori 14 — Disiplin Operasional (6 opsi)
None · Terlambat > 15 menit · Tidak ada di station · Tidak masuk tanpa kabar · > 3 kali absen 1 bulan · Terlambat > 5 kali 1 bulan

> 🔗 **Future integration**: Modul [FnB Scheduling Resto](fnb-scheduling/README.md) T3 (Phase 3) akan **auto-trigger BA** kategori ini dari clock-in/out data. Mapping opsi: `late_minutes > 15` → "Terlambat > 15 menit", `is_no_show=1` → "Tidak masuk tanpa kabar". Schema integrasi sudah disiapkan di T1 (lihat [ADR-005](decisions/005-scheduling-resto-phase3.md) + [fnb-scheduling/workflow.md §7a](fnb-scheduling/workflow.md#7a-t3-future-clock-in--ba-trigger)). T1 design hanya untuk roster — clock-in & auto-trigger di T3.

### Kategori 3, 5, 6, 8, 9 — Belum ada opsi
- **3 Fraud** ⏳
- **5 Indisipliner / Etika** ⏳
- **6 Menolak Tugas** ⏳
- **8 Kriminal** ⏳
- **9 Komplain Customer** ⏳

---

## Query Verifikasi Schema

Jalankan di tinker untuk verifikasi state actual:

```php
// List konteks
DB::table('ms_konteks')->orderBy('id')->get();

// List kategori
DB::table('ms_ba_kategori')->orderBy('id')->get();

// List opsi per kategori (via junction)
DB::table('ms_kategori_opsi_mapping as m')
  ->join('ms_ba_kategori as k', 'k.id', 'm.kategori_id')
  ->join('ms_ba_kategori_opsi as o', 'o.id', 'm.opsi_id')
  ->select('k.nama as kategori', 'm.kode', 'o.deskripsi', 'm.sort_order')
  ->orderBy('k.id')->orderBy('m.sort_order')
  ->get();

// Opsi yang context-filtered
DB::table('ms_opsi_konteks_mapping as okm')
  ->join('ms_ba_kategori_opsi as o', 'o.id', 'okm.opsi_id')
  ->join('ms_konteks as k', 'k.id', 'okm.konteks_id')
  ->select('o.deskripsi as opsi', 'k.kode as konteks')
  ->orderBy('k.id')->orderBy('o.id')
  ->get();
```

Atau jalankan `php artisan docs:check-schema` untuk validate dokumen ini vs DB.

---

## Aturan Validasi per Kategori

| Kategori | Aturan |
|---|---|
| `LAKA_PENYEBAB` | BA yang attach kategori ini wajib punya minimal 1 entry di `tr_ba_kronologi`. |

---

## Open Questions

1. **Konteks REVISI & FMCG** — perlu lengkapi `ms_konteks_kategori_mapping` (banyak kombinasi kategori × konteks belum di-mapping).
2. **Kesalahan Admin (kategori 10) opsi** — belum di-mapping ke konteks manapun di `ms_opsi_konteks_mapping`. Periksa logika query frontend apakah tampil tanpa entry mapping atau tidak.
3. **5 kategori kosong** (Fraud, Indisipliner, Menolak Tugas, Kriminal, Komplain Customer) — domain open-ended. Tunggu daftar konkret dari user/PIC per konteks.
4. **`Cek*` flags di `Tr_Ba_Main_New`** — akan deprecated setelah migrasi BA multi-kategori ([ADR-001](decisions/001-ba-multi-kategori-pivot.md)). Saat ini masih dipakai sebagai cache.
5. **Migration `2026_05_19_200000_create_ba_kategori_system.php`** — sudah outdated. Apakah perlu di-archive atau rewrite jadi mencerminkan state actual?
