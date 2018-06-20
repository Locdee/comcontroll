<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OfficialAccount extends Model
{
    //
    protected $fillable=[
        'name',
        'appid',
        'appsecret',
        'status'
    ];
    public function admin(){
        return $this->belongsToMany(Admin::class,'admin_official_accounts');
    }
}
