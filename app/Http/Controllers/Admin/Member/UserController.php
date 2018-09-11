<?php

namespace App\Http\Controllers\Admin\Member;

use App\Events\OrderDistributeEvent;
use App\Models\Dis_Account;
use App\Models\Dis_Config;
use App\Models\Dis_Level;
use App\Models\Member;
use App\Models\ShopConfig;
use App\Models\ShopProduct;
use App\Models\UserCharge;
use App\Models\UserIntegralRecord;
use App\Models\UserMoneyRecord;
use App\Models\UserOrder;
use App\Services\ServicePayOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index(Request $request)
    {
        //获取商城虚拟商品
        $sp_obj = new ShopProduct();
        $productList = $sp_obj->where('Products_IsVirtual', 1)->get();

        //会员的分销商等级
        $dl_obj = new Dis_Level();
        $UserLevel = $dl_obj->shop_distribute_level();

        $m_obj = new Member();
        $input = $request->input();
        //搜索
        if(isset($input["search"]) && $input["search"]==1){
            if(isset($input["Keyword"]) && $input["Keyword"] && $input['Fields']!= 'all'){
                if($input["Fields"] == 'Owner_Id'){
                    $rst_id = $m_obj->select('User_ID')
                        ->where('User_Mobile', 'like', '%'.$input["Keyword"].'%')
                        ->get();
                    $ids = [];
                    foreach($rst_id as $v){
                        $ids[] = $v['User_ID'];
                    }
                    if($ids){
                        $m_obj = $m_obj->whereIn('Owner_Id', $ids);
                    }

                }else{
                    $m_obj = $m_obj->where($input['Fields'], 'like', '%'.$input["Keyword"].'%');
                }
            }
            if(isset($input["MemberLevel"]) && $input["MemberLevel"] != "all"){
                if($input['MemberLevel'] != 0){
                    $da_obj = new Dis_Account();
                    $account = $da_obj->select('User_ID')->where('Level_ID', $input['MemberLevel'])->get();
                    $ids = [];
                    foreach($account as $v){
                        $ids[] = $v['User_ID'];
                    }
                    if($ids){
                        $m_obj = $m_obj->whereIn('User_ID', $ids);
                    }else{
                        $m_obj = $m_obj->where('User_ID', 0);
                    }
                }else{
                    $m_obj = $m_obj->where('Is_Distribute', 0);
                }
            }
        }
        $lists = $m_obj->orderBy('User_CreateTime', 'desc')->paginate(15);
        foreach($lists as $key => $value){
            if($value['Is_Distribute'] == 1){
                $value['Dis_Level'] = @$value->disAccount->Level_ID;
                $downuser = $m_obj->where('Owner_Id', $value['User_ID'])->get();
                if(count($downuser) > 0){
                    $value['downuser'] = 1;
                }else{
                    $value['downuser'] = 0;
                }
            }else{
                $value['Dis_Level'] = 0;
            }
            if($value['Owner_Id'] > 0){
                $m2_obj = new Member();
                $upuser = $m2_obj->select('User_NickName','User_Name','User_Mobile')
                    ->where('User_ID', $value['Owner_Id'])
                    ->first();
                $value['upuser'] = $upuser;
            }else{
                $value['upuser'] = ['User_Mobile' => '顶级'];
            }
            $value['User_CreateTime'] = date('Y-m-d H:i:s', $value['User_CreateTime']);
        }

        if(empty($input)){
            $input['Fields'] = 'all';
            $input['Keyword'] = '';
            $input['MemberLevel'] = 'all';
        }

        return view('admin.member.user_list', compact('UserLevel', 'lists', 'input', 'productList'));
    }


    public function update(Request $request)
    {
        $input = $request->input();

        //会员的分销商等级
        $dl_obj = new Dis_Level();
        $UserLevel = $dl_obj->shop_distribute_level();

        $m_obj = new Member();
        if(isset($input['action']) && $input['action'] == "mod_password"){
            $Data=array(
                "User_Password"=>md5(123456)
            );
            $set = $m_obj->where('User_ID', $input['UserID'])->update($Data);

            return redirect()->back()->with('success', '登陆密码重置成功');
        }

        if(isset($input['action']) && $input['action'] == "mod_payword") {
            $Data=array(
                "User_PayPassword"=>md5(123456)
            );
            $set = $m_obj->where('User_ID', $input['UserID'])->update($Data);

            return redirect()->back()->with('success', '支付密码重置成功');
        }


        if(isset($input['action']) && $input['action'] == "integral_mod"){

            $rsUser = $m_obj->find($input["UserID"]);
            $levelName=$UserLevel[@$rsUser->disAccount->Level_ID];

            if($rsUser['User_Integral']+$input['Value']<0){
                $Data=array("status"=>2);
            }else{
                //增加
                $Data=array(
                    'Record_Integral'=>$input['Value'],
                    'Record_SurplusIntegral'=>$rsUser['User_Integral'] + $input['Value'],
                    'Operator_UserName'=>Auth::user()->name,
                    'Record_Type'=>1,
                    'Record_Description'=>"手动修改积分",
                    'Record_CreateTime'=>time(),
                    'Users_ID'=>USERSID,
                    'User_ID'=>$input["UserID"]
                );
                $uir_obj = new UserIntegralRecord();
                $Add = $uir_obj->create($Data);
                if($input['Value']>0){
                    $Data=array(
                        "User_Integral"=>$rsUser['User_Integral']+$input['Value'],
                        "User_TotalIntegral"=>$rsUser['User_TotalIntegral']+$input['Value']
                    );
                }else{
                    $Data=array(
                        "User_Integral"=>$rsUser['User_Integral']+$input['Value']
                    );
                }

                $Set = $m_obj->where('User_ID', $input['UserID'])->update($Data);
                if($Set){
                    $Data=array("status"=>1,"lvl"=>1,"level"=>$levelName);
                }else{
                    $Data=array("status"=>0,"msg"=>"写入数据库失败");
                }
            }
            echo json_encode($Data,JSON_UNESCAPED_UNICODE);
            exit;
        }

        if(isset($input['action']) && $input['action'] == "money_mod") {
            $rsUser = $m_obj->find($input['UserID']);
            if($rsUser['User_Money']+$input['Value']<0){
                $Data=array("status"=>2);
            }else{
                //增加充值记录
                if($input['Value']>0){
                    $Data=array(
                        'Users_ID'=>USERSID,
                        'User_ID'=>$input["UserID"],
                        'Amount'=>$input['Value'],
                        'Total'=>$rsUser['User_Money']+$input['Value'],
                        'Operator'=>Auth::user()->name." 线下充值 +".$input['Value'],
                        'Status'=>1,
                        'CreateTime'=>time()
                    );
                    $uc_obj = new UserCharge();
                    $Add = $uc_obj->create($Data);
                }
                //增加资金流水
                $Data=array(
                    'Users_ID'=>USERSID,
                    'User_ID'=>$input["UserID"],
                    'Type'=>$input['Value']>0 ? 1 : 0,
                    'Amount'=>$input['Value'],
                    'Total'=>$rsUser['User_Money']+$input['Value'],
                    'Note'=>Auth::user()->name.($input['Value']>0 ? " 线下充值 +".$input['Value'] : " 线下减余额 ".$input['Value']),
                    'CreateTime'=>time()
                );
                $umr_obj = new UserMoneyRecord();
                $Add = $umr_obj->create($Data);

                //更新用户余额
                $Data=array(
                    'User_Money'=>$rsUser['User_Money']+$input['Value']
                );
                $Set = $m_obj->where('User_ID', $input['UserID'])->update($Data);
                if($Set){
                    $Data=array("status"=>1);
                }else{
                    $Data=array("status"=>0,"msg"=>"写入数据库失败");
                }
            }
            echo json_encode($Data,JSON_UNESCAPED_UNICODE);
            exit;
        }

    }


    public function do_order(Request $request)
    {
        $m_obj = new Member();
        $input = $request->input();
        //手动下单
        if(isset($input['action']) && $input['action'] == "do_order"){
            $rules = [
                'Mobile' => "required|exists:user,User_Mobile,User_ID,{$input['UserID']}",
                'Products_ID' => 'required|exists:shop_products,Products_ID',
                'price' => 'required|numeric'
            ];
            $validator = Validator::make($input, $rules);
            if($validator->fails()){
                return redirect()->back()->with('errors', $validator->messages());
            }
            $Products_ID = intval($input['Products_ID']);
            $price = trim($input['price']);
            $sp_obj = new ShopProduct();
            $rsProducts = $sp_obj->find($input['Products_ID']);
            $userInfo = $m_obj->select('User_ID', 'Is_Distribute', 'Owner_Id')
                ->where('User_ID', $input['UserID'])->first();
            if (!empty($userInfo['Is_Distribute'])) {
                $realownerid = $input['UserID'];
            } else {
                $realownerid = $userInfo['Owner_Id'];
            }
            //产品图片
            $JSON = json_decode($rsProducts['Products_JSON'], true);//产品图片
            $CartList[$Products_ID][] = array(
                "ProductsName" => $rsProducts["Products_Name"],
                "ImgPath" => $JSON["ImgPath"][0],
                "ProductsPriceX" => $price,
                "ProductsPriceY" => $rsProducts["Products_PriceY"],
                "ProductsWeight" => $rsProducts["Products_Weight"],
                "Products_Shipping" => $rsProducts["Products_Shipping"],
                "Products_Business" => $rsProducts["Products_Business"],
                "Shipping_Free_Company" => $rsProducts["Shipping_Free_Company"],
                "IsShippingFree" => $rsProducts["Products_IsShippingFree"],
                "Products_IsPaysBalance" => $rsProducts["Products_IsPaysBalance"],
                "OwnerID" => $realownerid,
                "ProductsIsShipping" => $rsProducts["Products_IsShippingFree"],
                "Qty" => 1,
                "spec_list" => '',
                "Property" => array(),
                "platForm_Income_Reward" => $rsProducts["platForm_Income_Reward"],
                "area_Proxy_Reward" => $rsProducts["area_Proxy_Reward"],
                "Products_Profit" => $rsProducts["Products_Profit"]
            );

            $Data = array(
                "Users_ID" => USERSID,
                "User_ID" => $input['UserID'],
                "Order_IsVirtual" => 1,
                "Order_IsRecieve" => 1,
                "Address_Mobile" => $input ["Mobile"],
                'Owner_ID' => $realownerid,
                "Order_Status" => 1,
                "Order_Type" => "shop",
                "Order_TotalPrice" => $price,
                "Order_TotalAmount" => $price,
                "Integral_Get" => $rsProducts['Products_Integration'],
                "Biz_ID" => $rsProducts['Biz_ID'],
                "Order_CartList" => json_encode($CartList,JSON_UNESCAPED_UNICODE),
                "Order_PaymentMethod" => '后台手动下单',
                "Order_CreateTime" => time(),
                "Web_Price" => $price*$rsProducts["platForm_Income_Reward"] * $rsProducts["commission_radio"]/10000,
                "addtype" => 1,//后台添加
            );

            $uo_obj = new UserOrder();
            $Flag_a = $uo_obj->create($Data);

            if($userInfo['Owner_Id'] > 0) {
                $e_flag = event(new OrderDistributeEvent($Flag_a));
            }

            $pay_order = new ServicePayOrder();
            $Data = $pay_order->make_pay($Flag_a['Order_ID']);

            if($Flag_a && $Data['status'] == 1){
                return redirect()->back()->with('success', '手动下单成功');
            }else{
                return redirect()->back()->with('errors', '手动下单失败');
            }
        }
    }


    public function show($id)
    {
        //会员的分销商等级
        $dl_obj = new Dis_Level();
        $UserLevel = $dl_obj->shop_distribute_level();

        $m_obj = new Member();
        $rsUser = $m_obj->find($id);
        $rsUser['Dis_Level'] = @$rsUser->disAccount->Level_ID;
        $rsRecord = $rsUser->MoneyRecord()->orderBy('Item_ID', 'desc')->paginate(10);
        unset($rsUser->MoneyRecord);
        return view('admin.member.user_capital', compact('rsUser', 'rsRecord', 'UserLevel'));
    }


    public function del($id)
    {
        $m_obj = new Member();
        $c = $m_obj->clearUser([$id]);
        if($c){
            return redirect()->back()->with('success', '删除会员成功');
        }else{
            return redirect()->back()->with('errors', '删除会员失败');
        }
    }



    public function all_del()
    {
        $m_obj = new Member();
        $c = $m_obj->clearUser();
        if($c){
            return redirect()->back()->with('success', '清除会员成功');
        }else{
            return redirect()->back()->with('errors', '清除会员失败');
        }
    }


    /**
     * 导出会员列表
     * @param Request $request
     */
    public function output(Request $request)
    {
        $input = $request->input();
        //会员的分销商等级
        $dl_obj = new Dis_Level();
        $UserLevel = $dl_obj->shop_distribute_level();
        //搜索
        $m_obj = new Member();

        if(isset($input["Keyword"]) && $input["Keyword"] && $input['Fields']!= 'all'){
            if($input["Fields"] == 'Owner_Id'){
                $rst_id = $m_obj->select('User_ID')
                    ->where('User_Mobile', 'like', '%'.$input["Keyword"].'%')
                    ->get();
                $ids = [];
                foreach($rst_id as $v){
                    $ids[] = $v['User_ID'];
                }
                if($ids){
                    $m_obj = $m_obj->whereIn('Owner_Id', $ids);
                }

            }else{
                $m_obj = $m_obj->where($input['Fields'], 'like', '%'.$input["Keyword"].'%');
            }
        }
        if(isset($input["MemberLevel"]) && $input["MemberLevel"] != "all"){
            if($input['MemberLevel'] != 0){
                $da_obj = new Dis_Account();
                $account = $da_obj->select('User_ID')->where('Level_ID', $input['MemberLevel'])->get();
                $ids = [];
                foreach($account as $v){
                    $ids[] = $v['User_ID'];
                }
                if($ids){
                    $m_obj = $m_obj->whereIn('User_ID', $ids);
                }else{
                    $m_obj = $m_obj->where('User_ID', 0);
                }
            }else{
                $m_obj = $m_obj->where('Is_Distribute', 0);
            }
        }

        $lists = $m_obj->orderBy('User_CreateTime', 'desc')->get();
        $data = [];
        foreach($lists as $key => $value){
            $data[$key]['index'] = $key+1;
            if($value['Owner_Id'] > 0){
                $m2_obj = new Member();
                $upuser = $m2_obj->select('User_Mobile')
                    ->where('User_ID', $value['Owner_Id'])
                    ->first();
                $data[$key]['Owner'] = $upuser['User_Mobile'];
            }else{
                $data[$key]['Owner'] = '顶级';
            }
            $data[$key]['User_No'] = $value['User_No'];
            $data[$key]['User_Mobile'] = $value['User_Mobile'];
            $data[$key]['User_Cost'] = round_pad_zero($value['User_Cost'], 2);
            if($value['Is_Distribute'] == 1){
                $data[$key]['Dis_Level'] = $UserLevel[@$value->disAccount->Level_ID];
            }else{
                $data[$key]['Dis_Level'] = $UserLevel[0];
            }
            $data[$key]['User_Integral'] = $value['User_Integral'];
            $data[$key]['User_Money'] = round_pad_zero($value['User_Money'], 2);
            $data[$key]['User_CreateTime'] = date('Y-m-d H:i:s', $value['User_CreateTime']);
        }

        //导出表
        $title = [['会员列表']];
        $cellData = [['序号','推荐人手机号','会员号','手机号','总消费额','会员等级','积分','余额','注册时间']];
        $cellData = array_merge($title, $cellData, $data);

        Excel::create('订单统计报表',function($excel) use ($cellData){

            $excel->sheet('order_report', function($sheet) use ($cellData){

                $sheet->mergeCells('A1:I1');//合并单元格
                $sheet->cell('A1', function($cell) {
                    // Set font size
                    $cell->setBackground('#ffffff');
                    $cell->setFontSize(16);
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                });
                $sheet->cell('A:I', function($cell) {
                    // Set font size
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                });
                $sheet->setBorder('A1', 'thin');
                $sheet->setHeight(1, 50);
                $sheet->setWidth([
                    'A' => 10,
                    'B' => 20,
                    'C' => 20,
                    'D' => 20,
                    'E' => 20,
                    'F' => 20,
                    'G' => 20,
                    'H' => 20,
                    'I' => 40,
                ]);

                $sheet->rows($cellData);
            });
        })->export('xls');
    }


    public function product_change($id)
    {
        $p_obj = new ShopProduct();
        $productInfo = $p_obj->select('Products_ID', 'Products_PriceX')
            ->where('Products_ID', $id)
            ->first();
        if (empty($productInfo)) {
            echo json_encode(array('status'=>0,'info'=>'未找到此产品'));
            exit;
        }
        $price = $productInfo['Products_PriceX'];
        echo json_encode(array('status'=>1,'data'=>$price));
        exit;
    }
}
