<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\OfficialAccount;
use App\Model\Admin;
class OfficialAccountController extends Controller
{
    //列表
    public function index(){
        $list = OfficialAccount::get();
        return view('admin.official_account.table',compact('list'));
    }

    public function create(){
        //编辑列表
        $admin_list = Admin::where('role_id',2)->get();
        return view('admin.official_account.create',compact('admin_list'));
    }

    public function store(Request $request){
        $data = $request->all();
        $account = OfficialAccount::create($data);
        $admin_ids = $request->get('admin_id');
        $account->admin()->attach($admin_ids);

        if($account){
            return ajaxResponse("保存成功",1);
        }else{
            return ajaxResponse("保存失败");
        }
    }

    public function edit($id){
        $account = OfficialAccount::find($id);
        $admin_list = Admin::where('role_id',2)->get();

        return view('admin.official_account.edit',compact('account','admin_list'));
    }

    public function update(Request $request,$id){
        $data = $request->all();
        $admin_ids = $request->get('admin_id');

        $account = OfficialAccount::find($id);
        if(!$account->update($data)){
            return ajaxResponse('保存公众号信息失败');
        }
        $account->admin()->sync($admin_ids);
        return ajaxResponse('保存成功',1);
    }

    public function destroy($id){
        $account = OfficialAccount::find($id);
        $account->admin()->detach();
        if($account->delete()){
            return ajaxResponse('删除成功',1);
        }else{
            return ajaxResponse('删除失败');
        }
    }
}
