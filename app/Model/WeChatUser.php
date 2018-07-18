<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WeChatUser extends Model
{
    //
    protected $fillable=[
        'openid',
        'headimg',
        'nickname',
        'official_account_id'
    ];

    //所属公众号
    public function official(){
        return $this->hasOne(OfficialAccount::class,'id','official_account_id');
    }
}
