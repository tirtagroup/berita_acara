<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * ms_doc_workflow — in-app help/tutorial documentation untuk user.
 *
 * Single table denormalized: konten markdown di 1 kolom (semua step disatukan).
 * Grouping by modul (BA/PICA/MASTER/UMUM) + kategori (tutorial/faq/workflow).
 *
 * Public viewer di /help, admin CRUD di /master/doc-workflow.
 */
return new class extends Migration
{
    public function up()
    {
        Schema::create('ms_doc_workflow', function (Blueprint $t) {
            $t->id();
            $t->string('kode', 50)->unique()->comment('slug: ba-create, pica-meeting, dll');
            $t->enum('modul', ['BA', 'PICA', 'MASTER', 'UMUM'])->default('UMUM');
            $t->enum('kategori', ['tutorial', 'faq', 'workflow', 'troubleshooting'])->default('tutorial');
            $t->string('judul', 200);
            $t->string('ringkasan', 500)->nullable()->comment('1-2 kalimat preview');
            $t->longText('konten')->comment('Markdown body');
            $t->string('target_role', 50)->default('all')->comment('all, admin, creator, pic, dewan, pelaku');
            $t->integer('urutan')->default(0);
            $t->string('icon', 50)->nullable()->comment('boxicons class, mis. bx-edit');
            $t->boolean('active')->default(true);
            $t->string('created_by', 100)->nullable();
            $t->string('updated_by', 100)->nullable();
            $t->timestamps();

            $t->index(['modul', 'kategori', 'urutan'], 'idx_doc_workflow_grouping');
            $t->index('active');
        });

        // Seed 10 default tutorials
        $now = now();
        $rows = [
            [
                'kode' => 'ba-create',
                'modul' => 'BA',
                'kategori' => 'tutorial',
                'judul' => 'Cara Membuat BA Baru',
                'ringkasan' => 'Step-by-step wizard 6-step untuk submit Berita Acara.',
                'icon' => 'bx-edit',
                'urutan' => 10,
                'konten' => <<<MD
# Cara Membuat BA Baru

Akses **Menu → Berita Acara → Create (v2 Wizard)** atau langsung `/beritaacara/v2/create`.

## Step 1: Pilih Konteks
Pilih salah satu: **LAKA**, **FnB**, **OP_HR**, **REVISI**, atau **FMCG**. Konteks menentukan kategori mana yang relevan di step berikutnya.

## Step 2: Data Umum
- **Tanggal kejadian**: default hari ini
- **Lokasi & Cabang**: pilih dari dropdown (master ms_lokasi, ms_company)
- **Karyawan subject (pelaku)**: cari nama/kode karyawan via Select2 AJAX
- **Divisi**: auto-fill saat karyawan dipilih, bisa override
- **Deskripsi singkat**: max 500 karakter
- **Kronologi**: detail urutan kejadian — bisa tambah lebih dari 1 baris

## Step 3-6: Kategori per konteks
Step 3 Kategori Umum + step 4-6 (FnB/LAKA/REVISI) muncul sesuai konteks dipilih. Pilih kategori + opsi yang relevan.

## Step 7: Review & Submit
Cek semua data. Klik **Submit BA** → BA tersimpan di database + auto-trigger WhatsApp notification ke nomor yang ter-config.
MD,
            ],
            [
                'kode' => 'ba-edit',
                'modul' => 'BA',
                'kategori' => 'tutorial',
                'judul' => 'Edit BA — siapa boleh, kapan',
                'ringkasan' => 'Permission edit BA: admin always, creator hanya bila admin allow.',
                'icon' => 'bx-edit-alt',
                'urutan' => 20,
                'konten' => <<<MD
# Edit BA

## Permission
- **Admin / Super Admin**: SELALU bisa edit BA manapun
- **Creator (Rec_UserCreated)**: bisa edit bila admin sudah **Buka Edit untuk Creator** di BA tersebut
- **Lainnya**: read-only

## Cara akses edit
1. Buka detail BA: `/beritaacara/v2/show?kode=BA-XXX`
2. Kalau admin: lihat 2 tombol:
   - **"Edit BA"** (warna warning) → buka form edit
   - **"Buka edit untuk creator"** (toggle) → set edit_allowed=true
3. Klik **Edit BA** → form muncul

## Field yang bisa di-edit
- Tanggal BA
- Lokasi, Cabang
- Pelaku (karyawan)
- Divisi
- Deskripsi
- Kategori (multi-select)
- Kronologi (dynamic rows, bisa tambah/hapus)

## Field yang TIDAK bisa di-edit
- Kode BA (PK)
- Konteks
- Pelapor (audit trail)
- Cek* flags legacy (audit trail)
MD,
            ],
            [
                'kode' => 'pica-create',
                'modul' => 'PICA',
                'kategori' => 'tutorial',
                'judul' => 'Cara Membuat PICA Baru',
                'ringkasan' => 'Wizard 6-step untuk setup PICA Plan awal.',
                'icon' => 'bx-list-plus',
                'urutan' => 10,
                'konten' => <<<MD
# Cara Membuat PICA Baru

Akses **Menu → PICA → Create PICA (v2 Wizard)** atau `/pica/v2/create`.

## Step 1: Pilih Konteks
LAKA / FNB / OP_HR / REVISI / FMCG.

## Step 2: BA Link (opsional)
Pilih BA induk kalau PICA ini tindak-lanjut dari BA. Bisa skip kalau PICA standalone.

## Step 3: Data Umum
- **Pelaku**: cari nama/kode karyawan
- **Tanggal PICA**: default hari ini
- **Kapan terjadi**: tanggal kejadian (opsional)
- **Lokasi, Cabang, Status kejadian**: opsional
- **Problem note**: deskripsi singkat masalah (wajib)
- **Kategori PICA**: multi-checkbox

## Step 4: Participants
- **PIC**: otomatis = creator (Anda)
- **Dewan**: pilih multi user lain yang akan ikut diskusi (PIC + Dewan = facilitator)

## Step 5: Setup Pertanyaan
- **Wajib Universal**: auto-include (lock, dari master)
- **Bantuan**: pilih dari library master + toggle wajib_jawab
- **Bebas**: tambah pertanyaan custom

## Step 6: Review & Submit
PICA dibuat dengan status **PREPARING** (PICA Plan).
MD,
            ],
            [
                'kode' => 'pica-workflow',
                'modul' => 'PICA',
                'kategori' => 'workflow',
                'judul' => 'Workflow PICA: PREPARING → MEETING → FINALIZED → DONE',
                'ringkasan' => 'Penjelasan 4 fase PICA + transisi + permission per fase.',
                'icon' => 'bx-flow-chart',
                'urutan' => 5,
                'konten' => <<<MD
# Workflow PICA v4

```
DRAFT → PREPARING (PICA Plan) → MEETING → FINALIZED → DONE
```

## Fase 1: PREPARING (PICA Plan)
Persiapan async sebelum meeting.

**Yang dilakukan:**
- PIC: siapkan agenda pembahasan
- Dewan: bantu tambah pertanyaan
- Pelaku: akses untuk **siapkan draft jawaban** (belum final)
- Kronologi BA induk tampil read-only

**Trigger ke MEETING:** PIC klik **"Mulai Meeting PICA"**.

## Fase 2: MEETING (dokumentasi saat meeting)
Saat meeting fisik / WA call / video call. Semua role akses page yang sama, isi sesuai login.

**3 tab:**
1. **Q&A Forum** — Pelaku jawab pertanyaan + tandai is_final
2. **Catatan Meeting** — Hasil Meeting (PIC) + Catatan Pelaku (independen)
3. **Pernyataan Pelaku** — Formal statement, signable

**Gate ke FINALIZED:**
- ✓ Semua wajib_jawab is_final
- ✓ Hasil Meeting (PIC) terisi
- ✓ Pernyataan pelaku signed

## Fase 3: FINALIZED
Post-meeting. Akses report editor (sections A-G). PIC + Dewan susun corrective + preventive action. Pelaku read-only.

**Gate ke DONE:**
- ✓ ≥1 corrective + ≥1 preventive action
- ✓ Section G closure_date diisi
- ✓ Pernyataan pelaku signed

## Fase 4: DONE
Final. Set oleh PIC. `done_at + done_by` tercatat. Seluruh PICA permanent read-only.
MD,
            ],
            [
                'kode' => 'pica-meeting',
                'modul' => 'PICA',
                'kategori' => 'tutorial',
                'judul' => 'Conduct Meeting PICA',
                'ringkasan' => 'Step-by-step PIC menjalankan meeting PICA.',
                'icon' => 'bx-conversation',
                'urutan' => 20,
                'konten' => <<<MD
# Conduct Meeting PICA (untuk PIC)

## Sebelum meeting (Fase PREPARING)
1. Buka PICA discussion page
2. Isi **Agenda Pembahasan** (kolaborasi dengan Dewan)
3. Pastikan semua pertanyaan/pernyataan wajib sudah ditambah
4. Pelaku boleh draft jawaban awal

## Saat meeting (Fase MEETING)
1. Klik **"Mulai Meeting PICA"** → status berubah ke MEETING
2. **Tab Q&A Forum**: bahas tiap pertanyaan. Pelaku tulis jawaban + tandai sebagai **final**
3. **Tab Catatan Meeting**:
   - Anda (PIC): tulis di **Hasil Meeting** — poin pembahasan, keputusan
   - Pelaku: tulis di **Catatan Pelaku** — perspektif sendiri
4. **Tab Pernyataan Pelaku**: pelaku review/edit template pernyataan → klik **Tanda Tangan**
5. Cek gate (3 indicator hijau): wajib jawab + hasil + signed
6. Klik **"Selesai Meeting → FINALIZED"** → redirect ke Report editor

## Setelah meeting (Fase FINALIZED)
1. Susun corrective action (Section D) — siapa PIC, deadline
2. Susun preventive action (Section E)
3. Isi Section F (Verifikasi) + Section G (Closure date, approver)
4. Klik **"Set PICA → DONE"** → final
MD,
            ],
            [
                'kode' => 'pica-pelaku-guide',
                'modul' => 'PICA',
                'kategori' => 'tutorial',
                'judul' => 'Panduan untuk Pelaku PICA',
                'ringkasan' => 'Apa yang harus pelaku lakukan di PREPARING + MEETING.',
                'icon' => 'bx-user-voice',
                'target_role' => 'pelaku',
                'urutan' => 30,
                'konten' => <<<MD
# Panduan untuk Pelaku PICA

Sebagai **pelaku** di PICA, Anda perlu participate di 2 fase:

## Fase PREPARING (sebelum meeting)
- Buka link PICA: `/pica/v2/discussion?kode=PICA-XXX`
- Anda bisa lihat:
  - Kronologi kejadian (dari BA induk)
  - Agenda pembahasan yang disiapkan PIC + Dewan
  - List pertanyaan & pernyataan
- Anda **boleh tulis draft jawaban** di field jawaban tiap pertanyaan (belum final)
- Anda **belum boleh** klik "Tandai final" — itu hanya saat meeting

## Fase MEETING (saat meeting berlangsung)
PIC akan klik "Mulai Meeting" → tab muncul.

### Tab 1: Q&A Forum
Untuk setiap pertanyaan/pernyataan:
1. Tulis jawaban Anda di textarea
2. Klik tombol kirim (📤)
3. Klik **"Tandai final"** pada jawaban Anda → menjadi **jawaban final**
4. Khusus pernyataan (Setuju/Tidak Setuju): pilih sikap + reasoning

### Tab 2: Catatan Meeting
- Anda punya kolom **"Catatan Pelaku"** — boleh tulis catatan independen (perspektif sendiri)
- PIC tidak bisa edit catatan Anda

### Tab 3: Pernyataan Pelaku
1. Sistem pre-fill template pernyataan formal (sudah include nama, kode, kejadian)
2. Anda boleh **edit** sebelum tanda tangan
3. Klik **"Simpan Draft"** untuk save dulu (boleh edit lagi)
4. Klik **"Tanda Tangan Pernyataan"** → **locked**, tidak bisa edit lagi
5. Kalau salah tanda tangan: minta PIC klik **"Unlock"**

## Setelah meeting (FINALIZED + DONE)
Anda **read-only** — bisa lihat hasil PICA tapi tidak bisa edit. PIC + Dewan susun action plan.
MD,
            ],
            [
                'kode' => 'master-konteks',
                'modul' => 'MASTER',
                'kategori' => 'tutorial',
                'judul' => 'Manage Master Konteks',
                'ringkasan' => 'CRUD konteks (LAKA, FNB, OP_HR, REVISI, FMCG).',
                'icon' => 'bx-category',
                'target_role' => 'admin',
                'urutan' => 10,
                'konten' => <<<MD
# Master Konteks

**Konteks** = dimensi utama BA + PICA (sebelumnya disebut "Business Unit"). Contoh: LAKA, FNB, OP_HR, REVISI, FMCG.

## Akses
**Menu → Master Kategori BA → Daftar Konteks** atau `/master/konteks`

## Operasi
- **List**: tabel semua konteks dengan kode, nama, deskripsi, status
- **Tambah Konteks**: klik "+ Tambah Konteks" → form
  - Kode: UNIQUE, huruf besar + underscore (mis. `FMCG`, `OP_HR`)
  - Nama: nama lengkap (mis. "FMCG (Fast-Moving Consumer Goods)")
  - Deskripsi: opsional
  - Active: centang kalau aktif (muncul di wizard)
- **Edit**: klik ikon pensil
- **Toggle active**: klik ikon power → aktif/nonaktif

## Catatan
- Kode konteks **tidak boleh dihapus** setelah dipakai di BA/PICA (FK constraint)
- Nonaktif konteks = tetap di-show di list tapi tidak muncul di wizard create baru
- Konteks baru perlu di-mapping ke kategori via `/master/konteks-mapping`
MD,
            ],
            [
                'kode' => 'master-mapping',
                'modul' => 'MASTER',
                'kategori' => 'tutorial',
                'judul' => 'Setup Konteks × Kategori Mapping',
                'ringkasan' => 'Matrix mapping kategori per konteks dengan level wajib/disarankan/opsional.',
                'icon' => 'bx-grid-alt',
                'target_role' => 'admin',
                'urutan' => 20,
                'konten' => <<<MD
# Konteks × Kategori Mapping

## Akses
`/master/konteks-mapping` — matrix N kategori × M konteks.

## Cara kerja
- Tiap sel di matrix punya dropdown 4 pilihan:
  - **Wajib**: auto-checked di wizard BA, tidak bisa di-uncheck
  - **Disarankan**: ditampilkan highlighted (kuning), user boleh skip
  - **Opsional**: tersedia tapi tidak ditonjolkan
  - **— (None)**: tidak relevan, di-hide dari wizard
- Click dropdown → ganti level → **auto-save** via AJAX (no submit button)

## Best practice
- Tiap kategori minimal punya 1 konteks dengan level "Wajib"
- Kategori yang general (mis. PELANGGARAN_SOP) → "Opsional" di banyak konteks
- Kategori spesifik (mis. LAKA_PENYEBAB) → "Wajib" hanya di LAKA

## Related
- `/master/opsi-konteks-mapping` — mapping opsi langsung ke konteks (filter ekstra di wizard)
- `/master/cek-mapping` — mapping flag legacy Cek* ke kategori v2 (untuk artisan migrate)
MD,
            ],
            [
                'kode' => 'workflow-overview',
                'modul' => 'UMUM',
                'kategori' => 'workflow',
                'judul' => 'Overview Workflow: BA → PICA',
                'ringkasan' => 'Hubungan BA dan PICA, kapan eskalasi.',
                'icon' => 'bx-sitemap',
                'urutan' => 1,
                'konten' => <<<MD
# Overview Workflow BA → PICA

## Flow utama

```
[Karyawan/SPV] lapor kejadian
     │
     ▼
┌──────────────────────────────────┐
│  Submit BA (Berita Acara)        │
│  /beritaacara/v2/create          │
│  - Tanggal, lokasi, pelaku       │
│  - Kategori (multi)              │
│  - Kronologi                     │
└────────────┬─────────────────────┘
             │
             ▼
        [BA tersimpan]
             │
             │ Otomatis WhatsApp notif
             │
             ▼
        [Review BA] di /beritaacara/v2/dashboard
             │
             ├─→ Tidak perlu PICA → done
             │
             └─→ Perlu investigation lebih dalam
                          │
                          ▼
              ┌────────────────────────────────┐
              │ Buat PICA tindak-lanjut         │
              │ "Buat PICA dari BA ini" button  │
              │ /pica/v2/create?ba_code=BA-XXX  │
              └────────────┬───────────────────┘
                           │
                           ▼
              [PICA workflow: PREPARING → MEETING → FINALIZED → DONE]
                           │
                           ▼
                  [Corrective + Preventive Action]
```

## Kapan eskalasi ke PICA?
PICA dipakai kalau:
- Perlu **root cause analysis** (5 Why, 4M+1E)
- Perlu **multi-participant discussion** (PIC + Dewan + Pelaku)
- Perlu **formal pernyataan** dari pelaku
- Perlu **structured corrective + preventive action plan**

Untuk BA ringan (mis. revisi data, info), cukup di-CLOSE di BA saja tanpa PICA.

## Lihat detail
- [Cara Buat BA Baru](/help/ba-create)
- [Cara Buat PICA Baru](/help/pica-create)
- [Workflow PICA Detail](/help/pica-workflow)
MD,
            ],
            [
                'kode' => 'faq-umum',
                'modul' => 'UMUM',
                'kategori' => 'faq',
                'judul' => 'FAQ Umum',
                'ringkasan' => 'Pertanyaan yang sering ditanyakan.',
                'icon' => 'bx-question-mark',
                'urutan' => 100,
                'konten' => <<<MD
# FAQ Umum

## Q: BA yang sudah saya submit kok tidak muncul di dashboard?
**A:** Cek 3 hal:
1. Range tanggal filter — default awal bulan ini → hari ini. Kalau Date_BA di luar range, tidak muncul.
2. Tab yang aktif — Overview menampilkan semua. Tab konteks (LAKA/FnB/dll) hanya menampilkan BA dari konteks itu.
3. Hard refresh browser (Ctrl+Shift+R) — browser kadang cache page lama.

## Q: Saya admin tapi tombol "Edit BA" tidak muncul?
**A:** Cek `users.role` Anda di DB. Helper isAdmin() recognize: 'admin', 'super_admin', 'superadmin', 'administrator'. Case-insensitive. Kalau role beda (mis. 'manager'), tombol tidak muncul.

## Q: PICA sudah meeting tapi tombol "Selesai Meeting" disabled?
**A:** Cek gate (3 indicator di header):
- Semua wajib_jawab harus is_final (pelaku tandai final)
- Hasil Meeting (PIC) tidak boleh kosong (PIC isi)
- Pernyataan pelaku harus signed (pelaku klik Tanda Tangan)

Kalau ada yang masih ❌, lengkapi dulu.

## Q: Saya bukan participant tapi mau lihat PICA?
**A:** Saat ini akses PICA discussion **strict participant only** (PIC/Dewan/Pelaku). Kalau perlu view-only untuk auditor, mintakan ditambah sebagai Dewan.

## Q: WhatsApp notification BA tidak ke-kirim?
**A:** Cek:
- `.env` variable WA_QONTAK_* terisi
- Cek log `storage/logs/laravel.log` → cari "WA notification gagal" message
- Token Qontak masih valid (cek di dashboard Qontak)

## Q: Cek* flag legacy harus di-migrate ke kategori v2?
**A:** Iya untuk konsistensi. Run di terminal:
```
php artisan ba:migrate-cek-flags --dry-run    # preview
php artisan ba:migrate-cek-flags --force      # eksekusi
```
Mapping diatur di `/master/cek-mapping`.
MD,
            ],
        ];

        foreach ($rows as $row) {
            DB::table('ms_doc_workflow')->insert(array_merge($row, [
                'target_role' => $row['target_role'] ?? 'all',
                'active'      => true,
                'created_by'  => 'system',
                'created_at'  => $now,
                'updated_at'  => $now,
            ]));
        }
    }

    public function down()
    {
        Schema::dropIfExists('ms_doc_workflow');
    }
};
