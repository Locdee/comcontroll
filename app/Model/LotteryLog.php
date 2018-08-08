<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LotteryLog extends Model
{
    //
    protected $fillable=[
        'openid',
        'prize_id',
        'status',
        'message' //相关用户信息
    ];

    public function prize(){
        return $this->hasOne(Prize::class,'id','prize_id');
    }

    public function activity(){
        return $this->hasOne(Activity::class,'id','activity_id');
    }
}
