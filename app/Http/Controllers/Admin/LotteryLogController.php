<?php

namespace App\Http\Controllers\Admin;

use App\Model\LotteryLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Activity;
class LotteryLogController extends Controller
{
    //
    public function index(Request $request){
        $official_list = admin_offical_list();
        $o_ids = array(0);
        foreach($official_list as $o){
            $o_ids[]=$o->id;
        }
        $activity_list = Activity::whereIn('official_account_id',$o_ids)->where('is_lottery',1)->orderBy('id','desc')->get(['id','activityname']);
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

        $condition = array();
        $condition[]=array('activity_id',$ac_id);
        $keyword = $request->get('keyword','');
        if($keyword){
            $condition[]=['content','like','%'.$keyword.'%'];
        }

        $activity = Activity::find($ac_id);
        $activity->register_content = \GuzzleHttp\json_decode($activity->register_content);

        $log_list = LotteryLog::where($condition)->paginate(20);
        foreach($log_list as $key=>$i){
            $log_list[$key]->message=\GuzzleHttp\json_decode($i->message,true);
        }
        return view('admin.activity.lottery.log.table',compact('activity_list','log_list','activity','ac_id','keyword'));
    }
}
