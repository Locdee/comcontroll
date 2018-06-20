<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminMenu extends Model
{
    //
    protected $fillable=[
        'name',
        'pid',
        'order_id',
        'status',
        'node_id',
        'url',
        'status'
    ];

    public function node(){
        return $this->hasOne(Node::class,'id','node_id');
    }

    public function children(){
        return $this->hasMany(AdminMenu::class,'pid','id');
    }
}
