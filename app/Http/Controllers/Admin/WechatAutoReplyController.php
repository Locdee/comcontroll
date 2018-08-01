<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\WechatAutoReply;
use App\Model\OfficialAccount;
class WechatAutoReplyController extends Controller
{
    //
    public function index(Request $request){
        $official_id = $request->get('official_id',0);

        $condition = array();
        if($official_id>0){
            $condition[] = array('official_account_id',$official_id);
        }

        $status_arr=[1=>'已开启',2=>'已关闭'];
        $type_arr = [
            'text'=>'文本消息',
            'image'=>'图片消息',
            'voice'=>'语音消息',
            'video'=>'视频消息',
            'music'=>'音乐消息',
            'news'=>'图文消息'
        ];
        $official_list = admin_offical_list();
        $o_ids = array(0);
        foreach($official_list as $o){
            $o_ids[]=$o->id;
        }
//        dd($o_ids);
        $list = WechatAutoReply::whereIn('official_account_id',$o_ids)->where($condition)->get();
//        dd($list);
        return view('admin.official_account.auto_reply.table',compact('official_list','status_arr','list','type_arr'));
    }

    public function create(Request $request){
        $official_id = $request->get('official_id',0);
        $msg_type_arr = array(

            array(
                'text'=>'文本消息',
                'type'=>'text',
                'disable'=>1
            ),
            array(
                'text'=>'图片消息',
                'type'=>'image',
                'disable'=>0
            ),
            array(
                'text'=>'图文消息',
                'type'=>'news',
                'disable'=>1
            ),
            array(
                'text'=>'语音消息',
                'type'=>'voice',
                'disable'=>0
            ),
            array(
                'text'=>'视频消息',
                'type'=>'video',
                'disable'=>0
            ),
            array(
                'text'=>'音乐消息',
                'type'=>'music',
                'disable'=>0
            ),

        );
        $status_arr=[1=>'已开启',2=>'已关闭'];

        $official_list = admin_offical_list();

        return view('admin.official_account.auto_reply.create',compact('official_list','msg_type_arr','official_id','status_arr'));
    }

    public function store(Request $request){
        $data = $request->all();
        if(WechatAutoReply::create($data)){
            return ajaxResponse('添加自动回复成功',1);
        }else{
            return ajaxResponse('保存失败');
        }
    }

    public function edit($id){
        $auto_reply = WechatAutoReply::find($id);
        $msg_type_arr = array(

            array(
                'text'=>'文本消息',
                'type'=>'text',
                'disable'=>1
            ),
            array(
                'text'=>'图片消息',
                'type'=>'image',
                'disable'=>0
            ),
            array(
                'text'=>'图文消息',
                'type'=>'news',
                'disable'=>1
            ),
            array(
                'text'=>'语音消息',
                'type'=>'voice',
                'disable'=>0
            ),
            array(
                'text'=>'视频消息',
                'type'=>'video',
                'disable'=>0
            ),
            array(
                'text'=>'音乐消息',
                'type'=>'music',
                'disable'=>0
            ),

        );
        $status_arr=[1=>'已开启',2=>'已关闭'];

        $official_list = admin_offical_list();

        return view('admin.official_account.auto_reply.edit',compact('official_list','status_arr','msg_type_arr','auto_reply'));
    }

    public function update(Request $request,$id){
        $data = $request->all();
        $auto_reply = WechatAutoReply::find($id);
        if($auto_reply->update($data)!==false){
            return ajaxResponse("修改成功",1);
        }else{
            return ajaxResponse("修改失败");
        }
    }

    public function destroy($id){
        if(WechatAutoReply::destroy($id)){
            return ajaxResponse('删除成功',1);
        }else{
            return ajaxResponse("删除失败");
        }
    }

    public function status($id,Request $request){
        $auto_reply = WechatAutoReply::find($id);
        $auto_reply->status = $request->get('status');
        if($auto_reply->save()!==false){
            return ajaxResponse("修改成功",1);
        }else{
            return ajaxResponse("修改失败");
        }
    }
}
