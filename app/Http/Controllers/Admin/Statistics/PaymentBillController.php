<?php
/**
 * 财务结算
 */
namespace App\Http\Controllers\Admin\Statistics;

use App\Models\Biz;
use App\Models\ShopSalesPayment;
use App\Models\ShopSalesRecord;
use App\Services\ServiceBalance;
use App\Services\ServiceOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PaymentBillController extends Controller
{
    public function index(Request $request)
    {
        $input = $request->only('BizID', 'Fields', 'Keyword', 'Status', 'date-range-picker');

        $b_obj = new Biz();
        $BizRs = $b_obj->all();
        $BizPayRate = [];
        foreach ($BizRs as $k => $v) {
            $BizPayRate[$v["Biz_ID"]] = empty($v['PaymenteRate']) ? '100' : $v['PaymenteRate'];
        }

        $ssp_obj = new ShopSalesPayment();
        //搜索
        if ($input['BizID'] > 0 && $input['BizID'] != null) {
            $ssp_obj = $ssp_obj->where('Biz_ID', $input['BizID']);
        }
        if ($input['Keyword'] != '' && $input['Keyword'] != null) {
            $ssp_obj = $ssp_obj->where($input['Fields'], 'like', $input['Keyword'] . '%');
        }
        if ($input['Status'] != 'all' && $input['Status'] != null) {
            $ssp_obj = $ssp_obj->where('Status', $input['Status']);
        }
        if ($input['date-range-picker'] != '' && $input['date-range-picker'] != null) {
            $times = explode('-', $input['date-range-picker']);
            $ssp_obj = $ssp_obj->where('CreateTime', '>=', strtotime($times[0]))
                ->where('CreateTime', '<=', strtotime($times[1]));
        }
        $lists = $ssp_obj->orderBy('Payment_ID', 'desc')
            ->paginate(20);

        foreach ($lists as $key => $value) {
            if ($value["Biz_ID"] == 0) {
                $value["Biz_Name"] = "本站供货";
            } else {
                $item = $b_obj->find($value["Biz_ID"]);
                if ($item) {
                    $value["Biz_Name"] = $item["Biz_Name"];
                } else {
                    $value["Biz_Name"] = "已被删除";
                }
            }
            $value['FromTime'] = date('Y-m-d H:i:s', $value['FromTime']);
            $value["EndTime"] = date("Y-m-d H:i:s", $value["EndTime"]);
            $value["CreateTime"] = date("Y-m-d H:i:s", $value["CreateTime"]);

            $BizPayRate[$value["Biz_ID"]] = isset($BizPayRate[$value["Biz_ID"]]) ? $BizPayRate[$value["Biz_ID"]] : 1;
            $value['zhuanzhuang'] = $value["Total"]*$BizPayRate[$value["Biz_ID"]]/100;//转账
            $value['zhuan_ye'] = $value["Total"]-($value["Total"]*$BizPayRate[$value["Biz_ID"]]/100);//转向余额
            $value['total_ss'] = $value["Amount"] + $value["Shipping"];//实收
        }

        $STATUS = array(
            '未收款',
            '已收款',
            '已结算（等待商家确认）',
            '申请中',
            '已驳回'
        );

        return view('admin.statistics.bill',
            compact('lists', 'STATUS', 'BizRs'));
    }


    public function create()
    {
        $b_obj = new Biz();
        $bizs = $b_obj->all();
        return view('admin.statistics.bill_create', compact('bizs'));
    }


    public function store(Request $request)
    {
        $input = $request->input();
        $rules = [
            'BizID' => 'required|exists:biz,Biz_ID'
        ];
        $messages = [
            'BizID.exists' => '无效的BIZ_ID!'
        ];
        $validator = Validator::make($input, $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->messages());
        }
        $b_obj = new Biz();
        $biz = $b_obj->find($input['BizID']);

        if (empty($biz['User_Mobile'])) {
            return redirect()->back()->with('errors', '该商家没有绑定前台会员,暂不能结款!');
        }

        $balance = new ServiceBalance();
        $Time = empty($input["date-range-picker"]) ? array(time(), time()) : explode("-", $input["date-range-picker"]);
        $StartTime = strtotime($Time[0]);
        $EndTime = strtotime($Time[1]);

        $paymentinfo = $balance->create_payment($input["BizID"], $StartTime, $EndTime, 0);
        if (intval($paymentinfo["supplytotal"]) < 0) {
            return redirect()->back()->with('errors', '结算不能为负值');
        }
        if (!$paymentinfo || $paymentinfo["products_num"] == 0) {
            return redirect()->back()->with('errors', '暂无结算数据');
        }

        $createtime = time();
        $Data = array(
            "FromTime" => $StartTime,
            "EndTime" => $EndTime,
            "Payment_Type" => $input['PaymentID'],
            "Amount" => $paymentinfo["alltotal"],
            "Shipping" => $paymentinfo["logistic"],
            "Diff" => $paymentinfo["cash"],
            "Web" => $paymentinfo["web"],
            "Total" => $paymentinfo["supplytotal"],
            "CreateTime" => $createtime,
            "Biz_ID" => $input["BizID"],
            "Users_ID" => USERSID,
            "Status" => 3
        );
        $Data['Bank'] = $input["Bank"];
        $Data['BankNo'] = $input["BankNo"];
        $Data['BankName'] = $input["BankName"];
        $Data['BankMobile'] = $input["BankMobile"];

        $ssp_obj = new ShopSalesPayment();
        $paymentid = $ssp_obj->insertGetId($Data);

        if ($paymentid) {
            $ssr_obj = new ShopSalesRecord();
            $p_data = [
                "Payment_ID" => $paymentid,
                "Record_Status" => 3
            ];
            $up_flag = $ssr_obj->where('Biz_ID', $input['BizID'])
                ->where('Record_CreateTime', '>=', $StartTime)
                ->where('Record_CreateTime', '<=', $EndTime)
                ->where('Record_Status', 0)
                ->update($p_data);

            $Payment_Sn = $createtime . $paymentid;
            $up_flag = $ssp_obj->where('Payment_ID', $paymentid)
                ->update(["Payment_Sn" => $Payment_Sn]);

            return redirect()->route('admin.statistics.bill_index')->with('success', '生成成功');
        } else {
            return redirect()->back()->with('errors', '生成失败');
        }
    }


    public function show($id)
    {
        $ssp_obj = new ShopSalesPayment();
        $b_obj = new Biz();
        $rsPayment = $ssp_obj->find($id);//结算信息详情
        if (!$rsPayment) {
            return redirect()->back()->with('errors', '暂无信息');
        }
        if (intval($rsPayment['Total']) < 0) {
            return redirect()->back()->with('errors', '结算不能为负值');
        }
        if ($rsPayment["Biz_ID"] == 0) {
            $rsPayment["Biz"] = "本站供货";
        } else {
            $item = $b_obj->find($rsPayment['Biz_ID']);
            if ($item) {
                $rsPayment["Biz"] = $item["Biz_Name"];
            } else {
                $rsPayment["Biz"] = "已被删除";
            }
        }

        //时间处理
        $rsPayment["CreateTime"] = date('Y-m-d H:i:s', $rsPayment["CreateTime"]);
        $rsPayment["FromTime"] = date('Y-m-d H:i:s', $rsPayment["FromTime"]);
        $rsPayment["EndTime"] = date('Y-m-d H:i:s', $rsPayment["EndTime"]);

        $BizPayRate = $b_obj->all();
        foreach ($BizPayRate as $BizRs) {
            $BizPayRate[$BizRs["Biz_ID"]] = empty($BizRs['PaymenteRate']) ? '100' : $BizRs['PaymenteRate'];//店铺结算比例
        }
        if (!empty($BizPayRate[$rsPayment['Biz_ID']])) {
            $rsPayment['webpayrate'] = $BizPayRate[$rsPayment['Biz_ID']];
        } else {
            $rsPayment['webpayrate'] = 0;
        }

        $totalmoney = $rsPayment['Total'];
        if (isset($rsPayment['webpayrate']) && !empty($rsPayment['webpayrate'])) {
            $zhuanzz = $totalmoney * $rsPayment['webpayrate'] / 100;
        } else {
            $zhuanzz = 0;
        }
        $zhuanyy = $totalmoney - $zhuanzz;

        $sb_obj = new ServiceBalance();
        $dtotalmoney = $sb_obj->rmb_format($totalmoney);//转大写

        //结算的销售记录列表
        $ssr_obj = new ShopSalesRecord();
        $data = $ssr_obj->where('Payment_ID', $id)
            ->orderBy('Record_ID', 'desc')
            ->get();
        foreach ($data as $key => $value) {
            $so_obj = new ServiceOrder();
            $value['Order_Sn'] = $so_obj->getorderno($value["Order_ID"]);//生成订单编号
        }

        return view('admin.statistics.bill_show',
            compact('rsPayment', 'data', 'totalmoney', 'zhuanyy', 'zhuanzz', 'dtotalmoney'));
    }


    public function del($id)
    {
        $obj = new ShopSalesPayment();
        $flag = $obj->destroy($id);
        if ($flag) {
            return redirect()->back()->with('success', '删除成功');
        } else {
            return redirect()->back()->with('errors', '删除失败');
        }

    }


    public function okey($id)
    {
        $ssp_obj = new ShopSalesPayment();
        $item = $ssp_obj->select('Status')->find($id);
        if ($item["Status"] != 3) {
            return redirect()->back()->with('errors', '该收款单已确认打款，不得再次打款');
        }
        $Flagone = $ssp_obj->where('Payment_ID', $id)->update(['Status' => 2]);
        $ssr_obj = new ShopSalesRecord();
        $Flagtwo = $ssr_obj->where('Payment_ID', $id)->update(['Record_Status' => 2]);
        if ($Flagone && $Flagtwo) {
            return redirect()->back()->with('success', '操作成功');
        } else {
            return redirect()->back()->with('errors', '操作失败');
        }
    }

}
