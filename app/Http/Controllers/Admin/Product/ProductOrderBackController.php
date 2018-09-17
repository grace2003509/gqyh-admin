<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\Area;
use App\Models\Biz;
use App\Models\ShopProduct;
use App\Models\User_Back_Order;
use App\Models\User_Back_Order_Detail;
use App\Services\ServiceOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductOrderBackController extends Controller
{
    /**
     * 退货单列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $ubo_obj = new User_Back_Order();
        $b_obj = new Biz();

        $status = array('申请中','卖家同意','买家发货','卖家收货并确定退款价格','完成','卖家拒绝退款');
        $tuikuan = array('未退款','已退款');

        //搜索
        $input = $request->input();
        if(isset($input['search']) && $input['search'] == 1){
            if(isset($input["Status"])){
                if($input["Status"]<>'all'){
                    $ubo_obj = $ubo_obj->where('Back_Status', $input['Status']);
                }
            }
            if(isset($input["IsCheck"])){
                if($input["IsCheck"]<>'all'){
                    $ubo_obj = $ubo_obj->where('Back_IsCheck', $input['IsCheck']);
                }
            }
            if(!empty($input["date-range-picker"])){
                $timer = explode('-', trim($input['date-range-picker']));
                $ubo_obj = $ubo_obj->where('Back_CreateTime', '>=', strtotime($timer[0]));
                $ubo_obj = $ubo_obj->where('Back_CreateTime', '<=', strtotime($timer[1]));
            }
        }

        $lists = $ubo_obj->where('Back_Type', 'shop')->paginate(15);
        foreach($lists as $key=>$rsBack) {
            if ($rsBack["Biz_ID"] == 0) {
                $rsBack["Biz_Name"] = "本站供货";
            } else {
                $item = $b_obj->select('Biz_Name')->find($rsBack["Biz_ID"]);
                if ($item) {
                    $rsBack["Biz_Name"] = $item["Biz_Name"];
                } else {
                    $rsBack["Biz_Name"] = "已被删除";
                }
            }

        }
        return view('admin.product.order_back', compact('lists', 'status', 'tuikuan'));
    }


    /**
     * 退货单详情页
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $ubo_obj = new User_Back_Order();
        $b_obj = new Biz();
        $sp_obj = new ShopProduct();
        $ubod_obj = new User_Back_Order_Detail();
        $a_obj = new Area();

        $status = array('申请中','卖家同意','买家发货','卖家收货并确定退款价格','完成','卖家拒绝退款');
        $tuikuan = array('未退款','已退款');

        $rsBack = $ubo_obj->find($id);
        $rsBack["Back_Json"] = str_replace('\n','',$rsBack["Back_Json"]);

        if($rsBack["Biz_ID"]==0){
            $rsBack["Biz_Name"] = "本站供货";
        }else{
            $item = $b_obj->select('Biz_Name')->find($rsBack["Biz_ID"]);
            if($item){
                $rsBack["Biz_Name"] = $item["Biz_Name"];
            }else{
                $rsBack["Biz_Name"] = "已被删除";
            }
        }

        if ($rsBack['order']['Is_Backup'] == 1){
            $rsBack['allow_back_money'] = true;
        } else {
            //产品是否允许退款判断
            $product = $sp_obj->select('Products_IsVirtual','Products_IsRecieve')->find(intval($rsBack['ProductID']));
            //商品信息未找到或者商品为虚拟产品(产品编辑页面的订单流程值为3)
            if (empty($product) || ($product['Products_IsVirtual'] == 1 && $product['Products_IsRecieve'] == 1)) {
                $rsBack['allow_back_money'] = false;
            } else {
                $rsBack['allow_back_money'] = true;
            }
            unset($product);
        }

        $rsBack['detail'] = $ubod_obj->where('backid', $id)
            ->orderBy('createtime', 'asc')
            ->get();

        $address = '';
        if(!empty($rsOrder['Address_Province'])){
            $p = $a_obj->find($rsOrder['Address_Province']);
            $address .= $p['area_name'].',';
        }
        if(!empty($rsOrder['Address_City'])){
            $c = $a_obj->find($rsOrder['Address_City']);
            $address .= $c['area_name'].',';
        }
        if(!empty($rsOrder['Address_Area'])){
            $a = $a_obj->find($rsOrder['Address_Area']);
            $address .= $a['area_name'];
        }

        $ProductList = json_decode(htmlspecialchars_decode($rsBack["Back_Json"]),true);
        if(!empty($ProductList['Property'])){
            $ProductList['ProductsPriceX'] = $ProductList['Property']['shu_pricesimp'];
        }

        return view('admin.product.order_back_show', compact(
            'rsBack', 'status', 'tuikuan', 'address', 'ProductList'
        ));
    }



    public function update(Request $request, $id)
    {
        $uob_obj = new User_Back_Order();
        $backup = new ServiceOrder();

        $rsBack = $uob_obj->find($id);

        $input = $request->input();
        if($input['action'] =="agree"){

            if($rsBack['Back_Status'] <> 0){
                return redirect()->back()->with('errors', '操作错误');
            }else{
                if ($rsBack['order']['Order_IsVirtual'] == 1 && $rsBack['order']['Order_Status'] == 4) {
                    return redirect()->back()->with('errors', '商品已经消费，不能申请退货');
                }
                if(!empty($rsBack['order']['Order_ShippingID'])){
                    if($rsBack['Order_Status'] == 2 || $rsBack['Order_Status'] == 5){
                        $backup->update_backup("seller_agrees",$id);
                    }else{
                        $backup->update_backup("seller_agree",$id);
                    }
                }else {
                    $backup->update_backup("seller_agrees",$id);
                }

                return redirect()->back()->with('success', '操作成功');
            }
        }elseif($input['action'] =="back_money"){
            if(in_array($rsBack['order']['Order_PaymentMethod'], ['支付宝','APP支付宝','微支付'])){
                if ($rsBack['Back_Status'] == 3 || $rsBack['Back_Status'] == 1) {
                    $backup->update_backup("admin_backmoney", $id);
                    //todo 用状态返回值判断是否，对接支付接口后确定
//                    return redirect()->back()->with('success', '操作成功');
                } else {
                    return redirect()->back()->with('errors', '操作错误');
                }
            }else{
                if ($rsBack['Back_Status'] == 3 || $rsBack['Back_Status'] == 1) {
                    $backup->update_backup("admin_backmoney", $id);
                    return redirect()->back()->with('success', '操作成功');
                } else {
                    return redirect()->back()->with('errors', '操作错误');
                }
            }
        }elseif($input['action'] =="reject"){
            if($rsBack['Back_Status']<>0){
                echo '<script language="javascript">alert("操作错误");history.back();</script>';
            }else{
                $Order = $rsBack['order'];

                if($Order['Order_Status'] == 4){
                    $backup->update_backup("seller_reject",$id,$input["reason"]);
                    return redirect()->back()->with('success', '操作成功');
                }elseif($Order['Order_Status'] == 5) {
                    $backup->update_backup("seller_reject",$id,$_GET["reason"]);
                    return redirect()->back()->with('success', '操作成功');
                }elseif($rsBack['Order_Status'] != $Order['Order_Status']) {
                    return redirect()->back()->with('success', '订单已完成，不能驳回');
                }else{
                    $backup->update_backup("seller_reject",$id,$_GET["reason"]);
                }

            }
        }elseif($input['action'] =="recieve"){
            if((($rsBack['Back_Status']==2 || $rsBack['Back_Status']==0) && $rsBack['order']["Order_IsVirtual"]==0) || ($rsBack['Back_Status']==0 && $rsBack['order']["Order_IsVirtual"]==1)){
                $backup->update_backup("seller_recieve",$id,$input["Amount"]."||%$%".$input["reason"]);
                return redirect()->back()->with('success', '操作成功');
            }else{
                return redirect()->back()->with('success', '操作错误');
            }
        }
    }
}
