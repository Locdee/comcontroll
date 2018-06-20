<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminFeedback extends Model
{
    //
    protected $fillable=[
        'admin_id',
        'status',
        'content'
    ];

    public function admin(){
        return $this->hasOne(Admin::class,'id','admin_id');
    }
}
