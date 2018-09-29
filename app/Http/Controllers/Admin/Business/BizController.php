<?php

namespace App\Http\Controllers\Admin\Business;

use App\Models\Biz;
use App\Models\Biz_Group;
use App\Models\Biz_Home;
use App\Models\Biz_Skin;
use App\Models\Dis_Account;
use App\Models\ShopProduct;
use App\Models\UserOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BizController extends Controller
{
    /**
     * 普通商家列表页
     */
    public function index(Request $request)
    {
        $bg_obj = new Biz_Group();
        $b_obj = new Biz();
        $da_obj = new Dis_Account();
        $input = $request->input();

        //升级
        if(isset($input["action"]) && $input["action"]=="upgrade"){
            $Data = array(
                "Is_Union"=>1,
                "Skin_ID"=>2
            );
            $Flag = $b_obj->where('Biz_ID', $input["id"])->update($Data);
            if($Flag){
                $sp_obj = new ShopProduct();
                $sp_obj->where('Biz_ID', $input["id"])->update(["Products_Union_ID"=>1]);
                return redirect()->back()->with('success', '升级成功');
            }else{
                return redirect()->back()->with('errors', '升级失败');
            }
        }

        //商家分组
        $groups = $bg_obj->orderBy('Group_Index')->orderBy('Group_ID')->get();

        $salesman_array = array();
        $is_salesman_array = array();
        $rows = $da_obj->select('Real_Name', 'Invitation_Code', 'Is_Salesman')
            ->where('Invitation_Code', '<>', '')
            ->get();
        foreach($rows as $key => $value){
            $salesman_array[$value['Invitation_Code']] = $value['Real_Name'];
            $is_salesman_array[$value['Invitation_Code']] = $value['Is_Salesman'];
        }

        //搜索
        if(isset($input['search']) && $input['search'] == 1){
            if($input['Keyword']){
                $b_obj = $b_obj->where($input['Fields'], 'like', '%'.$input['Keyword'].'%');
            }
            if($input['GroupID']!=0){
                $b_obj = $b_obj->where('Group_ID', intval($input['GroupID']));
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
        $lists = $b_obj->where('Is_Union', 0)->paginate(15);
        foreach($lists as $key => $value){
            $value["expiredate"] = !empty($value["expiredate"]) ? date("Y-m-d",$value["expiredate"]) : '';
            $value["addtype"] = $value['addtype'] == 1 ? '后台添加' : '注册';
            $value["Biz_Status"] = $value["Biz_Status"] == 0 ? '正常' : '禁用';
        }

        return view('admin.business.biz', compact(
            'groups', 'lists', 'salesman_array', 'is_salesman_array'));

    }


    /**
     * 添加普通商家页面
     */
    public function create()
    {
        $bg_obj = new Biz_Group();
        //商家分组
        $groups = $bg_obj->orderBy('Group_Index')->orderBy('Group_ID')->get();
        return view('admin.business.biz_create', compact('groups'));
    }


    /**
     * 保存普通商家
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
        ];
        $validator = Validator::make($input, $rules, $message);
        if($validator->fails()){
            return redirect()->back()->with('errors', $validator->messages())->withInput();
        }

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
            "Biz_Address"=>$input['Address'],
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
            "is_agree"=>1,
            "is_auth"=>2,
            "is_pay"=>1,
            "is_biz"=>1,
            "addtype"=>1,
            "Invitation_Code"=>isset($input['Invitation_Code'])?trim($input['Invitation_Code']):''

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
            return redirect()->route('admin.business.biz_index')->with('success', '添加成功');
        }else{
            return redirect()->back()->with('errors', '保存失败');
        }
    }


    /**
     * 编辑普通商家页面
     */
    public function edit($id)
    {
        $bg_obj = new Biz_Group();
        $b_obj = new Biz();
        //商家分组
        $groups = $bg_obj->orderBy('Group_Index')->orderBy('Group_ID')->get();
        $rsBiz = $b_obj->find($id);
        return view('admin.business.biz_edit', compact('groups', 'rsBiz'));
    }


    /**
     * 编辑普通商家
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
        ];
        $validator = Validator::make($input, $rules, $message);
        if($validator->fails()){
            return redirect()->back()->with('errors', $validator->messages());
        }

        $b_obj = new Biz();
        $sp_obj = new ShopProduct();

        $input['Introduce'] = htmlspecialchars($input['Introduce'], ENT_QUOTES);
        $Data = array(
            "Biz_Name" => $input['Name'],
            "bond_free"=>empty($input['bond_free'])?'0':trim($input['bond_free']),
            "expiredate"=>empty($input['expiredate'])?'0':strtotime($input['expiredate']),
            "Biz_Address" => $input['Address'],
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
            "Invitation_Code" => isset($input['Invitation_Code']) ? trim($input['Invitation_Code']) : ''
        );
        if (! empty($input["PassWord"])) {
            $Data["Biz_PassWord"] = md5($input["PassWord"]);
        }

        $Flag = $b_obj->where('Biz_ID', $id)->update($Data);
        if ($Flag) {
            if ($input["FinanceType"] == 0) {
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
        return redirect()->route('admin.business.biz_index')->with('success', '保存成功');

    }


    /**
     * 删除普通商家
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


}
