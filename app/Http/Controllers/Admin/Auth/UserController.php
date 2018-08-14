<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index(){
        $admin = Auth::guard('admin')->user();
        return view('admin.auth.infor',compact('admin'));
    }

    public function update(Request $request){
        $admin = Auth::guard('admin')->user();
    }
}
