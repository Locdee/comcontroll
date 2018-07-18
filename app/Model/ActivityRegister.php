<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ActivityRegister extends Model
{
    //
    protected $fillable=[
        'openid',
        'content',
        'status',
        'activity_id'
    ];

    public function activity(){
        return $this->hasOne(Activity::class,'id','activity_id');
    }

    public function user(){
        return $this->hasOne(WeChatUser::class,'openid','openid');
    }
}
