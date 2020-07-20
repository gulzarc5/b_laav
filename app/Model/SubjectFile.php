<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SubjectFile extends Model
{
    protected $table = 'subject_file';

    protected $fillable = [
        'subject_id', 'name', 'org_id','description','pdf_file','status'
    ];

    public function subject()
    {
        return $this->belongsTo('App\Model\Subject','subject_id','id');
    }
}
