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

    Route::group(['prefix' => 'admin/statistics', 'middleware' => 'auth'], function () {

        //生成报告
        Route::get('/index', 'Admin\Statistics\CreateReportController@index')->name('admin.statistics.index');
        Route::get('/download', 'Admin\Statistics\CreateReportController@download')->name('admin.statistics.download');

    });

});

//登入登出
Route::get('/admin/login', 'Admin\Auth\LoginController@showLoginForm')->name('admin.user.login');
Route::post('/admin/login', 'Admin\Auth\LoginController@login')->name('admin.login');
Route::get('/admin/logout', 'Admin\Auth\LoginController@logout')->name('admin.user.logout');

//忘记密码重置
Route::get('/admin/password/email', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.email');
Route::post('/admin/password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('/admin/password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm');
Route::post('/admin/password/reset', 'Admin\Auth\ResetPasswordController@reset')->name('admin.password.reset');
