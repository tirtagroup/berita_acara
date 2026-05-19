<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BA_Main extends Model
{
  protected $table = 'tr_ba_main';
  protected $fillable = [
      'Tr_BA_Code ',
      'BA_Type_Code',
      'BA_Admin',
      'Admin_Div',
      'User_Code',
      'BA_Note',
      'note2',
      'note3',
      'note4',
      'note5',
      'note6',
      'note_koord',
      'note_bod',
      'note_it',
      'Date_BA',
      'Division_Code',
      'Position_Code',
      'Category_Code',
      'ba_status',
      'jenis',
      'Location_Code',
      'Company_Code',
      'mengetahui1',
      'atasan1',
      'mengetahui2',
      'mengetahui3',
      'mengetahui4',
      'mengetahui5',
      'mengetahui_koord',
      'mengetahui_it',
      'ba_bod',
      'atasan2',
      'perlu_approval',
      'rec_status'
  ];
}
