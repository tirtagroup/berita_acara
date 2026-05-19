<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class ms_users
 * @package App\Models
 * @version September 7, 2021, 3:50 am UTC
 *
 * @property string $User_name
 * @property boolean $User_active
 */
class ms_users extends Model
{
    use SoftDeletes;


    public $table = 'ms_user';
    

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
