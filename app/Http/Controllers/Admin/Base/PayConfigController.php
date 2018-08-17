<?php

namespace App\Http\Controllers\Admin\Base;

use App\Models\UsersConfig;
use App\Models\UsersPayConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PayConfigController extends Controller
{
    public function index()
    {
        $rsConfig = UsersPayConfig::where('Users_ID', USERSID)->first();
        if (!$rsConfig) {
            $Data = array(
                'Users_ID' => USERSID
            );
            UsersPayConfig::create("users_payconfig", $Data);
            $rsConfig = UsersPayConfig::where('Users_ID', USERSID)->first();
        }
        return view('admin.base.pay_config', compact('rsConfig'));
    }


    public function edit(Request $request)
    {
        $input = $request->input();
        $Data = array(
            "Payment_AlipayEnabled" => isset($input["AlipayEnabled"]) ? $input["AlipayEnabled"] : 0,
            "Payment_AlipayPartner" => $input["AlipayPartner"],
            "Payment_AlipayKey" => $input["AlipayKey"],
            "Payment_AlipayAccount" => $input["AlipayAccount"],
            "Payment_UnionpayEnabled" => isset($input["UnionpayEnabled"]) ? $input["UnionpayEnabled"] : 0,
            "Payment_UnionpayAccount" => $input["Unionum"],
            "PaymentUnionpayPfx" => $input["PfxPath"],
            "PaymentUnionpayPfxpwd" => $input["Pfxpwd"],
            "PaymentUnionpayCer" => $input["CerPath"],
            "Payment_OfflineEnabled" => isset($input["OfflineEnabled"]) ? $input["OfflineEnabled"] : 0,
            "Payment_RmainderEnabled" => isset($input["RemainderEnabled"]) ? $input["RemainderEnabled"] : 0,
            "Payment_OfflineInfo" => $input["OfflineInfo"],
            "PaymentWxpayEnabled" => isset($_POST["PaymentWxpayEnabled"]) ? $input["PaymentWxpayEnabled"] : 0,
            "PaymentWxpayType" => $input["PaymentWxpayType"],
            "PaymentWxpayPartnerId" => $input["PaymentWxpayPartnerId"],
            "PaymentWxpayPartnerKey" => $input["PaymentWxpayPartnerKey"],
            "PaymentWxpayPaySignKey" => $input["PaymentWxpayPaySignKey"],
            "PaymentWxpayCert" => $input["CertPath"],
            "PaymentWxpayKey" => $input["KeyPath"],
            "PaymentYeepayEnabled" => isset($input["PaymentYeepayEnabled"]) ? $input["PaymentYeepayEnabled"] : 0,
            "PaymentYeepayEnabled" => isset($input["PaymentYeepayEnabled"]) ? $input["PaymentYeepayEnabled"] : 0,
            "PaymentYeepayAccount" => $input["PaymentYeepayAccount"],
            "PaymentYeepayPrivateKey" => $input["PaymentYeepayPrivateKey"],
            "PaymentYeepayPublicKey" => $input["PaymentYeepayPublicKey"],
            "PaymentYeepayYeepayPublicKey" => $input["PaymentYeepayYeepayPublicKey"],
            "PaymentYeepayProductCatalog" => !empty($input["PaymentYeepayProductCatalog"]) ? $input["PaymentYeepayProductCatalog"] : 0,
        );
        if (isset($appwitch20180321) && $appwitch20180321) {
            $Data["PaymentAppWxpayCert"] = !empty($input["CertAppPath"]) ? $input["CertAppPath"] : '';
            $Data["PaymentAppWxpayKey"] = !empty($input["KeyAppPath"]) ? $input["KeyAppPath"] : '';
            $Data["PaymentAppWxpayPaySignKey"] = !empty($input["PaymentAppWxpayPaySignKey"]) ? $input["PaymentAppWxpayPaySignKey"] : '';
            $Data["PaymentAppWxpayEnabled"] = !empty($input["PaymentAppWxpayEnabled"]) ? $input["PaymentAppWxpayEnabled"] : 0;
            $Data["PaymentAppWxpayPartnerId"] = !empty($input['PaymentAppWxpayPartnerId']) ? $input['PaymentAppWxpayPartnerId'] : '';
            $Data["PaymentAppWechatAppId"] = !empty($input['PaymentAppWechatAppId']) ? $input['PaymentAppWechatAppId'] : '';
        }

        $Set = UsersPayConfig::where('Users_ID', USERSID)->update($Data);

        if ($Set) {
            return redirect()->route('admin.base.pay_index')->with('success', '设置成功！');
        } else {
            return redirect()->route('admin.base.pay_index')->with('errors', '设置失败！');
        }
    }


    public function wechat_set()
    {
        $rsUsers = UsersConfig::find(USERSID);
        return view('admin.base.wechat_set', compact('rsUsers'));
    }


    public function wechat_edit(Request $request)
    {
        $input = $request->input();
        $Data = array(
            "Users_WechatAppId" => $input["WechatAppId"],
            "Users_WechatAppSecret" => $input["WechatAppSecret"],
            "Users_WechatAuth" => isset($input["WechatAuth"]) ? 1 : 0,
            "Users_WechatVoice" => isset($input["WechatVoice"]) ? 1 : 0,
        );

        $obj = UsersConfig::find(USERSID);
        $Flag = $obj->update($Data);
        if ($Flag) {
            return redirect()->route('admin.base.wechat_set')->with('success', '设置成功！');
        } else {
            return redirect()->route('admin.base.wechat_set')->with('errors', '设置失败！');
        }
    }


}
