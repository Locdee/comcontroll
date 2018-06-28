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
        $account_list = OfficialAccount::get();
        $account_id = $request->get('account_id',0);
        if($account_id==0){
            $account_id = $account_list[0]['id'];
        }

        return view('admin.wechat_menu.table',compact('account_list','menu_list'));
    }

    private function tree($id){

    }
}
