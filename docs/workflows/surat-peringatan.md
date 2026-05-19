# Workflow: Surat Peringatan (SP)

## Tujuan
Workflow disipliner: menerbitkan Surat Peringatan kepada karyawan atas pelanggaran (biasanya hasil tindak lanjut dari BA).

## Role 🟡 ASUMSI

| Role | Peran |
|---|---|
| **HRD** | Membuat SP, set tipe, kirim ke karyawan & atasan |
| **Atasan / Manager** | Approval SP sebelum diterbitkan |
| **Karyawan** | Menerima SP (tanda terima/acknowledgment) |

## Tipe SP (dari master `ms_type_sp`) 🟡 ASUMSI

| Kode | Tipe | Tingkat |
|---|---|---|
| SP1 | Surat Peringatan 1 | Ringan |
| SP2 | Surat Peringatan 2 | Sedang |
| SP3 | Surat Peringatan 3 | Berat (sebelum PHK) |
| SP-PHK | Pemutusan Hubungan Kerja | Terberat |

Nilai aktual perlu dicek di `ms_type_sp` di DB produksi.

## Alur Utama 🟡 ASUMSI

```
[HRD]
    │ 1. Input data SP baru
    │    - Karyawan target
    │    - Type SP (1/2/3/PHK)
    │    - Alasan / pelanggaran (link ke BA?)
    │    - Tanggal berlaku
    ▼
┌────────────────────┐
│ tr_acc_sp_main     │  (header SP)
│ tr_acc_sp_h        │  (header alternatif?)
│ tr_acc_sp_d        │  (detail/multi-pelanggaran)
└────────────────────┘
    │
    │ 2. Submit ke approval atasan
    ▼
[Manager approval]
    │
    ├─→ Approve ──→ SP terbit, dicetak
    │
    └─→ Reject ──→ batal / revisi
    │
    ▼
[Karyawan menerima SP — tanda tangan]
    │
    │ 3. (Bila SP-PHK) trigger workflow PHK
    ▼
[PutusHubunganKerjaController]
```

## Tabel yang Ter-update

Lihat detail kolom di [docs/tables/surat-peringatan.md](../tables/surat-peringatan.md).

| Tabel | Operasi |
|---|---|
| `ms_type_sp` | (master, read-only) |
| `tr_acc_sp_main` | INSERT (header SP) |
| `tr_acc_sp_h` | INSERT (header alternatif?) |
| `tr_acc_sp_d` | INSERT (detail per pelanggaran) |

## Route & Controller

Controller: `Tr_Sp_Controller`, `MS_Type_SP_Controller` (master), `PutusHubunganKerjaController` (untuk PHK).

URL pattern: `/sp/*`, `/ms_type_sp/*`.

## Hubungan dengan BA & PICA

- SP biasanya **konsekuensi** dari BA yang terverifikasi sebagai pelanggaran.
- Link tracking dari `Tr_Ba_Main_New` ke `tr_acc_sp_*` perlu dikonfirmasi (kolom FK?).

## Edge Case 🟡 ASUMSI

- **SP tumpang tindih**: bila karyawan dapat SP2 lalu pelanggaran lagi, otomatis naik SP3 atau independent?
- **Masa berlaku SP**: ada expiry? (mis. SP1 hilang dari catatan setelah 1 tahun?)
- **PHK**: trigger workflow separate atau bagian dari SP-PHK?

---

> **Action item**: Tim HRD mohon konfirmasi tipe SP, alur approval, dan masa berlaku.
