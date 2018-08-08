<?php

namespace App\Http\Controllers\Admin;

use App\Model\ActivityRegister;
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

        $official_account_id = $request->get('official_account_id',0);
        $condition = array();
        if($official_account_id){
            $condition[]=array('official_account_id',$official_account_id);
        }
        $keyword = $request->get('keyword','');
        if($keyword){
            $condition[]=['activityname','like','%'.$keyword.'%'];
        }
        $type_arr = [
            'is_register'=>'信息采集',
            'is_vote'=>'投票',
            'is_lottery'=>'抽奖',
            'is_questionnaire'=>'答题'
        ];

        $type = $request->get('type','');
        if($type){
            $condition[]=[$type,1];
        }
        $activity_list = Activity::whereIn('official_account_id',$o_ids)->where($condition)->paginate(20);
        return view('admin.activity.table',compact('official_list','activity_list','official_account_id','keyword','type_arr','type'));
    }

    //添加
    public function create(){
        $official_list = admin_offical_list();
        $status_arr=[1=>'进行中',2=>'已关闭'];
        //信息采集相关
        $register_element_type_arr = array(
            1=>'文字信息',
            2=>'单张图片信息',
            3=>'多张图片信息',
            4=>'图文信息'
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
        //信息采集相关
        $register_element_type_arr = array(
            1=>'文字信息',
            2=>'单张图片信息',
            3=>'多张图片信息',
            4=>'图文信息'
        );
        //投票相关
        $vote_times_arr = array(
            1=>'每天',
            2=>'总共一次'
        );
        $activity = Activity::find($id);
        if(!$activity){
            abort(404,'该活动不存在或已经被删除');
        }
        $activity->register_content=\GuzzleHttp\json_decode($activity->register_content);
        $activity->vote_rule = \GuzzleHttp\json_decode($activity->vote_rule);
//        dd($activity);
        return view('admin.activity.edit',compact('activity','official_list','status_arr','register_element_type_arr','vote_times_arr'));
    }

    //保存
    public function store(Request $request){
        $data = $request->all();
        $data['is_vote']=$request->get('is_vote',0);
        $data['is_register']=$request->get('is_register',0);
        $data['is_lottery']=$request->get('is_lottery',0);
        $data['is_questionnaire']=$request->get('is_questionnaire',0);
//        dd($data);
        //时间处理
        $data['register_start_time']=strtotime($data['register_start_time']);
        $data['register_end_time']=strtotime($data['register_end_time']);

        $data['vote_start_time']=strtotime($data['vote_start_time']);
        $data['vote_end_time']=strtotime($data['vote_end_time']);

        $data['lottery_start_time']=strtotime($data['lottery_start_time']);
        $data['lottery_end_time']=strtotime($data['lottery_end_time']);

        $data['questionnaire_start_time']=strtotime($data['questionnaire_start_time']);
        $data['questionnaire_end_time']=strtotime($data['questionnaire_end_time']);
        //提交名称
        $r_name_arr = array(
            1=>'text',
            2=>'single_image',
            3=>'images',
            4=>'reach_text'
        );

//        if($data['is_register']==1){
            $content_arr = array();
            $element_name = $request->get('element_name',[]);
            $element_type = $request->get('element_type');

            $element_time_key=$request->get('time_key');
            foreach($element_name as $k=>$i){
                $content = array();
                $content['name']=$i;

                if(empty($i)){
                    return ajaxResponse('请填写信息元素名称');
                }

                $content['type']=$element_type[$k];
                $content['r_name']=$r_name_arr[$element_type[$k]].'_'.$k;
                $key= $element_time_key[$k];

                //收集情况
                $content['register_time']=$request->get('register_time_'.$key,0);

                $content['vote_team_time']=$request->get('vote_team_time_'.$key,0);
                $content['vote_people_time']=$request->get('vote_people_time_'.$key,0);

                $content['lottery_before_time']=$request->get('lottery_before_time_'.$key,0);
                $content['lottery_after_time']=$request->get('lottery_after_time_'.$key,0);

                $content['questionnaire_before_time']=$request->get('questionnaire_before_time_'.$key,0);
                $content['questionnaire_after_time']=$request->get('questionnaire_after_time_'.$key,0);

                $content_arr[]=$content;
            }
            $data['register_content'] = json_encode($content_arr,JSON_UNESCAPED_UNICODE);
//        }

        if($data['is_vote']){
            $rule_arr = array(
                'vote_times'=>$request->get('vote_times'),
                'vote_person_times'=>$request->get('vote_person_times'),
                'vote_repeat_times'=>$request->get('vote_repeat_times')
            );
            $data['vote_rule']=json_encode($rule_arr, JSON_UNESCAPED_UNICODE);
        }

        if(Activity::create($data)){
            return ajaxResponse('添加活动成功',1);
        }else{
            return ajaxResponse('添加活动失败');
        }
    }

    //更新
    public function update($id,Request $request){
        $activity = Activity::find($id);
        $data = $request->all();

        $data['is_vote']=$request->get('is_vote',0);
        $data['is_register']=$request->get('is_register',0);
        $data['is_lottery']=$request->get('is_lottery',0);
        $data['is_questionnaire']=$request->get('is_questionnaire',0);

        //时间处理
        $data['register_start_time']=strtotime($data['register_start_time']);
        $data['register_end_time']=strtotime($data['register_end_time']);

        $data['vote_start_time']=strtotime($data['vote_start_time']);
        $data['vote_end_time']=strtotime($data['vote_end_time']);

        $data['lottery_start_time']=strtotime($data['lottery_start_time']);
        $data['lottery_end_time']=strtotime($data['lottery_end_time']);

        $data['questionnaire_start_time']=strtotime($data['questionnaire_start_time']);
        $data['questionnaire_end_time']=strtotime($data['questionnaire_end_time']);

        //提交名称
        $r_name_arr = array(
            1=>'text',
            2=>'single_image',
            3=>'images',
            4=>'reach_text'
        );

//        if($data['is_register']==1){
            $content_arr = array();
            $element_name = $request->get('element_name');
            $element_type = $request->get('element_type');
            $element_time_key=$request->get('time_key');
            foreach($element_name as $k=>$i){
                $content = array();
                $content['name']=$i;
                $content['type']=$element_type[$k];

                $content['r_name']=$r_name_arr[$element_type[$k]].'_'.$k;

                $key= $element_time_key[$k];

                //收集情况
                $content['register_time']=$request->get('register_time_'.$key,0);

                $content['vote_team_time']=$request->get('vote_team_time_'.$key,0);
                $content['vote_people_time']=$request->get('vote_people_time_'.$key,0);

                $content['lottery_before_time']=$request->get('lottery_before_time_'.$key,0);
                $content['lottery_after_time']=$request->get('lottery_after_time_'.$key,0);

                $content['questionnaire_before_time']=$request->get('questionnaire_before_time_'.$key,0);
                $content['questionnaire_after_time']=$request->get('questionnaire_after_time_'.$key,0);

                $content_arr[]=$content;
            }
            $data['register_content'] = json_encode($content_arr,JSON_UNESCAPED_UNICODE);
//        }

        if($data['is_vote']){
            $rule_arr = array(
                'vote_times'=>$request->get('vote_times'),
                'vote_person_times'=>$request->get('vote_person_times'),
                'vote_repeat_times'=>$request->get('vote_repeat_times')
            );
            $data['vote_rule']=json_encode($rule_arr, JSON_UNESCAPED_UNICODE);
        }
        if($activity->update($data)){
            return ajaxResponse('保存活动内容成功',1);
        }else{
            return ajaxResponse('修改活动内容失败');
        }
    }

    //删除
    public function destroy($id){
        $activity = Activity::find($id);
        if(ActivityRegister::where('activity_id',$id)->count()>0){
            return ajaxResponse('该活动已经有数据产生，无法进行删除');
        }
//        return ajaxResponse('删除成功',1);

        if($activity->delete()){
            return ajaxResponse('删除成功',1);
        }else{
            return ajaxResponse('删除失败');
        }
    }

    //批量更新
    public function batch_status(){

    }

    public function status($id,Request $request){
        $activity = Activity::find($id);
        $activity->status = $request->get('status');
        if($activity->save()!==false){
            return ajaxResponse("修改成功",1);
        }else{
            return ajaxResponse("修改失败");
        }
    }
}
