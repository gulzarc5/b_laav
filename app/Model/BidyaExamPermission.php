<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BidyaExamPermission extends Model
{
    protected $table = 'bidya_student_exam_permission';
    protected $fillable = [
        'org_id','student_id','bidya_exam_id',
    ];

    public function question()
    {
        return $this->hasMany('App\Model\BidyaExamQuestion','bidya_exam_id','id');
    }

    public function examClass()
    {
        return $this->hasMany('App\Model\BidyaExamClass','exam_id','id');
    }

    public function student()
    {
        return $this->hasOne('App\Model\User','id','student_id');
    }
}
