<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewUser extends Model
{
  protected $table = 'tr_report_lowongan_interview_kedua';
  protected $fillable = [
      'rec_usercreated',
      'rec_userupdate',
      'ms_divisi',
      'tr_interview_code',
      'Tr_report_hrd_main_code',
      'Ms_ReportType_Code',
      'Ms_Media_Code',
      'Ms_Perusahaan_Code',
      'NamaLowongan',
      'userinterview',
      'NamaCandidate',
      'Telepon',
      'skill',
      'attitude',
      'leadership',
      'inisiative',
      'problem_solve',
      'drive',
      'pengalaman_dengan_posisi',
      'jam_kerja',
      'prestasi',
      'soft_skill',
      'hasil_interview',
      'Tr_status_interview',
      'user',
      'note'
  ];
}
