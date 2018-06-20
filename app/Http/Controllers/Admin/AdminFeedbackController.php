<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\AdminFeedback;
use Illuminate\Support\Facades\Auth;
class AdminFeedbackController extends Controller
{
    //
    public function index(){
        $list = AdminFeedback::get();
        return view('admin.feedback.table',compact('list'));
    }

    public function create(){
        return view('admin.feedback.create');
    }

    public function store(Request $request){
        $data = $request->all();
        $data['status']=1;
        $data['admin_id']= Auth::guard('admin')->user()->id;
        if(AdminFeedback::create($data)){
            return ajaxResponse('保存成功',1);
        }else{
            return ajaxResponse('保存失败');
        }
    }

    public function status($id){
        $feedback = AdminFeedback::find($id);
        $feedback->status=2;
        if($feedback->save()){
            return ajaxResponse('保存成功',1);
        }else{
            return ajaxResponse('保存失败');
        }
        
    }

}
