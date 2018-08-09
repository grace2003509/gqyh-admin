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

Route::group(['prefix' => 'system', 'middleware' => ['auth', 'role:administrator']], function () {

    //用户管理
    Route::resource('/user', 'System\UserController');

    //角色管理
    Route::resource('/role', 'System\RoleController');

    //角色分配
    Route::resource('/assignrole', 'System\AssignroleController');

    //权限分配
    Route::resource('/assignpermission', 'System\AssignpermissionController');
});

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'HomeController@index')->name('home');

    //个人资料修改
    Route::resource('/system/profile', 'System\ProfileController');

});

//登入登出
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('user.login');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::get('/logout', 'Auth\LoginController@logout')->name('user.logout');

//忘记密码重置
Route::get('/password/email', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.email');
Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset');
