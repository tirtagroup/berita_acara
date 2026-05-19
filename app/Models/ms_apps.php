<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class ms_apps
 * @package App\Models
 * @version September 7, 2021, 4:03 am UTC
 *
 * @property string $apps_code
 * @property string $apps_name
 * @property string $apps_address
 */
class ms_apps extends Model
{
    use SoftDeletes;


    public $table = 'ms_apps';
    
    protected $primaryKey = 'apps_code';
    protected $keyType = 'string';

    protected $dates = ['deleted_at'];



    public $fillable = [
        'apps_code',
        'apps_name',
        'apps_address'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'apps_code' => 'string',
        'apps_name' => 'string',
        'apps_address' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'apps_code' => 'required',
        'apps_name' => 'required',
        'apps_address' => 'required'
    ];

    
}
