<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class WaMakeTemplate extends Command
{
    private const BASE_URL     = 'https://service-chat.qontak.com';
    private const TEMPLATE_KEY = 'berita_acara_baru';

    protected $signature   = 'wa:make-template';
    protected $description = 'Buat WhatsApp Message Template berita_acara_baru di Qontak via API';

    public function handle(): int
    {
        $token = config('services.wa_qontak.token');

        if (!$token) {
            $this->error('WA_QONTAK_TOKEN kosong di .env.');
            return self::FAILURE;
        }

        $this->info('─── Membuat WhatsApp Message Template ───');
        $this->newLine();

        $payload = [
            'name'          => self::TEMPLATE_KEY,
            'language_code' => 'id',
            'category'      => 'UTILITY',
            'header'        => [
                'format' => 'TEXT',
                'text'   => 'BERITA ACARA BARU',
            ],
            'body'          => implode("\n", [
                'No BA: {{1}}',
                'Business Unit: {{2}}',
                'Tanggal: {{3}}',
                '',
                'Pelapor: {{4}}',
                'Subject: {{5}}',
                'Divisi: {{6}}',
                'Cabang: {{7}}',
                'Lokasi: {{8}}',
                '',
                'Deskripsi:',
                '{{9}}',
                '',
                'Kategori:',
                '{{10}}',
                '',
                'Kronologi:',
                '{{11}}',
            ]),
            'footer'        => 'BA-PICA Tirta Group',
        ];

        $this->line('Nama template : ' . self::TEMPLATE_KEY);
        $this->line('Bahasa        : id (Indonesia)');
        $this->line('Kategori      : UTILITY');
        $this->newLine();

        $this->info('Mengirim ke Qontak API...');

        try {
            $resp = Http::withToken($token)
                ->timeout(15)
                ->post(self::BASE_URL . '/api/open/v1/message_templates', $payload);

            $this->line('HTTP Status : ' . $resp->status());
            $this->line('Response    : ' . $resp->body());
            $this->newLine();

            if ($resp->successful()) {
                $data       = $resp->json();
                $templateId = data_get($data, 'data.id', data_get($data, 'id'));

                if ($templateId) {
                    $this->info('✓ Template berhasil dibuat!');
                    $this->line("  Template ID : {$templateId}");
                    $this->newLine();
                    $this->warn('Update .env sekarang:');
                    $this->line("  WA_QONTAK_TEMPLATE_ID={$templateId}");
                    $this->line('Lalu jalankan: php artisan config:clear');

                    // Auto-tulis ke .env jika confirm
                    if ($this->confirm('Otomatis update WA_QONTAK_TEMPLATE_ID di .env?', true)) {
                        $this->updateEnv($templateId);
                    }
                } else {
                    $this->warn('Template mungkin dibuat tapi ID tidak ditemukan di response.');
                    $this->line('Cek dashboard Qontak → Settings → Message Templates untuk mendapatkan ID-nya.');
                }

                return self::SUCCESS;
            }

            if ($resp->status() === 401) {
                $this->error('401 Unauthorized — token expired. Jalankan: php artisan wa:test --refresh');
                return self::FAILURE;
            }

            if ($resp->status() === 422 || $resp->status() === 400) {
                $this->warn('API menolak payload (HTTP ' . $resp->status() . ').');
                $this->warn('Format mungkin berbeda. Buat manual di dashboard Qontak dengan isi di bawah ini:');
                $this->newLine();
                $this->printManualInstructions($payload['body']);
                return self::FAILURE;
            }

            // Status lain
            $this->warn('Status tidak dikenal. Buat manual di dashboard:');
            $this->printManualInstructions($payload['body']);
            return self::FAILURE;

        } catch (\Throwable $e) {
            $this->error('Gagal koneksi: ' . $e->getMessage());
            return self::FAILURE;
        }
    }

    private function updateEnv(string $templateId): void
    {
        $envPath = base_path('.env');
        $content = file_get_contents($envPath);

        if (str_contains($content, 'WA_QONTAK_TEMPLATE_ID=')) {
            $content = preg_replace(
                '/^WA_QONTAK_TEMPLATE_ID=.*/m',
                "WA_QONTAK_TEMPLATE_ID={$templateId}",
                $content
            );
        } else {
            $content .= "\nWA_QONTAK_TEMPLATE_ID={$templateId}";
        }

        file_put_contents($envPath, $content);
        $this->info('✓ .env diupdate. Jalankan: php artisan config:clear');
    }

    private function printManualInstructions(string $bodyText): void
    {
        $this->line('─── Cara buat template manual di dashboard Qontak ───');
        $this->line('1. Login ke app.qontak.com');
        $this->line('2. Settings → WhatsApp → Message Templates → + New Template');
        $this->line('3. Isi:');
        $this->line('     Nama     : berita_acara_baru');
        $this->line('     Bahasa   : Indonesian');
        $this->line('     Kategori : Utility');
        $this->line('     Header   : BERITA ACARA BARU  (tipe: Text)');
        $this->line('     Footer   : BA-PICA Tirta Group');
        $this->newLine();
        $this->line('4. Isi Body (copy-paste persis):');
        $this->newLine();
        $this->line($bodyText);
        $this->newLine();
        $this->line('5. Submit → tunggu approval');
        $this->line('6. Setelah approved, copy UUID template → .env: WA_QONTAK_TEMPLATE_ID=<uuid>');
    }
}
