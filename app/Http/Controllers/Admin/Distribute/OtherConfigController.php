<?php

namespace App\Http\Controllers\Admin\Distribute;

use App\Models\Dis_Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OtherConfigController extends Controller
{
    /**
     * 分销其他设置展示页面
     */
    public function index()
    {
        $dc_obj = new Dis_Config();

        //获取分销配置信息
        $rsConfig = $dc_obj->find(1);

        return view('admin.distribute.other_config', compact('rsConfig'));

    }


    /**
     * 保存分销其他设置
     */
    public function update(Request $request)
    {
        $input = $request->input();

        $dc_obj = new Dis_Config();
        $distribute_config = $dc_obj->find(1);

        //是否可自定义店名和头像
        $distribute_config->Distribute_Customize = $input['Customize'];
        //分销中心强制绑定手机号
        $distribute_config->Bindmobile = $input['Bindmobile'];
        //是否显示下级名称
        $distribute_config->Fbonsnameswitch = $input['Fbonsnameswitch'];
        //总部分销商排行榜
        $distribute_config->HIncomelist_Open = $input['HIncomelist_Open'];
        //入榜最低佣金
        $distribute_config->H_Incomelist_Limit = !empty($_POST['H_Incomelist_Limit'])?$_POST['H_Incomelist_Limit']:0;
        //昵称后的文字
        $distribute_config->nicheng_after = $_POST['nicheng_after'];
        //二维码背景图
        $distribute_config->QrcodeBg = $_POST['QrcodeBg'];
        //分销中心顶部banner图片
        $distribute_config->ApplyBanner = $_POST['ApplyBanner'];
        //邀请人限制
        $distribute_config->Distribute_Limit = $_POST["Distribute_Limit"];
        //商城入口设置
        $distribute_config->Distribute_ShopOpen = $_POST["Distribute_ShopOpen"];

        $distribute_config->save();

        return redirect()->back()->with('success', '保存成功');
    }
}
