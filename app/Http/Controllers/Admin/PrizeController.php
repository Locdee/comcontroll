<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Activity;
use App\Model\Prize;
class PrizeController extends Controller
{
    //
    public function index(Request $request){
        $official_list = admin_offical_list();
        $o_ids = array(0);
        foreach($official_list as $o){
            $o_ids[]=$o->id;
        }
        $activity_list = Activity::whereIn('official_account_id',$o_ids)->get(['id','activityname']);
        foreach($activity_list as $a){
            $ac_ids[]=$a->id;
        }
        $ac_id = $request->get('activity_id',0);
        $condition = array();
        if($ac_id){
            $condition[]=array('activity_id',$ac_id);
        }
        $prize_list = Prize::whereIn($ac_ids)->where($condition)->get();
        $status_arr = array(
            1=>'正常',
            2=>'下架'
        );
        return view('admin.activity.lottery.prize.table',compact('prize_list','status_arr','activity_list','ac_id'));
    }
}
