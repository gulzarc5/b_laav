<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $table = 'exams';

    protected $fillable = [
        'class_id','org_id','subject_id','name','start_date','end_date','exam_type ','exam_status','total_mark','pass_mark','duration',
    ];

    public function class()
    {
        return $this->belongsTo('App\Model\Classes','class_id','id');
    }
    public function subject()
    {
        return $this->belongsTo('App\Model\Subject','subject_id','id');
    }
    public function question()
    {
        return $this->hasMany('App\Model\ExamQuestion','exam_id','id');
    }
}
