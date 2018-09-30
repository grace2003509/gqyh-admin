<?php

namespace App\Http\Controllers\Admin\Business;

use App\Models\Biz_Config;
use App\Models\Biz_Union_Home;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BizConfigController extends Controller
{
    /**
     * 商家列表首页设置页面
     */
    public function home_describe()
    {
        $buh_obj = new Biz_Union_Home();
        $s_obj = new Setting();

        $rsHome = $buh_obj->find(1);
        if(!$rsHome){
            $Data = array(
                "Users_ID"=>USERSID,
                "Home_Json"=>'[{"ContentsType":"1","Title":["","",""],"ImgPath":["/uploadfiles/i719b43jsa/image/5806d1f4dd.jpg","/uploadfiles/i719b43jsa/image/5806d13c8f.jpg","/uploadfiles/i719b43jsa/image/5806d140c9.jpg"],"Url":["","",""],"Postion":"t01","Width":"640","Height":"294","NeedLink":"1"},{"ContentsType":"0","Title":"","ImgPath":"/api/shop/union/i1.jpg","Url":"","Postion":"t02","Width":"320","Height":"140","NeedLink":"1"},{"ContentsType":"0","Title":"","ImgPath":"/api/shop/union/i2.jpg","Url":"","Postion":"t03","Width":"320","Height":"140","NeedLink":"1"},{"ContentsType":"0","Title":"","ImgPath":"/api/shop/union/i3.jpg","Url":"","Postion":"t04","Width":"320","Height":"140","NeedLink":"1"},{"ContentsType":"0","Title":"","ImgPath":"/api/shop/union/i4.jpg","Url":"","Postion":"t05","Width":"320","Height":"140","NeedLink":"1"}]'
            );
            $rsHome = $buh_obj->create($Data);
        }

        $Home_Json=json_decode($rsHome['Home_Json'],true);
        $json=$s_obj->set_homejson_array($Home_Json);

        if ($json == 110) {
            return redirect()->back()->with('errors', '模版设置有误！联系管理员！');
        }

        return view('admin.business.home_describe', compact('json'));

    }



    /**
     * 商家入驻描述设置页面
     */
    public function enter_describe()
    {
        $bc_obj = new Biz_Config();
        $item = $bc_obj->find(1);
        if (!$item) {
            $Data = array(
                "Users_ID" => USERSID,
                "BaoZhengJin" => "",
                "NianFei" => "",
                "JieSuan" => ""
            );
            $item = $bc_obj->create($Data);
        }

        return view('admin.business.enter_describe', compact('item'));

    }


    /**
     * 商家注册页面描述设置
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function register_describe()
    {
        $bc_obj = new Biz_Config();
        $item = $bc_obj->find(1);
        if(!$item){
            $Data = array(
                "Users_ID"=>USERSID,
                "join_desc"=>"1",
            );
            $item = $bc_obj->create($Data);
        }

        return view('admin.business.register_describe', compact('item'));

    }


    /**
     * 年费设置
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function fee_describe()
    {
        $bc_obj = new Biz_Config();
        $bizConfig = $bc_obj->find(1);
        if (!$bizConfig) {
            return redirect()->route('admin.business.register_describe')->with('errors', '注册未设置');
        }
        $year_list = json_decode($bizConfig['year_fee'],true);

        return view('admin.business.fee_describe', compact('year_list'));

    }


    /**
     * 保存设置
     */
    public function describe_update(Request $request)
    {
        $bc_obj = new Biz_Config();
        $buh_obj = new Biz_Union_Home();
        $input = $request->input();

        if(isset($input['submit_home']) && $input['submit_home'] == 1){
            $rsHome = $buh_obj->find(1);
            $Home_Json=json_decode($rsHome['Home_Json'],true);
            $no=intval($input["no"])+1;
            $is_array = is_array($Home_Json[$no-1]['Title']) ? 1 : 0;
            if($is_array==1){
                $input["TitleList"]=array();
                foreach($input["ImgPathList"] as $key=>$value){
                    $input["TitleList"][$key]="";
                    if(empty($value)){
                        unset($input["TitleList"][$key]);
                        unset($input["ImgPathList"][$key]);
                        unset($input["UrlList"][$key]);
                    }
                }
            }
            if(!empty($Home_Json[$no-1])){
                $Home_Json[$no-1]['Title'] = $is_array==1 ? $input["TitleList"] : $input['Title'];
                $Home_Json[$no-1]['ImgPath'] = $is_array==1 ? $input["ImgPathList"] : $input['ImgPath'];
                $Home_Json[$no-1]['Url'] = $is_array==1 ? $input["UrlList"] : $input['Url'];

                $Data=array(
                    "Home_Json"=>json_encode($Home_Json,JSON_UNESCAPED_UNICODE),
                );

                $buh_obj->where('Home_ID', 1)->update($Data);
            }
        }

        if(isset($input['submit_enter']) && $input['submit_enter'] == 1){
            $Data = array(
                "BaoZhengJin"=>$input['BaoZhengJin'],
                "NianFei"=>$input['NianFei'],
                "JieSuan"=>$input['JieSuan'],
                "bond_desc"=>$input['bond_desc'],
                "mobile_desc"=>$input['mobile_desc']
            );

            $bc_obj->where('ItemID', 1)->update($Data);
        }

        if(isset($input['submit_register']) && $input['submit_register'] == 1){
            $Data = array(
                "join_desc"=>$input['join_desc'],
                "bannerimg"=>$input['bannerimg'],
            );

            $bc_obj->where('ItemID', 1)->update($Data);
        }

        if(isset($input['submit_fee']) && $input['submit_fee'] == 1){
            if (!isset($input['year_fee'])) {
                return redirect()->back()->with('errors', '请增加年费设置');
            }
            foreach ($input['year_fee']['name'] as $k => $v ) {
                if (!is_numeric($v) || $v < 0) {
                    return redirect()->back()->with('errors', '时间为大于0的数字');
                }
            }
            foreach ($input['year_fee']['value'] as $k => $v ) {
                if (!is_numeric($v) || $v < 0) {
                    return redirect()->back()->with('errors', '费用为大于0的数字');
                }
            }
            $Data = array(
                "year_fee"=>json_encode($input['year_fee'],JSON_UNESCAPED_UNICODE)
            );

            $bc_obj->where('ItemID', 1)->update($Data);
        }

        return redirect()->back()->with('success', '编辑成功');
    }


}
