# WhatsApp Integration — Status & Planned Features

**Provider**: Mekari Qontak Omnichannel API
**Last updated**: 2026-05-27
**Status**: ⚠️ Code ready, credentials BELUM diset (config kosong di `.env`)

---

## Current state

### Komponen yang sudah ada

| Komponen | Path | Status |
|---|---|---|
| Service class | [`app/Services/WaQontakService.php`](../app/Services/WaQontakService.php) | ✅ Ready |
| Auto-trigger saat BA submit | [`BeritaAcaraV2Controller::store`](../app/Http/Controllers/BeritaAcaraV2Controller.php) (line 948 "Notifikasi WhatsApp" block) | ✅ Ready (silent fail kalau credentials kosong) |
| Test command | `php artisan wa:make-template` | ✅ Buat template baru di Qontak |
| Test command | `php artisan wa:qontak:test` | ✅ Kirim notif uji ke nomor di `WA_QONTAK_NUMBERS` |

### Config keys (di `.env`)

```env
WA_QONTAK_TOKEN=                       # Bearer token Qontak (kosong = belum aktif)
WA_QONTAK_REFRESH_TOKEN=               # Refresh token
WA_QONTAK_CHANNEL_INTEGRATION_ID=      # Channel Integration ID
WA_QONTAK_SENDER_NUMBER=               # Nomor WA bisnis pengirim
WA_QONTAK_TEMPLATE_ID=                 # UUID Message Template (approved Meta)
WA_QONTAK_NUMBERS=                     # Penerima default, comma-separated
WA_QONTAK_VERIFY_SSL=true              # default true
```

### Setup steps (untuk activate)

1. Login Mekari Qontak dashboard
2. Get Bearer token, channel integration ID, sender number
3. Create message template: `php artisan wa:make-template` (auto-update `.env`) atau via dashboard manual
4. Wait Meta approval (~1-24 jam)
5. Update `.env` dengan 5 keys
6. Verify: `php artisan config:clear && php artisan wa:qontak:test`

⚠️ **Golden Rule**: edit `.env` hanya boleh oleh user / IT, bukan AI agent.

---

## Planned Features

### F1. WA Share button di BA detail page

**Status**: 🟡 Planned, belum di-implement
**Requested**: 2026-05-27
**URL target**: `/beritaacara/v2/show?kode={kode}` (`berita-acara-v2.show`)

**Spec**:

Tambah action button di header BA detail page (sebelah tombol Edit / Print):

```
[Send to WA Group]  ← button baru
```

**Behavior saat di-click**:
- Buka modal/dropdown dengan pilihan:
  - **A. Kirim isi BA (text)** → Format pesan dengan content dari BA: kode, tanggal, pelaku, deskripsi, kronologi, kategori, dst. **Plus link** ke BA detail page (mis. `https://ba.tirtagroup.net/beritaacara/v2/show?kode={kode}`).
  - **B. Kirim screenshot + link** → Generate screenshot/PDF dari BA detail page (pakai library headless browser / mPDF), attach ke pesan WA, plus link.

**Recipient**:
- Default: WA group(s) yang sudah dikonfigurasi di `WA_QONTAK_NUMBERS` (atau env terpisah `WA_QONTAK_GROUP_IDS`)
- Atau: input manual nomor / group ID di modal saat klik (untuk one-off share)

**Schema tambahan yang mungkin perlu**:
- Tidak perlu DB change kalau pakai env config saja
- Atau: tabel `ms_wa_recipient` (group_id, nama, kategori_recipient: BA_general / FNB_only / LAKA_only / dll.) untuk routing dinamis

**Implementation outline** (saat akan dibangun):
1. Add `Route::post('/beritaacara/v2/{kode}/share-wa', [BeritaAcaraV2Controller::class, 'shareToWa'])` di routes
2. Method `shareToWa()` di controller — format pesan, panggil `WaQontakService::send()`
3. Add button + modal di [`resources/views/berita_acara_v2/show.blade.php`](../resources/views/berita_acara_v2/show.blade.php)
4. (Opsional B) Add screenshot generator — pakai `barryvdh/laravel-snappy` (wkhtmltopdf) atau headless Chrome via `spatie/browsershot`
5. Permission check: hanya user dengan `level_id` certain yang bisa kirim (security policy — avoid spam)

**Open questions** sebelum implement:
- Format pesan WA: full content text, atau ringkas + link saja?
- Recipient model: hardcode di env vs configurable per BA konteks?
- Quota Qontak / template approval — message template baru untuk BA share, atau pakai template existing `berita_acara_baru`?
- Audit log: log siapa kirim WA, kapan, ke mana? (mirip `tr_ba_kategori_d` log pattern)
- Rate limiting: prevent spam — mis. max 5 share per user per jam?

**Effort estimate**: ~4-6 jam
- 1 jam: design + open Q resolution
- 1 jam: controller method + route
- 2 jam: UI button + modal + format pesan
- 1 jam: (opsional) screenshot generator integration
- 30 menit: test + edge case

**Dependencies**:
- WA Qontak credentials ter-setup di `.env` (precondition)
- Message template approved Meta (kalau pakai template baru)

---

## Trigger points existing

### Auto-notif saat BA di-submit

Di [`BeritaAcaraV2Controller::store`](../app/Http/Controllers/BeritaAcaraV2Controller.php) line 948+:

```php
// ── Notifikasi WhatsApp ──────────────────────────────────────────
// Kumpulkan data tambahan (lookup nama, cabang, lokasi, kategori)
// Gagal tidak membatalkan penyimpanan BA
try {
    // Nama karyawan (subject) — cross-DB ke mysql_new
    $erpDbName = config('database.connections.mysql_new.database');
    $empName = DB::table("{$erpDbName}.Ms_User_Emp")
        ->where('Ms_Emp_Code', $request->emp_code)
        ->value('Emp_Name') ?? $request->emp_code;
    // ... format pesan + panggil WaQontakService::send()
} catch (\Throwable $e) {
    Log::warning('Notif WA gagal: ' . $e->getMessage());
}
```

**Trigger**: Setiap BA baru sukses di-store.
**Recipient**: Nomor di `WA_QONTAK_NUMBERS` (kosong saat ini → silent skip).
**Template**: `berita_acara_baru` (UUID di `WA_QONTAK_TEMPLATE_ID`).
**Failure mode**: Silent (log warning, BA tetap tersimpan).

---

## Related docs

- [`config/services.php`](../config/services.php) — `wa_qontak` section (config structure)
- [`app/Services/WaQontakService.php`](../app/Services/WaQontakService.php) — service class + Qontak API endpoint
- [Mekari Qontak docs](https://docs.qontak.com) (external)
- [WhatsApp Business Message Template guidelines](https://developers.facebook.com/docs/whatsapp/message-templates/guidelines/) (Meta requirements)
