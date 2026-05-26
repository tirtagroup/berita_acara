# ADR-008: Drop Level (Wajib/Disarankan/Opsional) di Konteks-Kategori Mapping

**Status**: 🟡 Proposed
**Date**: 2026-05-25
**Decider**: user (Charles)
**Supersedes part of**: [ADR-006](006-konteks-renamed-from-bu.md) (level mechanism)

## Context

Tabel `ms_konteks_kategori_mapping` (junction `ms_konteks × ms_ba_kategori`) saat ini punya kolom `level` ENUM dengan 3 nilai:

- **`wajib`** — auto-check + locked di form BA wizard (user tidak bisa uncheck)
- **`disarankan`** — highlighted di UI (UX hint)
- **`opsional`** — available, user pilih bebas

Konteks tanpa entry di mapping = kategori hidden untuk konteks itu.

### Data state sekarang

Dari 35 mapping ter-seed (per [docs/categories.md](../categories.md)):

| Level | Count | Contoh |
|---|---|---|
| `wajib` | 5 | LAKA→Laka Penyebab, FNB→Logistik, FNB→Kualitas Makanan, FNB→Pelayanan, FNB→Disiplin Operasional |
| `disarankan` | ~13 | LAKA→Pelanggaran SOP, FNB→Komplain Customer, semua OP_HR→{Pelanggaran SOP, Fraud, ...} |
| `opsional` | ~17 | Sisanya |

### Problem yang muncul

1. **Maintenance overhead admin** — admin matrix UI butuh 3-radio per cell (W/D/O + hidden), 3× lebih sulit dibanding 1-checkbox.

2. **Behavior "Wajib auto-check + lock" terlalu kaku** — manager kadang punya kasus legitimate untuk uncheck "wajib" tapi tidak bisa override. Workaround: assign konteks lain → tapi semantic-nya salah.

3. **"Disarankan" UX hint tidak terbukti dipakai** — tidak ada feedback bahwa highlight ini benar-benar guide user; sebagian besar manager pilih kategori berdasarkan kebutuhan kasus aktual, bukan ikut hint.

4. **Schema kompleksitas tidak ter-justify** — 3-state ENUM untuk fitur yang sebenarnya bisa 2-state (available / not).

5. **Cognitive load** — saat add konteks baru (mis. REVISI, FMCG yang sudah dimasuk tapi belum di-map), admin harus memikirkan W/D/O level untuk setiap kombinasi kategori — friction yang mencegah completion.

## Decision

**Drop kolom `level` dari `ms_konteks_kategori_mapping`. Mapping jadi boolean murni** (presence/absence of row).

- Row ada di mapping = kategori muncul di konteks itu (available, opsional)
- Row tidak ada = kategori hidden untuk konteks itu

**Tidak ada mekanisme pengganti** untuk "wajib auto-check". Semua kategori applicable jadi opsional. Manager pilih manual.

**Tidak ada mekanisme pengganti** untuk "disarankan highlight". UI cuma show available categories.

Konsekuensi business:
- ✅ Manager bebas pilih kategori sesuai kasus actual, tanpa lock yang mengganggu
- ❌ Risiko manager lupa pilih kategori yang seharusnya wajib (mis. BA FNB tanpa Kualitas Makanan)
- Mitigasi: validasi kontekstual di app layer kalau ada concern bisnis spesifik (mis. "BA konteks FNB harus punya minimal 1 dari [Logistik, Kualitas Makanan, Pelayanan, Disiplin Operasional]"). **Belum implement di T1 refactor — tunggu feedback**.

## Alternatives Considered

### A. Pertahankan W/D/O current
- ❌ Rejected: overhead maintenance + locked behavior terlalu kaku per problem #1, #2

### B. Boolean + kolom `is_default_checked` (replace W → default checked tapi unlockable)
- ❌ Rejected (user pilih simpler): hilangkan "wajib" auto-check sekaligus. Kalau ada kebutuhan ingat-ingatan, pakai validasi bisnis di app layer terpisah.

### C. Boolean + tabel terpisah `ms_konteks_kategori_default`
- ❌ Rejected: 2 tabel untuk 1 konsep over-engineered

### D. Soft-deprecate level tapi keep column nullable
- ❌ Rejected: dead column = dead code path, tidak clean

## Consequences

### Plus ✅
- Schema lebih simpel (drop 1 kolom + drop ENUM constraint)
- Admin UI lebih simpel (1 checkbox vs 3 radio per cell)
- App logic lebih simpel (no `ORDER BY FIELD(level, ...)`, no domain calc via wajib)
- Onboarding admin baru lebih cepat (tidak harus mempelajari W/D/O semantics)
- Cocok untuk konteks baru (REVISI, FMCG) yang mappings-nya belum lengkap — boolean lebih cepat di-fill

### Minus ❌
- Behavior auto-check "Wajib" hilang — risiko data BA tidak konsisten (mis. BA FNB tanpa kategori operasional FnB)
- "Disarankan" hint hilang — UX tidak ada lagi guidance prioritas
- Data history Wajib/Disarankan tidak bisa di-recover otomatis kalau rollback migration (down() set semua jadi 'opsional')

### Risks ⚠️

| Risk | Mitigasi |
|---|---|
| Manager lupa pick kategori yang seharusnya wajib → data BA jadi tidak consistent | Tambah validasi bisnis di app layer untuk konteks yang punya "minimum kategori" requirement. Implementasi: terpisah dari migration ini. Atau training admin. |
| Production data hilang kalau migration di-rollback | Manual backup `ms_konteks_kategori_mapping` (32 row, kecil) sebelum migrate. Down migration tidak restore original level — hanya add column ENUM dengan default 'opsional'. |
| Code change tidak sinkron — migration jalan tapi controller masih `SELECT m.level` | Migration + code change harus di-deploy bersamaan. List code change di [Implementation](#implementation). |
| User Tirta expect behavior auto-check, lalu kaget data BA mulai inconsistent | Komunikasi: announcement ke user setelah deploy. Atau pilot dengan 1 outlet dulu sebelum global rollout. |

## Implementation

### Step 1 — Migration (FILE SUDAH DIBUAT)

`database/migrations/2026_05_25_120000_drop_level_from_ms_konteks_kategori_mapping.php`

```php
public function up()
{
    Schema::table('ms_konteks_kategori_mapping', function (Blueprint $table) {
        $table->dropColumn('level');
    });
}
```

**Sebelum jalan**:
```sql
-- Backup data Wajib/Disarankan untuk audit history
CREATE TABLE _backup_ms_konteks_kategori_mapping_2026_05_25 AS
SELECT * FROM ms_konteks_kategori_mapping;
```

**Lalu**:
```bash
php artisan migrate
```

### Step 2 — Code changes (BELUM DI-EKSEKUSI — USER YANG REVIEW + RUN)

#### File 1: `app/Models/KonteksKategoriMapping.php`

```diff
- protected $fillable = [
-     'konteks_id',
-     'kategori_id',
-     'level',
- ];
+ protected $fillable = [
+     'konteks_id',
+     'kategori_id',
+ ];

- const LEVELS = ['wajib', 'disarankan', 'opsional'];
```

#### File 2: `app/Http/Controllers/BeritaAcaraV2Controller.php`

Line 617–648 (sekitar method `getKategoriForKonteks` atau sejenisnya):

```diff
  $rows = DB::table('ms_ba_kategori as k')
              ->join('ms_konteks_kategori_mapping as m', function ($j) use ($konteks) {
                  $j->on('m.kategori_id', '=', 'k.id')
                    ->where('m.konteks_id', '=', $konteks->id);
              })
              ->where('k.active', true)
-             ->select('k.id', 'k.kode', 'k.nama', 'm.level')
-             ->orderByRaw("FIELD(m.level, 'wajib', 'disarankan', 'opsional')")
+             ->select('k.id', 'k.kode', 'k.nama')
              ->orderBy('k.nama')
              ->get();

- // Compute domain per kategori berdasarkan konteks mana yang punya level WAJIB.
- $wajibByKategori = DB::table('ms_konteks_kategori_mapping as m')
-     ->join('ms_konteks as k', 'm.konteks_id', '=', 'k.id')
-     ->where('m.level', 'wajib')
-     ->select('m.kategori_id', 'k.kode')
-     ->get()
-     ->groupBy('kategori_id');
-
- foreach ($rows as $r) {
-     $domain = $wajibByKategori[$r->id] ?? collect();
-     if ($domain->count() === 1) {
-         $r->domain = $domain->first()->kode;
-     } else {
-         $r->domain = 'UMUM';
-     }
-     $r->level = $r->level ?? 'opsional';
- }
+ // Domain calculation removed — semua kategori opsional. UI tidak perlu kategorisasi
+ // "FNB" / "LAKA" / "UMUM" berbasis wajib lagi.
```

> Catatan: kalau ada UI yang masih butuh `domain` (mis. group kategori di wizard), bisa derive dari sumber lain (mis. konteks yang user pilih) atau drop fitur grouping.

#### File 3: `app/Http/Controllers/MasterKategoriController.php`

```diff
  return view('master.kategori.form', [
      'parentOptions' => $parentOptions,
      'availableKonteks'   => $availableKonteks,
-     'allLevels'     => KonteksKategoriMapping::LEVELS,
  ]);
```

Method `kategoriBuUpsert`:

```diff
- $request->validate([
-     'konteks_id' => ['required', 'integer', 'exists:ms_konteks,id'],
-     'level' => ['required', 'string', 'in:wajib,disarankan,opsional'],
- ]);
-
- KonteksKategoriMapping::updateOrCreate(
-     ['konteks_id' => $request->konteks_id, 'kategori_id' => $id],
-     ['level' => $request->level]
- );
+ $request->validate([
+     'konteks_id' => ['required', 'integer', 'exists:ms_konteks,id'],
+ ]);
+
+ KonteksKategoriMapping::firstOrCreate([
+     'konteks_id' => $request->konteks_id,
+     'kategori_id' => $id,
+ ]);
```

Method matrix upsert (sekitar line 290):

```diff
  $request->validate([
      'konteks_id'        => ['required', 'integer', 'exists:ms_konteks,id'],
      'kategori_id'  => ['required', 'integer', 'exists:ms_ba_kategori,id'],
-     'level'        => ['required', 'string', 'in:wajib,disarankan,opsional,none'],
+     'aktif'        => ['required', 'boolean'],  // true = create, false = delete
  ]);

- if ($request->level === 'none') {
+ if (!$request->aktif) {
      KonteksKategoriMapping::where('konteks_id', $request->konteks_id)
          ->where('kategori_id', $request->kategori_id)
          ->delete();
      return ...;
  }

- KonteksKategoriMapping::updateOrCreate(
-     ['konteks_id' => $request->konteks_id, 'kategori_id' => $request->kategori_id],
-     ['level' => $request->level]
- );
+ KonteksKategoriMapping::firstOrCreate([
+     'konteks_id' => $request->konteks_id,
+     'kategori_id' => $request->kategori_id,
+ ]);
```

#### File 4: `resources/views/master/konteks_kategori_mapping/index.blade.php`

Replace 3-radio (W/D/O/none) per cell dengan single checkbox:
```diff
- <select name="level" class="form-select form-select-sm">
-   <option value="none">— hidden —</option>
-   <option value="wajib">Wajib</option>
-   <option value="disarankan">Disarankan</option>
-   <option value="opsional">Opsional</option>
- </select>
+ <input type="checkbox" name="aktif"
+        @if($mapping) checked @endif
+        data-konteks-id="{{ $konteks->id }}"
+        data-kategori-id="{{ $kategori->id }}"
+        class="form-check-input" />
```

(Implementasi exact tergantung struktur Blade existing — user yang adjust)

#### File 5: `resources/views/berita_acara_v2/wizard.blade.php`

Hapus:
- Auto-check + disabled-attribute untuk kategori dengan `level=wajib`
- Badge/icon "Wajib" / "Disarankan" di setiap kategori option
- Sorting by level

Setelah refactor:
- Semua kategori tampil sebagai checkbox bebas
- Urutan by `nama` atau `sort_order` (kalau ada)

#### File 6: `app/Console/Commands/CheckDocsSchemaCommand.php`

Update kalau ada expectation kolom `level` di tabel `ms_konteks_kategori_mapping`.

### Step 3 — Rollout sequence (recommended)

1. **Backup**: `CREATE TABLE _backup_ms_konteks_kategori_mapping_2026_05_25 AS SELECT * FROM ms_konteks_kategori_mapping;`
2. **Staging test**: Run migration + apply code changes di local/staging. Verify:
   - Admin matrix UI works (checkbox)
   - BA wizard tampilkan kategori tanpa auto-check
   - No PHP error reference ke `->level`
3. **Production deploy**:
   - Tag commit pre-refactor sebagai `pre-konteks-level-drop`
   - Deploy code + migrate dalam window maintenance
   - Verify smoke test (open BA wizard, submit BA test, open admin matrix)
4. **Announcement**: kabari user FnB ops bahwa kategori tidak auto-check lagi → "harap pilih manual"
5. **Monitoring**: 2 minggu setelah deploy, cek data BA — apakah ada drop "kategori X tidak di-pick" yang seharusnya wajib? Kalau ya, tambah validasi bisnis di app layer.

## Related

- [ADR-006](006-konteks-renamed-from-bu.md) — rename Business Unit → Konteks (level mechanism dipertahankan di ADR-006, sekarang superseded sebagian oleh ADR-008)
- Schema doc: [docs/categories.md](../categories.md) (akan di-update setelah migration jalan)
- Migration file: `database/migrations/2026_05_25_120000_drop_level_from_ms_konteks_kategori_mapping.php`
- BA wizard: [docs/workflows/berita-acara.md](../workflows/berita-acara.md)
