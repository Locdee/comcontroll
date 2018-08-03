<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\WeChatMenu;
use App\Model\OfficialAccount;
class WeChatMenuController extends Controller
{
    //
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
        $menu_list = WeChatMenu::whereIn('official_account_id',$o_ids)->where('pid',0)->orderBy('listindex','desc')->get();

        return view('admin.official_account.menu.table',compact('official_list','status_arr','menu_list'));
    }

    public function create(){
        $type_arr = array(
            1=>'click',
            2=>'view',
            3=>'miniprogram',
            4=>'media_id',
            5=>'view_limit'

        );
    }
    private function tree($id){

    }
}
