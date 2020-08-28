<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $table = 'app_setting';

    protected $fillable = [
        'type','file',
    ];

}
