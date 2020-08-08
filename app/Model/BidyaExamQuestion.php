<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BidyaExamQuestion extends Model
{
    protected $table = 'bidya_exam_question_list';

    protected $fillable = [
        'bidya_exam_id', 'question_type', 'question','correct_answer_id','mark',
    ];

    public function options()
    {
        return $this->hasMany('App\Model\BidyaQuestionOption','bidya_exam_question_list_id','id');
    }
}

