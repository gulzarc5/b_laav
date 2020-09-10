<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LikeHistory extends Model
{
    protected $table = 'like_history';
    protected $fillable = [
        'user_id','answer_id',
    ];

    // public function question()
    // {
    //     return $this->hasMany('App\Model\BidyaExamQuestion','bidya_exam_id','id');
    // }
}
