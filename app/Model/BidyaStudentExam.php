<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BidyaStudentExam extends Model
{
    protected $table = 'bidya_student_exam';

    protected $fillable = [
        'org_id','student_id','bidya_exam_id','marks_obtain','exam_status'
    ];

    public function exam()
    {
        return $this->belongsTo('App\Model\BidyaExam','bidya_exam_id','id');
    }

   
}
