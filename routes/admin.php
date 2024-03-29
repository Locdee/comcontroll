<?php

/*
|--------------------------------------------------------------------------
| 后台管理路由
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('admin.logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

//首页
Route::get('home', 'HomeController@index')->name('admin.home');
//我的桌面
Route::get('main','HomeController@main')->name('admin.main');

//节点
Route::resource('node','NodeController');
//角色
Route::resource('role','RoleController');

//菜单栏
Route::resource('menu','AdminMenuController');

//管理员
Route::resource('admin','AdminController');

//公众号管理
Route::resource('official_account','OfficialAccountController');
//公众号菜单栏管理
Route::resource('wechat_menu','WechatMenuController');
Route::put('wechat_menu/status/{id}','WechatMenuController@status')->name('wechat_menu.status');
Route::get('get_parent_menu','WechatMenuController@ajax_menu')->name('get_parent_menu');
//自动回复
Route::resource('auto_reply','WechatAutoReplyController');
Route::put('auto_reply/status/{id}','WechatAutoReplyController@status')->name('auto_reply.status');

//文章分类
Route::resource('article_class','ArticleClassController');
Route::put('article_class/status/{id}','ArticleClassController@status')->name('article_class.status');
//文章
Route::resource('article','ArticleController');
//投票
Route::resource('vote','VoteController');
//投票队伍
Route::resource('vote_team','VoteTeamController');
Route::put('vote_team/status/{id}','VoteTeamController@status')->name('vote_team.status');
//活动
Route::resource('activity','ActivityController');
Route::put('activity/status/{id}','ActivityController@status')->name('activity.status');

//相关奖品
Route::resource('prize','PrizeController');
Route::put('prize/status/{id}','PrizeController@status')->name('prize.status');
//中奖记录
Route::resource('lottery_log','LotteryLogController');

//相关题目
Route::resource('questionnaire','QuestionnaireController');
Route::put('questionnaire/status/{id}','QuestionnaireController@status')->name('questionnaire.status');
//答题记录
Route::resource('answer_log','AnswerLogController');

//报名活动
Route::resource('register_activity','ActivityRegisterController');
//报名用户
Route::resource('register_user','RegisterActivityUserController');
//后台反馈
Route::resource('admin_feedback','AdminFeedbackController');

Route::put('admin_feedback/status/{id}','AdminFeedbackController@status')->name('admin_feedback.status');