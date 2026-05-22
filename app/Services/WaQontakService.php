<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Integrasi WhatsApp notification via Mekari Qontak Omnichannel API.
 *
 * Konfigurasi di .env:
 *   WA_QONTAK_TOKEN                  — Bearer token Qontak
 *   WA_QONTAK_CHANNEL_INTEGRATION_ID — Channel Integration ID dari dashboard Qontak
 *   WA_QONTAK_TEMPLATE_ID            — Message Template ID (harus sudah approved di Qontak)
 *   WA_QONTAK_NUMBERS                — Nomor tujuan, pisahkan koma: 628111,628222
 *
 * Template WA harus punya 11 parameter body:
 *   {{1}}  Kode BA            {{2}}  Business Unit       {{3}}  Tanggal
 *   {{4}}  Pelapor            {{5}}  Subject (Karyawan)  {{6}}  Divisi
 *   {{7}}  Cabang             {{8}}  Lokasi              {{9}}  Deskripsi
 *   {{10}} Kategori           {{11}} Kronologi
 *
 * Contoh teks template yang harus didaftarkan di Qontak:
 * ─────────────────────────────────────────────────────
 * *BERITA ACARA* 📋
 *
 * No BA: {{1}}
 * Business Unit: {{2}}
 * Tanggal: {{3}}
 *
 * 👤 Pelapor: {{4}}
 * 🎯 Subject: {{5}}
 * 💼 Divisi: {{6}}
 * 🏢 Cabang: {{7}}
 * 📍 Lokasi: {{8}}
 *
 * 📝 Deskripsi:
 * {{9}}
 *
 * 🏷️ Kategori:
 * {{10}}
 *
 * 📖 Kronologi:
 * {{11}}
 * ─────────────────────────────────────────────────────
 */
class WaQontakService
{
    private const BASE_URL = 'https://service-chat.qontak.com';
    private const API_URL   = self::BASE_URL . '/api/open/v1/broadcasts/whatsapp/direct';

    /**
     * Kirim notifikasi BA baru ke semua nomor yang dikonfigurasi.
     *
     * @param array $ba  Keys: ba_code, bu_kode, tanggal, pelapor, emp_name,
     *                         emp_div, cabang, lokasi, deskripsi, kategori, kronologi
     */
    public function sendBaNotification(array $ba): void
    {
        $token      = config('services.wa_qontak.token');
        $channelId  = config('services.wa_qontak.channel_integration_id');
        $templateId = config('services.wa_qontak.template_id');
        $rawNumbers = config('services.wa_qontak.numbers', '');

        if (!$token || !$channelId || !$templateId || !$rawNumbers) {
            Log::info('WA Qontak: konfigurasi belum lengkap (cek WA_QONTAK_TEMPLATE_ID di .env), notifikasi dilewati.');
            return;
        }

        $numbers = array_filter(array_map('trim', explode(',', $rawNumbers)));

        foreach ($numbers as $number) {
            $this->sendToNumber($number, $ba, $token, $channelId, $templateId);
        }
    }

    private function sendToNumber(string $number, array $ba, string $token, string $channelId, string $templateId): void
    {
        $payload = [
            'to_number'              => $number,
            'to_name'                => 'Admin',
            'message_template_id'    => $templateId,
            'channel_integration_id' => $channelId,
            'language'               => ['code' => 'id'],
            'parameters'             => [
                'body' => [
                    ['key' => '1',  'value_text' => $ba['ba_code'],              'value' => 'ba_code'],
                    ['key' => '2',  'value_text' => $ba['bu_kode'],              'value' => 'bu_kode'],
                    ['key' => '3',  'value_text' => $ba['tanggal'],              'value' => 'tanggal'],
                    ['key' => '4',  'value_text' => $ba['pelapor'],              'value' => 'pelapor'],
                    ['key' => '5',  'value_text' => $ba['emp_name'],             'value' => 'emp_name'],
                    ['key' => '6',  'value_text' => $ba['emp_div'],              'value' => 'emp_div'],
                    ['key' => '7',  'value_text' => $ba['cabang'],               'value' => 'cabang'],
                    ['key' => '8',  'value_text' => $ba['lokasi'],               'value' => 'lokasi'],
                    ['key' => '9',  'value_text' => mb_substr($ba['deskripsi'], 0, 300), 'value' => 'deskripsi'],
                    ['key' => '10', 'value_text' => $ba['kategori'],             'value' => 'kategori'],
                    ['key' => '11', 'value_text' => mb_substr($ba['kronologi'], 0, 500), 'value' => 'kronologi'],
                ],
            ],
        ];

        try {
            $verifySsl = config('services.wa_qontak.verify_ssl', true);

            $response = Http::withToken($token)
                ->timeout(10)
                ->withOptions(['verify' => filter_var($verifySsl, FILTER_VALIDATE_BOOLEAN)])
                ->post(self::API_URL, $payload);

            if ($response->successful()) {
                Log::info("WA Qontak: notifikasi BA {$ba['ba_code']} terkirim ke {$number}");
            } else {
                Log::error("WA Qontak: gagal kirim ke {$number}", [
                    'ba_code' => $ba['ba_code'],
                    'status'  => $response->status(),
                    'body'    => $response->body(),
                ]);
            }
        } catch (\Throwable $e) {
            Log::error("WA Qontak: exception saat kirim ke {$number} — " . $e->getMessage());
        }
    }
}
