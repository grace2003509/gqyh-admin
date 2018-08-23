<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Models\AreaRegion;
use App\Models\ShopConfig;
use App\Models\UsersConfig;
use App\Models\WechatKeyWordReply;
use App\Models\WechatMaterial;
use App\Services\ServiceSMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BaseConfigController extends Controller
{
    public function index()
    {
        $sc_obj = new ShopConfig();
        $wk_obj = new WechatKeyWordReply();
        $m_obj = new WechatMaterial();

        $rsKeyword = $wk_obj->where('Reply_Table', 'shop')
            ->where('Reply_TableID', 0)
            ->where('Reply_Display', 0)
            ->first();
        $rsConfig = $sc_obj->get_one();
        $json = $m_obj->get_one_bymodel("shop/union");
        $rsMaterial=json_decode($json['Material_Json'],true);
        if($rsConfig["DefaultAreaID"]>0){
            $r_obj = new AreaRegion();
            $areaids = $r_obj->get_areaparent($rsConfig["DefaultAreaID"]);
        }

        $sms_obj = new ServiceSMS();//剩余短信量
        $remain_sms = $sms_obj->get_remain_sms();

        return view('admin.shop.base_config',
            compact('rsConfig', 'rsKeyword', 'rsMaterial', 'remain_sms', 'areaids'));
    }


    public function update(Request $request)
    {
        $flag = true;

        $input = $request->input();

        if($input["Area"]>0){
            $areaid = $input["Area"];
        }else{
            if($input["City"]>0){
                $areaid = $input["City"];
            }else{
                return redirect()->back()->with('errors', '请选择默认地级市');
            }
        }

        $input['ShopAnnounce'] = str_replace('"','&quot;',$input['ShopAnnounce']);
        $input['ShopAnnounce'] = str_replace("'","&quot;",$input['ShopAnnounce']);
        $input['ShopAnnounce'] = str_replace('>','&gt;',$input['ShopAnnounce']);
        $input['ShopAnnounce'] = str_replace('<','&lt;',$input['ShopAnnounce']);
        $Data=array(
            "ShopName"=>$input["ShopName"],
            "biz_qrcodeone"=>$input["biz_qrcodeone"],
            "biz_qrcodetwo"=>$input["biz_qrcodetwo"],
            //"show_t"=>$input["show_t"],
            "DisSwitch"=>isset($input["DisSwitch"])?$input["DisSwitch"]:0,
            "ShopAnnounce"=>$input["ShopAnnounce"],
            "Bottom_Style"=>$input["Bottom_Style"],
            "ShopLogo"=>$input["Logo"],
            "NeedShipping"=>1,
//            "SendSms"=>isset($input["SendSms"])?$input["SendSms"]:0,
//            "MobilePhone"=>$input["MobilePhone"],
//            "CallEnable"=>isset($input["CallEnable"])?$input["CallEnable"]:0,
//            "CallPhoneNumber"=>$input["CallPhoneNumber"],
            "Icon_Color"=>$input["icon_color"],
            "CheckOrder"=>isset($input["CheckOrder"])?$input["CheckOrder"]:0,
            "Confirm_Time"=>isset($input["Confirm_Time"])?$input["Confirm_Time"]*86400:0,
            "DefaultLng"=>isset($input["DefaultLng"])?$input["DefaultLng"]:0,
            "Commit_Check"=>isset($input["CommitCheck"])?$input["CommitCheck"]:0,
            "Substribe"=>isset($input["Substribe"])?$input["Substribe"]:0,
            "SubstribeUrl"=>trim($input["SubstribeUrl"]),
            "moneytoscore"=>preg_replace('/[^\d\.]/', '', $input["moneytoscore"]),
            "SubscribeQrcode"=>trim(htmlspecialchars($input["SubscribeQrcodeDetail"])),
            "Distribute_Share"=>isset($input["DistributeShare"])?$input["DistributeShare"]:0,
            "Member_Share"=>isset($input["MemberShare"])?$input["MemberShare"]:0,
            "Member_SubstribeScore"=>empty($input["Member_SubstribeScore"]) ? 0 : $input["Member_SubstribeScore"],
            "SubstribeScore"=>isset($input["SubstribeScore"])?$input["SubstribeScore"]:0,
            "ShareLogo"=>$input["ShareLogo"],
            "ShareIntro"=>$input["ShareIntro"],
            "DefaultAreaID"=>$areaid,
            'user_trans_switch' => (int)$input['user_trans_switch']
        );
        if(!empty($input['app_login_secret_key'])){
            $Data['app_login_secret_key'] = htmlspecialchars($input['app_login_secret_key']);
        }
        $sc_obj = new ShopConfig();
        $Set = $sc_obj->set_config($Data);
        $flag = $flag||$Set;

        $Data = ['Is_Open_WxAppLogin' => !empty($input['Is_Open_WxAppLogin']) ? $input['Is_Open_WxAppLogin'] : 0];
        $uc_obj = new UsersConfig();
        $Set = $uc_obj->where('Users_ID', USERSID)->update($Data);
        $flag = $flag||$Set;

        $Data=array(
            "Reply_Keywords"=>$input["Keywords"],
            "Reply_PatternMethod"=>isset($input["PatternMethod"])?$input["PatternMethod"]:0
        );
        $wk_obj = new WechatKeyWordReply();
        $Set = $wk_obj->where('Reply_Table', 'shop')
            ->where('Reply_TableID', 0)
            ->where('Reply_Display', 0)
            ->update($Data);
        $flag = $flag||$Set;

        $Material=array(
            "Title"=>$input["Title"],
            "ImgPath"=>$input["ImgPath"],
            "TextContents"=>"",
            "Url"=>""
        );
        $Data=array(
            "Material_Json"=>json_encode($Material,JSON_UNESCAPED_UNICODE)
        );
        $wm_obj = new WechatMaterial();
        $Set = $wm_obj->where('Material_Table', 'shop/union')
            ->where('Material_TableID', 0)
            ->where('Material_Display', 0)
            ->update($Data);
        $flag = $flag||$Set;

        if($flag){
            return redirect()->back()->with('success', '设置成功');
        }else{
            return redirect()->back()->with('errors', '设置失败');
        }
    }
}
