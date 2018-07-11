<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    //
    protected $fillable=[
        'prizename',
        'weight',
        'activity_id',
        'count',
        'status'
    ];

    public function activity(){
        return $this->HasOne(Activity::class,'id','activity_id');
    }
}
