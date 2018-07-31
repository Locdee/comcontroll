<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use EasyWeChat\Foundation\Application as EasyWeChat;
use Overtrue\LaravelWechat\CacheBridge;

use App\Model\OfficialAccount;
class WechatController extends Controller
{
    //
    public function index($id){
        $account = OfficialAccount::find($id);
        if($account){
            app('config')->set('wechat.app_id',$account->appid);
            app('config')->set('wechat.secret',$account->appsecret);
        }

        $easywechat = new EasyWeChat(config('wechat'));
        if (config('wechat.use_laravel_cache')) {
            $easywechat->cache = new CacheBridge();
        }
        $easywechat->server->setRequest(app('request'));
    }
}
