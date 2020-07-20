<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegRequest extends Model
{
    protected $table = 'reg_req';

    protected $fillable = [
        'name','father_name','email','mobile','dob','address','city','pin',
    ];
}
