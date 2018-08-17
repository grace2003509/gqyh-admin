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

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {

    Route::get('/home', 'Admin\HomeController@index')->name('admin.home');

    //个人资料修改
    Route::resource('/system/profile', 'Admin\System\ProfileController');

    Route::group(['prefix' => 'statistics', 'middleware' => 'auth'], function () {
        //生成报告
        Route::get('/index', 'Admin\Statistics\CreateReportController@index')->name('admin.statistics.index');
        Route::get('/download', 'Admin\Statistics\CreateReportController@download')->name('admin.statistics.download');

    });

    //基础设置
    Route::group(['prefix' => 'base', 'middleware' => 'auth'], function () {
        //系统设置
        Route::get('/sys_index', 'Admin\Base\SysConfigController@index')->name('admin.base.sys_index');
        Route::post('/sys_edit', 'Admin\Base\SysConfigController@edit')->name('admin.base.sys_edit');
        //客服设置
        Route::get('/kf_index', 'Admin\Base\KfConfigController@index')->name('admin.base.kf_index');
        Route::post('/kf_edit', 'Admin\Base\KfConfigController@edit')->name('admin.base.kf_edit');
        //支付设置
        Route::get('/pay_index', 'Admin\Base\PayConfigController@index')->name('admin.base.pay_index');
        Route::post('/pay_edit', 'Admin\Base\PayConfigController@edit')->name('admin.base.pay_edit');
        Route::get('/wechat_set', 'Admin\Base\PayConfigController@wechat_set')->name('admin.base.wechat_set');
        Route::post('/wechat_edit', 'Admin\Base\PayConfigController@wechat_edit')->name('admin.base.wechat_edit');

    });

    //上传文件
    Route::post('/upload_json', 'Admin\UploadController@upload_json')->name('admin.upload_json');
    Route::get('/file_manager_json', 'Admin\UploadController@file_manager_json')->name('admin.file_manager_json');

});

//登入登出
Route::get('/admin/login', 'Admin\Auth\LoginController@showLoginForm')->name('login');
Route::post('/admin/login', 'Admin\Auth\LoginController@login')->name('admin.login');
Route::get('/admin/logout', 'Admin\Auth\LoginController@logout')->name('admin.user.logout');

//忘记密码重置
Route::get('/admin/password/email', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.email');
Route::post('/admin/password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('/admin/password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm');
Route::post('/admin/password/reset', 'Admin\Auth\ResetPasswordController@reset')->name('admin.password.reset');
