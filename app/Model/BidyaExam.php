<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BidyaExam extends Model
{
    protected $table = 'bidya_exam';
    protected $fillable = [
        'org_id','name','start_date','end_date','exam_status','exam_type','total_mark','pass_mark','duration',
    ];

    public function question()
    {
        return $this->hasMany('App\Model\BidyaExamQuestion','bidya_exam_id','id');
    }

    public function examClass()
    {
        return $this->hasMany('App\Model\BidyaExamClass','exam_id','id');
    }
}
