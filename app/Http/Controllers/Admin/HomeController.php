<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dis_Account;
use App\Models\Dis_Account_Record;
use App\Services\ServiceSMS;
use Carbon\Carbon;
use App\Models\Order;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $Users_ID = USERSID;

        $sms_obj = new ServiceSMS();
        $remain_count = $sms_obj->get_remain_sms();

        //计算时间
        $carbon = Carbon::createFromTimestamp(1440055725);
        $carbon = Carbon::now();
        $now = $carbon->timestamp;
        $today = $carbon->startOfDay()->timestamp;
        $month_start = $carbon->startOfMonth()->timestamp;
        $month_end =  $carbon->endOfMonth()->timestamp;

        $order = new Order();
        $account_record = new Dis_Account_Record();
        $account = new Dis_Account();
        //今日订单总数目
        $today_all_order_num = $order->statistics($Users_ID,'num',$today,$now);
        //今日已付款订单
        $today_payed_order_num = $order->statistics($Users_ID,'num',$today,$now,2);
        //今日销售额
        $today_order_sales = $order->statistics($Users_ID,'sales',$today,$now,2);
        //本月销售额
        $month_order_sales = $order->statistics($Users_ID,'sales',$month_start,$month_end,2);
        //今日支出佣金
        $today_output_money = $account_record->recordMoneySum($Users_ID,$today,$now,1);
        $today_output_money = round_pad_zero($today_output_money,2);
        //本月支出佣金
        $month_output_money = $account_record->recordMoneySum($Users_ID,$month_start,$month_end,1);
        $month_output_money = round_pad_zero($month_output_money, 2);
        //今日加入分销商
        $today_new__account_num = $account->accountCount($Users_ID,$today,$now);
        //本月加入分销商
        $month_new_account_num =  $account->accountCount($Users_ID,$month_start,$month_end);

        //七天内订单统计
        $endDayTime = time();
        $startDayTime = strtotime(date('Y-m-d', $endDayTime - 86400 * 6));
        //获取七天内所有订单列表
        $week_order_list = Order::where('Users_ID',$Users_ID)
            ->whereBetween('Order_CreateTime', array($startDayTime, $endDayTime))
            ->where('Order_Status',4)
            ->get(array('Order_ID','Order_TotalAmount','Order_CreateTime'))->toArray();

        $weekData = $weekChartData = [];
        $orderData = $orderChartData = [];
        if (count($week_order_list) > 0) {
            foreach ($week_order_list as $order) {
                $day = date('Y-m-d', $order['Order_CreateTime']);
                if (! isset($weekData[$day])) {
                    $weekData[$day] = $order['Order_TotalAmount'];
                    $orderData[$day] = 1;
                } else {
                    $weekData[$day] += $order['Order_TotalAmount'];
                    $orderData[$day]++;
                }
            }
            unset($order);
        }
        $days = ceil(($endDayTime - $startDayTime) / 86400);

        //填充收入为空的日期
        if (count($weekData) <= $days) {
            for($i = 0; $i < $days; $i++) {
                $day = date('Y-m-d', $startDayTime + 86400 * $i);
                if (! isset($weekData[$day])) {
                    $weekChartData[$day] = 0;
                    //$orderData[$day] = 0;
                } else {
                    $weekChartData[$day] = $weekData[$day];
                }
            }
        }

        //填充订单数量为空的日期
        if (count($orderData) <= $days) {
            for($i = 0; $i < $days; $i++) {
                $day = date('Y-m-d', $startDayTime + 86400 * $i);
                if (! isset($orderData[$day])) {
                    $orderChartData[$day] = 0;
                } else {
                    $orderChartData[$day] = $orderData[$day];
                }
            }
        }
        $orderChartData_keys = implode('","',array_keys($orderChartData));
        $orderChartData_value = implode(',',array_values($orderChartData));
        $weekChartData_keys = implode(',',array_keys($weekChartData));
        $weekChartData_value = implode(',',array_values($weekChartData));
        unset($day);

        $item['today_all_order_num']=$today_all_order_num;
        $item['today_payed_order_num']=$today_payed_order_num;
        $item['today_order_sales']=$today_order_sales;
        $item['month_order_sales']=$month_order_sales;
        $item['today_output_money']=$today_output_money;
        $item['month_output_money']=$month_output_money;
        $item['today_new__account_num']=$today_new__account_num;
        $item['month_new_account_num']=$month_new_account_num;

        $report['orderChartData_keys'] = $orderChartData_keys;
        $report['orderChartData_value'] = $orderChartData_value;
        $report['weekChartData_keys'] = $weekChartData_keys;
        $report['weekChartData_value'] = $weekChartData_value;

        return view('admin.home',compact('remain_count','item', 'report'));

    }


}