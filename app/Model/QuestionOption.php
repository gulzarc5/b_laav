<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    protected $table = 'question_option';

    protected $fillable = [
        'exam_question_list_id', 'option','option_type',
    ];
}
