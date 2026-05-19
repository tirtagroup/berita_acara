<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class ms_user
 * @package App\Models
 * @version September 7, 2021, 3:47 am UTC
 *
 * @property string $User_name
 * @property boolean $User_active
 */
class ms_user extends Model
{
    use SoftDeletes;


    public $table = 'ms_user';
    
        // if your key name is not 'id'
    // you can also set this to null if you don't have a primary key
    protected $primaryKey = 'User_code';


    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType = 'string';

    protected $dates = ['deleted_at'];



    public $fillable = [
        'User_name',
        'User_active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'User_code' => 'integer',
        'User_name' => 'string',
        'User_active' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        // 'UIser_code' => 'required',
        'User_name' => 'required',
        'User_active' => 'required'
    ];

    
}
