<?php

namespace App\Policies;

use App\Model\OfficialAccount;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AdminRbackPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */

    public function __construct()
    {
        //
    }

    //调用权限方法
    public static function determine($model,$action='view'){
        $admin_session = Auth::guard('admin');

        //超级管理员判断
        $admin = $admin_session->user();
        if(!$admin){
            return false;
        }
//        dd($admin->role->node()->where('model','Modle\Admin')->first());
        $role_node = $admin->role->node()->where('model',$model)->first();
//        if($admin->id==1){
//            return true;
//        }
        if(empty($role_node)){
            return false;
        }
//        dd($role_node->pivot->view);
        if($role_node->pivot->$action==1){
            return true;
        }else{
            return false;
        }

    }

    //相关公众号
    public static function admin_offical_list(){

        $admin_session = Auth::guard('admin');

        //超级管理员判断
        $admin = $admin_session->user();
        if(!$admin){
            return array();
        }
        if($admin->role_id==1){
            return  OfficialAccount::get();
        }else{
            return $admin->official_account()->get();
//            dd($official_list);
        }
    }
}
