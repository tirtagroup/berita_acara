<?php

namespace App\Console\Commands;

use App\Services\WaQontakService;
use Illuminate\Console\Command;

/**
 * Artisan command untuk menguji pengiriman notifikasi WhatsApp via Qontak.
 *
 * Penggunaan:
 *   php artisan wa:qontak:test
 *   php artisan wa:qontak:test --ba_code=BA-2024-001 --number=628XXXXXXXXX
 *
 * Jika --number diberikan, hanya nomor tersebut yang dikirim (override .env).
 */
class WaQontakTestSend extends Command
{
    protected $signature = 'wa:qontak:test
                            {--ba_code=BA-TEST-001    : Kode BA yang akan dikirim}
                            {--number=                : Override nomor tujuan (opsional)}';

    protected $description = 'Kirim notifikasi WA Qontak test menggunakan data dummy BA';

    public function handle(WaQontakService $service): int
    {
        $baCode = $this->option('ba_code');
        $number = $this->option('number');

        $dummyBa = [
            'ba_code'   => $baCode,
            'bu_kode'   => 'TG-PUSAT',
            'tanggal'   => now()->format('d-m-Y H:i'),
            'pelapor'   => 'Admin Test',
            'emp_name'  => 'Karyawan Uji Coba',
            'emp_div'   => 'Divisi IT',
            'cabang'    => 'Head Office Jakarta',
            'lokasi'    => 'Gedung Utama Lt. 3',
            'deskripsi' => 'Ini adalah pesan uji coba pengiriman notifikasi WhatsApp dari sistem BA-PICA Tirta Group.',
            'kategori'  => 'Test Notifikasi',
            'kronologi' => 'Command artisan dijalankan secara manual untuk memverifikasi integrasi WA Qontak berjalan dengan benar.',
        ];

        // Jika --number diberikan, sementara override env numbers
        if ($number) {
            $this->info("Override nomor tujuan: {$number}");
            config(['services.wa_qontak.numbers' => $number]);
        }

        $this->info("Mengirim notifikasi BA [{$baCode}] ke Qontak...");

        $service->sendBaNotification($dummyBa);

        $this->info('Selesai. Cek storage/logs/laravel.log untuk detail respon.');

        return self::SUCCESS;
    }
}
