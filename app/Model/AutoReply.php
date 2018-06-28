<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AutoReply extends Model
{
    //
    protected $fillable=[
        'official_account_id',
        'key',
        'click_key',
        'type', // text,image,voice,video,music,news
        'url',
    ];

    public function account(){
        $this->hasOne(OfficialAccount::class,'id','official_account_id');
    }
}
