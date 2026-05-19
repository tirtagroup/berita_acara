# Setup & Instalasi

Panduan menjalankan project BA-PICA dari nol di mesin development (Windows).

---

## 1. Prasyarat

| Tool | Versi | Catatan |
|---|---|---|
| PHP | **8.2.x** | **JANGAN pakai 8.3** — `nette/schema` & `nette/utils` di `composer.lock` belum support 8.3. PHP 8.2 portable bisa hidup berdampingan dengan instalasi lain (XAMPP, dsb.) |
| Composer | 2.x | |
| Node.js | ≥ 18 | direkomendasikan v20 atau v22 |
| npm | ≥ 9 | |
| MySQL | 5.7+ atau 8.x | atau gunakan DB produksi langsung |
| Ekstensi PHP wajib | `openssl mbstring fileinfo curl zip gd pdo_mysql mysqli exif sodium intl bcmath sqlite3 pdo_sqlite tokenizer xml` | aktifkan di `php.ini` |

---

## 2. Install PHP 8.2 Portable (Windows)

Bila Anda sudah punya PHP 8.3 (mis. di XAMPP), PHP 8.2 dapat dipasang berdampingan tanpa mengganggu.

```powershell
# Download PHP 8.2 (Thread Safe x64) dari windows.php.net
Invoke-WebRequest -Uri "https://windows.php.net/downloads/releases/php-8.2.31-Win32-vs16-x64.zip" `
                  -OutFile "$env:USERPROFILE\php82.zip"

# Extract ke folder terpisah
Expand-Archive "$env:USERPROFILE\php82.zip" -DestinationPath "$env:USERPROFILE\php82"
```

### Konfigurasi `php.ini`

```powershell
# Salin template
Copy-Item "$env:USERPROFILE\php82\php.ini-development" "$env:USERPROFILE\php82\php.ini"
```

Edit `C:\Users\<user>\php82\php.ini`:

```ini
; Set extension_dir ke path absolut
extension_dir = "C:\Users\<user>\php82\ext"

; Aktifkan ekstensi (hapus titik koma di awal baris)
extension=openssl
extension=mbstring
extension=fileinfo
extension=curl
extension=zip
extension=gd
extension=pdo_mysql
extension=mysqli
extension=exif
extension=sodium
extension=intl
extension=sqlite3
extension=pdo_sqlite

; Naikkan memory limit (default 128M tidak cukup untuk beberapa report)
memory_limit = 1024M
```

Verifikasi:

```powershell
& "$env:USERPROFILE\php82\php.exe" --version
# Output yang diharapkan: PHP 8.2.31 (cli) ...
```

---

## 3. Clone Repository

```bash
git clone https://github.com/tirtagroup/berita_acara.git
cd berita_acara
```

---

## 4. Install Dependency PHP

```powershell
# Bila PHP global Anda = 8.3, pakai PHP 8.2 portable secara eksplisit:
& "$env:USERPROFILE\php82\php.exe" "C:\composer\composer.phar" install --no-interaction --prefer-dist

# Bila PHP global = 8.2, cukup:
composer install
```

---

## 5. Install Dependency Frontend

```bash
npm install
```

Bila gagal dengan error `EOVERRIDE` (autoprefixer), hapus baris `"autoprefixer": "10.4.5"` dari `overrides` & `resolutions` di `package.json`, lalu ulangi `npm install`.

---

## 6. Buat Folder Storage (bila belum ada)

Setelah clone, beberapa folder yang dibutuhkan Laravel tidak ada (gitignored):

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

## 7. Konfigurasi `.env`

File `.env` sudah ada di repo dengan kredensial default. Sesuaikan minimal:

```env
APP_URL=http://127.0.0.1:9876        # sesuaikan port (lihat docs/running.md)

DB_CONNECTION=mysql
DB_HOST=absensi.tirtagroup.net       # atau localhost untuk MySQL lokal
DB_PORT=3306
DB_DATABASE=tirt3038_HR_Worksheet
DB_USERNAME=tirt3038_HR_Management
DB_PASSWORD=<kontak tim>

# Koneksi kedua (untuk modul ERP/Assessment)
DB_HOST_NEW=absensi.tirtagroup.net
DB_DATABASE_NEW=tirt3038_ERP
```

Bila `APP_KEY` kosong:

```bash
php artisan key:generate
```

---

## Setelah Setup Selesai

Lanjut ke [docs/running.md](running.md) untuk menjalankan aplikasi.

Bila menemui error, cek [docs/caveats.md](caveats.md#troubleshooting).
