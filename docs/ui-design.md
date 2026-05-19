# UI Design — Form Berita Acara

Rancangan UI untuk Form Berita Acara dengan struktur **Business Unit + Universal Categories + BU Mapping** (lihat [categories.md](categories.md)).

**Status**: 🟡 Disetujui sebagai rancangan, belum implementasi kode.

---

## Keputusan Arsitektur

**Hybrid layout**: **Wizard** untuk mode Create, **Tab** untuk mode Edit/View.

| Mode | Layout | Alasan |
|---|---|---|
| **Create** | Wizard 5-step (linear) | Guided experience untuk first-time user, validasi per step, kategori driven by BU choice |
| **Edit / View / Validate** | Tab horizontal (free jump) | User sudah tahu mau ubah section mana, audit trail tab untuk validator |

Library yang dipakai (semua **sudah** di [package.json](../package.json)):
- `bs-stepper` (wizard component)
- Bootstrap 5.2.3 nav-tabs (tab component)
- Select2 (multi-select kategori, search karyawan)
- Flatpickr / bootstrap-datepicker (date input)
- Dropzone (file upload)
- SweetAlert2 (konfirmasi submit)
- Toastr (toast feedback)

---

## CREATE Mode — Wizard 5 Step

### Layout Umum

```
┌──────────────────────────────────────────────────────────────┐
│  ① ─── ② ─── ③ ─── ④ ─── ⑤                                  │
│  BU   Data   Kat   Krono   Review                            │
├──────────────────────────────────────────────────────────────┤
│                                                              │
│  [Content step aktif]                                        │
│                                                              │
│         [← Kembali]    [Lanjut →]    /   [Submit ✓]          │
└──────────────────────────────────────────────────────────────┘
```

### Step ① — Business Unit

```
┌──────────┐  ┌──────────┐  ┌──────────┐
│  🚚      │  │  🍽️      │  │  🏢      │
│  LAKA    │  │  FnB     │  │ OP / HR  │
│  Truck   │  │  Gerai   │  │  Kantor  │
└──────────┘  └──────────┘  └──────────┘
(radio card, pilih 1)
```

- Card style radio (Bootstrap card + `border-primary` saat selected).
- Required.

### Step ② — Data Umum

```
Tanggal kejadian *  : [____]
Lokasi *            : [Select ▼ - dari ms_lokasi]
Cabang/Company *    : [Select ▼ - dari ms_company]
Subject karyawan *  : [Search ▼ - dari master_employees]
Deskripsi singkat * : [textarea 3-row]
```

- Field bertanda `*` = required.
- Subject karyawan = Select2 dengan AJAX search (pattern existing di project).

### Step ③ — Kategori Kejadian (multi-select)

Kategori dikelompokkan **3 level** berdasarkan BU yang dipilih di step ①:

```
🔴 WAJIB   (auto-checked, locked 🔒)
┌──────────────────────────────────────────────────────────────┐
│ ☑ Laka Penyebab    🔒                                       │
│   Opsi: ( ) Mengakibatkan laka                              │
│         (•) Diakibatkan pihak lain                          │
│         ( ) Tabrak lari                                     │
│         ( ) Single vehicle                                  │
│         ( ) Kontribusi bersama                              │
│         ( ) Force majeure                                   │
└──────────────────────────────────────────────────────────────┘

🟡 DISARANKAN
┌──────────────────────────────────────────────────────────────┐
│ ☐ Pelanggaran SOP                                            │
│ ☐ Kerusakan/Kehilangan                                       │
│ ☐ Komplain Customer                                          │
└──────────────────────────────────────────────────────────────┘

⚪ OPSIONAL  [▼ Show 7 more]
┌──────────────────────────────────────────────────────────────┐
│ ☐ Fraud                ☐ Indisipliner / Etika                │
│ ☐ Kriminal             ☐ Menolak Tugas                       │
│ ☐ Temuan Kasus         ☐ Kesalahan Admin                     │
│ ☐ Logistik             ☐ Kualitas Makanan                    │
│ ☐ Pelayanan            ☐ Disiplin Operasional                │
└──────────────────────────────────────────────────────────────┘
```

**Behavior**:
- Tiap kategori yang ter-check langsung **expand sub-section** dengan opsi (radio/dropdown dari `ms_ba_<kategori>`).
- Wajib auto-checked + disabled (tooltip: "Wajib untuk BU [X]").
- Validasi: min 1 kategori. Per kategori, opsi 0=None artinya "tidak detail" tapi tetap valid.

### Step ④ — Kronologi

**Conditional**: tampil bila `LAKA_PENYEBAB` di-check di step ③.

```
[textarea 5-row]
[textarea 5-row]
[+ Tambah baris kronologi]
```

- Min 1 entry kronologi (saved as multiple rows di `tr_ba_kronologi`).
- Bila step ini di-skip (LAKA_PENYEBAB tidak dipilih) → indikator step jadi gray dengan label "Tidak diperlukan".

### Step ⑤ — Review & Submit

```
┌─────────────────────────────────────────┐
│  RINGKASAN BA                  [Edit]   │
├─────────────────────────────────────────┤
│  BU       : LAKA Truck                  │
│  Tanggal  : 2026-05-19                  │
│  Lokasi   : Jakarta-Utara               │
│  Subject  : Budi Santoso (EMP00123)     │
│  Deskripsi: Tabrakan di Tol JORR        │
├─────────────────────────────────────────┤
│  KATEGORI                      [Edit]   │
│  • Laka Penyebab → Diakibatkan pihak    │
│    lain                                 │
│  • Pelanggaran SOP → SOP dilanggar      │
├─────────────────────────────────────────┤
│  KRONOLOGI                     [Edit]   │
│  1. 08:30 - kendaraan keluar pool       │
│  2. 09:15 - terjadi tabrakan...         │
├─────────────────────────────────────────┤
│  DOKUMEN: 3 file uploaded   [Edit]      │
├─────────────────────────────────────────┤
│  [Simpan Draft]   [Submit ➜]            │
└─────────────────────────────────────────┘
```

- "Edit" link kembali ke step terkait.
- "Simpan Draft" = simpan dengan status `DRAFT`, user bisa lanjut nanti.
- "Submit" = simpan dengan status `PENDING_VALIDASI` → kirim ke validator level 1 (koord/manager).
- Konfirmasi via SweetAlert2 sebelum submit.

---

## EDIT / VIEW Mode — Tab

```
┌──────────────────────────────────────────────────────────────┐
│ [Umum] [Kategori] [Kronologi] [Dokumen] [● Validasi/Log]    │
├──────────────────────────────────────────────────────────────┤
│  [Content tab aktif]                                         │
└──────────────────────────────────────────────────────────────┘
```

| Tab | Isi |
|---|---|
| **Umum** | BU (readonly setelah create) + Data Umum |
| **Kategori** | Daftar kategori terpilih + opsi. Add/remove kategori bila status DRAFT/REVISI |
| **Kronologi** | List entry + append baru |
| **Dokumen** | Daftar dokumen + upload baru |
| **● Validasi/Log** | Audit trail validasi (siapa, kapan, komentar) + form aksi validasi untuk validator |

### Status BA → Editability

| Status | Tab Umum | Tab Kategori | Tab Kronologi | Tab Dokumen | Tab Validasi |
|---|---|---|---|---|---|
| `DRAFT` | ✏️ Editable | ✏️ Editable | ✏️ Editable | ✏️ Editable | — (belum disubmit) |
| `PENDING` | 🔒 Readonly | 🔒 Readonly | 🔒 Readonly | 🔒 Readonly | ✏️ Validator aksi |
| `REVISI` | ✏️ Editable | ✏️ Editable | ✏️ Editable | ✏️ Editable | 📖 Lihat alasan revisi |
| `APPROVED` / `CLOSED` | 🔒 Readonly | 🔒 Readonly | 🔒 Readonly | 🔒 Readonly | 📖 History only |

### Badge & Notifikasi

- Tab "Validasi/Log" punya **badge merah** bila ada aksi pending untuk user yang sedang login (mis. user = validator dan BA status PENDING).
- Bila status REVISI, banner kuning di atas tab dengan alasan revisi.

---

## Komponen Reuse: Blade Partials

Setiap section dipisah jadi **partial standalone** yang di-include oleh wizard step / tab pane.

```
resources/views/berita_acara/
├── create.blade.php                 ← Wizard wrapper
├── edit.blade.php                   ← Tab wrapper (mode edit)
├── show.blade.php                   ← Tab wrapper (mode view + validasi)
└── _partials/
    ├── _section_bu.blade.php
    ├── _section_data_umum.blade.php
    ├── _section_kategori.blade.php
    ├── _section_kronologi.blade.php
    ├── _section_dokumen.blade.php
    └── _section_validasi_log.blade.php
```

**Prinsip**:
- Logic & validation **identik** antara wizard dan tab.
- Wrapper hanya beda **navigasi** (next/back vs tab-click).
- Partial menerima `$mode` ('create'|'edit'|'view') untuk kontrol readonly.

---

## Routing

```php
// routes/web.php
Route::middleware('auth')->group(function() {
    Route::get('/beritaacara/create',         [BeritaAcaraController::class, 'create']);
    Route::post('/beritaacara/store',         [BeritaAcaraController::class, 'store']);
    Route::post('/beritaacara/save-draft',    [BeritaAcaraController::class, 'saveDraft']);
    Route::get('/beritaacara/{id}',           [BeritaAcaraController::class, 'show']);
    Route::get('/beritaacara/{id}/edit',      [BeritaAcaraController::class, 'edit']);
    Route::put('/beritaacara/{id}',           [BeritaAcaraController::class, 'update']);
    Route::post('/beritaacara/{id}/validate', [BeritaAcaraController::class, 'submitValidation']);

    // Endpoint AJAX untuk dynamic data
    Route::get('/api/bu/{bu_code}/kategori',  [BeritaAcaraController::class, 'kategoriByBu']);
    Route::get('/api/kategori/{kategori_code}/opsi', [BeritaAcaraController::class, 'opsiByKategori']);
});
```

⚠️ **Catatan**: existing `routes/web.php` punya 62 endpoint di `BeritaAcaraController` dengan nama berbeda. Migrasi ke struktur RESTful di atas perlu fase transisi (keep old endpoints sambil rolling out new).

---

## Komponen Frontend yang Dipakai

| Komponen | Library | Fungsi |
|---|---|---|
| Wizard stepper | `bs-stepper` | Indikator step + navigation |
| Tab horizontal | Bootstrap nav-tabs | Tab edit mode |
| Card BU (radio) | Bootstrap card + custom JS | Pilih BU |
| Select dengan search | Select2 | Karyawan, lokasi, kategori multi |
| Checkbox kategori | Native + custom CSS untuk W/D/O styling | Multi-select kategori |
| Date picker | Flatpickr | Tanggal kejadian |
| File upload | Dropzone | Dokumen pendukung |
| Confirmation modal | SweetAlert2 | Submit konfirmasi |
| Toast | Toastr | Save draft success/error |

**Tidak install library baru** — semua sudah ada.

---

## Validation Rules

| Rule | Where |
|---|---|
| BU wajib dipilih | Step ① / Server (Form Request) |
| Field required di data umum | Step ② / Server |
| Min 1 kategori dipilih | Step ③ / Server |
| Tiap kategori dipilih wajib punya opsi (boleh `0=None`) | Step ③ / Server |
| Kronologi wajib bila `LAKA_PENYEBAB` dipilih | Step ④ / Server |
| User auth + role check | Middleware `auth` + custom permission middleware |

Server-side validation primary (Laravel Form Request). Client-side validation untuk UX preventif saja.

---

## Lingkup Belum Dirancang (Defer ke Fase Berikutnya)

1. **Routing validator per kategori** — siapa boleh validasi kategori apa (perlu role/permission table).
2. **Mobile responsive layout** — desktop dulu, mobile menyusul.
3. **Bulk action di dashboard list** — defer.
4. **Notification push** real-time untuk validator — pakai Pusher / WebSocket, defer.
5. **PDF preview di tab Dokumen** — embed PDF.js?
6. **Komentar per kategori** (validator memberi comment terhadap satu kategori spesifik, bukan global) — fase 2.

---

## Catatan untuk Implementasi (Saat Mulai Coding)

1. **Implementasi bertahap**: mulai dari wizard create, tab edit menyusul.
2. **Backward compat**: keep endpoint lama (`/dashboard_ba`, `/store_validasi/*`, dll.) selama fase transisi.
3. **Kolom existing**: `Cek*` flags di `Tr_Ba_Main_New` bisa di-sync dari pivot kategori (sebagai cache untuk query agregat existing).
4. **Test data**: gunakan data dummy dulu — jangan test di DB produksi.
