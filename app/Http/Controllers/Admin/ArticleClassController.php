<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ArticleClass;

class ArticleClassController extends Controller
{
    //
    public function index(){
        $official_list = admin_offical_list();
        $o_ids = array(0);
        foreach($official_list as $o){
            $o_ids[]=$o->id;
        }
        $article_class_list = ArticleClass::whereIn('official_account_id',$o_ids)->get();
        $status_arr=[1=>'开放中',2=>'已关闭'];
        return view('admin.article_class.table',compact('official_list','article_class_list','status_arr'));
    }

    public function create(){
        $status_arr=[1=>'开放中',2=>'已关闭'];
        $official_list = admin_offical_list();

        return view('admin.article_class.create',compact('status_arr','official_list'));
    }

    public function store(Request $request){
        $data = $request->all();

        if(ArticleClass::create($data)){
            return ajaxResponse('保存成功',1);
        }else{
            return ajaxResponse('保存失败');
        }
    }

    public function edit($id){
        $article_class = ArticleClass::find($id);
        $status_arr=[1=>'开放中',2=>'已关闭'];
        $official_list = admin_offical_list();

        return view('admin.article_class.edit',compact('status_arr','official_list','article_class'));
    }

    public function update(Request $request,$id){
        $article_class = ArticleClass::find($id);
        $data = $request->all();
        if($article_class->update($data)){
            return ajaxResponse("修改文章分类成功",1);
        }else{
            return ajaxResponse("修改文章分类失败");
        }
    }

    public function destroy($id){
        if(ArticleClass::destroy($id)){
            return ajaxResponse("删除成功",1);
        }else{
            return ajaxResponse("删除失败");
        }
    }
}
