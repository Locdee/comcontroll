<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    //
    protected $fillable=[
        'name',
        'model'
    ];

    public function roles(){
        $this->belongsToMany(Role::class,'role_nodes');
    }

}
