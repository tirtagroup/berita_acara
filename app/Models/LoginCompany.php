<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginCompany extends Model
{
    
    protected $table = 'tr_createlogin';
    protected $fillable = [
        'id',
        'Tr_CreateLogin',
        'UserEmail',
        'CompanyID',  
        'CompanyPhone',
        'Ms_Status',
        'NamePIC',
        'Password',
        'SizeCompany',
        'CompanyAddress'      

    ];
}
