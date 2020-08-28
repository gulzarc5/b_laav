<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrgClass extends Model
{
    protected $table = 'org_class';

    protected $fillable = [
        'class_id','org_id',
    ];

    // public function stream()
    // {
    //     return $this->belongsTo('App\Model\Stream','stream_id','id');
    // }

    // public function subject()
    // {
    //     return $this->hasMany('App\Model\Subject','class_id','id');
    // }
}
