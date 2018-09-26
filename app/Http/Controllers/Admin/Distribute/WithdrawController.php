<?php

namespace App\Http\Controllers\Admin\Distribute;

use App\Models\Dis_Withdraw_Record;
use App\Models\Member;
use App\Models\UserMoneyRecord;
use App\Services\ServiceProTitle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class WithdrawController extends Controller
{
    /**
     * 提现记录列表
     */
    public function index(Request $request)
    {
        $status = array("申请中","已执行","已驳回");
        $dwr_obj = new Dis_Withdraw_Record();

        //搜索
        $input = $request->input();
        if(isset($input['search']) && $input['search'] == 1){
            if(!empty($input["Keyword"])){
                $dwr_obj = $dwr_obj->where('Method_Account', 'like', '%'.$input["Keyword"].'%');
            }
            if($input["Status"] != 'all'){
                $dwr_obj = $dwr_obj->where('Record_Status', $input["Status"]);
            }
            if(!empty($input["date-range-picker"])){
                $timer = explode('-', $input["date-range-picker"]);
                $dwr_obj = $dwr_obj->where('Record_CreateTime', '>=', strtotime($timer[0]));
                $dwr_obj = $dwr_obj->where('Record_CreateTime', '<=', strtotime($timer[1]));
            }
        }

        $record_list = $dwr_obj->orderBy('Record_CreateTime', 'desc')
            ->paginate(15);
        foreach($record_list as $key => $value){
            $value['status'] = $status[$value['Record_Status']];
            $value['Record_CreateTime'] = date("Y-m-d H:i:s",$value['Record_CreateTime']);
        }

        return view('admin.distribute.withdraw', compact('record_list'));
    }


    /**
     * 保存提现记录操作
     */
    public function update(Request $request, $id)
    {
        $umr_obj = new UserMoneyRecord();
        $dwr_obj = new Dis_Withdraw_Record();
        $m_obj = new Member();
        $input = $request->input();

        $withdraw_data = $dwr_obj->find($id);
        if(!$withdraw_data){
            return redirect()->back()->with('errors', '相应的提现记录不存在');
        }

        $amount = $withdraw_data['Record_Money'];
        $UserID = $withdraw_data['User_ID'];

        $rsUser = $m_obj->find($UserID);
        if(!$rsUser){
            return redirect()->back()->with('errors', '相应的会员不存在');
        }

        if(isset($input['action']) && $input['action'] == "fullfill"){
            DB::beginTransaction();
            if($withdraw_data['Method_Name'] == '余额提现'){
                $rsUser->User_Money += $amount;
                $Flag_user = $rsUser->save();

                $Data=array(
                    'Users_ID'=>USERSID,
                    'User_ID'=>$UserID,
                    'Type'=>1,
                    'Amount'=>$amount,
                    'Total'=>$rsUser['User_Money']+$amount,
                    'Note'=>"佣金余额提现 +".$amount,
                    'CreateTime'=>time()
                );
                $Flag_UserMoneyRecord = $umr_obj->create($Data);

                if (!$Flag_UserMoneyRecord || !$Flag_user) {
                    DB::rollBack();
                    return redirect()->back()->with('errors', '更新失败');
                }
            }else{
                if($withdraw_data['Record_Yue']>0){
                    $rsUser->User_Money += $withdraw_data['Record_Yue'];
                    $Flag_user = $rsUser->save();

                    $Data=array(
                        'Users_ID'=>USERSID,
                        'User_ID'=>$UserID,
                        'Type'=>1,
                        'Amount'=>$amount,
                        'Total'=>$rsUser['User_Money']+$withdraw_data['Record_Yue'],
                        'Note'=>"佣金提现转入余额 +".$withdraw_data['Record_Yue'],
                        'CreateTime'=>time()
                    );
                    $Flag_UserMoneyRecord = $umr_obj->create($Data);

                    if (!$Flag_UserMoneyRecord || !$Flag_user) {
                        DB::rollBack();
                        return redirect()->back()->with('errors', '更新失败');
                    }
                }
            }

            $withdraw_data->Record_Status = 1;
            $FlagDis = $withdraw_data->save();

            //发放爵位奖佣金start
            $pro_obj = new ServiceProTitle($UserID);
            $pro_flag = $pro_obj->send_pro_bouns($amount);
            //end

            if($FlagDis && $pro_flag)
            {
                DB::commit();
                return redirect()->back()->with('success', '更新成功');
            }else
            {
                DB::rollBack();
                return redirect()->back()->with('errors', '更新失败');
            }
        }
    }


    /**
     * 导出提现记录
     */
    public function output(Request $request)
    {
        //搜索
        $status = array("申请中","已执行","已驳回");
        $dwr_obj = new Dis_Withdraw_Record();
        $input = $request->input();
        if(isset($input['search']) && $input['search'] == 1){
            if(!empty($input["Keyword"])){
                $dwr_obj = $dwr_obj->where('Method_Account', 'like', '%'.$input["Keyword"].'%');
            }
            if($input["Status"] != 'all'){
                $dwr_obj = $dwr_obj->where('Record_Status', $input["Status"]);
            }
            if(!empty($input["date-range-picker"])){
                $timer = explode('-', $input["date-range-picker"]);
                $dwr_obj = $dwr_obj->where('Record_CreateTime', '>=', strtotime($timer[0]));
                $dwr_obj = $dwr_obj->where('Record_CreateTime', '<=', strtotime($timer[1]));
            }
        }

        $record_list = $dwr_obj->orderBy('Record_CreateTime', 'desc')->get();

        $lists = [];
        foreach($record_list as $key => $value){
            $lists[$key]['index'] = $key+1;
            $lists[$key]['mobile'] = $value['user']['User_Mobile'];
            $lists[$key]['Method_Name'] = $value['Method_Name'];
            $lists[$key]['Method_Account'] = $value['Method_Account'];
            $lists[$key]['Method_No'] = $value['Method_No'];
            $lists[$key]['Method_Bank'] = $value['Method_Bank'];
            $lists[$key]['Record_Total'] = $value['Record_Total'];
            $lists[$key]['Record_Fee'] = $value['Record_Fee'];
            $lists[$key]['Record_Yue'] = $value['Record_Yue'];
            $lists[$key]['Real_Fee'] = $value['Record_Total'] - $value['Record_Fee'];
            $lists[$key]['status'] = $status[$value['Record_Status']];
            $lists[$key]['Record_CreateTime'] = date("Y-m-d H:i:s",$value['Record_CreateTime']);
        }

        $title = [['提现记录列表']];
        $cellData = [['序号','用户','提现方式', '提现账户', '提现账号', '开户行', '提现总金额', '提现手续费',
            '提现转入余额', '实提金额', '状态', '时间']];
        $cellData = array_merge($title, $cellData, $lists);

        Excel::create('提现记录列表',function($excel) use ($cellData){

            $excel->sheet('withdraw_record', function($sheet) use ($cellData){

                $sheet->mergeCells('A1:L1');//合并单元格
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
                    'A' => 7,
                    'B' => 15,
                    'C' => 20,
                    'D' => 20,
                    'E' => 20,
                    'F' => 20,
                    'G' => 15,
                    'H' => 15,
                    'I' => 15,
                    'J' => 15,
                    'K' => 15,
                    'L' => 20,
                ]);
                $sheet->rows($cellData);
            });
        })->export('xls');
    }
}
