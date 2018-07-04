<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','password',
        'qq',
        'phone',
        'headimg',
        'last_login_time',
        'last_login_ip',
        'login_count',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //更新登录信息
    public function login_update(){
        $this->last_login_ip=app('request')->getClientIp();
        $this->last_login_time=date('Y-m-d H:i:s');
        $this->increment('login_count');
        return $this->save();
    }

    public function role(){
        return $this->hasOne(Role::class,'id','role_id');
    }

    public function official_account(){
        return $this->belongsToMany(OfficialAccount::class,'admin_official_accounts');
    }
}
