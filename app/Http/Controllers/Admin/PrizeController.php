<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Activity;
use App\Model\Prize;
use App\Model\LotteryLog;
class PrizeController extends Controller
{
    //
    public function index(Request $request){
        $official_list = admin_offical_list();
        $o_ids = array(0);
        foreach($official_list as $o){
            $o_ids[]=$o->id;
        }
        $activity_list = Activity::whereIn('official_account_id',$o_ids)->where('is_lottery',1)->get(['id','activityname']);
        $ac_ids = array(0);
        foreach($activity_list as $a){
            $ac_ids[]=$a->id;
        }
        $ac_id = $request->get('activity_id',0);
        $condition = array();
        if($ac_id){
            $condition[]=array('activity_id',$ac_id);
        }

        $keyword = $request->get('keyword','');
        if($keyword){
            $condition[]=['prizename','like','%'.$keyword.'%'];
        }

        $prize_list = Prize::whereIn('activity_id',$ac_ids)->where($condition)->paginate(20);
        $status_arr = array(
            1=>'正常',
            2=>'下架'
        );
        return view('admin.activity.lottery.prize.table',compact('prize_list','status_arr','activity_list','ac_id','keyword'));
    }

    public function create(Request $request){
        $official_list = admin_offical_list();
        $o_ids = array(0);
        foreach($official_list as $o){
            $o_ids[]=$o->id;
        }
        $activity_list = Activity::whereIn('official_account_id',$o_ids)->where('is_lottery',1)->get(['id','activityname']);

        $ac_id = $request->get('activity_id',0);
        $status_arr = array(
            1=>'正常',
            2=>'下架'
        );
        return view('admin.activity.lottery.prize.create',compact('prize_list','status_arr','activity_list','ac_id'));
    }

    public function store(Request $request){
        $data = $request->all();
        if(Prize::create($data)){
            return ajaxResponse("保存成功",1);
        }else{
            return ajaxResponse("保存失败");
        }
    }

    public function edit($id,Request $request){
        $prize = Prize::find($id);
        $official_list = admin_offical_list();
        $ac_id = $request->get('activity_id',0);
        $o_ids = array(0);
        foreach($official_list as $o){
            $o_ids[]=$o->id;
        }
        $activity_list = Activity::whereIn('official_account_id',$o_ids)->where('is_lottery',1)->get(['id','activityname']);

//        $ac_id = $request->get('activity_id',0);
        $status_arr = array(
            1=>'正常',
            2=>'下架'
        );
        return view('admin.activity.lottery.prize.edit',compact('prize','activity_list','status_arr','ac_id'));
    }

    public function update($id,Request $request){
        $node = Prize::find($id);
        $data = $request->all();
        if($node->update($data)){
            return ajaxResponse("修改奖品信息成功",1);
        }else{
            return ajaxResponse("修改奖品信息失败");
        }
    }

    public function destroy($id){
        if(LotteryLog::where('prize_id',$id)->count()>0){
            return ajaxResponse("该奖品已经有人中奖，无法删除");
        }else{
            if(Prize::destroy($id)){
                return ajaxResponse("删除成功",1);
            }else{
                return ajaxResponse("删除失败");
            }
        }
    }

    public function status($id,Request $request){
        $prize = Prize::find($id);
        $prize->status=$request->get('status');;
        if($prize->save()){
            return ajaxResponse('保存成功',1);
        }else{
            return ajaxResponse('保存失败');
        }

    }
}
