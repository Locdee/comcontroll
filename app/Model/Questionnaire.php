<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    //
    protected $fillable=[
        'activity_id',
        'type',
        'question',
        'answer_iterm',
        'explain',
        'right_answer',
        'status',
        'score'
    ];

    public function activity(){
        return $this->hasOne(Activity::class,'id','activity_id');
    }
}
