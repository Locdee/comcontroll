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
        //信息采集相关
        $register_element_type_arr = array(
            1=>'文字信息',
            2=>'单张图片信息',
            3=>'多张图片信息'
        );
        //投票相关
        $vote_times_arr = array(
            1=>'每天',
            2=>'总共一次'
        );
        //抽奖相关
        //答题相关
        return view('admin.activity.create',compact('official_list','status_arr','register_element_type_arr','vote_times_arr'));
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
