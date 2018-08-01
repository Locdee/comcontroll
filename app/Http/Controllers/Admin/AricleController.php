<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ArticleClass;
use App\Model\Article;
class AricleController extends Controller
{
    //
    public function index(Request $request){
        $official_list = admin_offical_list();
        $o_ids = array(0);
        foreach($official_list as $o){
            $o_ids[]=$o->id;
        }
        $article_class_list = ArticleClass::whereIn('official_account_id',$o_ids)->get();
        $c_ids = array(0);
        foreach($article_class_list as $c){
            $c_ids[]=$c->id;
        }
        $article_list = Article::whereIn('class_id',$c_ids)->paginate(20);
        $status_arr=[1=>'显示',2=>'隐藏',3=>'头条'];

        return view('admin.article.table',compact('status_arr','article_list','official_list','article_class_list'));
    }

    public function create(){
        $official_list = admin_offical_list();
        $o_ids = array(0);
        foreach($official_list as $o){
            $o_ids[]=$o->id;
        }
        $article_class_list = ArticleClass::whereIn('official_account_id',$o_ids)->get();

        return view('admin.article.create',compact('official_list','article_class_list'));
    }
}
