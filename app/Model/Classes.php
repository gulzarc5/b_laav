<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'stream_id', 'name','org_id',
    ];

    public function stream()
    {
        return $this->belongsTo('App\Model\Stream','stream_id','id');
    }

    public function subject()
    {
        return $this->hasMany('App\Model\Subject','class_id','id');
    }
}
