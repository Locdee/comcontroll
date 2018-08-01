<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WechatAutoReply extends Model
{
    //
    protected $fillable=[
        'key',
        'click_key',
        'external_link',
        'official_account_id',
        'msg_type',
        'status',
        'content',
        'media_id',
        'title',
        'description',
        'music_url',
        'HQMusic_url',
        'thumb_media_id',
        'pic_url',
        'url'
    ];

    public function official(){
        return $this->Hasone(OfficialAccount::class,'id','official_account_id');
    }
}
