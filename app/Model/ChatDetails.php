<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ChatDetails extends Model
{
    protected $table = 'chat_details';
    protected $fillable = [
        'chat_id','message','user_type','is_liked_admin','is_liked_user',
    ];

    // public function question()
    // {
    //     return $this->hasMany('App\Model\BidyaExamQuestion','bidya_exam_id','id');
    // }
}
