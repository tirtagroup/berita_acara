# Kategori BA — Inventory

Dokumen kerja untuk inventarisasi **Business Unit**, **Kategori**, dan **Opsi** Berita Acara.

**Status**: ✅ Migration file dibuat: [`database/migrations/2026_05_19_200000_create_ba_kategori_system.php`](../database/migrations/2026_05_19_200000_create_ba_kategori_system.php). Belum di-run.

---

## Arsitektur Data

```
ms_business_unit          ← daftar BU (LAKA, FnB, OP_HR, ...)
        │
        │ N:N
        │
ms_bu_kategori_mapping    ← BU × Kategori dengan level (wajib/disarankan/opsional)
        │
        │ N:N
        │
ms_ba_kategori            ← daftar SEMUA kategori (universal)
        │
        │ 1:N
        │
ms_ba_<kategori>          ← tabel opsi per kategori (univeral, tidak per-BU)
```

**Prinsip**:
- Semua kategori **universal** — bisa attach ke BA mana pun (multi-kategori).
- **BU adalah helper/preset**, bukan partisi data: BU memandu user kategori mana yang **wajib / disarankan / opsional** untuk diisi.
- Saat user pilih BU di form, UI menampilkan checkbox kategori dengan urutan: wajib (auto-check, locked) → disarankan (highlighted) → opsional (collapsible).
- User tetap bisa attach kategori "opsional" bila relevan (mis. driver LAKA + Fraud).

---

## Business Unit

| Kode | Nama | Deskripsi |
|---|---|---|
| `LAKA` | LAKA (Truck) | Kecelakaan kendaraan operasional — driver & truck |
| `FNB` | FnB | Food & Beverage — gerai/restoran |
| `OP_HR` | Operation / HR | HR pusat & operasi kantor |

⏳ BU lain (kalau ada): menunggu daftar dari user.

---

## Kategori (Universal)

Semua kategori di bawah ini ada di master `ms_ba_kategori`. Tabel opsi per kategori (`ms_ba_<kategori>`) berisi pilihan/kasus spesifik.

| # | Kode | Nama | Tabel opsi | Status data |
|---|---|---|---|---|
| 1 | `LAKA_PENYEBAB` | Laka Penyebab | `ms_ba_laka_penyebab` | ✅ 7 opsi |
| 2 | `PELANGGARAN_SOP` | Pelanggaran SOP | `ms_ba_pelanggaran_sop` | ✅ 5 opsi |
| 3 | `FRAUD` | Fraud | `ms_ba_fraud` | ⏳ |
| 4 | `TEMUAN_KASUS` | Temuan Kasus | `ms_ba_temuan_kasus` | ⏳ |
| 5 | `INDISIPLINER_ETIKA` | Indisipliner / Etika | `ms_ba_indisipliner_etika` | ⏳ |
| 6 | `MENOLAK_TUGAS` | Menolak Tugas | `ms_ba_menolak_tugas` | ⏳ |
| 7 | `KERUSAKAN_KEHILANGAN` | Kerusakan / Kehilangan | `ms_ba_kerusakan_kehilangan` | ⏳ |
| 8 | `KRIMINAL` | Kriminal | `ms_ba_kriminal` | ⏳ |
| 9 | `KOMPLAIN_CUSTOMER` | Komplain Customer | `ms_ba_komplain_customer` | ⏳ |
| 10 | `KESALAHAN_ADMIN` | Kesalahan Admin | `ms_ba_kesalahan_admin` | ⏳ |
| 11 | `LOGISTIK` | Logistik (FnB) | `ms_ba_logistik` | ✅ 6 opsi |
| 12 | `KUALITAS_MAKANAN` | Kualitas Makanan | `ms_ba_kualitas_makanan` | ✅ 4 opsi |
| 13 | `PELAYANAN` | Pelayanan | `ms_ba_pelayanan` | ✅ 9 opsi |
| 14 | `DISIPLIN_OPERASIONAL` | Disiplin (operasional) | `ms_ba_disiplin_operasional` | ✅ 5 opsi |

Catatan: kategori `DISIPLIN_OPERASIONAL` dan `INDISIPLINER_ETIKA` **terpisah** — user yang menentukan mana yang relevan, BU mapping membantu.

---

## BU × Kategori Mapping (Proposed — Belum Dikonfirmasi User)

Ini draft kasar untuk diskusi. Setiap baris menentukan "level" kategori untuk BU tertentu.

> **Level**:
> - **W** = Wajib (auto-check, tidak bisa uncheck)
> - **D** = Disarankan (highlighted di UI)
> - **O** = Opsional (tersedia, tidak ditonjolkan)
> - **—** = Tidak relevan (di-hide dari UI)

| Kategori | LAKA | FNB | OP_HR |
|---|---|---|---|
| Laka Penyebab | **W** | — | O |
| Pelanggaran SOP | D | D | D |
| Fraud | O | O | D |
| Temuan Kasus | O | O | D |
| Indisipliner / Etika | O | O | D |
| Menolak Tugas | O | O | D |
| Kerusakan / Kehilangan | D | D | D |
| Kriminal | O | O | O |
| Komplain Customer | O | D | O |
| Kesalahan Admin | O | O | D |
| Logistik | — | **W** | O |
| Kualitas Makanan | — | **W** | — |
| Pelayanan | — | **W** | — |
| Disiplin (operasional) | D | **W** | O |

⏳ User perlu validasi mapping di atas.

---

## Opsi per Kategori (yang sudah ada datanya)

### `ms_ba_laka_penyebab`

| Kode | Deskripsi |
|---|---|
| 0 | None |
| 1 | Mengakibatkan laka (driver kita yang salah) |
| 2 | Diakibatkan pihak lain (third party fault) |
| 3 | Tabrak lari (pelaku kabur / tidak diketahui) |
| 4 | Single vehicle / self-accident (terguling, masuk parit, tergelincir) |
| 5 | Kontribusi bersama (joint fault) |
| 6 | Force majeure (bencana alam, kondisi luar kendali) |

### `ms_ba_pelanggaran_sop`

| Kode | Deskripsi |
|---|---|
| 0 | None |
| 1 | SOP dilanggar |
| 2 | SOP tidak dikerjakan |
| 3 | Tidak mengerti SOP |
| 4 | SOP terpaksa dilanggar |

### `ms_ba_logistik`

| Kode | Deskripsi |
|---|---|
| 0 | None |
| 1 | Barang tidak datang |
| 2 | Barang datang rusak |
| 3 | Terima barang kurang |
| 4 | Lupa order |
| 5 | Kurang order |
| 6 | Salah order |

### `ms_ba_kualitas_makanan`

| Kode | Deskripsi |
|---|---|
| 0 | None |
| 1 | Makanan basi |
| 2 | Ada serangga |
| 3 | Tidak enak |
| 4 | Salah kirim |

### `ms_ba_pelayanan`

| Kode | Deskripsi |
|---|---|
| 0 | None |
| 1 | Makanan terlambat |
| 2 | Salah order |
| 3 | Salah buat |
| 4 | Salah kirim |
| 5 | Tumpah |
| 6 | Tidak ramah |
| 7 | Lama tidak datang ke meja |
| 8 | Utensil tidak bersih |
| 9 | Meja tidak bersih |

### `ms_ba_disiplin_operasional`

| Kode | Deskripsi |
|---|---|
| 0 | None |
| 1 | Terlambat lebih dari 15 menit |
| 2 | Tidak ada di station |
| 3 | Tidak masuk tanpa kabar |
| 4 | Lebih dari 3 kali absen 1 bulan |
| 5 | Terlambat lebih dari 5 kali 1 bulan |

### `ms_ba_kerusakan_kehilangan`

⏳ Opsi global belum diberikan. Opsi awal dari FnB (alat rusak, alat hilang) sebagai starting point.

| Kode | Deskripsi |
|---|---|
| 0 | None |
| 1 | Alat rusak |
| 2 | Alat hilang |

---

## Aturan Validasi per Kategori (cross-ref)

| Kategori | Aturan |
|---|---|
| `LAKA_PENYEBAB` | BA yang attach kategori ini wajib punya minimal 1 entry di `tr_ba_kronologi`. |

Lihat detail di [workflows/berita-acara.md](workflows/berita-acara.md).

---

## Catatan & Open Questions

1. **Naming tabel**: konvensi `ms_ba_<kategori>` (universal, tanpa prefix BU). Sudah disesuaikan dari rancangan sebelumnya yang sempat pakai `ms_ba_fnb_*`.
2. **Selalu tambah `0=None`** sebagai opsi default — disepakati.
3. **Mapping BU × kategori** di atas masih DRAFT — user perlu validate level (W/D/O/—) sebelum di-encode ke `ms_bu_kategori_mapping`.
4. **Sub-LAKA lain** (existing `ms_jenis_laka`, `ms_faktor_laka`, `ms_klasifikasi_laka`, `ms_dampak_laka`) — perlu diputuskan: dikonsolidasi sebagai kategori universal, atau tetap sebagai master legacy yang berdiri sendiri.
5. **`Cek*` flags di `Tr_Ba_Main_New`**: belum jelas akan diganti dengan pivot kategori atau tetap dipakai sebagai cache.
