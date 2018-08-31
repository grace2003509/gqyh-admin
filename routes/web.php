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

//管理后台管理员认证
Route::group(['prefix' => 'admin', 'namespace' => 'Admin\Auth'], function ($route){
    //登入登出
    $route->get('/login', 'LoginController@showLoginForm')->name('login');
    $route->post('/login', 'LoginController@login')->name('admin.login');
    $route->get('/logout', 'LoginController@logout')->name('admin.user.logout');

    //忘记密码重置
    $route->get('/password/email', 'ForgotPasswordController@showLinkRequestForm')->name('admin.password.email');
    $route->post('/password/email', 'ForgotPasswordController@sendResetLinkEmail');
    $route->get('/password/reset/{token}', 'ResetPasswordController@showResetForm');
    $route->post('/password/reset', 'ResetPasswordController@reset')->name('admin.password.reset');
});

Route::group(['prefix' => 'admin/system', 'middleware' => ['auth', 'role:administrator']], function ($route) {
    //用户管理
    $route->resource('/user', 'Admin\System\UserController');
    //角色管理
    $route->resource('/role', 'Admin\System\RoleController');
    //角色分配
    $route->resource('/assignrole', 'Admin\System\AssignroleController');
    //权限分配
    $route->resource('/assignpermission', 'Admin\System\AssignpermissionController');
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
        //自定义URL
        $route->get('/diy_url', 'DiyUrlController@index')->name('admin.base.diy_url');
        $route->post('/diy_url_store', 'DiyUrlController@store')->name('admin.base.diy_url_store');
        $route->post('/diy_url_update/{id}', 'DiyUrlController@update')->name('admin.base.diy_url_update');
        $route->get('/diy_url_del/{id}', 'DiyUrlController@del')->name('admin.base.diy_url_del');
        //系统url查询
        $route->get('/sys_url', 'SysUrlController@index')->name('admin.base.sys_url');

    });

    //我的微信
    Route::group(['perfix' => 'wechat', 'namespace' => 'Wechat'], function ($route) {
        //微信接口配置
        $route->get('/api_index', 'ApiConfigController@index')->name('admin.wechat.api_index');
        $route->post('/api_edit', 'ApiConfigController@edit')->name('admin.wechat.api_edit');
        //首次关注设置
        $route->get('/reply_index', 'ReplyConfigController@index')->name('admin.wechat.reply_index');
        $route->post('/reply_edit', 'ReplyConfigController@edit')->name('admin.wechat.reply_edit');
        //自定义菜单设置
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

    Route::group(['prefix' => 'shop', 'namespace' => 'Shop'], function ($route) {
        //商城基本设置
        $route->get('/base_index', 'BaseConfigController@index')->name('admin.shop.base_index');
        $route->post('/base_update', 'BaseConfigController@update')->name('admin.shop.base_update');
        //积分设置
        $route->get('/integrate_index','IntegrateConfigController@index')->name('admin.shop.integrate_index');
        $route->post('/integrate_update','IntegrateConfigController@update')->name('admin.shop.integrate_update');
        //开关设置
        $route->get('/on_off_index', 'OnOffConfigController@index')->name('admin.shop.on_off_index');
        $route->get('/on_off_edit/{id}', 'OnOffConfigController@edit_status')->name('admin.shop.on_off_edit');
        $route->post('/on_off_store', 'OnOffConfigController@store')->name('admin.shop.on_off_store');
        $route->post('/on_off_update/{id}', 'OnOffConfigController@update')->name('admin.shop.on_off_update');
        $route->get('/on_off_del/{id}', 'OnOffConfigController@del')->name('admin.shop.on_off_del');
    });

    Route::group(['prefix' => 'active', 'namespace' => 'Active'], function ($route) {
        $route->get('/index', 'ActiveController@index')->name('admin.active.index');
        $route->get('/create', 'ActiveController@create')->name('admin.active.create');
        $route->post('/store', 'ActiveController@store')->name('admin.active.store');
        $route->get('/edit/{id}', 'ActiveController@edit')->name('admin.active.edit');
        $route->post('/update/{id}', 'ActiveController@update')->name('admin.active.update');
        $route->get('/del/{id}', 'ActiveController@del')->name('admin.active.del');
        $route->get('/biz_active/{id}', 'ActiveController@biz_actives')->name('admin.active.biz_active');
    });

    //财务统计
    Route::group(['prefix' => 'statistics', 'namespace' => 'Statistics'], function ($route) {
        //销售记录
        $route->get('/sale_record', 'SaleRecordController@index')->name('admin.statistics.sale_record');
        //自动结算配置
        $route->get('/balance_index', 'BalanceConfigController@index')->name('admin.statistics.balance_index');
        $route->post('/balance_update', 'BalanceConfigController@update')->name('admin.statistics.balance_update');
        //生成报告
        $route->get('/report_index', 'CreateReportController@index')->name('admin.statistics.report_index');
        $route->get('/report_download', 'CreateReportController@download')->name('admin.statistics.report_download');
        //付款单
        $route->get('/bill_index', 'PaymentBillController@index')->name('admin.statistics.bill_index');
        $route->get('/bill_create', 'PaymentBillController@create')->name('admin.statistics.bill_create');
        $route->get('/bill_show/{id}', 'PaymentBillController@show')->name('admin.statistics.bill_show');
        $route->post('/bill_store', 'PaymentBillController@store')->name('admin.statistics.bill_store');
        $route->get('/bill_del/{id}', 'PaymentBillController@del')->name('admin.statistics.bill_del');
        $route->get('/bill_okey/{id}', 'PaymentBillController@okey')->name('admin.statistics.bill_okey');

    });

    //上传文件
    Route::post('/upload_json', 'UploadController@upload_json')->name('admin.upload_json');
    Route::get('/file_manager_json', 'UploadController@file_manager_json')->name('admin.file_manager_json');

});


