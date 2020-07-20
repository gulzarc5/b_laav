<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    protected $table = 'exam_question_list';

    protected $fillable = [
        'exam_id', 'question_type', 'question','correct_answer_id','mark',
    ];

    public function options()
    {
        return $this->hasMany('App\Model\QuestionOption','exam_question_list_id','id');
    }
}

