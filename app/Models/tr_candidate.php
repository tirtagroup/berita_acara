<?php

namespace App\Models;
use App\Models\candidate_photos;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class tr_candidate
 * @package App\Models
 * @version September 7, 2021, 4:26 am UTC
 *
 * @property integer $tr_canddate_code
 * @property string $Name
 * @property string $Birthdate
 * @property string $KTP
 * @property string $EducationLast
 * @property string $CompanyLast
 * @property string $JobTitileLast
 * @property number $SalaryLast
 * @property string $Handphone
 * @property integer $Email
 * @property string $Alamat
 * @property string $Position
 * @property integer $From
 * @property string $CityBirth
 * @property integer $Facebook
 * @property string $Instagram
 * @property string $Twitter
 * @property string $Linkedin
 * @property string $Company1
 * @property string $Title
 */
class tr_candidate extends Model
{
    use SoftDeletes;
    public $table = 'tr_candidate';
    // protected $primaryKey = 'tr_canddate_code';
    protected $primaryKey = 'Ktp';
    protected $keyType = 'string';
    protected $dates = ['deleted_at'];
    public $fillable = [
        // 'tr_canddate_code',
        'Name',
        'Ktp',
        'domisili',
        'CityBirth',
        'Birthdate',
        'status',
        'jenis_kelamin',
        'agama',
        'Handphone',
        'Email',
        'pengajuan_gaji',
        'Info_lowongan',
        'Position_aplly1',
        'ketersediaan',
        'layak',
        'patner',
        'pasfoto',
        'photo',
        'rec_status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'tr_canddate_code' => 'integer',
        'Name' => 'string',
        'KTP' => 'integer',
        'domisili' => 'string',
        'CityBirth' => 'string',
        'Birthdate' => 'date',
        'status' => 'string',
        'jenis_kelamin' => 'string',
        'agama' => 'string',
        'Handphone' => 'string',
        'Email' => 'string',
        'pengajuan_gaji' => 'string',
        'Info_lowongan' => 'string',
        'Position_aplly' => 'string',
        'ketersediaan' => 'string',
        'layak' => 'string',
        'patner' => 'string',
        'pasfoto'=>'string'

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

        'Name'=> 'required',
        'KTP'=> 'required',
        'domisili'=> 'required',
        'CityBirth'=> 'required',
        'Birthdate'=> 'required',
        'status'=> 'required',
        'agama'=> 'required',
        'jenis_kelamin'=> 'required',
        'Handphone'=> 'required',
        'Email'=> 'required',
        'pengajuan_gaji'=> 'required',
        'info_lowongan' => 'required',
        'Position_aplly'=> 'required',
        'ketersediaan' => 'string',
        'layak' => 'string',
        'patner' => 'string',
        'pasfoto'=> 'required',

    ];

    public function photo()
    {
        return $this->hasOne(candidate_photos::class, 'id_tr_candidate', 'id');
    }

}
