# Menjalankan Aplikasi

Setelah [setup](setup.md) selesai, jalankan aplikasi dengan langkah berikut.

---

## 1. PHP Dev Server

```powershell
# Pakai port di atas 9000 — port 8000/8080 sering diblok Windows/Hyper-V
& "$env:USERPROFILE\php82\php.exe" artisan serve --host=127.0.0.1 --port=9876
```

Akses di browser: **http://127.0.0.1:9876**

---

## 2. Build Asset (Laravel Mix)

```bash
# Compile sekali (development)
npm run dev

# Auto-recompile saat ada perubahan SCSS/JS
npm run watch

# Production build (minify)
npm run production
```

Hasil compile masuk ke `public/assets/`. Sebagian sudah ter-commit di repo, jadi aplikasi bisa langsung dipakai tanpa build ulang.

---

## 3. Workflow Development Standar

Buka dua terminal:

**Terminal 1 — PHP server:**
```bash
php artisan serve --port=9876
```

**Terminal 2 — Asset watcher:**
```bash
npm run watch
```

Setiap perubahan SCSS/JS akan otomatis di-compile. Refresh browser manual untuk lihat hasilnya.

---

## 4. Maintenance Artisan

Bila ada perubahan `.env`, config, atau route, clear cache dulu:

```bash
php artisan config:clear      # hapus cache config
php artisan route:clear       # hapus cache route
php artisan view:clear        # hapus cache blade compiled
php artisan cache:clear       # hapus cache aplikasi
```

---

## 5. Tip — Tail Log Real-time

```powershell
Get-Content storage/logs/laravel.log -Wait -Tail 50
```

Atau di Git Bash:

```bash
tail -f storage/logs/laravel.log
```

---

## Berikutnya

- Daftar route & modul → [docs/routes.md](routes.md)
- Skema database → [docs/database.md](database.md)
- Konvensi UI / coding → [docs/conventions.md](conventions.md)
- Error & gotcha → [docs/caveats.md](caveats.md)
