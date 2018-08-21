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

Route::group(['prefix' => 'admin/system', 'middleware' => ['auth', 'role:administrator']], function () {

    //用户管理
    Route::resource('/user', 'Admin\System\UserController');

    //角色管理
    Route::resource('/role', 'Admin\System\RoleController');

    //角色分配
    Route::resource('/assignrole', 'Admin\System\AssignroleController');

    //权限分配
    Route::resource('/assignpermission', 'Admin\System\AssignpermissionController');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'namespace' => 'Admin'], function () {

    Route::get('/home', 'HomeController@index')->name('admin.home');

    //个人资料修改
    Route::resource('/system/profile', 'System\ProfileController');

    //基础设置
    Route::group(['prefix' => 'base', 'namespace' => 'Base'], function ($route) {
        //系统设置
        $route->get('/sys_index', 'SysConfigController@index')->name('admin.base.sys_index');
        $route->post('/sys_edit', 'SysConfigController@edit')->name('admin.base.sys_edit');
        //客服设置
        $route->get('/kf_index', 'KfConfigController@index')->name('admin.base.kf_index');
        $route->post('/kf_edit', 'KfConfigController@edit')->name('admin.base.kf_edit');
        //支付设置
        $route->get('/pay_index', 'PayConfigController@index')->name('admin.base.pay_index');
        $route->post('/pay_edit', 'PayConfigController@edit')->name('admin.base.pay_edit');
        $route->get('/wechat_set', 'PayConfigController@wechat_set')->name('admin.base.wechat_set');
        $route->post('/wechat_edit', 'PayConfigController@wechat_edit')->name('admin.base.wechat_edit');
        //快递公司管理
        $route->get('/shipping', 'ShippingController@index')->name('admin.base.shipping');
        $route->post('/shipping_store', 'ShippingController@store')->name('admin.base.shipping_store');
        $route->post('/shipping_update/{id}', 'ShippingController@update')->name('admin.base.shipping_update');
        $route->get('/shipping_del/{id}', 'ShippingController@destroy')->name('admin.base.shipping_del');
        $route->post('/shipping_recovered', 'ShippingController@destroy')->name('admin.base.shipping_recovered');

    });

    //我的微信
    Route::group(['perfix' => 'wechat', 'namespace' => 'Wechat'], function ($route) {

        $route->get('/api_index', 'ApiConfigController@index')->name('admin.wechat.api_index');
        $route->post('/api_edit', 'ApiConfigController@edit')->name('admin.wechat.api_edit');
        $route->get('/reply_index', 'ReplyConfigController@index')->name('admin.wechat.reply_index');
        $route->post('/reply_edit', 'ReplyConfigController@edit')->name('admin.wechat.reply_edit');
        $route->get('/menu_index', 'DiyMenuConfigController@index')->name('admin.wechat.menu_index');
        $route->get('/menu_edit/{id}', 'DiyMenuConfigController@edit')->name('admin.wechat.menu_edit');
        $route->post('/menu_update/{id}', 'DiyMenuConfigController@update')->name('admin.wechat.menu_update');
        $route->get('/menu_add', 'DiyMenuConfigController@add')->name('admin.wechat.menu_add');
        $route->post('/menu_store', 'DiyMenuConfigController@store')->name('admin.wechat.menu_store');
        $route->get('/menu_del/{id}', 'DiyMenuConfigController@del')->name('admin.wechat.menu_del');
        $route->get('/menu_push', 'DiyMenuConfigController@push')->name('admin.wechat.menu_push');
        $route->get('/menu_cancel', 'DiyMenuConfigController@cancel')->name('admin.wechat.menu_cancel');
        //关键词设置
        $route->get('/keyword_index', 'KeyWordController@index')->name('admin.wechat.keyword_index');
        $route->get('/keyword_edit/{id}', 'KeyWordController@edit')->name('admin.wechat.keyword_edit');
        $route->post('/keyword_update/{id}', 'KeyWordController@update')->name('admin.wechat.keyword_update');
        $route->get('/keyword_add', 'KeyWordController@add')->name('admin.wechat.keyword_add');
        $route->post('/keyword_store', 'KeyWordController@store')->name('admin.wechat.keyword_store');
        $route->get('/keyword_del/{id}', 'KeyWordController@del')->name('admin.wechat.keyword_del');
        //图文消息管理
        $route->get('/material_index', 'MaterialController@index')->name('admin.wechat.material_index');
        $route->get('/material_edit/{id}', 'MaterialController@edit')->name('admin.wechat.material_edit');
        $route->post('/material_update/{id}', 'MaterialController@update')->name('admin.wechat.material_update');
        $route->get('/material_add', 'MaterialController@add')->name('admin.wechat.material_add');
        $route->get('/material_madd', 'MaterialController@madd')->name('admin.wechat.material_madd');
        $route->post('/material_store', 'MaterialController@store')->name('admin.wechat.material_store');
        $route->get('/material_del/{id}', 'MaterialController@del')->name('admin.wechat.material_del');
    });

    //财务统计
    Route::group(['prefix' => 'statistics', 'namespace' => 'Statistics'], function ($route) {
        //生成报告
        $route->get('/index', 'CreateReportController@index')->name('admin.statistics.index');
        $route->get('/download', 'CreateReportController@download')->name('admin.statistics.download');

    });

    //上传文件
    Route::post('/upload_json', 'UploadController@upload_json')->name('admin.upload_json');
    Route::get('/file_manager_json', 'UploadController@file_manager_json')->name('admin.file_manager_json');

});


Route::group(['prefix' => 'admin', 'namespace' => 'Admin\Auth'], function (){
    //登入登出
    Route::get('/login', 'LoginController@showLoginForm')->name('login');
    Route::post('/login', 'LoginController@login')->name('admin.login');
    Route::get('/logout', 'LoginController@logout')->name('admin.user.logout');

//忘记密码重置
    Route::get('/password/email', 'ForgotPasswordController@showLinkRequestForm')->name('admin.password.email');
    Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail');
    Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm');
    Route::post('/password/reset', 'ResetPasswordController@reset')->name('admin.password.reset');
});


