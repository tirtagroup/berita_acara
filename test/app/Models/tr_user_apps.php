<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class tr_user_apps
 * @package App\Models
 * @version September 7, 2021, 4:44 am UTC
 *
 * @property integer $tr_user_apps_code
 * @property integer $ms_user_code
 * @property integer $pass
 * @property integer $email
 */
class tr_user_apps extends Model
{
    use SoftDeletes;


    public $table = 'tr_user_apps';
    
    protected $primaryKey = 'tr_user_apps_code';
    protected $keyType = 'string';

    protected $dates = ['deleted_at'];



    public $fillable = [
        'tr_user_apps_code',
        'ms_user_code',
        'pass',
        'email'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'tr_user_apps_code' => 'string',
        'ms_user_code' => 'string',
        'pass' => 'string',
        'email' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'tr_user_apps_code' => 'required',
        'ms_user_code' => 'required',
        'pass' => 'required',
        'email' => 'required'
    ];

    
}
