<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dis_Account;
use App\Models\Dis_Account_Record;
use App\Models\Dis_Agent_Record;
use App\Services\ServiceSMS;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Dis_Record;
use Illuminate\Support\Facades\DB;

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

        $orderChartData_keys = array_keys($orderChartData);
        $orderChartData_value = implode(',',array_values($orderChartData));
        $weekChartData_keys = array_keys($weekChartData);
        $weekChartData_value = implode(',',array_values($weekChartData));
        unset($day);

        //顶部标签数据
        $item['today_all_order_num']=$today_all_order_num;
        $item['today_payed_order_num']=$today_payed_order_num;
        $item['today_order_sales']=$today_order_sales;
        $item['month_order_sales']=$month_order_sales;
        $item['today_output_money']=$today_output_money;
        $item['month_output_money']=$month_output_money;
        $item['today_new__account_num']=$today_new__account_num;
        $item['month_new_account_num']=$month_new_account_num;

        //七天订单统计
        $report['orderChartData_keys'] = $orderChartData_keys;
        $report['orderChartData_value'] = $orderChartData_value;
        $report['weekChartData_keys'] = $weekChartData_keys;
        $report['weekChartData_value'] = $weekChartData_value;

        //月订单统计
        //年，月
        $month = intval(date('m'));
        $year = date('Y');
        $day = intval(date('d'));
        $daysnum = days_in_month($month,$year);
        $carbon = Carbon::createFromFormat('Y/m/d',"$year/$month/$day");
        $mon_start = $carbon->startOfMonth()->timestamp;
        $month_days_range = array();
        $month_sales = array();
        //获取每天的时间戳
        for ($i=1; $i<=$daysnum; $i++) {
            $month_days_range[$i] = array('begin'=>$carbon->startOfDay()->timestamp,
                'end'=>$carbon->endOfDay()->timestamp);
            $month_sales[$i] = 0;
            if($i < $daysnum){
                $carbon->addDay();
            }

        }
        $mon_end = $carbon->endOfMonth()->timestamp;
        //获取本月内所有订单列表
        $month_order_list = Order::where('Users_ID',$Users_ID)
            ->whereBetween('Order_CreateTime', array($mon_start,$mon_end))
            ->where('Order_Status',4)
            ->get(array('Order_ID','Order_TotalAmount','Order_CreateTime'));
        //统计每日销量
        $max_val = 0;
        $month_summary = [];
        if($month_order_list->count()>0){
            $order_array = 	$month_order_list->toArray();
            $new_collect = collect($order_array);
            foreach($month_days_range as $key => $day){
                $sum = $new_collect->filter(function($order) use($day){
                    if($order['Order_CreateTime'] >$day['begin']&&$order['Order_CreateTime'] <= $day['end']){
                        return true;
                    }
                })->sum('Order_TotalAmount');
                if($sum>$max_val){
                    $max_val = $sum;
                }
                $month_sales[$key] = $sum;
            }
            //支出统计 begin （返佣金+代理佣金)
            if (count($order_array) > 0) {
                foreach ($order_array as $key => $value) {
                    $day = date('Y-m-d', $value['Order_CreateTime']);
                    $order_id_arr[$day] = $this->get_day_summary($Users_ID, $value['Order_ID']);
                }

                foreach ($month_days_range as $key => $value) {
                    $day = date('Y-m-d', $value['begin']);
                    if (isset($order_id_arr[$day])) {
                        $month_summary[$key] = $order_id_arr[$day];
                    } else {
                        $month_summary[$key] = 0;
                    }
                }
            }
            //支出统计 end
        }

        //月销售统计图
        $saleline['month_sales_value'] = implode(',',array_values($month_sales));
        $saleline['month_summary_value'] = implode(',',array_values($month_summary));
        $saleline['month_sales_keys'] = implode(',',array_keys($month_sales));


        //月统计饼状图
        $getMoney = array_sum(array_values($month_sales));//进账
        $outMoney = array_sum(array_values($month_summary));//出账
        if (($getMoney + $outMoney) == 0) {
            $getPercent = 50;
        } else {
            $getPercent = round($getMoney / ($getMoney + $outMoney) * 100, 2);
        }
        $outPercent = 100 - $getPercent;
        $sales['getPercent'] = $getPercent;
        $sales['outPercent'] = $outPercent;


        return view('admin.home',compact('remain_count','item', 'report', 'saleline', 'sales'));

    }



    private function get_day_summary($Users_ID, $Order_ID) {
        $money = $money1 = $money2 = 0;
        $row = Dis_Record::select('Record_ID')
            ->where('Users_ID', $Users_ID)
            ->where('Order_ID', intval($Order_ID))
            ->first();

        //统计出所有分销信息
        if ($row) {
            $row = Dis_Account_Record::where('Record_Status',2)
                ->where('Users_ID', $Users_ID)
                ->where('Ds_Record_ID', $row['Record_ID'])
                ->first(
                    array(
                        DB::raw('SUM(Record_Price+Nobi_Money) as total')
                    )
                )->toArray();
            if ($row['total']) {
                $money1= $row['total'];
            }
        }

        //代理商支出的钱
        $row = Dis_Agent_Record::where('Order_ID', intval($Order_ID))->sum('Record_Money');
        $total = $row['Record_Money'];
        if ($total) {
            $money2 = $total;
        }

        $money = $money1 + $money2;
        unset($money1, $money2);

        return $money;

    }

}