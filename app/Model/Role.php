<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $fillable=['name'];

    public function node(){
        return $this->belongsToMany(Node::class,'role_node')->withPivot('create', 'update','view','delete');
    }
}
