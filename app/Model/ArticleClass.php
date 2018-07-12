<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ArticleClass extends Model
{
    //
    protected $fillable=[
        'official_account_id',
        'classname',
        'status'
    ];

    public function official(){
        return $this->hasOne(OfficialAccount::class,'id','official_account_id');
    }
}
