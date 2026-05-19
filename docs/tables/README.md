# Database Tables — Per Domain

Schema dump dari **DB produksi** tanggal 2026-05-19. File ini di-generate via `php Users\user\php82\dump_schema.php` — bila schema berubah, re-generate.

**Total tabel** di `tirt3038_HR_Worksheet`: 163. Di `tirt3038_ERP`: 11.

## Daftar Domain

- [Berita Acara (BA)](berita-acara.md) — 18 tabel
- [PICA — Problem Identification & Corrective Action](pica.md) — 6 tabel
- [Assessment / Penilaian Karyawan](assessment.md) — 21 tabel
- [Surat Peringatan (SP)](surat-peringatan.md) — 4 tabel
- [Rekrutmen & Kandidat](rekrutmen.md) — 31 tabel
- [Master Data](master-data.md) — 26 tabel
- [Meeting & Action Items](meeting.md) — 6 tabel
- [Report Security & Lain-lain](report-security.md) — 28 tabel
- [Sistem & Autentikasi](sistem.md) — 23 tabel
- [ERP Database](erp.md) — 11 tabel di `tirt3038_ERP`

## Catatan

- Estimasi `~N rows` diambil dari `information_schema.TABLES.TABLE_ROWS` (perkiraan, bukan exact count).
- Kolom **Keterangan** kosong bila tabel produksi tidak punya `COLUMN_COMMENT`. Pertimbangkan menambah comment ke schema untuk dokumentasi yang lebih kaya.
- File `_missed.txt` (bila ada) berisi tabel yang belum dikelompokkan.
