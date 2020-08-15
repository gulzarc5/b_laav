<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BidyaStudentExamDetail extends Model
{
    protected $table = 'bidya_student_exam_details';

    protected $fillable = [
        'student_exam_id','question_id','answer_id','is_correct','mark'
    ];

   
}
