<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin;
use App\Model\Role;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(){
        if(!rbac_determine('Admin','view')){
            abort(403,'您无权限查看该信息');
        }
        $list = Admin::paginate(20);
        return view('admin.admin.table',compact('list'));
    }

    public function create(){
        $role_list = Role::get();
        return view('admin.admin.create',compact('role_list'));
    }

    public function store(Request $request){
        $data = $request->all();
        $data['password']=Hash::make($data['password']);
        if(Admin::create($data)){
            return ajaxResponse("保存成功",1);
        }else{
            return ajaxResponse("保存失败");
        }
    }

    public function edit($id){
        $admin = Admin::find($id);
        $role_list = Role::get();
        return view('admin.admin.edit',compact('admin','role_list'));
    }

    public function update($id,Request $request){
        $admin = Admin::find($id);
        $data = $request->all();
        if(empty($data['password'])){
            unset($data['password']);
        }else{
            $data['password']=Hash::make($data['password']);
        }

        if($admin->update($data)){
            return ajaxResponse("修改管理员信息成功",1);
        }else{
            return ajaxResponse("修改管理员信息失败");
        }
    }

    public function destroy($id){
        if($id==1){
            return ajaxResponse('该管理员无法被删除');
        }
        if(Admin::destroy($id)){
            return ajaxResponse("删除管理员成功",1);
        }else{
            return ajaxResponse("删除管理员失败");
        }
    }
}
