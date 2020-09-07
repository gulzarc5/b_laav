<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chat';
    protected $fillable = [
        'user_id'
    ];

    // public function question()
    // {
    //     return $this->hasMany('App\Model\BidyaExamQuestion','bidya_exam_id','id');
    // }
}
