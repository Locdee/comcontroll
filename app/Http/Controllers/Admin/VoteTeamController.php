<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Activity;
use App\Model\ActivityRegister;
class VoteTeamController extends Controller
{
    //

    public function index(Request $request){
        $official_list = admin_offical_list();
        $o_ids = array(0);
        foreach($official_list as $o){
            $o_ids[]=$o->id;
        }
        $activity_list = Activity::whereIn('official_account_id',$o_ids)->where('is_vote',1)->orderBy('id','desc')->get(['id','activityname']);
        $ac_ids = array(0);
        foreach($activity_list as $a){
            $ac_ids[]=$a->id;
        }
        $ac_id = $request->get('activity_id',0);

//        $condition = array();
        if($ac_id==0){
            $ac_id= $activity_list[0]->id;
//            abort('403','请选择相关活动');
        }
        $activity = Activity::find($ac_id);
        $activity->register_content = \GuzzleHttp\json_decode($activity->register_content);

        $register_list = ActivityRegister::where('activity_id',$ac_id)->paginate(20);
        foreach($register_list as $key=>$i){
            $register_list[$key]->content=\GuzzleHttp\json_decode($i->content,true);
        }
        return view('admin.activity.vote.team.table',compact('activity_list','register_list','activity','ac_id'));
    }

    public function create(Request $request){
        $ac_id = $request->get('activity_id',0);

        if($ac_id==0){
            abort('403','请选择相关活动');
        }
        $activity = Activity::find($ac_id);
        $status_arr = array(
            1=>'正常',
            2=>'隐藏'
        );
        $activity->register_content = \GuzzleHttp\json_decode($activity->register_content);
        return view('admin.activity.vote.team.create',compact('activity','ac_id','status_arr'));
    }

    public function store(Request $request){
        $data= $request->all();
        $content = json_encode($data, JSON_UNESCAPED_UNICODE);
        $data['content']=$content;
        if(ActivityRegister::create($data)){
            return ajaxResponse('保存成功',1);
        }else{
            return ajaxResponse('文件保存失败');
        }
    }

    public function edit($id){

        $register = ActivityRegister::find($id);
        $register->content = \GuzzleHttp\json_decode($register->content,true);

        $ac_id = $register->activity_id;

        $activity = Activity::find($ac_id);
        $activity->register_content = \GuzzleHttp\json_decode($activity->register_content);

        $status_arr = array(
            1=>'正常',
            2=>'隐藏'
        );

        return view('admin.activity.vote.team.edit',compact('activity','ac_id','status_arr','register'));
    }

    public function update(Request $request,$id){

        $data= $request->all();
        $register = ActivityRegister::find($id);
        $old_content = json_decode($register->content,true);

        $content=array_merge($old_content,$data);

        $data['content']= json_encode($content, JSON_UNESCAPED_UNICODE);

        if($register->update($data)){
            return ajaxResponse('保存成功',1);
        }else{
            return ajaxResponse('文件保存失败');
        }
    }
}
