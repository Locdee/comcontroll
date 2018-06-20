<?php

namespace App\Http\Middleware;

use Closure;
use App\Policies\AdminRbackPolicy as Policy;
class Rbac
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
        $uri = $request->getRequestUri();
        $uri = trim($uri,'/');
        $url_arr=explode('/',$uri);
        $node = $url_arr[1];
        $action = isset($url_arr[2])?$url_arr[2]:'view';
//        echo $action;
        Policy::determine($node,$action);
        return $next($request);
    }
}
