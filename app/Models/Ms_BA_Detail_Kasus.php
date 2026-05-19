<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ms_BA_Detail_Kasus extends Model
{
  protected $table = 'Ms_Kasus_Detail';
  protected $fillable = [
      'Ms_Kasus_Detail_Code',
      'Detail_Desc',
      'Cek_Revisi',
      'Cek_Fraud',
      'Cek_Pelanggaran_SOP',
      'Cek_Disiplin',
      'Cek_Laka',
      'Cek_Kerusakan',
      'Cek_Approval',
      'Cek_Tolak_Tugas',
      'Cek_Barang_hilang',
      'Cek_Salah_Isi'
  ];
}
