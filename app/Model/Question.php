<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'question';
    protected $fillable = [
        'user_id','subject','message','is_answered',
    ];

    public function user()
    {
        return $this->belongsTo('App\Model\User','user_id','id');
    }

    public function answer()
    {
        return $this->hasOne('App\Model\Answer','question_id','id');
    }
}
