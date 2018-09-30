<?php

namespace App\Http\Controllers\Admin\Business;

use App\Models\AreaRegion;
use App\Models\Biz;
use App\Models\Biz_Group;
use App\Models\Biz_Home;
use App\Models\Biz_Skin;
use App\Models\Biz_Union_Category;
use App\Models\Setting;
use App\Models\ShopProduct;
use App\Models\UserOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BizUnionController extends Controller
{
    /**
     * 联盟商家列表
     */
    public function index(Request $request)
    {
        $input = $request->input();
        $buc_obj = new Biz_Union_Category();
        $b_obj = new Biz();

        $category_list = $buc_obj->where('Category_ParentID', 0)
            ->orderBy('Category_Index', 'asc')
            ->orderBy('Category_ID', 'asc')
            ->get();
        foreach($category_list as $key => $value){
            $child = $buc_obj->where('Category_ParentID', $value['Category_ID'])
                ->orderBy('Category_ParentID', 'asc')
                ->orderBy('Category_Index', 'asc')
                ->orderBy('Category_ID', 'asc')
                ->get();
            if(count($child) > 0){
                $value['child'] = $child;
            }
        }

        //搜索
        if(isset($input['search']) && $input['search'] == 1){
            if($input['Keyword']){
                $b_obj = $b_obj->where($input['Fields'], 'like', '%'.$input['Keyword'].'%');
            }
            if($input['SearchCateId']>0){
                $catid = $buc_obj->select('Category_ID')
                    ->where('Category_ParentID', $input['SearchCateId'])
                    ->get();
                if(count($catid) > 0){
                    $b_obj = $b_obj->whereIn('Category_ID', $catid);
                }else{
                    $b_obj = $b_obj->where('Category_ID', intval($input['SearchCateId']));
                }
            }
            if($input['Status']!="all"){
                $b_obj = $b_obj->where('Biz_Status', intval($input['Status']));
            }
            if($input['OrderBy']){
                $b_obj = $b_obj->orderBy('Biz_CreateTime', $input['OrderBy']);
            }
        }else{
            $b_obj = $b_obj->orderBy('Biz_Status')->orderByDesc('Biz_CreateTime');
        }
        //商家列表
        $lists = $b_obj->where('Is_Union', 1)->paginate(15);
        foreach($lists as $key => $value){
            $value["expiredate"] = !empty($value["expiredate"]) ? date("Y-m-d",$value["expiredate"]) : '';
            $value["addtype"] = $value['addtype'] == 1 ? '后台添加' : '注册';
            $value["Biz_Status"] = $value["Biz_Status"] == 0 ? '正常' : '禁用';
        }

        return view('admin.business.biz_union', compact('category_list', 'lists'));
    }


    /**
     * 添加联盟商家页面
     */
    public function create()
    {
        $bg_obj = new Biz_Group();
        $buc_obj = new Biz_Union_Category();
        $s_obj = new Setting();

        $category_list = $buc_obj->where('Category_ParentID', 0)
            ->orderBy('Category_Index', 'asc')
            ->orderBy('Category_ID', 'asc')
            ->get();
        foreach($category_list as $key => $value){
            $child = $buc_obj->where('Category_ParentID', $value['Category_ID'])
                ->orderBy('Category_ParentID', 'asc')
                ->orderBy('Category_Index', 'asc')
                ->orderBy('Category_ID', 'asc')
                ->get();
            if(count($child) > 0){
                $value['child'] = $child;
            }
        }

        //商家分组
        $groups = $bg_obj->orderBy('Group_Index')->orderBy('Group_ID')->get();

        //百度地图设置
        $setting = $s_obj->select('sys_baidukey')->find(1);
        $ak_baidu = $setting["sys_baidukey"];

        return view('admin.business.biz_union_create', compact(
            'groups', 'category_list', 'ak_baidu'));

    }


    /**
     * 保存联盟商家
     */
    public function store(Request $request)
    {
        $input = $request->input();

        $rules = [
            'Account' => 'required|unique:biz,Biz_Account',
            'PassWord' => 'required|confirmed',
            'FinanceRate' => 'required_if:FinanceType,0|numeric|min:0|max:100',
            'PaymenteRate' => 'required|numeric|min:0|max:100',
            'bond_free' => 'nullable|numeric|min:0',
            'Phone' => 'required|phone',
            'SmsPhone' => 'nullable|mobile',
            'PrimaryLng' => 'required',
            'PrimaryLat' => 'required',
        ];
        $message = [
            'Account.required' => '商家登录账号不能为空',
            'Account.unique' => '此登录账号已被注册，请更改',
            'PassWord.required' => '登录密码不能为空',
            'PassWord.confirmed' => '登录密码与确认密码不相同',
            'FinanceRate.min' => '网站提成不能小于0',
            'FinanceRate.max' => '网站提成不能大于100',
            'PaymenteRate.min' => '结算比例不能小于0',
            'PaymenteRate.max' => '结算比例不能大于100',
            'bond_free.numeric' => '保证金必须是数字',
            'Phone.required' => '联系电话不能为空',
            'Phone.phone' => '联系电话格式不正确',
            'SmsPhone.mobile' => '接收短信电话格式不正确',
            'PrimaryLng.required' => '定位有误重新添加',
            'PrimaryLat.required' => '定位有误重新添加',
        ];
        $validator = Validator::make($input, $rules, $message);
        if($validator->fails()){
            return redirect()->back()->with('errors', $validator->messages())->withInput();
        }

        $rmenu = array();
        if(!isset($input["rmenu"])){
            return redirect()->back()->with('errors', '请选择分类')->withInput();
        }
        foreach($input["rmenu"] as $k=>$vv){
            $rmenu[] = $k;
            foreach($vv as $v){
                $rmenu[] = $v;
            }
        }
        $rmenu = array_unique($rmenu);

        $b_obj = new Biz();
        $bh_obj = new Biz_Home();
        $bs_obj = new Biz_Skin();

        $input['Introduce'] = htmlspecialchars($input['Introduce'], ENT_QUOTES);
        $Data=array(
            "Biz_Account"=> trim($input['Account']),
            "bond_free"=>empty($input['bond_free'])?'0':trim($input['bond_free']),
            "expiredate"=>empty($input['expiredate'])?'0':strtotime($input['expiredate']),
            "Biz_PassWord"=>md5($input['PassWord']),
            "Biz_Name"=>$input['Name'],
            "Group_ID"=>$input['GroupID'],
            "Area_ID"=>!empty($input["Area"]) ? $input["Area"] : 0,
            "Biz_Province"=>empty($input["Province"]) ? 0 : $input["Province"],
            "Biz_City"=>empty($input["City"]) ? 0 : $input["City"],
            "Biz_Area"=>empty($input["Area"]) ? 0 : $input["Area"],
            "City_ID"=>empty($input["City"])?0:$input["City"],
            "Region_ID"=>!empty($input["RegionID_0"]) ? $input["RegionID_0"] : 0,
            "Biz_Address"=>$input['Address'],
            "Biz_PrimaryLng"=>$input['PrimaryLng'],
            "Biz_PrimaryLat"=>$input['PrimaryLat'],
            "Biz_Homepage"=>$input['Homepage'],
            "Biz_Introduce"=>$input['Introduce'],
            "Biz_Contact"=>$input['Contact'],
            "Biz_Phone"=>$input['Phone'],
            "Biz_Email"=>$input['Email'],
            "Biz_Status"=>$input['Status'],
            "Biz_CreateTime"=>time(),
            "Biz_SmsPhone"=>$input['SmsPhone'],
            "Skin_ID"=>2,
            "Finance_Type"=>$input["FinanceType"],
            "Finance_Rate"=>empty($input["FinanceRate"]) ? 0 : $input["FinanceRate"],
            "PaymenteRate"=>empty($input["PaymenteRate"]) ? 100 : $input["PaymenteRate"],
            "Users_ID"=>USERSID,
            "Biz_Logo"=>$input['LogoPath'],
            "Is_Union"=>1,
            "is_agree"=>1,
            "is_auth"=>2,
            "is_pay"=>1,
            "is_biz"=>1,
            "addtype"=>1,
            "Invitation_Code"=>isset($input['Invitation_Code'])?trim($input['Invitation_Code']):'',
            "Category_ID"=>','.implode(",",$rmenu).',',
            "Category_Arr"=>json_encode(isset($input['rmenu'])?$input['rmenu']:'',JSON_UNESCAPED_UNICODE),
            "Biz_IndexShow"=>$input["IndexShow"],
            "Biz_Index"=> $input["Index"] > 0 ? $input["Index"] : 0
        );
        $Flag = $b_obj->create($Data);

        $r = $bs_obj->select('Skin_Json')->find(2);
        $Data2 = array(
            "Users_ID"=>USERSID,
            "Biz_ID"=>$Flag['Biz_ID'],
            "Skin_ID"=>2,
            "Home_Json"=>$r["Skin_Json"]
        );
        $bh_obj->create($Data2);

        if($Flag){
            $biz_url = 'http://'.$_SERVER["HTTP_HOST"].'/api/shop/biz/'.$Flag['Biz_ID'].'/';
            $qrcode = array(
                "Biz_Qrcode"=>generate_qrcode($biz_url),
            );
            $b_obj->where('Biz_ID', $Flag['Biz_ID'])->update($qrcode);

            return redirect()->route('admin.business.biz_union_index')->with('success', '添加成功');
        }else{
            return redirect()->back()->with('errors', '保存失败');
        }
    }


    /**
     * 编辑联盟商家页面
     */
    public function edit($id)
    {
        $buc_obj = new Biz_Union_Category();
        $bg_obj = new Biz_Group();
        $b_obj = new Biz();
        $s_obj = new Setting();
        $ar_obj = new AreaRegion();

        $rsBiz = $b_obj->find($id);

        $areaids = $ar_obj->get_areaparent($rsBiz["Area_ID"]);
        $regionids = $ar_obj->get_regionids($rsBiz["Region_ID"]);

        if($regionids[1] == 0){
            $regions = $ar_obj->select('Region_ID', 'Region_Name')
                ->where('Area_ID', empty($areaids["city"]) ? 0 : $areaids["city"])
                ->where('Region_ParentID', 0)
                ->orderBy('Region_Index', 'asc')
                ->orderBy('Region_ID', 'asc')
                ->get();
        }else{
            $regions = $ar_obj->select('Region_ID', 'Region_Name')
                ->where('Area_ID', empty($areaids["city"]) ? 0 : $areaids["city"])
                ->where('Region_ParentID', $regionids[1])
                ->orderBy('Region_Index', 'asc')
                ->orderBy('Region_ID', 'asc')
                ->get();
        }

        $category_list = $buc_obj->where('Category_ParentID', 0)
            ->orderBy('Category_Index', 'asc')
            ->orderBy('Category_ID', 'asc')
            ->get();
        foreach($category_list as $key => $value){
            $child = $buc_obj->where('Category_ParentID', $value['Category_ID'])
                ->orderBy('Category_ParentID', 'asc')
                ->orderBy('Category_Index', 'asc')
                ->orderBy('Category_ID', 'asc')
                ->get();
            if(count($child) > 0){
                $value['child'] = $child;
            }
        }

        //商家分组
        $groups = $bg_obj->orderBy('Group_Index')->orderBy('Group_ID')->get();
        if(!empty($rsBiz['Category_Arr'])){
            $category_arr = json_decode($rsBiz['Category_Arr'],true);
        }

        //百度地图设置
        $setting = $s_obj->select('sys_baidukey')->find(1);
        $ak_baidu = $setting["sys_baidukey"];

        return view('admin.business.biz_union_edit', compact(
            'groups', 'rsBiz', 'ak_baidu', 'category_list', 'category_arr', 'areaids', 'regionids', 'regions'));

    }


    /**
     * 编辑联盟商家
     */
    public function update(Request $request, $id)
    {
        $input = $request->input();

        $rules = [
            'Account' => "required|unique:biz,Biz_Account,{$id},Biz_ID",
            'PassWord' => 'nullable|confirmed',
            'FinanceRate' => 'required_if:FinanceType,0|numeric|min:0|max:100',
            'PaymenteRate' => 'required|numeric|min:0|max:100',
            'bond_free' => 'nullable|numeric|min:0',
            'Phone' => 'required|phone',
            'SmsPhone' => 'nullable|mobile',
            'PrimaryLng' => 'required',
            'PrimaryLat' => 'required',
        ];
        $message = [
            'Account.required' => '商家登录账号不能为空',
            'Account.unique' => '此登录账号已被注册，请更改',
            'PassWord.confirmed' => '登录密码与确认密码不相同',
            'FinanceRate.min' => '网站提成不能小于0',
            'FinanceRate.max' => '网站提成不能大于100',
            'PaymenteRate.min' => '结算比例不能小于0',
            'PaymenteRate.max' => '结算比例不能大于100',
            'bond_free.numeric' => '保证金必须是数字',
            'Phone.required' => '联系电话不能为空',
            'Phone.phone' => '联系电话格式不正确',
            'SmsPhone.mobile' => '接收短信电话格式不正确',
            'PrimaryLng.required' => '定位有误重新添加',
            'PrimaryLat.required' => '定位有误重新添加',
        ];
        $validator = Validator::make($input, $rules, $message);
        if($validator->fails()){
            return redirect()->back()->with('errors', $validator->messages());
        }

        $rmenu = array();
        if(!isset($input["rmenu"])){
            return redirect()->back()->with('errors', '请选择分类')->withInput();
        }
        foreach($input["rmenu"] as $k=>$vv){
            $rmenu[] = $k;
            foreach($vv as $v){
                $rmenu[] = $v;
            }
        }
        $rmenu = array_unique($rmenu);

        $b_obj = new Biz();
        $sp_obj = new ShopProduct();

        $biz = $b_obj->find($id);

        $input['Introduce'] = htmlspecialchars($input['Introduce'], ENT_QUOTES);
        $Data = array(
            "Biz_Name" => $input['Name'],
            "bond_free"=>empty($input['bond_free'])?'0':trim($input['bond_free']),
            "expiredate"=>empty($input['expiredate'])?'0':strtotime($input['expiredate']),
            "Area_ID"=>!empty($input["Area"]) ? $input["Area"] : 0,
            "Biz_Province"=>empty($input["Province"]) ? 0 : $input["Province"],
            "Biz_City"=>empty($input["City"]) ? 0 : $input["City"],
            "Biz_Area"=>empty($input["Area"]) ? 0 : $input["Area"],
            "City_ID"=>empty($input["City"])?0:$input["City"],
            "Region_ID"=>!empty($input["RegionID_0"]) ? $input["RegionID_0"] : 0,
            "Biz_Address"=>$input['Address'],
            "Biz_PrimaryLng"=>$input['PrimaryLng'],
            "Biz_PrimaryLat"=>$input['PrimaryLat'],
            "Biz_Homepage" => $input['Homepage'],
            "Biz_Introduce" => $input['Introduce'],
            "Biz_Contact" => $input['Contact'],
            "Biz_Phone" => $input['Phone'],
            "Biz_SmsPhone" => $input['SmsPhone'],
            "Biz_Email" => $input['Email'],
            "Biz_Status" => $input['Status'],
            "Finance_Type" => $input["FinanceType"],
            "Finance_Rate" => empty($input["FinanceRate"]) ? 0 : $input["FinanceRate"],
            "Group_ID" => $input["GroupID"],
            "PaymenteRate" => empty($input["PaymenteRate"]) ? 100 : $input["PaymenteRate"],
            "Biz_Logo" => $input['LogoPath'],
            "Invitation_Code" => isset($input['Invitation_Code']) ? trim($input['Invitation_Code']) : '',
            "Biz_IndexShow"=>$input["IndexShow"],
            "Category_ID"=>','.implode(",",$rmenu).',',
            "Category_Arr"=>json_encode(isset($input['rmenu'])?$input['rmenu']:'',JSON_UNESCAPED_UNICODE),
            "Biz_Index"=>isset($input["Index"]) ? $input["Index"] : 0
        );
        if (!empty($input["PassWord"])) {
            $Data["Biz_PassWord"] = md5($input["PassWord"]);
        }

        $Flag = $b_obj->where('Biz_ID', $id)->update($Data);

        if ($Flag) {
            if ($input["FinanceType"] == 0 && $input["FinanceRate"] != $biz['Finance_Rate']) {
                $products = $sp_obj->select('Products_ID','Products_FinanceType','Products_FinanceRate','Products_PriceS','Products_PriceX')
                    ->where('Biz_ID', $id)->get();
                foreach ($products as $v) {
                    $data2 = array(
                        'Products_FinanceType' => 0,
                        'Products_FinanceRate' => empty($input["FinanceRate"]) ? 0 : $input["FinanceRate"],
                        'Products_PriceS' => number_format($v['Products_PriceX'] * (1 - $input["FinanceRate"] / 100), 2, '.', '')
                    );
                    $sp_obj->where('Products_ID', $v["Products_ID"])->update($data2);
                }
            }
        }
        return redirect()->route('admin.business.biz_union_index')->with('success', '保存成功');
    }


    /**
     * 删除联盟商家
     */
    public function del($id)
    {
        $sp_obj = new ShopProduct();
        $uo_obj = new UserOrder();
        $b_obj = new Biz();

        $delconfirm_shop = $sp_obj->select('Products_ID')->where('Biz_ID', $id)->count();
        if($delconfirm_shop > 0) {
            return redirect()->back()->with('errors', '该商家有产品不能删除');
        }

        $delconfirm_order = $uo_obj->select('Order_ID')
            ->where('Order_Status', '<>', 4)
            ->where('Biz_ID', $id)->count();
        if($delconfirm_order > 0) {
            return redirect()->back()->with('errors', '该商家存在未完成订单不能删除');
        }

        $Flag=$b_obj->destroy($id);
        if($Flag) {
            return redirect()->back()->with('success', '删除成功');
        }else {
            return redirect()->back()->with('errors', '删除失败');
        }
    }


    /**
     * 获取区域列表
     */
    public function get_region(Request $request)
    {
        $input = $request->input();
        $areaid = isset($input["areaid"]) ? $input["areaid"] : 0;
        $parentid = isset($input["parentid"]) ? $input["parentid"] : 0;

        $ar_obj = new AreaRegion();

        if($areaid>0){
            $ar_obj = $ar_obj->where('Region_ParentID', 0)
                ->where('Area_ID', $areaid)
                ->orderBy('Region_Index', 'asc')
                ->orderBy('Region_ID', 'asc');
        }
        if($parentid>0){
            $ar_obj = $ar_obj->where('Region_ParentID', $parentid)
                ->orderBy('Region_Index', 'asc')
                ->orderBy('Region_ID', 'asc');
        }

        $html = array();
        $list = $ar_obj->select('Region_ID', 'Region_Name')->get();
        foreach($list as $key => $value){
            $html[] = array('id' => $value['Region_ID'], 'name' => $value['Region_Name']);
        }

        $Data = array(
            "status"=> count($html)>0 ? 1 : 0,
            "html"=>count($html)>0 ? $html : ""
        );
        echo json_encode($Data,JSON_UNESCAPED_UNICODE);
        exit;
    }

}
