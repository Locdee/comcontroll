<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WechatMenu extends Model
{
    //
    protected $fillable=[
        'official_account_id',
        'name',
        'pid',
        'listindex',
        'type',
        'status',
        'url', //view(小程序) 对应的地址
        'click_key',//click对应key值
        'media_id',//media_id类型和view_limited类型必须
        //小程序相关信息
        'appid',//小程序appid
        'pagepath' //路径

    ];

    public function official_account(){
        return $this->hasOne(OfficialAccount::class,'id','official_account_id');
    }

    public function children(){
        return $this->hasMany(WechatMenu::class,'id','pid');
    }
}
