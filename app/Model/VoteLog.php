<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VoteLog extends Model
{
    //
    protected $fillable=[
        'openid',
        'activity_id',
        'team_id',
        'riqi'
    ];

    public function team(){
        return $this->hasOne(VoteTeam::class,'id','team_id');
    }

}
