<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Role;

use App\Model\Node;
class RoleController extends Controller
{
    //
    public function index(){
        $list = Role::get();
        return view('admin.role.table',compact('list'));
    }

    public function create(){
        $node_list = Node::get();
        $action_arr = array(
            'create'=>'增加',
            'update'=>'修改',
            'view'=>'查询',
            'delete'=>'删除'
        );

        return view('admin.role.create',compact('node_list','action_arr'));
    }

    public function store(Request $request){
        $data = $request->all();
        $role = Role::create($data);
        $role_ids = $request->get('node_id');

        $attach_arr = array();
        foreach($role_ids as $id){
            $attach_arr[$id]=array(
                'create'=>$request->get('node_create_'.$id,0),
                'update'=>$request->get('node_update_'.$id,0),
                'view'=>$request->get('node_view_'.$id,0),
                'delete'=>$request->get('node_delete_'.$id,0),
            );
        }
//        dd($attach_arr);
        $role->node()->attach($attach_arr);

        if($role){
            return ajaxResponse("保存成功",1);
        }else{
            return ajaxResponse("保存失败");
        }
    }

    public function edit($id){
        $role = Role::find($id);
        $action_arr = array(
            'create'=>'增加',
            'update'=>'修改',
            'view'=>'查询',
            'delete'=>'删除'
        );
//        $res = $role->node()->wherePivot('node_id',1)->count();
//        dd($res);
//        dd($role->node->toArray());
//        $n = $role->node()->wherePivot('node_id',5)->first();
//        echo $n->pivot->create;die;

        $node_list = Node::get();
        return view('admin.role.edit',compact('role','node_list','action_arr'));
    }

    public function update($id,Request $request){
        $role = Role::find($id);


        if(!$role){
            return ajaxResponse('无法找到该角色相关信息');
        }
        $data = $request->all();


        if(!$role->update($data)){
            return ajaxResponse('保存角色信息失败');
        }
        $role_ids = $request->get('node_id');

        $attach_arr = array();
        if($role_ids){

            foreach($role_ids as $id){
                $attach_arr[$id]=array(
                    'create'=>$request->get('node_create_'.$id,0),
                    'update'=>$request->get('node_update_'.$id,0),
                    'view'=>$request->get('node_view_'.$id,0),
                    'delete'=>$request->get('node_delete_'.$id,0),
                );
            }
        }


        $role->node()->sync($attach_arr);
        return ajaxResponse('保存成功',1);
    }

    public function destroy($id){
        $role = Role::find($id);
        $role->node()->detach();
        if($role->delete()){
            return ajaxResponse('删除成功',1);
        }else{
            return ajaxResponse('删除失败');
        }
    }
}
