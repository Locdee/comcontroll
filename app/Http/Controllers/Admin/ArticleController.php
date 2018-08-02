<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ArticleClass;
use App\Model\Article;
class ArticleController extends Controller
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

    public function create(Request $request){
        $class_id = $request->get('class_id',0);
        $official_list = admin_offical_list();
        $o_ids = array(0);
        foreach($official_list as $o){
            $o_ids[]=$o->id;
        }
        $article_class_list = ArticleClass::whereIn('official_account_id',$o_ids)->get();
        $status_arr=[1=>'显示',2=>'隐藏',3=>'头条'];

        return view('admin.article.create',compact('official_list','article_class_list','class_id','status_arr'));
    }

    public function store(Request $request){
        $data = $request->all();
        if(Article::create($data)){
            return ajaxResponse('添加成功',1);
        }else{
            return ajaxResponse('添加失败');
        }
    }

    public function edit($id){
        $article = Article::find($id);
        $official_list = admin_offical_list();

        $o_ids = array(0);
        foreach($official_list as $o){
            $o_ids[]=$o->id;
        }
        $article_class_list = ArticleClass::whereIn('official_account_id',$o_ids)->get();
        $status_arr=[1=>'显示',2=>'隐藏',3=>'头条'];

        return view('admin.article.edit',compact('article','status_arr','article_class_list'));
    }

    public function update(Request $request,$id){
        $article = Article::find($id);
        $data = $request->all();
        if($article->update($data)){
            return ajaxResponse('修改成功',1);
        }else{
            return ajaxResponse('修改失败');
        }
    }

    public function destroy($id){

        if(Article::destroy($id)){
            return ajaxResponse("删除成功",1);
        }else{
            return ajaxResponse("删除失败");
        }
    }

    public function list_status(Request $request){


//        $article_class->status=$request->get('status');
//        if($article_class->save()){
//            return ajaxResponse('保存成功',1);
//        }else{
//            return ajaxResponse('保存失败');
//        }

    }
}
