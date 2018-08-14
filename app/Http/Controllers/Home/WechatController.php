<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use EasyWeChat\Foundation\Application as EasyWeChat;
use Mockery\CountValidator\Exception;
use Overtrue\LaravelWechat\CacheBridge;

use App\Model\OfficialAccount;
use App\Model\WechatMenu;
use App\Model\WechatAutoReply;

use EasyWeChat\Message\Text;
use EasyWeChat\Message\News;
class WechatController extends Controller
{


    //
    public function index($id){
        $account = OfficialAccount::find($id);
        if($account){
            app('config')->set('wechat.official_id',$id);
            app('config')->set('wechat.app_id',$account->appid);
            app('config')->set('wechat.secret',$account->appsecret);
        }
        $easywechat = new EasyWeChat(config('wechat'));
        dd($easywechat);

        if (config('wechat.use_laravel_cache')) {
            $easywechat->cache = new CacheBridge();
        }
        $easywechat->server->setRequest(app('request'));
    }
    //菜单栏管理
    public function add_menu(Request $request){
        $id = $request->get('official_id',0);

        $account = OfficialAccount::find($id);

        if($account){
            app('config')->set('wechat.official_id',$id);
            app('config')->set('wechat.app_id',$account->appid);
            app('config')->set('wechat.secret',$account->appsecret);
        }else{
            return ajaxResponse('该公众号信息不存在,请添加公众号信息');
        }

//        dd($account);
        $easywechat = new EasyWeChat(config('wechat'));
        if (config('wechat.use_laravel_cache')) {
            $easywechat->cache = new CacheBridge();
        }

        //获取菜单栏
        $buttons =[];
        $condition = [
            ['status',1],
            ['official_account_id',$id],
            ['pid',0]
        ];
        $p_b = WechatMenu::where($condition)->orderBy('listindex','desc')->get();
        foreach($p_b as $button){
            $sub_condition = [
                ['status',1],
                ['official_account_id',$id],
                ['pid',$button->id]
            ];
            $c_b = WechatMenu::where($sub_condition)->orderBy('listindex','desc')->get();
            $b = [
                'name'=>$button->name
            ];

            if($c_b){
                foreach($c_b as $c){
                    //转换处理
                    $b['sub_button'][]= $this->menu_change($c);
                }
            }else{
                $b=$this->menu_change($button);
            }

            $buttons[]=$b;
        }
//        dd($buttons);
        $menu = $easywechat->menu;
        $res = $menu->add($buttons);
        if($res['code']==0){
            return ajaxResponse('更新'.$account->name.'微信菜单栏成功');
        }else{
            return ajaxResponse($res['msg']);
        }
//        dd($menu->add($buttons));
//        $easywechat->server->setRequest(app('request'));
    }



    //自动回复
    public function message(Request $request){
        $id = $request->get('official_id',2);

        $account = OfficialAccount::find($id);

        if($account){
            app('config')->set('wechat.official_id',$id);
            app('config')->set('wechat.app_id',$account->appid);
            app('config')->set('wechat.secret',$account->appsecret);
            app('config')->set('wechat.token',$account->token);
        }else{
            return ajaxResponse('该公众号信息不存在,请添加公众号信息');
        }

//        dd($account);
        $easywechat = new EasyWeChat(config('wechat'));
        if (config('wechat.use_laravel_cache')) {
            $easywechat->cache = new CacheBridge();
        }
        //如何获取公众号id;

        $server = $easywechat->server;

//        dd($server);
        $server->setMessageHandler(function($message){
            switch($message->MsgType){
                case 'event':
//                    return '收到事件消息';
                    return WechatController::event_handler($message);
                    break;
                case 'text':
//                    return '收到文字消息';
                    return WechatController::text_headler($message);
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                // ... 其它消息
                default:
                    return '收到其它消息';
//                    return $this->event_handler();
                    break;
            }
        });
        $response = $server->serve();
        return $response;
    }
    //事件消息
    public static function event_handler($message){
        $official_id = app('request')->get('official_id',0);
        $event_key = $message->EventKey;
        switch($message->Event){
            case 'CLICK':
                $reply = WechatAutoReply::where([['official_account_id',$official_id],['click_key',$event_key]])->first();
                return self::mes_handler($reply);
                break;
            default:
                return new Text(['content'=>'未知消息类型']);
                break;
        }
//        return app('request')->get('official_id');
    }
    //文本消息
    public static function text_headler($message){
        $content = $message->Content;
        $official_id = app('request')->get('official_id',0);

        $reply = WechatAutoReply::where([['official_account_id',$official_id],['key',$content]])->first();
//        dd($reply);
//        return $reply->content;

//        return new Text(['content'=>$reply->content]);

        if($reply){
            switch($reply->msg_type){
                case 'text':
                    return new Text(['content'=>$reply->content]);
                    break;
                case 'news':
                    return new News([
                        'title'=>$reply->title,
                        'description'=>$reply->description,
                        'url'=>$reply->url,
                        'image'=>'http://comcontrol.hangzhou.com.cn'.$reply->pic_url,
                    ]);
                    break;
                default:
                    return new Text(['content'=>'未知消息类型']);
                    break;
            }
        }else{
            return new Text(['content'=>'欢迎关注'.$official_id]);
        }
    }
    //图片消息(待开发)
    public function image_handler($imgeurl){

    }
    public static function mes_handler(WechatAutoReply $reply){
        switch($reply->msg_type){
            case 'text':
                return new Text(['content'=>$reply->content]);
                break;
            case 'news':
                return new News([
                    'title'=>$reply->title,
                    'description'=>$reply->description,
                    'url'=>$reply->url,
                    'image'=>'http://comcontroll.hangzhou.com.cn'.$reply->pic_url,
                ]);
                break;
            default:
                return new Text(['content'=>'未知消息类型']);
                break;
        }
    }
    //菜单栏处理
    public function menu_change(WechatMenu $menu){
        $button = [
            'type'=>$menu->type,
            'name'=>$menu->name
        ];
        switch($menu->type){
            case 'click':
                $button['key']=$menu->click_key;
                break;
            case 'view':
                $button['url']=$menu->url;
                break;
            case 'miniprogram':
                $button['url']=$menu->url;
                $button['appid']=$menu->appid;
                $button['pagepath']=$menu->pagepath;
                break;
            default:
                throw new Exception('未知事件类型');
                break;
        }

        return $button;
    }

    public function test(){
        $reply = WechatAutoReply::where([['official_account_id',2],['key','测']])->first();
        dd($reply);
    }
}
