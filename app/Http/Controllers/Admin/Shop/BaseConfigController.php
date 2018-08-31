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
        $rsConfig = $sc_obj->get_one();

        if($rsConfig["DefaultAreaID"]>0){
            $r_obj = new AreaRegion();
            $areaids = $r_obj->get_areaparent($rsConfig["DefaultAreaID"]);
        }

        return view('admin.shop.base_config',
            compact('rsConfig','areaids'));
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

        $Data=array(
            "ShopName"=>$input["ShopName"],
            "DisSwitch"=>isset($input["DisSwitch"])?$input["DisSwitch"]:0,
            "ShopAnnounce"=>$input["ShopAnnounce"],
            "Bottom_Style"=>$input["Bottom_Style"],
            "ShopLogo"=>$input["Logo"],
            "NeedShipping"=>1,
            "Icon_Color"=>$input["icon_color"],
            "CheckOrder"=>isset($input["CheckOrder"])?$input["CheckOrder"]:0,
            "Confirm_Time"=>isset($input["Confirm_Time"])?$input["Confirm_Time"]*86400:0,
            "DefaultLng"=>isset($input["DefaultLng"])?$input["DefaultLng"]:0,
            "Commit_Check"=>isset($input["CommitCheck"])?$input["CommitCheck"]:0,
            "Substribe"=>isset($input["Substribe"])?$input["Substribe"]:0,
            "moneytoscore"=>preg_replace('/[^\d\.]/', '', $input["moneytoscore"]),
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

        if($flag){
            return redirect()->back()->with('success', '设置成功');
        }else{
            return redirect()->back()->with('errors', '设置失败');
        }
    }
}
