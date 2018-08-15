<?php
/*生成统计报告*/
namespace App\Http\Controllers\Admin\Statistics;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class CreateReportController extends Controller
{
    public function index(Request $request)
    {
        //计算时间点
        $get_data = $request->only(['type','time']);
        $type = isset($get_data['type']) ? $get_data['type'] : 'week';
        $type = !in_array($type, ['week', 'month', 'quarter', 'half', 'year']) ? 'week' : $type;

        $time = isset($get_data['time']) ? $get_data['time'] : 'day';
        $time = !in_array($time, ['day', 'week', 'month']) ? 'day' : $time;

        $carbon = Carbon::now();

        if ($type == 'week') {
            //本周
            $end_time = $carbon->timestamp;
            $begin_time = $end_time - 86400 * 7;
        } else if ($type == 'month') {
            //计算本月时间始末
            $begin_time = strtotime("-1 month");
            $end_time =  $carbon->timestamp;
        } elseif ($type == 'quarter') {
            //近三月
            $begin_time = strtotime("-3 month");
            $end_time = time();
        } elseif ($type == 'half') {
            $begin_time = strtotime("-6 month");
            $end_time = time();
        } elseif ($type == 'year') {
            $begin_time = strtotime("-1 year");
            $end_time = time();
        }

        $order = new Order();

        $Order_Status = 2;
        $order_list = $order->whereBetween('Order_CreateTime', [$begin_time, $end_time])
            ->where('Order_Status', '>=', $Order_Status)
            ->orderBy('Order_ID', 'DESC')
            ->get(['Order_ID', 'User_ID', 'Order_TotalAmount', 'Order_CreateTime'])
            ->toArray();

        //粒度按天
        $data = $data2 = [];

        if ($time == 'day' && count($order_list) > 0) {
            foreach ($order_list as $value) {
                $data[date('Y-m-d', $value['Order_CreateTime'])][] = $value;
            }

        } else if ($time == 'week' && count($order_list) > 0) {
            //粒度按周
            foreach ($order_list as $value) {
                $data[date('Y-W', $value['Order_CreateTime'])][] = $value;
            }

        } else if ($time == 'month' && count($order_list) > 0) {
            //粒度按月
            foreach ($order_list as $value) {
                $data[date('Y-m', $value['Order_CreateTime'])][] = $value;
            }

        }

        if (count($order_list) > 0) {
            foreach ($data as $key => $value) {
                //订单数量
                $data2[$key]['date'] = $key;
                $data2[$key]['OrderTotal'] = count($value);

                //订单总金额
                foreach ($value as $item) {
                    if (! isset($data2[$key]['OrderTotalAmount'])) {
                        $data2[$key]['OrderTotalAmount'] = $item['Order_TotalAmount'];
                    } else {
                        $data2[$key]['OrderTotalAmount'] += $item['Order_TotalAmount'];
                    }
                }
            }
        }

        $totalAmount = $totalOrder = 0;
        foreach($data2 as $k=>$v){
            $totalOrder += $v['OrderTotal'];
            $totalAmount += $v['OrderTotalAmount'];
        }
        $default_data['time'] = $time;
        $default_data['type'] = $type;

        return view('admin.statistics.create_report',
            compact('data2', 'default_data', 'totalAmount', 'totalOrder'));
    }


    /**
     * 下载统计结果
     */
    public function download(Request $request)
    {
        //计算时间点
        $get_data = $request->only(['type','time']);
        $type = isset($get_data['type']) ? $get_data['type'] : 'week';
        $type = !in_array($type, ['week', 'month', 'quarter', 'half', 'year']) ? 'week' : $type;

        $time = isset($get_data['time']) ? $get_data['time'] : 'day';
        $time = !in_array($time, ['day', 'week', 'month']) ? 'day' : $time;

        $carbon = Carbon::now();

        if ($type == 'week') {
            //本周
            $end_time = $carbon->timestamp;
            $begin_time = $end_time - 86400 * 7;
        } else if ($type == 'month') {
            //计算本月时间始末
            $begin_time = strtotime("-1 month");
            $end_time =  $carbon->timestamp;
        } elseif ($type == 'quarter') {
            //近三月
            $begin_time = strtotime("-3 month");
            $end_time = time();
        } elseif ($type == 'half') {
            $begin_time = strtotime("-6 month");
            $end_time = time();
        } elseif ($type == 'year') {
            $begin_time = strtotime("-1 year");
            $end_time = time();
        }

        $order = new Order();

        $Order_Status = 2;
        $order_list = $order->whereBetween('Order_CreateTime', [$begin_time, $end_time])
            ->where('Order_Status', '>=', $Order_Status)
            ->orderBy('Order_ID', 'DESC')
            ->get(['Order_ID', 'User_ID', 'Order_TotalAmount', 'Order_CreateTime'])
            ->toArray();

        //粒度按天
        $data = $data2 = [];

        if ($time == 'day' && count($order_list) > 0) {
            foreach ($order_list as $value) {
                $data[date('Y-m-d', $value['Order_CreateTime'])][] = $value;
            }

        } else if ($time == 'week' && count($order_list) > 0) {
            //粒度按周
            foreach ($order_list as $value) {
                $data[date('Y-W', $value['Order_CreateTime'])][] = $value;
            }

        } else if ($time == 'month' && count($order_list) > 0) {
            //粒度按月
            foreach ($order_list as $value) {
                $data[date('Y-m', $value['Order_CreateTime'])][] = $value;
            }

        }

        if (count($order_list) > 0) {
            foreach ($data as $key => $value) {
                //订单数量
                $data2[$key]['date'] = $key;
                $data2[$key]['OrderTotal'] = count($value);

                //订单总金额
                foreach ($value as $item) {
                    if (! isset($data2[$key]['OrderTotalAmount'])) {
                        $data2[$key]['OrderTotalAmount'] = $item['Order_TotalAmount'];
                    } else {
                        $data2[$key]['OrderTotalAmount'] += $item['Order_TotalAmount'];
                    }
                }
            }
        }

        $totalAmount = $totalOrder = 0;
        foreach($data2 as $k=>$v){
            $totalOrder += $v['OrderTotal'];
            $totalAmount += $v['OrderTotalAmount'];
        }

        //导出表
        $title = [['订单统计报表','','']];
        $total = [['','共'.$totalOrder.'个订单','共'.$totalAmount.'元']];
        $cellData = [['日期','订单数量','金额']];
        $cellData = array_merge($title, $cellData, $data2, $total);

        Excel::create('订单统计报表',function($excel) use ($cellData){

            $excel->sheet('order_report', function($sheet) use ($cellData){

                $sheet->mergeCells('A1:C1');//合并单元格
                $sheet->cell('A1', function($cell) {
                    // Set font size
                    $cell->setBackground('#ffffff');
                    $cell->setFontSize(16);
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                    $cell->setValignment('center');
                });
                $sheet->setBorder('A1', 'thin');
                $sheet->setHeight(1, 50);
                $sheet->setWidth([
                    'A' => 20,
                    'B' => 40,
                    'C' => 40
                ]);
                $sheet->rows($cellData);
            });
        })->export('xls');

    }

}
