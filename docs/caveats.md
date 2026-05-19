# Caveats & Troubleshooting

Hal-hal yang harus diketahui sebelum kerja di project ini, plus solusi untuk error umum.

---

## ⚠️ Caveats

### `.env` Ter-commit di Repo

File `.env` **berisi kredensial produksi asli** (DB password, SMTP password) dan **ter-commit ke GitHub** (tidak ada di `.gitignore`, hanya `.env.backup` yang di-ignore).

**Rekomendasi**:
1. Rotasi password DB & SMTP.
2. Tambahkan `.env` ke `.gitignore`.
3. `git rm --cached .env` lalu commit.
4. Distribusikan kredensial via channel aman (1Password, vault, dll.).

---

### PHP 8.3 Tidak Kompatibel

`composer.lock` pin `nette/schema` 1.2.3 & `nette/utils` 4.0.0 (cap di PHP 8.2). Pilihan:
- **Tetap di PHP 8.2** (rekomendasi — sudah dites)
- Jalankan `composer update` untuk memutakhirkan lock file ke versi yang mendukung 8.3 (boleh, tapi perubahan harus di-test menyeluruh)

---

### Bootstrap Pin di 5.2.3

`package.json` (`devDependencies.bootstrap`) **harus** `"bootstrap": "5.2.3"` (bukan `^5.2.3`).

Bootstrap 5.3 menghapus parameter `form-validation-state` dan mengubah theme color jadi CSS var — SCSS template tidak kompatibel dan akan menghasilkan **32 error** saat `npm run watch`.

---

### `overrides.autoprefixer` Tidak Valid

Versi awal `package.json` punya `overrides.autoprefixer: "10.4.5"` padahal devDependency-nya `^10.4.7` — npm modern menolak ini dengan `EOVERRIDE`. Sudah di-fix: entri tersebut **dihapus** dari `overrides` & `resolutions`.

---

### `fruitcake/laravel-cors` Abandoned

Paket sudah ditandai *abandoned* upstream. Laravel 9 sudah punya CORS built-in (`fruitcake/laravel-cors` versi 3.x adalah alias). Pertimbangkan migrasi.

---

### DB Produksi = Live Data

Saat `DB_HOST=absensi.tirtagroup.net`, **semua insert/update/delete dari dev box masuk ke DB live**. Untuk testing destruktif, dump dan gunakan replica lokal.

---

### File Duplikat di Repo

Ditemukan beberapa file copy yang masih ter-commit (kemungkinan ter-upload tidak sengaja):

- `app/Http/Controllers/HomeController copy.php`
- `app/Models/User copy.php`
- `app/Models/tr_import_data copy.php`
- `app/Models/MsLocationController.php` (model ber-namespace controller — kesalahan)
- `resources/views/home..copy/`, `homeoriginal.backup.php`

Composer autoload-dump akan menampilkan PSR-4 warning untuk file-file ini. Aman untuk dihapus setelah diverifikasi tidak dipakai.

---

### SQL Injection (Potensi)

Banyak controller existing memakai **string interpolation** untuk SQL:

```php
$report = DB::select("... WHERE user = '$user->username'");
```

Bila menambah query baru, pakai **prepared statement** dengan bindings:

```php
$report = DB::select("... WHERE user = ?", [$user->username]);
```

Lihat [docs/conventions.md](conventions.md#4-query-database).

---

## 🔧 Troubleshooting

### `Failed to listen on 127.0.0.1:8000` saat `artisan serve`

Windows/Hyper-V mereservasi range port dinamis. Pakai port di atas 9000:

```bash
php artisan serve --port=9876
```

---

### `Please provide a valid cache path` saat `composer install`

Folder `storage/framework/{views,sessions,cache}` belum ada. Buat manual:

```bash
mkdir -p storage/framework/cache/data \
         storage/framework/sessions \
         storage/framework/views \
         storage/framework/testing \
         storage/app/public \
         storage/logs \
         bootstrap/cache
```

---

### `SQLSTATE[HY000] [1045] Access denied for user`

DB credentials di `.env` tidak match dengan MySQL lokal. Switch ke DB produksi:

```env
DB_HOST=absensi.tirtagroup.net
```

…atau buat user/database lokal dengan kredensial yang sama.

---

### `Mix: Compiled with 32 errors` (Sass)

Bootstrap > 5.2 ter-install. Edit `package.json`:

```json
"devDependencies": {
  "bootstrap": "5.2.3"     // BUKAN "^5.2.3"
}
```

Lalu `npm install` ulang.

---

### `npm error code EOVERRIDE`

Hapus entry yang konflik dari `overrides` di `package.json` (lihat [Caveats #4](#overridesautoprefixer-tidak-valid)).

---

### Composer artisan script error: PSR-4 autoload warning

Aman diabaikan untuk file `*copy.php`. Untuk menghilangkan warning: hapus file duplikat (lihat [File Duplikat](#file-duplikat-di-repo)).

---

### PHP `dynamic library not found`

`extension_dir` di `php.ini` belum benar. Set ke path absolut:

```ini
extension_dir = "C:\Users\<user>\php82\ext"
```

---

### HTTP 500 — `Allowed memory size of 134217728 bytes exhausted`

PHP default `memory_limit = 128M` tidak cukup untuk beberapa halaman report. Naikkan di `php.ini`:

```ini
memory_limit = 1024M
```

Lalu restart `php artisan serve`.

---

### Halaman blank atau session error setelah update `.env`

Clear cache config:

```bash
php artisan config:clear
php artisan view:clear
php artisan route:clear
```
