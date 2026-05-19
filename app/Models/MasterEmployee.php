<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterEmployee extends Model
{
    use HasFactory;
    protected $table = 'master_employees';
    protected $keyType = 'string';

    protected $http_response_header = "Accept: application/json";
    protected $fillable = [
        'user_created',
        'user_updated',
        'rec_datecreated',
        'rec_dateupdate',
        'rec_status',
        'emp_id',
        'emp_iddivision',
        'emp_name',
        'emp_inactive',
        'emp_subdivision',
        'emp_upahpokok',
        'emp_tunjangan',
        'emp_datejoin',
        'emp_dateresign',
        'emp_born',
        'emp_nokontrak',
        'emp_expdatekontrak',
        'emp_numkontrak',
        'emp_npwp',
        'emp_bank',
        'emp_norek',
        'emp_address',
        'emp_idktp',
        'emp_kotalahir',
        'emp_childno',
        'emp_namaistri',
        'emp_jamsostek',
        'emp_includepajak',
        'emp_telp',
        'emp_lastedu',
        'emp_lastcom',
        'emp_telplastcom',
        'emp_lastjabatan',
        'emp_lastsalary',
        'emp_cutitotal',
        'emp_com',
        'emp_status',
        'emp_religion',
        'emp_citizen',
        'emp_desc',
        'emp_levelclass',
        'emp_leveljabatan',
        'emp_lastjobdesk',
        'emp_apprlast',
        'emp_gender',
        'emp_typepayroll',
        'emp_reason_nonactive',
        'emp_aksesuser',
        'emp_email',
        'emp_statuskaryawan'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];
}
