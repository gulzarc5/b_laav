<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answer';
    protected $fillable = [
        'question_id','answer','like_count',
    ];

    // public function question()
    // {
    //     return $this->hasMany('App\Model\BidyaExamQuestion','bidya_exam_id','id');
    // }
}
