<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('admin.login');
});

//公众号验证信息(如果没有改变，不用重复下载了验证txt了)
Route::get('/{code}.txt',function($code) {
   return str_replace('MP_verify_','',$code);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//微信公众号信息
//Route::get('wechat/{id}','Home\WechatController@index');

//设置微信公众号菜单栏
Route::get('wechat/add_menu','Home\WechatController@add_menu')->name('wechat.add_menu');

//微信消息处理
Route::post('wechat/message','Home\WechatController@message')->name('wechat.message');

Route::get('wechat/test','Home\WechatController@test');

Route::post('image_upload','Common\ImageController@save')->name('image_upload');