<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Activity;
class ActivityController extends Controller
{

    //列表
    public function index(Request $request){
        $official_list = admin_offical_list();
        $o_ids = array(0);
        foreach($official_list as $o){
            $o_ids[]=$o->id;
        }

        $activity_list = Activity::whereIn('official_account_id',$o_ids)->paginate(20);

        return view('admin.activity.table',compact('official_list','activity_list'));
    }

    //添加
    public function create(){
        $official_list = admin_offical_list();
        $status_arr=[1=>'进行中',2=>'已关闭'];
        return view('admin.activity.create',compact('official_list','status_arr'));
    }

    //编辑
    public function edit($id){
        $official_list = admin_offical_list();
        $status_arr=[1=>'进行中',2=>'已关闭'];
    }

    //保存
    public function store(){

    }

    //更新
    public function update(){

    }

    //删除
    public function destroy($id){

    }

    //批量更新
    public function batch_status(){

    }
}
