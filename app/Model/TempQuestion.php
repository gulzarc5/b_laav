<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TempQuestion extends Model
{
    protected $table = 'temp_question';

    protected $fillable = [
        'org_id'
    ];
}
