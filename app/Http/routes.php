<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//    Route::get('/', function () {
//        return view('welcome');
//    });22

//每创建一个方法都要申请一个路由
//前台主页
    Route::get('/','Home\IndexController@index');
//前台列表页
    Route::get('/cate/{cate_id}','Home\IndexController@cate');
//前台详情页
    Route::get('/art/{art_id}','Home\IndexController@news');
//搜索
    Route::get('/search','Home\IndexController@search');
//评论
    Route::post('/art/comment','Home\IndexController@comment');
//测试
    Route::get('/demo','Home\DemoController@add');
//后台
//登录
    Route::any('admin/login','Admin\LoginController@login');
//验证码
    Route::get('admin/code','Admin\LoginController@code');
//独立出来 分配中间件
Route::group(['middleware'=>['admin.login'],'prefix'=>'admin','namespace'=>'Admin'],function(){
//后台主页子页面
    Route::get('info','IndexController@info');
//后台主页
    Route::get('index','IndexController@index');
//删除缓存
    Route::get('cache','IndexController@cache');
//退出
    Route::get('quit','LoginController@quit');
//重置密码
    Route::any('pass','IndexController@pass');
//文章分类
    Route::resource('category','CategoryController');
//文章分类排序ajax
    Route::post('cate/changeorder','CategoryController@changeOrder');
//文章
    Route::resource('article','ArticleController');
//文章推荐
    Route::get('art/commend/{art_id}','ArticleController@commend');
 //文章评论
    Route::get('art/comment','CommentController@index');
 //文章评论详情
    Route::get('art/comment/show/{com_id}','CommentController@show');
//文章评论删除
    Route::post('art/comment/delete','CommentController@delete');
//图片上传
    Route::any('upload','CommonController@upload');
//链接
    Route::resource('links','LinksController');
//链接排序ajax
    Route::post('links/changeorder','LinksController@changeOrder');
//网站配置项模块
    Route::resource('config','ConfigController');
//网站配置项排序ajax
    Route::post('config/changeorder','ConfigController@changeOrder');
//网站配置项内容修改
    Route::post('config/changecontent','ConfigController@changeContent');
//网站配置导出
    Route::get('putfile','ConfigController@putFile');

});


