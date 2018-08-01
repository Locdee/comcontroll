<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable=[
        'title',
        'intr',//摘要
        'content',//内容
        'url',
        'thump', //缩略图
        'imageurl',//图片

        'class_id',//所在分类
        'author',//作者
        'listindex',//显示顺序
        'publish_time',//发布时间
        'status'//状态
    ];
    //

    public function in_class(){
        return $this->hasOne(ArticleClass::class,'id','class_id');
    }

}
