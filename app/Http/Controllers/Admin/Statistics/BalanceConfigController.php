<?php

namespace App\Http\Controllers\Admin\Statistics;

use App\Models\UsersSchedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BalanceConfigController extends Controller
{
    public function index()
    {
        $obj = new UsersSchedule();
        $sch = $obj->find(1);
        $type = 2;
        if($sch){
            $type = $sch['RunType'];
            $sch['time'] = $sch['StartRunTime'];
        }
        return view('admin.statistics.balance_config',
            compact('sch', 'type'));
    }


    public function update(Request $request)
    {
        $input = $request->input();
        $rules = [
            'Time' => 'required',
            'day' => 'required|numeric'
        ];
        $message = [
            'Time.required' => '请选择结算时间',
            'day.required' => '结算天数不能为空',
            'day.numeric'=> '结算天数必须是数字',
        ];
        $validator = Validator::make($input, $rules, $message);
        if($validator->fails()){
            return redirect()->back()->with('errors', $validator->messages());
        }

        $RunType = $input['RunType'];
        $day = intval($input['day']);
        $Time = $input['Time'];
        if(!$day){
            $day =1;
        }
        if(empty($Time) || !$Time){
            $Time = date("H:i");
        }

        $data = array(
            'Users_ID' => USERSID,
            'StartRunTime' => $Time,
            'RunType' => $RunType,
            'Status' => 1,
            'LastRunTime' => strtotime(date("Y-m-d",time())),
            'day' =>$day
        );
        //添加计划任务
        $obj = new UsersSchedule();
        $sch = $obj->find(1);
        if ($sch) {
            $flag = $sch->update($data);
        } else {
            $flag = $obj->create($data);
        }

        if($flag){
            return redirect()->back()->with('success', '计划任务保存成功');
        }else{
            return redirect()->back()->with('errors', '计划任务保存失败');
        }

    }

}
