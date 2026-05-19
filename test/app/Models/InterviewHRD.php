<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewHRD extends Model
{
    protected $table = 'tr_report_lowongan_interview';
    protected $fillable = [
        'Ms_User_Code',
        'Ms_UserUpdate',
        'ms_divisi',
        'tr_lowongan_Interview',
        'Tr_report_hrd_main_code',
        'Ms_ReportType_Code',
        'Ms_Media_Code',
        'Ms_Perusahaan_Code',
        'NamaLowongan',
        'userinterview',
        'NamaCandidate',
        'Telepon',
        'latar_belakang',
        'pengalaman_kerja',
        'rincian_pekrjaan',
        'alasan_keluar',
        'referensi',
        'alasan_melamar',
        'fisik',
        'sopan_santun',
        'pendidikan_kerja',
        'prestasi',
        'penyampaian_pendapat',
        'komunikasi',
        'daya_tangkap',
        'analis',
        'percaya_diri',
        'stabilitas_emosi',
        'motivasi',
        'user',
        'hasil_interview',
        'Tr_status_interview',
        'note',
        'lanjut_tidaklanjut',
        'priority',
        'langsungBD'
    ];
}
