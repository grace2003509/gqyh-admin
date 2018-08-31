<?php

namespace App\Http\Controllers\Admin\Active;

use App\Models\Active;
use App\Models\Biz_Active;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ActiveController extends Controller
{
    const TYPE = [
        1 => '限时抢购'
    ];


    public function index()
    {
        $typelist = self::TYPE;

        $a_obj = new Active();
        $lists = $a_obj->orderBy('Status', 'asc')
            ->orderBy('Active_ID', 'desc')
            ->paginate(15);
        foreach($lists as $key => $value){
            $value['starttime'] = date("Y-m-d",$value["starttime"]);
            $value['stoptime'] = date("Y-m-d",$value["stoptime"]);
        }

        return view('admin.active.active_index', compact('lists', 'typelist'));
    }


    public function create()
    {
        $typelist = self::TYPE;

        return view('admin.active.active_create', compact('typelist'));
    }



    public function store(Request $request)
    {
        $input = $request->input();
        $rules = [
            'Active_Name' => 'required|unique:active,Active_Name|string|max:100',
            'ActiveType' => 'required',
            'date-range-picker' => 'required',
            'MaxBizCount' => 'required|integer|min:1',
            'MaxGoodsCount' => 'required|integer|min:1',
            'BizGoodsCount' => 'required|integer|nothan:MaxGoodsCount,'.$input['MaxGoodsCount'].'|min:1',
            'ListShowGoodsCount' => 'required|integer|nothan:MaxGoodsCount,'.$input['MaxGoodsCount'].'|min:1',
            'BizShowGoodsCount' => 'required|integer|nothan:MaxGoodsCount,'.$input['MaxGoodsCount'].'|min:1',
        ];
        $message = [
            'BizGoodsCount.nothan' => '商家推荐产品数不能大于活动最多产品数',
            'ListShowGoodsCount.nothan' => '列表页显示产品数不能大于活动最多产品数',
            'BizShowGoodsCount.nothan' => '商家店铺页显示产品数不能大于活动最多产品数',
        ];
        $des = [
            'Active_Name' => '活动名称',
            'ActiveType' => '活动类型',
            'MaxBizCount' => '商家数',
            'MaxGoodsCount' => '活动最多产品数',
            'BizGoodsCount' => '商家推荐产品数',
            'ListShowGoodsCount' => '列表页显示产品数',
            'BizShowGoodsCount' => '商家店铺页显示产品数',
            'date-range-picker' => '参与活动时间',
        ];
        $validator = Validator::make($input, $rules, $message, $des);
        if($validator->fails()){
            return redirect()->back()->with('errors', $validator->messages())->withInput();
        }

        $data['Users_ID'] = USERSID;
        $data['Active_Name'] = $input['Active_Name'];
        $data['MaxGoodsCount'] = intval($input['MaxGoodsCount']);
        $data['MaxBizCount'] = intval($input['MaxBizCount']);
        $data['BizGoodsCount'] = intval($input['BizGoodsCount']);
        $data['ListShowGoodsCount'] = intval($input['ListShowGoodsCount']);
        $data['BizShowGoodsCount'] = intval($input['BizShowGoodsCount']);
        $time = explode('-', $input['date-range-picker']);
        $data['starttime'] = strtotime($time[0]);
        $data['stoptime'] = strtotime($time[1]);
        $data['Type_ID'] = $input['ActiveType'];
        $data['addtime'] = time();

        if (isset($input['imgurl']) && $input['imgurl']) {
            $data['imgurl'] = $input['imgurl'];
        }
        $data['Status'] = $input['Status'];

        $a_obj = new Active();
        $flag = $a_obj->create($data);
        if($flag){
            return redirect()->route('admin.active.index')->with('success', '保存成功');
        } else {
            return redirect()->back()->with('errors', '保存失败');
        }
    }



    public function edit($id)
    {
        $typelist = self::TYPE;
        $a_obj = new Active();
        $active = $a_obj->find($id);
        $active['date-range-picker'] = date('Y/m/d',$active['starttime']).'-'.date('Y/m/d',$active['stoptime']);

        return view('admin.active.active_edit', compact('active', 'typelist'));
    }



    public function update(Request $request, $id)
    {
        $input = $request->input();
        $rules = [
            'Active_Name' => "required|unique:active,Active_Name,{$id},Active_ID|string|max:100",
            'ActiveType' => 'required',
            'date-range-picker' => 'required',
            'MaxBizCount' => 'required|integer|min:1',
            'MaxGoodsCount' => 'required|integer|min:1',
            'BizGoodsCount' => 'required|integer|nothan:MaxGoodsCount,'.$input['MaxGoodsCount'].'|min:1',
            'ListShowGoodsCount' => 'required|integer|nothan:MaxGoodsCount,'.$input['MaxGoodsCount'].'|min:1',
            'BizShowGoodsCount' => 'required|integer|nothan:MaxGoodsCount,'.$input['MaxGoodsCount'].'|min:1',
        ];
        $message = [
            'BizGoodsCount.nothan' => '商家推荐产品数不能大于活动最多产品数',
            'ListShowGoodsCount.nothan' => '列表页显示产品数不能大于活动最多产品数',
            'BizShowGoodsCount.nothan' => '商家店铺页显示产品数不能大于活动最多产品数',
        ];
        $des = [
            'Active_Name' => '活动名称',
            'ActiveType' => '活动类型',
            'MaxBizCount' => '商家数',
            'MaxGoodsCount' => '活动最多产品数',
            'BizGoodsCount' => '商家推荐产品数',
            'ListShowGoodsCount' => '列表页显示产品数',
            'BizShowGoodsCount' => '商家店铺页显示产品数',
            'date-range-picker' => '参与活动时间',
        ];
        $validator = Validator::make($input, $rules, $message, $des);
        if($validator->fails()){
            return redirect()->back()->with('errors', $validator->messages())->withInput();
        }

        $data['Users_ID'] = USERSID;
        $data['Active_Name'] = $input['Active_Name'];
        $data['MaxGoodsCount'] = intval($input['MaxGoodsCount']);
        $data['MaxBizCount'] = intval($input['MaxBizCount']);
        $data['BizGoodsCount'] = intval($input['BizGoodsCount']);
        $data['ListShowGoodsCount'] = intval($input['ListShowGoodsCount']);
        $data['BizShowGoodsCount'] = intval($input['BizShowGoodsCount']);
        $time = explode('-', $input['date-range-picker']);
        $data['starttime'] = strtotime($time[0]);
        $data['stoptime'] = strtotime($time[1]);
        $data['Type_ID'] = $input['ActiveType'];
        $data['addtime'] = time();

        if (isset($input['imgurl']) && $input['imgurl']) {
            $data['imgurl'] = $input['imgurl'];
        }
        $data['Status'] = $input['Status'];

        $a_obj = new Active();
        $flag = $a_obj->where('Active_ID', $id)->update($data);
        if($flag){
            return redirect()->route('admin.active.index')->with('success', '保存成功');
        } else {
            return redirect()->back()->with('errors', '保存失败');
        }
    }



    public function del($id)
    {
        $ba_obj = New Biz_Active();
        $biz_active = $ba_obj->where('Active_ID', $id)->where('Status', 2)->get();
        if($biz_active){
            return redirect()->back()->with('errors', '已有商家正在参加活动，不能删除');
        }

        $a_obj = New Active();
        $rst = $a_obj->find($id);
        $flag2 = $rst->biz_actives->delete();
        $flag1 = $a_obj->destroy($id);

        if($flag1 || $flag2){
            return redirect()->back()->with('success', '删除成功');
        }else{
            return redirect()->back()->with('errors', '删除失败');
        }

    }



    public function biz_actives($id)
    {
        $status = [
            '未开始',
            '申请中',
            '已同意',
            '已拒绝',
            '已结束'
        ];
        $typelist = self::TYPE;;

        $ba_obj = New Biz_Active();
        $actives = $ba_obj->where('Active_ID', $id)->paginate(15);

        return view('admin.active.biz_actives', compact('actives', 'status', 'typelist'));
    }
}
