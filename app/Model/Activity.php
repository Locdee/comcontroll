<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //
    protected $fillable=[
        'official_account_id',
        'activityname',
        'is_register',
        'register_start_time',
        'register_end_time',
        'register_content',
        'is_vote',
        'vote_start_time',
        'vote_end_time',
        'vote_rule',

        'is_lottery',
        'lottery_start_time',
        'lottery_end_time',
        'lottery_rule',

        'is_questionnaire',
        'questionnaire_start_time',
        'questionnaire_end_time',

        'status'
    ];

    public function official(){
        return $this->hasOne(OfficialAccount::class,'id','official_account_id');
    }


}
