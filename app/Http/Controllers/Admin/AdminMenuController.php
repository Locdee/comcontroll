<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AdminMenu;
use App\Model\Node;

use Illuminate\Support\Facades\Auth;

class AdminMenuController extends Controller
{
    //
    public function index(Request $request){
        $menu_tree = AdminMenu::where('pid',0)->orderBy('order_id')->get();
        return view('admin.adminmenu.tree',compact('menu_tree'));
    }

    public function create(){
        $parent_list = AdminMenu::where('pid',0)->orderBy('order_id')->get();
        $node_list = Node::get();
        $status_arr = array('1'=>'显示','2'=>'隐藏');
        return view('admin.adminmenu.create',compact('parent_list','node_list','status_arr'));
    }

    public function store(Request $request){
        $data = $request->all();
        if(AdminMenu::create($data)){
            return ajaxResponse('保存成功',1);
        }else{
            return ajaxResponse('保存失败');
        }
    }

    public function edit($id){
        $menu = AdminMenu::find($id);
        $parent_list = AdminMenu::where('pid',0)->orderBy('order_id')->get();
        $node_list = Node::get();
        $status_arr = [1=>'显示',2=>'隐藏'];
        return view('admin.adminmenu.edit',compact('menu','node_list','parent_list','status_arr'));
    }

    public function update($id,Request $request){
        $menu = AdminMenu::find($id);
        $data = $request->all();
        if($data['pid']==$id){
            return ajaxResponse('父级菜单不能选择自己');
        }
        if($menu->update($data)){
            return ajaxResponse("修改节点信息成功",1);
        }else{
            return ajaxResponse("修改节点信息失败");
        }
    }

    public function destroy($id){
        $menu = AdminMenu::find($id);
        if($menu->status=='3'){
            return ajaxResponse('该菜单栏由于权限问题无法被删除，请联系超级管理员');
        }
        if($menu->children()->count()){
            return ajaxResponse('请先将该菜单的子菜单清空在删除此菜单');
        }
        if(AdminMenu::destroy($id)){
            return ajaxResponse("删除成功",1);
        }else{
            return ajaxResponse("删除失败");
        }
    }

    public static function tree(){
        $admin_session = Auth::guard('admin');
        //超级管理员判断
        $admin = $admin_session->user();
        if(!$admin){
            return [];
        }
        //获取节点信息
        $node_id_list = array();
        $node_arr = $admin->role->node()->wherePivot('view',1)->get();
        $menu_tree = array();
//        dd($node_arr);
        foreach($node_arr as $node){
            $node_id_list[]=$node->id;
        }
        //遍历菜单栏
        $menu_list = AdminMenu::where([['pid',0],['status',1]])->orderBy('order_id')->get();
        foreach($menu_list as $menu){
            //或主菜单是否是相关节点
            $children_list = array();
            //子菜单中是否有相关节点
            $childern_count = $menu->children()->where('status',1)->whereIn('node_id',$node_id_list)->orderBy('order_id')->count();
            if($childern_count || in_array($menu->node_id,$node_id_list)){
                $children_list = $menu->children()->where('status',1)->whereIn('node_id',$node_id_list)->orderBy('order_id')->get()->toArray();
                $menu_arr = $menu->toArray();
                $menu_arr['children']=$children_list;
                $menu_tree[]=$menu_arr;
            }
        }
        return $menu_tree;
//        dd($menu_tree);
    }
}
