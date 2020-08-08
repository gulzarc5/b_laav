<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StudentExamDetail extends Model
{
    protected $table = 'student_exam_details';

    protected $fillable = [
        'student_exam_id','question_id','answer_id','is_correct','mark'
    ];

   
}
