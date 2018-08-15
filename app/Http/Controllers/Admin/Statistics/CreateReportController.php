<?php
/*生成统计报告*/
namespace App\Http\Controllers\Admin\Statistics;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CreateReportController extends Controller
{
    public function index(Request $request)
    {
        $Users_ID = USERSID;

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
        $order_list = $order->where('Users_ID', $Users_ID)
            ->whereBetween('Order_CreateTime', [$begin_time, $end_time])
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
//按日期索引排序
        krsort($data2);

        return view('admin.statistics.create_report');
    }



    /**
     * 下载统计结果
     * @param array $data
     * @return attach
     */
    private function getExcel($fileName, $headArr, $data){
        if(empty($data) || !is_array($data)){
            die("data must be a array");
        }
        if(empty($fileName)){
            exit;
        }
        $date = date("Y_m_d",time());
        $fileName .= "_{$date}.xls";

        //创建新的PHPExcel对象
        $objPHPExcel = new PHPExcel();
        $objProps = $objPHPExcel->getProperties()->setCreator("wangzhongwang");;

        //设置表头
        $key = ord("A");
        foreach($headArr as $v){
            $colum = chr($key);
            $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
            $key += 1;
        }

        $column = 2;
        $objActSheet = $objPHPExcel->getActiveSheet();
        foreach($data as $key => $rows){ //行写入
            $span = ord("A");
            foreach($rows as $keyName=>$value){// 列写入
                $j = chr($span);
                $objActSheet->setCellValue($j.$column, $value);
                $span++;
            }
            $column++;
        }

        $fileName = iconv("utf-8", "gb2312", $fileName);
        //重命名表
        $objPHPExcel->getActiveSheet()->setTitle('Simple');

        //设置活动单指数到第一个表,所以Excel打开这是第一个表
        $objPHPExcel->setActiveSheetIndex(0);


        //清除缓存
        ob_clean();


        //将输出重定向到一个客户端web浏览器(Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output'); //文件通过浏览器下载

        die();

    }
}
