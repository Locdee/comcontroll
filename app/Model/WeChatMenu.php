<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WeChatMenu extends Model
{
    //
    protected $fillable=[
        'official_account_id',
        'name',
        'pid',
        'order_id',
        'type',
        'status',
        'url', //view 对应的地址
        'click_key',//click对应key值
        'media_id',//media_id类型和view_limited类型必须

    ];

    public function official_account(){
        return $this->hasOne(OfficialAccount::class,'id','official_account_id');
    }
}
