<?php

namespace App\Http\Controllers\Admin\Statistics;

use App\Models\Biz;
use App\Models\Order;
use App\Models\ShopSalesRecord;
use App\Models\UserOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaleRecordController extends Controller
{
    public function index(Request $request)
    {
        $get = $request->input();

        $record_obj = new ShopSalesRecord();
        if(isset($get["search"]) && $get["search"] == 1){

            if($get["Status"] != 'all'){
                $record_obj = $record_obj->where('Record_Status', $get["Status"]);
            }
            if($get['BizID']>0){
                $record_obj = $record_obj->where('Biz_ID', $get["BizID"]);
            }
            if($get["date-range-picker"] != ''){
                $range_date = explode('-', $get["date-range-picker"]);
                $record_obj = $record_obj->where('Record_CreateTime', '>=', strtotime($range_date[0]));
                $record_obj = $record_obj->where('Record_CreateTime', '<=', strtotime($range_date[1]));
            }

        }
        $sale_records = $record_obj->orderBy('Record_ID', 'desc')->paginate(20);

        $b = [0,0,0,0,0,0,0];
        foreach($sale_records as $key => $value){

            $flag = strpos($value['Order_Json'],'&amp');
            if ($flag) {
                $sale_records[$value["Record_ID"]]['Order_Json'] = htmlspecialchars_decode($value['Order_Json']);
            }

            $o_obj = new Order();
            $value['ordersn'] = $o_obj->getorderno($value["Order_ID"]);
            $value['rsorder'] = UserOrder::find($value["Order_ID"]);

            $value["Order_Amount"] = round_pad_zero($value["Order_Amount"], 2);
            $value["Record_CreateTime"] = date('Y-m-d', $value["Record_CreateTime"]);

            $b[0] += round_pad_zero($value["Order_Amount"], 2);
            $b[1] += round_pad_zero($value["Order_Shipping"], 2);
            $b[2] += round_pad_zero($value["Order_Amount"] + $value["Order_Shipping"], 2);
            $b[3] += round_pad_zero($value["Order_Diff"], 2);
            $b[4] += round_pad_zero($value["Order_Amount"] + $value["Order_Shipping"] - $value["Order_Diff"], 2);
            $b[5] += round_pad_zero($value["Web_Price"], 2);
            $b[6] += round_pad_zero($value["Order_Amount"] + $value["Order_Shipping"] - $value["Order_Diff"] - $value["Web_Price"], 2);

            if($value["Biz_ID"]==0){
                $value["Biz_Name"] = "本站供货";
            }else{
                $item = Biz::find($value["Biz_ID"]);
                if($item){
                    $value["Biz_Name"] = $item["Biz_Name"];
                }else{
                    $value["Biz_Name"] = "已被删除";
                }
            }
        }

        $biz = Biz::all();//商家列表
        $status = [
            '未结算','已结算'
        ];
        $order_typearr = array(
            'offline_st' => '在线买单',
            'offline_qrcode' => '扫码支付',
            'shop' => '商城下单',
            'offline' => '实体消费'
        );

        return view('admin.statistics.sale_record',
            compact('biz', 'sale_records', 'status', 'order_typearr', 'b'));
    }
}