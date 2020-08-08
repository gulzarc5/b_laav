<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BidyaExamClass extends Model
{
    protected $table = 'bidya_exam_class';
    protected $fillable = [
        'exam_id','class_id',
    ];

    public function class()
    {
        return $this->belongsTo('App\Model\Classes','class_id','id');    
    }

}
