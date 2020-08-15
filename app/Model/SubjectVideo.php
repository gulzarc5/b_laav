<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SubjectVideo extends Model
{
    protected $table = 'subject_video';

    protected $fillable = [
        'subject_id', 'org_id', 'video_id','status',
    ];

    public function subject()
    {
        return $this->belongsTo('App\Model\Subject','subject_id','id');
    }
}
