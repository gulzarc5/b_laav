<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StudentExam extends Model
{
    protected $table = 'student_exam';

    protected $fillable = [
        'org_id','student_id','exam_id','marks_obtain','exam_status'
    ];

    public function exam()
    {
        return $this->belongsTo('App\Model\Exam','exam_id','id');
    }

   
}
