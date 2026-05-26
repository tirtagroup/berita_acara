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

---

## 10. Domain Prefix Naming (`fnb`, dst.)

**Aturan**: Setiap artifact yang scope-nya **spesifik ke satu domain bisnis** (mis. operasi FnB resto, SOP, Risk Register) WAJIB pakai prefix domain di posisi yang sesuai dengan tipe artifact.

### Kapan WAJIB pakai prefix domain ✅

Artifact yang hanya relevan untuk satu domain bisnis:

- **`fnb`** — Operasi FnB resto: scheduling resto, resep, inventory dapur, FOH/BOH staffing, dll.
- **`sop`** — SOP module (future, Phase 2 — lihat [ADR-003](decisions/003-sop-module-tier2.md))
- **`risk`** — Risk Register (future, Phase 4)

### Kapan TIDAK boleh pakai prefix domain ❌

Artifact universal / cross-domain:

- **Kategori BA universal** — sudah ada precedent revert dari `fnb_*` ke `ms_ba_*`. Lihat [database.md §Planned Change](database.md#-planned-change-multi-category-berita-acara) + [ADR-006](decisions/006-konteks-renamed-from-bu.md).
- **Master global**: `ms_konteks`, `ms_company`, `MsBranch`, `Ms_User_Emp`, dll.
- **Modul cross-domain**: BA, PICA, SP, Assessment, Rekrutmen, Help center, Permission system.
- **Tabel sistem Laravel**: `users`, `sessions`, `migrations`, `personal_access_tokens`.

### Aturan per tipe artifact

| Tipe | Pattern | Contoh (domain `fnb`) |
|---|---|---|
| **DB table** | `{ms\|tr}_<domain>_<entity>[_h\|_d\|_log]` (domain di TENGAH, ms/tr tetap di depan untuk konsistensi codebase) | `ms_fnb_outlet`, `tr_fnb_jadwal_h`, `tr_fnb_jadwal_d`, `tr_fnb_jadwal_h_log` |
| **Model class** | `App\Models\<Domain>\<Entity>` (sub-namespace, **bukan flat**) | `App\Models\Fnb\Outlet`, `App\Models\Fnb\JadwalHeader` |
| **Controller** | `App\Http\Controllers\<Domain>\<Name>Controller` | `App\Http\Controllers\Fnb\JadwalController` |
| **Route URI** | `/<domain>/<sub-module>/<resource>` | `/fnb/scheduling/jadwal`, `/fnb/master/outlet` |
| **Route name** | `<domain>.<sub-module>.<resource>.<action>` | `fnb.scheduling.jadwal.index` |
| **View / Blade** | `resources/views/<domain>/<sub-module>/...` | `fnb/scheduling/jadwal/edit.blade.php` |
| **Permission code** | `<domain>.<sub-module>.<resource>.<action>` | `fnb.scheduling.jadwal.approve` |
| **JS asset** | `resources/js/<domain>/<sub-module>/*` | `resources/js/fnb/scheduling/calendar.js` |
| **Migration file** | `YYYY_MM_DD_HHMMSS_create_<table>_table.php` (table name sudah punya domain prefix) | `2026_07_01_100000_create_ms_fnb_outlet_table.php` |
| **CSS class** | `.<domain>-<sub-module>-<element>` | `.fnb-scheduling-cell`, `.fnb-jadwal-status-published` |
| **Docs folder** | `docs/<domain>-<sub-module>/` | `docs/fnb-scheduling/` |

### Penjelasan posisi prefix di DB table

Tabel pakai **`{ms|tr}_<domain>_<entity>`** (BUKAN `<domain>_{ms|tr}_<entity>`) karena:

- Konsisten dengan precedent codebase: `ms_ba_kategori`, `tr_ba_kategori_d`, `tr_emp_assesment`. Pattern existing = `{ms|tr}_<domain/area>_<entity>`.
- Sort alfabetis di DB tool mengumpulkan semua master (`ms_*`) dan transactional (`tr_*`) — bagus untuk DBA & schema review.
- Tooling existing (`php artisan docs:check-schema`, backup scripts) yang assume `ms_*`/`tr_*` di awal tetap berfungsi.

> Code layer (model, controller, route, permission, view) tidak punya klasifikasi master/transactional, jadi domain prefix langsung di depan.

### Edge cases

| Situasi | Aturan |
|---|---|
| **Artifact existing belum pakai prefix** (mis. tabel BA, PICA) | **Tidak retroaktif**. Rule berlaku untuk modul baru saja, jangan rename existing. |
| **Sub-module dalam domain** (mis. `scheduling` dalam `fnb`) | Pakai sebagai segmen path/permission/folder, **bukan** di table prefix. Table tetap `ms_fnb_<entity>` (singkat), bukan `ms_fnb_scheduling_<entity>` (kepanjangan). Sub-module name baru wajib di route/permission/view path. |
| **Feature pindah dari domain-specific → universal** | Rename via migration eksplisit + ADR. Precedent: `ms_business_unit` → `ms_konteks` ([ADR-006](decisions/006-konteks-renamed-from-bu.md)). |
| **Feature lintas-domain** (mis. fitur dipakai FnB + SOP) | Universal — tidak pakai prefix domain. |
| **ADR file** | Tetap di `docs/decisions/NNN-*.md` (project-wide series). Filename slug boleh include domain, mis. `007-fnb-scheduling-staff-source.md`. |

### Penerapan saat ini

| Modul | Folder docs | Table prefix | Code namespace |
|---|---|---|---|
| FnB Scheduling Resto | [docs/fnb-scheduling/](fnb-scheduling/) | `ms_fnb_*` / `tr_fnb_*` | `App\Models\Fnb\*`, `/fnb/scheduling/*` |

Modul-modul existing (BA, PICA, SP, Assessment, Rekrutmen) **tidak terkena rule ini** — mereka mengikuti konvensi historical.
