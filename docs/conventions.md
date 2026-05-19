# Konvensi UI & Coding

Aturan yang berlaku saat menambah/edit fitur di BA-PICA.

---

## 1. Default Date Range untuk Filter

**Aturan**: Semua halaman/dashboard yang punya filter rentang tanggal (`tgl_awal` / `tgl_akhir`) harus pakai default:

- **`tgl_awal`** = awal bulan berjalan
- **`tgl_akhir`** = tanggal hari ini

**Alasan**: User Tirta Group ingin selalu melihat data sebulan terakhir saat masuk dashboard, tanpa harus klik filter dulu.

**Implementasi di controller**:

```php
use Carbon\Carbon;

public function get_dashboard_xxx()
{
    $tgl_awal  = Carbon::now()->startOfMonth()->format('Y-m-d');
    $tgl_akhir = Carbon::now()->format('Y-m-d');

    $report = DB::connection('mysql')->select("
        select ...
        from xxx
        where date(created_at) >= '$tgl_awal'
          and date(created_at) <= '$tgl_akhir'
    ");

    return view('xxx.dashboard_xxx', compact('report', 'tgl_awal', 'tgl_akhir'));
}
```

**Implementasi di view**:

```blade
<input type="date" name="tgl_awal"
       value="@isset($tgl_awal){{$tgl_awal}}@endisset"
       class="form-control" />
<input type="date" name="tgl_akhir"
       value="@isset($tgl_akhir){{$tgl_akhir}}@endisset"
       class="form-control" />
```

**Referensi**: lihat `Tr_PICA_Controller::get_dashboard_pika()`.

---

## 2. Struktur Controller

- **Method `get_*` atau `index*`** → render view pertama kali (tanpa parameter POST).
- **Method `search_*` atau `post_*`** → handle form filter / submission.
- Kedua method **harus** sama-sama mem-pass `$tgl_awal` & `$tgl_akhir` ke view.

---

## 3. Naming

### Tabel Database
- **`Ms_*` / `ms_*`** — master data (referensi tetap)
- **`Tr_*` / `tr_*`** — transactional (data operasional, sering insert/update)
- **`*_h` + `*_d`** — pasangan header & detail (master-detail)

### Model PHP
Ikuti nama tabel persis. Contoh: tabel `Tr_BA_Main_New` → model `Tr_BA_Main_New`.

### Controller
- Business controller: di **root** `app/Http/Controllers/`
- Demo template Sneat: di subfolder (`apps/`, `dashboard/`, `cards/`, dll.) — **jangan diubah**, biarkan apa adanya.

---

## 4. Query Database

- Pakai **raw SQL via `DB::connection('mysql')->select(...)`** untuk query kompleks (sudah jadi pola di project ini).
- Pakai **Eloquent** untuk operasi sederhana (CRUD per record).
- Bila ada cross-connection (`mysql` ↔ `mysql_new`), selalu sebutkan `connection` secara eksplisit.

⚠️ **Hati-hati SQL injection** — banyak query existing memakai string interpolation (`'$user->username'`). Idealnya pakai prepared statement (`?` + bindings). Bila menambah query baru, pakai bindings:

```php
DB::connection('mysql')->select("... where Ms_User = ?", [$user->username]);
```

---

## 5. PDF Generation

- **mPDF** (`mpdf/mpdf`) — dipakai untuk PDF dengan styling kompleks (CSS).
- **DomPDF** (`barryvdh/laravel-dompdf`) — alternatif untuk PDF sederhana.
- Output PDF ke `storage/app/public/` lalu `Storage::download(...)`.

---

## 6. Frontend

- **Bootstrap 5.2.3** — di-pin, JANGAN upgrade ke 5.3+ (lihat [caveats](caveats.md#bootstrap-pin-di-523)).
- **DataTables (jQuery)** untuk tabel data.
- **SweetAlert2** untuk konfirmasi destructive action (delete, etc.).
- **Toastr** untuk notifikasi pendek.
- **Flatpickr** atau `<input type="date">` untuk date picker.

---

## 7. Internationalization

Bahasa default: **English** (`config/app.php` → `locale => 'en'`).

Translasi tersedia: `lang/de.json`, `lang/en.json`, `lang/fr.json`, `lang/pt.json`.

Switch via route `/lang/{locale}`.

---

## 8. Authentication

- **Primary**: `LoginController` (custom — tidak pakai Laravel default Auth fully).
- **Middleware**: `auth` (lihat `App\Http\Middleware\LocaleMiddleware`).
- **Session**: file-based (`SESSION_DRIVER=file`).
- **Multi-tenant**: ada `LoginCompanyController` untuk login mitra/anak perusahaan.

---

## 9. Logging

- Channel default: `stack` (gabungan).
- File: `storage/logs/laravel.log` (rotated daily oleh `LOG_LEVEL=debug`).
- Hindari `dd()` di production — pakai `Log::info(...)` atau `Log::error(...)`.
