<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\AdminMenu;
class HomeController extends Controller
{
    //
    public function index(Request $request){
        //获取菜单栏
        $menu_tree = AdminMenuController::tree();
//        dd($menu_tree);
//        dd(Auth::guard('admin')->user() );
        return view('admin.index',compact('menu_tree'));
    }
    public function main(){
//        dd(Auth::guard('admin')->user() );
        return view('admin.main');
    }

}
