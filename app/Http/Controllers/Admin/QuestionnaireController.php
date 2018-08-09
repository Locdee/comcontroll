<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Questionnaire;
use App\Model\Activity;
class QuestionnaireController extends Controller
{
    //
    public function index(Request $request){
        $official_list = admin_offical_list();
        $o_ids = array(0);
        foreach($official_list as $o){
            $o_ids[]=$o->id;
        }
        $activity_list = Activity::whereIn('official_account_id',$o_ids)->where('is_questionnaire',1)->orderBy('id','desc')->get(['id','activityname']);
        $ac_ids = array(0);
        foreach($activity_list as $a){
            $ac_ids[]=$a->id;
        }
        $ac_id = $request->get('activity_id',0);
        $type = $request->get('type',0);
        $condition = array();
        if($ac_id>0){
            $condition[]=['activity_id',$ac_id];
//            $ac_id= $activity_list[0]->id;
//            abort('403','请选择相关活动');
        }
        if($type>0){
            $condition[]=['type',$type];
        }
        $keyword = $request->get('keyword','');
        if($keyword){
            $condition[]=['question','like','%'.$keyword.'%'];
        }
        $status_arr = array(
            1=>'正常',
            2=>'下架'
        );
        $type_arr =array(
            1=>'单选题',
            2=>'多选题',
            3=>'判断题'
        );
        $question_list = Questionnaire::where($condition)->paginate(20);

        return view('admin.activity.questionnaire.table',compact('activity_list','question_list','activity','ac_id','type_arr','type','status_arr','keyword'));
    }

    public function create(Request $request){
        $status_arr = array(
            1=>'正常',
            2=>'下架'
        );
        $type_arr =array(
            1=>'单选题',
            2=>'多选题',
            3=>'判断题'
        );
        $official_list = admin_offical_list();
        $o_ids = array(0);
        foreach($official_list as $o){
            $o_ids[]=$o->id;
        }
        $activity_list = Activity::whereIn('official_account_id',$o_ids)->where('is_questionnaire',1)->orderBy('id','desc')->get(['id','activityname']);
        $ac_id = $request->get('activity_id',0);

        return view('admin.activity.questionnaire.create',compact('activity_list','ac_id','type_arr','status_arr'));
    }

    public function store(Request $request){
        $data = $request->all();
        if($data['type']==3){
            $data['right_answer']= $request->get('right_answer_judge','right');
        }else{
            $data['right_answer']= $request->get('right_answer_choise');

            $right_answer= $request->get('right_answer_choise');
            $right_answer_arr = explode(',',$right_answer);
            $right_arr = array();
            foreach($right_answer_arr as $a){
                if($a!=''){
                    $right_arr[]=$a;
                }
            }
            sort($right_arr);
            $data['right_answer']= implode($right_arr,',');

            $iterm_arr = ['A','B','C','D','E'];
            $answer_iterm_arr = array();
            foreach($iterm_arr as $i){
                $answer_iterm = $request->get('anser_iterm_'.$i,'');
                if($answer_iterm!=''){
                    $answer_iterm_arr[$i]=$answer_iterm;
                }
            }
            $data['answer_iterm']=json_encode($answer_iterm_arr,JSON_UNESCAPED_UNICODE);
        }
        if(Questionnaire::create($data)){
            return ajaxResponse('添加题目成功',1);
        }else{
            return ajaxResponse('添加题目失败');
        }
    }

    public function edit($id){
        $questionnair = Questionnaire::find($id);
        $questionnair->answer_iterm=\GuzzleHttp\json_decode($questionnair->answer_iterm,true);
        $status_arr = array(
            1=>'正常',
            2=>'下架'
        );
        $type_arr =array(
            1=>'单选题',
            2=>'多选题',
            3=>'判断题'
        );
        $official_list = admin_offical_list();
        $o_ids = array(0);
        foreach($official_list as $o){
            $o_ids[]=$o->id;
        }
        $activity_list = Activity::whereIn('official_account_id',$o_ids)->where('is_questionnaire',1)->orderBy('id','desc')->get(['id','activityname']);

        return view('admin.activity.questionnaire.edit',compact('activity_list','type_arr','status_arr','questionnair'));
    }

    public function update($id,Request $request){
        $questionnair = Questionnaire::find($id);

        $data = $request->all();
        if($data['type']==3){
            $data['right_answer']= $request->get('right_answer_judge','right');
        }else{
            $right_answer= $request->get('right_answer_choise');
            $right_answer_arr = explode(',',$right_answer);
            $right_arr = array();
            foreach($right_answer_arr as $a){
                if($a!=''){
                    $right_arr[]=$a;
                }
            }
            sort($right_arr);
            $data['right_answer']= implode($right_arr,',');

            $iterm_arr = ['A','B','C','D','E'];
            $answer_iterm_arr = array();
            foreach($iterm_arr as $i){
                $answer_iterm = $request->get('anser_iterm_'.$i,'');
                if($answer_iterm!=''){
                    $answer_iterm_arr[$i]=$answer_iterm;
                }
            }
            $data['answer_iterm']=json_encode($answer_iterm_arr,JSON_UNESCAPED_UNICODE);
        }
        if($questionnair->update($data)){
            return ajaxResponse('修改题目成功',1);
        }else{
            return ajaxResponse('修改题目失败');
        }
    }

    public function destroy($id){
        $questionnair = Questionnaire::find($id);

        if($questionnair->delete()){
            return ajaxResponse('删除成功',1);
        }else{
            return ajaxResponse('删除失败');
        }
    }

    public function status($id,Request $request){
        $questionnair = Questionnaire::find($id);
        $questionnair->status=$request->get('status');;
        if($questionnair->save()){
            return ajaxResponse('保存成功',1);
        }else{
            return ajaxResponse('保存失败');
        }
    }
}
