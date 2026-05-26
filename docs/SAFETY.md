# SAFETY — Operasi Berisiko & Larangan Eksplisit

Dokumen ini melengkapi [caveats.md](caveats.md). Caveats = quirk & error umum yang ditemui. **SAFETY = apa yang BOLEH dan TIDAK BOLEH dilakukan** (terutama oleh AI agent).

> AI agent: baca ini **sebelum** eksekusi command apa pun yang menulis/mengubah state.

---

## 🚫 OPERASI YANG TIDAK BOLEH TANPA KONFIRMASI USER EKSPLISIT

### Database / data

| Operasi | Kenapa berbahaya |
|---|---|
| `php artisan migrate` (di env dengan `DB_HOST=absensi.tirtagroup.net`) | Mengubah schema DB PRODUKSI Tirta. Migrations folder tidak fully mirror schema bisnis — bisa drop kolom yang masih dipakai. |
| `php artisan migrate:fresh`, `migrate:rollback`, `migrate:reset` | Bisa drop tabel produksi atau revert schema yang sudah live. **Hampir selalu salah** di env ini. |
| `php artisan db:seed` | Insert data ke DB live. |
| `DB::table('...')->truncate()`, `delete()` tanpa where, `DB::statement('DROP/ALTER/TRUNCATE')` lewat tinker | Destroy/alter live data. |
| `DB::statement('TRUNCATE ...')` atau `DELETE` tanpa WHERE | Hapus semua row tabel produksi. |
| Edit data lewat tinker (`update(...)`, `insert(...)`) di tabel produksi | Mutasi data live tanpa audit trail. |

**Aturan**: kalau perlu mutate DB → kasih plan ke user dulu, tunggu approval, baru eksekusi. Untuk testing destruktif, **dump ke replica lokal dulu** ([caveats](caveats.md#db-produksi--live-data)).

### Git

| Operasi | Kenapa berbahaya |
|---|---|
| `git push --force` ke `main` / `master` | Bisa overwrite kerjaan orang lain di remote. |
| `git reset --hard`, `git checkout --`, `git clean -fd`, `git restore .` | Hapus uncommitted work permanen — tidak ada di reflog kalau belum di-commit. |
| `git rebase -i` | Mode interaktif tidak supported di harness AI. |
| `git commit --no-verify`, `--no-gpg-sign` | Bypass pre-commit hooks (tests, linting, signing). Investigasi root cause kalau hook gagal. |
| `git branch -D <branch>` | Force delete branch, lose unmerged commits. |
| `git config --global ...` | Ubah global config user. |

### Filesystem

| Operasi | Kenapa berbahaya |
|---|---|
| Edit `.env` | Berisi kredensial produksi. Sudah ter-commit di repo ([caveats](caveats.md#env-ter-commit-di-repo)), jadi sekali sentuh = ke commit history. |
| Edit `storage/` content directly | Berisi session aktif user, log produksi. |
| `rm -rf` / `Remove-Item -Recurse -Force` di luar `node_modules`, `vendor`, atau folder yang jelas regenerable | Bisa hilangkan kerjaan user. |
| Hapus file di `resources/views/` yang nama mirip "copy" / "backup" | Bisa jadi user sengaja tinggal sebagai referensi — konfirmasi dulu (lihat [caveats](caveats.md#file-duplikat-di-repo)). |

### Composer / NPM

| Operasi | Kenapa berbahaya |
|---|---|
| `composer update` (tanpa lock target spesifik) | Bisa upgrade `nette/schema` keluar dari range PHP 8.2. |
| `composer require ...` package baru tanpa user setuju | Bisa berkonflik dengan pinned versions. |
| `npm install bootstrap@latest` (atau update Bootstrap ke 5.3+) | Bootstrap pin di 5.2.3. Upgrade = 32 SCSS error. |
| `npm update` blanket | Bisa break dependency chain. |

---

## ⚠️ DANGEROUS PATTERNS (saat tulis code baru)

### SQL injection

Banyak controller existing pakai string interpolation:

```php
// JANGAN tiru pattern ini di code baru:
DB::select("... WHERE user = '$user->username'");

// SELALU pakai bindings:
DB::select("... WHERE user = ?", [$user->username]);
```

Lihat [conventions.md#4-query-database](conventions.md#4-query-database).

### `compact()` dengan variable tidak terdefinisi

Laravel `compact('var1', 'var2')` akan throw error kalau variable belum di-define. Pastikan semua variable yang di-compact memang ada di scope. (Bug pernah terjadi: `PicaV2Controller compact() refers undefined $buKode` — commit c79c445.)

### `dd()` / `dump()` / `var_dump()` di production code

Sebelum commit, scan blade & controller untuk debug helper yang tertinggal. Pakai `Log::info(...)` / `Log::error(...)` untuk persistent logging.

### Date filter tanpa default

UI filter tanggal **harus** default ke awal-bulan→hari-ini. Jangan kosong, jangan all-time. Lihat [conventions.md#1-default-date-range](conventions.md#1-default-date-range).

### Single-value category untuk BA

BA bisa multi-kategori/jenis/kasus. Jangan tambah kolom single-value baru di `Tr_Ba_Main_New`. Pakai pivot pattern. Lihat [ADR-001](decisions/001-ba-multi-kategori-pivot.md).

### Logika permission di view/blade

Logic akses harus di controller atau middleware, bukan di blade. Permission system ada di 4 tabel (lihat commit f616af7).

---

## 🔐 SENSITIVE AREAS — Perubahan butuh extra review

| Area | Sensitivitas |
|---|---|
| **Auth & permission system** (`LoginController`, `LoginCompanyController`, 4 tabel permission) | Bug di sini = security incident. Setiap perubahan butuh review manual + test multi-role. |
| **`.env` & kredensial** | Sudah ter-commit historis. Sebaiknya rotasi password + add ke .gitignore (belum dikerjakan — [caveats](caveats.md#env-ter-commit-di-repo)). |
| **Payroll & HR sensitif** | `tirt3038_HR_*` & `tirt3038_ERP` punya data gaji, NIK, identitas. Jangan log ke `storage/logs/` plain text. |
| **PICA — jawaban pelaku** (`tr_pica_jawaban`) | Legal-sensitive. Jawaban final dengan `is_final=true` + `signed_at` = formal statement, tidak bisa diedit pelaku (lihat [ADR-002](decisions/002-pica-v2-design.md) rule 10). Hanya PIC yang boleh unlock untuk emergency revert. |
| **BA `kronologi`** | Kolom legacy typo: `kronlogi` (bukan `kronologi`). Jangan rename — banyak query existing pakai nama lama. Reference: commit 148608c. |
| **Migrations** (`database/migrations/`) | Schema bisnis tidak fully mirror di sini — schema asli ada di DB produksi. Jangan asumsi `php artisan migrate:status` representatif. |
| **Modul existing yang sudah live** (BA, PICA, SP, Assessment, Rekrutmen) | Daily-ops tool, banyak user aktif. Tidak ada feature flag — perubahan langsung visible. Test di staging dulu. |

---

## ✅ AMAN DILAKUKAN TANPA KONFIRMASI

- Read file (Read, Grep, Glob)
- `php artisan route:list`, `php artisan tinker` untuk SELECT query
- Run dev server (`php artisan serve`)
- `npm run watch` / `npm run dev`
- Membuat file/folder baru di `docs/` (tidak ada hubungan ke runtime)
- Edit file di `docs/` (tidak mengubah behavior aplikasi)
- Edit code di file yang user secara eksplisit instruksikan
- Stage file (`git add`) — commit-nya tetap minta konfirmasi
- Branch lokal baru (`git checkout -b ...`)

---

## 📋 Checklist Sebelum Eksekusi Operasi Berisiko

1. ☐ Apakah ini di "TIDAK BOLEH" list di atas? Jika ya → STOP, minta konfirmasi user.
2. ☐ Apakah ada cara reversible? Pilih reversible kalau ada.
3. ☐ Apakah saya sudah baca dokumen relevan (caveats, conventions, workflow modul, ADR)?
4. ☐ Apakah saya sudah jelas state perubahan ke user sebelum eksekusi (plan-then-confirm)?
5. ☐ Apakah ada backup / rollback plan kalau salah?
6. ☐ Apakah operasi ini bisa visible ke user lain (push, PR comment, send Slack, dll.)?

Kalau ada salah satu yang nggak pasti — **tanya user dulu**.

---

## 🚨 Eskalasi

Kalau AI tidak yakin apakah suatu operasi aman atau tidak, **default ke MINTA KONFIRMASI**. Lebih baik tanya sekali dan benar, daripada eksekusi salah dan harus rollback live data.
