<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\WechatMenu;
use App\Model\OfficialAccount;
use Symfony\Component\HttpFoundation\RedirectResponse;

class WeChatMenuController extends Controller
{
    //
    private $menu_type_arr = array(
        array(
            'text'=>'点击事件',
            'type'=>'click',
            'disable'=>1
        ),
        array(
            'text'=>'跳转网页',
            'type'=>'view',
            'disable'=>1
        ),
        array(
            'text'=>'小程序',
            'type'=>'miniprogram',
            'disable'=>1
        ),
        array(
            'text'=>'图片',
            'type'=>'meidia_id',
            'disable'=>0
        ),
        array(
            'text'=>'发送位置',
            'type'=>'location_select',
            'disable'=>0
        )
    );
    public function index(Request $request){
        $official_list = admin_offical_list();
        $o_ids = array(0);
        foreach($official_list as $o){
            $o_ids[]=$o->id;
        }

        $account_id = $request->get('account_id',0);
        $condition = [];
        if($account_id>0){
            $condition[] = ['official_account_id',$account_id];
        }
        $status_arr = array(
            1=>'显示',
            2=>'隐藏'
        );
        $menu_list = WechatMenu::whereIn('official_account_id',$o_ids)->where('pid',0)->orderBy('listindex','desc')->get();
//        dd($menu_list);
        return view('admin.official_account.menu.table',compact('official_list','status_arr','menu_list'));
    }

    public function create(){
        $menu_type_arr = $this->menu_type_arr;
        $official_list = admin_offical_list();

        $status_arr=[1=>'显示',2=>'隐藏'];
        return view('admin.official_account.menu.create',compact('menu_type_arr','official_list','status_arr'));
    }

    public function store(Request $request){
        $data = $request->all();
//        dd($data);
        $official_id=$data['official_account_id'];
        if($data['status']==1){
            if($data['pid']==0){
                if(WechatMenu::where([['official_account_id',$official_id],['pid',0],['status',1]])->count()>=3){
                    return ajaxResponse('自定义菜单最多包括3个一级菜单');
                }
            }else{
                if(WechatMenu::where([['official_account_id',$official_id],['pid',$data['pid']],['status',1]])->count()>=5){
                    return ajaxResponse('每个一级菜单最多包含5个二级菜单');
                }
            }
        }

        if(WeChatMenu::create($data)){
            return ajaxResponse('添加成功',1);
        }else{
            return ajaxResponse('添加失败');
        }
    }

    public function edit($id){
        $menu = WechatMenu::find($id);
//        dd($menu->children);
        $menu_type_arr = $this->menu_type_arr;

        $official_list = admin_offical_list();
        $status_arr=[1=>'显示',2=>'隐藏'];

        $parent_menu_list = WechatMenu::where([['official_account_id',$menu->official_account_id],['pid',0],['id','<>',$id]])->orderBy('listindex','desc')->get();
        return view('admin.official_account.menu.edit',compact('menu','menu_type_arr','official_list','parent_menu_list','status_arr'));
    }

    public function update(Request $request,$id){
        $data = $request->all();
//        dd($data);
        $official_id=$data['official_account_id'];
        if($data['status']==1){
            if($data['pid']==0){
                if(WechatMenu::where([['official_account_id',$official_id],['pid',0],['status',1],['id','<>',$id]])->count()>=3){
                    return ajaxResponse('自定义菜单最多包括3个一级菜单');
                }
            }else{
                if(WechatMenu::where([['official_account_id',$official_id],['pid',$data['pid']],['status',1],['id','<>',$id]])->count()>=5){
                    return ajaxResponse('每个一级菜单最多包含5个二级菜单');
                }
            }
        }
        $menu = WechatMenu::find($id);
        if($menu->update($data)){
            return ajaxResponse('修改成功',1);
        }else{
            return ajaxResponse('修改失败');
        }

    }

    public function destroy($id){

        if(WechatMenu::where('pid',$id)->count()>0){
            return ajaxResponse('该菜单栏下有子菜单，请先移除子菜单再执行删除操作');
        }

        if(WechatMenu::destroy($id)){
            return ajaxResponse("删除成功",1);
        }else{
            return ajaxResponse("删除失败");
        }
    }

    public function ajax_menu(Request $request){
        $official_id = $request->get('official_account_id',0);
        $id = $request->get('id',0);
        $condition = array(
            array('pid',0),
            array('id','<>',$id),
            array('official_account_id',$official_id)
        );
        $menu_list = WechatMenu::where($condition)->orderBy('listindex','desc')->get()->toArray();
        return ajaxResponse('',1,$menu_list);
    }
}
