<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class ms_recruit_from
 * @package App\Models
 * @version September 7, 2021, 4:11 am UTC
 *
 * @property integer $recruit_code
 * @property string $recruit_nam
 * @property string $recruit_desc
 * @property string $recruit_type
 */
class ms_recruit_from extends Model
{
    use SoftDeletes;


    public $table = 'ms_recruit_from';

    protected $primaryKey = 'recruit_code';
    protected $keyType = 'string';

    protected $dates = ['deleted_at'];



    public $fillable = [
        'recruit_code',
        'recruit_nam',
        'recruit_desc',
        'recruit_type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'recruit_code' => 'integer',
        'recruit_nam' => 'string',
        'recruit_desc' => 'string',
        'recruit_type' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'recruit_code' => 'required',
        'recruit_nam' => 'required',
        'recruit_desc' => 'required',
        'recruit_type' => 'required'
    ];

    
}
