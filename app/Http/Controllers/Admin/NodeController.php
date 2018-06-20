<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Node;
use App\Policies\AdminRbackPolicy;
class NodeController extends Controller
{
    //
    public function index(){
        if(!rbac_determine('Node','view')){
            abort(403,'您无权限查看该信息');
        }
        $list = Node::get();
        return view('admin.node.table',compact('list'));
    }

    public function create(){
        return view('admin.node.create');
    }

    public function store(Request $request){
        $data = $request->all();
        if(Node::create($data)){
            return ajaxResponse("保存成功",1);
        }else{
            return ajaxResponse("保存失败");
        }
    }

    public function edit($id){
        $node = Node::find($id);

        return view('admin.node.edit',compact('node'));
    }

    public function update($id,Request $request){
        $node = Node::find($id);
        $data = $request->all();
        if($node->update($data)){
            return ajaxResponse("修改节点信息成功",1);
        }else{
            return ajaxResponse("修改节点信息失败");
        }
    }

    public function destroy($id){

        if(Node::destroy($id)){
            return ajaxResponse("删除成功",1);
        }else{
            return ajaxResponse("删除失败");
        }
    }
}
