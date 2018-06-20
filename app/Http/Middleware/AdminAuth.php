<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        $test = Auth::guard('admin')->check();
        $uri = $request->getRequestUri();
//        echo $uri;die;
        if(!Auth::guard('admin')->check() && in_array($uri,$this->except)==false)
        {

            return redirect(route('admin.login'));
        }
        //已经登录则自动跳转到首页
        if(Auth::guard('admin')->check() && $uri=='/admin/login'){
            return redirect(route('admin.home'));
        }
        return $next($request);
    }

    protected $except=[
        '/admin/login',
        '/admin/logout'
    ];
}
