<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subject';

    protected $fillable = [
        'class_id', 'name', 'org_id',
    ];

    public function class()
    {
        return $this->belongsTo('App\Model\Classes','class_id','id');
    }
}
