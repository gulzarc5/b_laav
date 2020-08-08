<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BidyaQuestionOption extends Model
{
    protected $table = 'bidya_question_option';

    protected $fillable = [
        'bidya_exam_question_list_id', 'option','option_type',
    ];
}
