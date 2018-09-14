<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\Area;
use App\Models\Biz;
use App\Models\User_Recieve_Address;
use App\Models\UserOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ProductOrderController extends Controller
{
    /**
     * 订单列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $b_obj = new Biz();
        $uo_obj = new UserOrder();
        $a_obj = new Area();

        $bizs = $b_obj->select('Biz_ID', 'Biz_Name')->get();//商家列表

        $Order_Status = array("待确认", "待付款", "已付款", "已发货", "已完成", "申请退款中");

        //搜索
        $input = $request->input();
        if (isset($input['search']) && $input['search'] == 1) {
            if ($input["Keyword"] != '') {
                $uo_obj = $uo_obj->where($input['Fields'], 'like', '%' . $input['Keyword'] . '%');
            }
            if (!empty($input["OrderNo"])) {
                $OrderID = substr($input["OrderNo"], 8);
                $OrderID = $OrderID > 0 ? intval($OrderID) : 0;
                $uo_obj = $uo_obj->where('Order_ID', $OrderID);
            }
            if ($input['BizID'] > 0) {
                $uo_obj = $uo_obj->where('Biz_ID', $input['BizID']);
            }
            if ($input["Status"] <> '') {
                $uo_obj = $uo_obj->where('Order_Status', $input["Status"]);
            }
            if ($input["date-range-picker"] != '') {
                $timearr = explode('-', $input["date-range-picker"]);
                $uo_obj = $uo_obj->where('Order_CreateTime', '>=', strtotime($timearr[0]));
                $uo_obj = $uo_obj->where('Order_CreateTime', '<=', strtotime($timearr[1]));
            }
        }
        $rsOrderlist = $uo_obj->orderBy('Order_CreateTime', 'desc')
            ->orderBy('Order_Status', 'asc')
            ->paginate(15);

        foreach ($rsOrderlist as $key => $value) {
            $value['shipping'] = json_decode(htmlspecialchars_decode($value["Order_Shipping"]), true);
            if (empty($value['shipping'])) {
                $value['shipping'] = '免运费';
            } else {
                if (isset($value['shipping']["Express"])) {
                    $value['shipping'] = $value['shipping']["Express"];
                } else {
                    $value['shipping'] = '无配送信息';
                }
            }
            $value['city'] = $a_obj->select('area_name')->find($value['Address_City']);
            if (($value["Order_TotalPrice"] <= $value["Back_Amount"] || $value['Order_Status'] == 4) && $value['Is_Backup'] == 1) {
                $value['status'] = '<span style="color:#999; text-decoration:line-through">已退款</span>';
            } else {
                if ($value["Order_Status"] == 1 && $value["Order_PaymentMethod"] == "线下支付" && !empty($value["Order_PaymentInfo"])) {
                    $value['status'] = '待卖家确认';
                } elseif ($value["Order_Status"] == 30) {
                    $value['status'] = '线下余额充值待付款';
                } elseif ($value["Order_Status"] == 31) {
                    $value['status'] = '线下余额充值已付款';
                } else {
                    $value['status'] = $Order_Status[$value["Order_Status"]];
                }
            }
        }

        //导出表
        if (isset($input['action']) && $input['action'] == 'output') {
            $this->output($rsOrderlist);
        }

        return view('admin.product.order', compact('bizs', 'rsOrderlist', 'Order_Status'));
    }


    /**
     * 订单详情页
     * @param $id
     */
    public function show($id)
    {

        return view('admin.product.order_show');
    }


    public function order_print($ids)
    {
        $uo_obj = new UserOrder();
        $orderlist = $uo_obj->whereIn('Order_ID', explode(',', $ids))->get();

        $Order_Status = array("待确认", "待付款", "已付款", "已发货", "已完成", "申请退款中", "申请换货");
        $Back_After_Status = array("申请换货中", "卖家同意换货", "换货-买家发货", "换货-卖家确定收货", "换货-卖家已发货", "买家拒绝换货");
        $Back_Status = array("申请退款中", "卖家同意退款/退款退货", "退货-买家发货", "退货-卖家确定收货", "已完成", "卖家驳回");

        foreach ($orderlist as $key => $value) {
            $value['Order_SN'] = date("Ymd", $value['Order_CreateTime']) . '-' . $value['Order_ID'];
            $value['Order_CreateTime'] = date("Y-m-d H:i:s", $value['Order_CreateTime']);
            $value['Order_Shipping'] = json_decode(htmlspecialchars_decode($value['Order_Shipping']), true);
            $value['Order_ShippingID'] = !empty($value['Order_ShippingID']) ? $value['Order_ShippingID'] : '未发货';

            if ($value['Order_Status'] == 6 || $value['Order_Status'] == 5) {
                $value['rsBack'] = $value->backOrder()->get("Back_Type, Back_After_Status, Back_Status");
            }

            $value['Order_Status_type'] = '未知状态';
            if (isset($value['rsBack']) && $value['rsBack']['Back_Type'] == "after_sale") {
                if (isset($Back_After_Status[$rsBack["Back_After_Status"]])) {
                    $value['Order_Status_type'] = $Back_After_Status[$value['rsBack']["Back_After_Status"]];
                } else {
                    $value['Order_Status_type'] = '未知状态';
                }
            } elseif (isset($value['rsBack']) && $value['rsBack']['Back_Type'] == "shop") {
                if (isset($Back_Status[$value['rsBack']["Back_Status"]])) {
                    $value['Order_Status_type'] = $Back_Status[$value['rsBack']["Back_Status"]];
                } else {
                    $value['Order_Status_type'] = '未知状态';
                }
            } else {
                if (isset($Order_Status[$value["Order_Status"]])) {
                    $value['Order_Status_type'] = $Order_Status[$value["Order_Status"]];
                } else {
                    $value['Order_Status_type'] = '未知状态';
                }
            }

            //订单商品信息处理
            $value['Order_CartList'] = json_decode(htmlspecialchars_decode($value['Order_CartList']), true);
            $value['Order_PaymentMethod'] = $value['Order_PaymentMethod'] ? $value['Order_PaymentMethod'] : '未支付';
            if (is_numeric($value['Address_Province'])) {
                $a_obj = new Area();

                $Province = '';
                if (!empty($value['Address_Province'])) {
                    $province_list = $a_obj->find($value['Address_Province']);
                    $Province = $province_list['area_name'];
                }
                $City = '';
                if (!empty($value['Address_City'])) {
                    $city_list = $a_obj->find($value['Address_City']);
                    $City = $city_list['area_name'];
                }
                $Area = '';
                if (!empty($value['Address_Area'])) {
                    $area_list = $a_obj->find($value['Address_City']);
                    $Area = $area_list['area_name'];
                }

                $value['Address_Province'] = $Province;
                $value['Address_City'] = $City;
                $value['Address_Area'] = $Area;
            }
            $value['Biz_Name'] = $value['biz']['Biz_Name'];
        }

        //获取寄件人信息
        $ura_obj = new User_Recieve_Address();
        $receiveInfo = $ura_obj->find(USERSID);
        if(is_numeric($receiveInfo['RecieveProvince'])){
            $a_obj = new Area();

            $Province = '';
            if (!empty($receiveInfo['RecieveProvince'])) {
                $province_list = $a_obj->find($receiveInfo['RecieveProvince']);
                $Province = $province_list['area_name'];
            }
            $City = '';
            if (!empty($receiveInfo['RecieveCity'])) {
                $city_list = $a_obj->find($receiveInfo['RecieveCity']);
                $City = $city_list['area_name'];
            }
            $Area = '';
            if (!empty($receiveInfo['RecieveArea'])) {
                $area_list = $a_obj->find($receiveInfo['RecieveArea']);
                $Area = $area_list['area_name'];
            }
            $receiveInfo['Address_Province'] = $Province;
            $receiveInfo['Address_City'] = $City;
            $receiveInfo['Address_Area'] = $Area;
        }

        return view('admin.product.order_print', compact('orderlist', 'receiveInfo'));
    }


    /**
     * 导出订单列表
     * @param $list
     */
    private function output($list)
    {
        $totalAmount = $totalOrder = 0;
        $data = [];
        foreach ($list as $k => $v) {
            $data [] = [
                'index' => $v['Order_ID'],
                'order_sn' => date("Ymd", $v["Order_CreateTime"]) . $v['Order_ID'],
                'biz' => $v['biz']['Biz_Name'],
                'user_no' => $v["user"]['User_No'],
                'mobile' => $v['Address_Mobile'],
                'money' => $v['Back_Amount'] > 0 ? '退款金额' . $v['Back_Amount'] : $v['Order_TotalPrice'],
                'shipping' => $v['shipping'],
                'address' => $v['store_mention'] == 1 ? '到店自提' : $v['city']['area_name'],
                'status' => $v['status'],
                'create_time' => date('Y-m-d', $v['Order_CreateTime']),
            ];
        }
        //导出表
        $title = [['订单列表']];
        $total = [['', '共' . $totalOrder . '个订单', '共' . $totalAmount . '元']];
        $cellData = [['序号', '订单号', '商家', '会员号', '收货手机号', '金额', '配送方式', '送货地址', '订单状态', '时间']];
        $cellData = array_merge($title, $cellData, $data);

        Excel::create('订单列表', function ($excel) use ($cellData) {

            $excel->sheet('order_report', function ($sheet) use ($cellData) {

                $sheet->mergeCells('A1:J1');//合并单元格
                $sheet->cell('A1', function ($cell) {
                    // Set font size
                    $cell->setBackground('#ffffff');
                    $cell->setFontSize(16);
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                });
                $sheet->cell('A:J', function ($cell) {
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                });
                $sheet->setBorder('A1', 'thin');
                $sheet->setHeight(1, 50);
                $sheet->setWidth([
                    'A' => 5,
                    'B' => 20,
                    'C' => 30,
                    'D' => 15,
                    'E' => 15,
                    'F' => 15,
                    'G' => 15,
                    'H' => 15,
                    'I' => 15,
                    'J' => 15,
                ]);
                $sheet->rows($cellData);
            });
        })->export('xls');
    }
}
