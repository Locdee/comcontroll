<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ArticleClass;
use App\Model\Article;

class ArticleClassController extends Controller
{
    //
    public function index(Request $request){
        $official_list = admin_offical_list();
        $o_ids = array(0);
        foreach($official_list as $o){
            $o_ids[]=$o->id;
        }
        $official_account_id = $request->get('official_account_id',0);
        $condition = array();
        if($official_account_id>0){
            $condition[]=array('official_account_id',$official_account_id);
        }
        $keyword = $request->get('keyword','');
        if($keyword){
            $condition[]=['classname','like','%'.$keyword.'%'];
        }
        $article_class_list = ArticleClass::whereIn('official_account_id',$o_ids)->where($condition)->paginate(30);
        $status_arr=[1=>'已开启',2=>'已关闭'];
        return view('admin.article_class.table',compact('official_list','article_class_list','status_arr','official_account_id','keyword'));
    }

    public function create(){
        $status_arr=[1=>'已开启',2=>'已关闭'];
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
        $status_arr=[1=>'已开启',2=>'已关闭'];
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
        if(Article::where('class_id',$id)->count()>0){
            return ajaxResponse('该分类下有文章存在，无法删除');
        }
        if(ArticleClass::destroy($id)){
            return ajaxResponse("删除成功",1);
        }else{
            return ajaxResponse("删除失败");
        }
    }

    public function status($id,Request $request){
        $article_class = ArticleClass::find($id);
        $article_class->status=$request->get('status');;
        if($article_class->save()){
            return ajaxResponse('保存成功',1);
        }else{
            return ajaxResponse('保存失败');
        }

    }
}
