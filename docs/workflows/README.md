# Workflow / Alur Bisnis

Dokumentasi alur kerja untuk setiap modul utama BA-PICA. File-file di folder ini menjelaskan **urutan langkah**, **role yang terlibat**, **status data**, dan **tabel yang berubah** untuk setiap proses bisnis.

## Daftar Workflow

| Modul | File | Status Doc |
|---|---|---|
| Berita Acara | [berita-acara.md](berita-acara.md) | Skeleton — perlu validasi tim |
| PICA | [pica.md](pica.md) | Skeleton |
| Assessment | [assessment.md](assessment.md) | Skeleton |
| Surat Peringatan | [surat-peringatan.md](surat-peringatan.md) | Skeleton |
| Rekrutmen | [rekrutmen.md](rekrutmen.md) | Skeleton |
| Login per Perusahaan | [login-company.md](login-company.md) | Skeleton |

## Konvensi Penulisan Workflow

Setiap file workflow sebaiknya berisi:

1. **Tujuan modul** — singkat, 1-2 kalimat
2. **Role yang terlibat** — siapa saja (Karyawan, Supervisor, HRD, GM, BOD, IT, dll.)
3. **Alur utama** — diagram teks (ASCII art) atau bullet list bertingkat
4. **Status data** — daftar nilai status & perpindahannya
5. **Tabel yang ter-update** — referensi ke [`docs/tables/`](../tables/)
6. **Route & controller terkait** — referensi ke [`docs/routes.md`](../routes.md)
7. **Trigger email / notifikasi** (bila ada)
8. **Edge case** — apa yang terjadi jika revisi, reject, timeout, dll.

> **Catatan**: File-file ini di-bootstrap berdasarkan **deduksi dari kode** (nama controller, view, model). Detail alur bisnis sebenarnya **perlu dikonfirmasi dengan tim HR/IT Tirta Group**. Bagian yang masih asumsi ditandai dengan `🟡 ASUMSI` — mohon di-update setelah review.
