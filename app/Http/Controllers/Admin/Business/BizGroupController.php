<?php

namespace App\Http\Controllers\Admin\Business;

use App\Models\Biz;
use App\Models\Biz_Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BizGroupController extends Controller
{
    /**
     * 商家分组列表
     */
    public function index()
    {
        $bg_obj = new Biz_Group();
        $lists = $bg_obj->orderBy('Group_ID', 'asc')->paginate(15);

        return view('admin.business.group', compact('lists'));
    }


    /**
     * 添加商家分组页面
     */
    public function create()
    {
        return view('admin.business.group_create');
    }


    /**
     * 保存商家分组
     */
    public function store(Request $request)
    {
        $input = $request->input();
        $rules = [
            'Name' => 'required|unique:biz_group,Group_Name',
            'Index' => 'required|integer|min:0'
        ];
        $message = [
            'Name.required' => '商家分组名称不能为空',
            'Name.unique' => '商家分组名称不能重复',
            'Index.required' => '商家分组排序不能为空',
            'Index.integer' => '商家分组排序必须是整数',
            'Index.min' => '商家分组排序不能小于0',
        ];
        $validator = Validator::make($input, $rules, $message);
        if($validator->fails()){
            return redirect()->back()->with('errors', $validator->messages())->withInput();
        }

        $bg_obj = new Biz_Group();
        $Data=array(
            "Group_Name"=>$input['Name'],
            "Group_Index"=>empty($input['Index']) ? 0 : intval($input['Index']),
            "Group_IsStore"=>empty($input['IsStore']) ? 0 : intval($input['IsStore']),
            "Users_ID"=>USERSID,

        );
        $Flag = $bg_obj->create($Data);
        if($Flag){
            return redirect()->route('admin.business.group_index')->with('success', '添加成功');
        }else{
            return redirect()->back()->with('errors', '保存失败');
        }

    }


    /**
     * 编辑商家分组页面
     */
    public function edit($id)
    {
        $bg_obj = new Biz_Group();
        $group = $bg_obj->find($id);
        return view('admin.business.group_edit', compact('group'));
    }


    /**
     * 保存编辑
     */
    public function update(Request $request, $id)
    {
        $input = $request->input();
        $rules = [
            'Name' => "required|unique:biz_group,Group_Name,{$id},Group_ID",
            'Index' => 'required|integer|min:0'
        ];
        $message = [
            'Name.required' => '商家分组名称不能为空',
            'Name.unique' => '商家分组名称不能重复',
            'Index.required' => '商家分组排序不能为空',
            'Index.integer' => '商家分组排序必须是整数',
            'Index.min' => '商家分组排序不能小于0',
        ];
        $validator = Validator::make($input, $rules, $message);
        if($validator->fails()){
            return redirect()->back()->with('errors', $validator->messages())->withInput();
        }

        $bg_obj = new Biz_Group();
        $Data=array(
            "Group_Name"=>$input['Name'],
            "Group_Index"=>empty($input['Index']) ? 0 : intval($input['Index']),
            "Group_IsStore"=>empty($input['IsStore']) ? 0 : intval($input['IsStore']),
        );
        $bg_obj->where('Group_ID', $id)->update($Data);

        return redirect()->route('admin.business.group_index')->with('success', '保存成功');

    }


    /**
     * 删除商家分组
     */
    public function del($id)
    {
        $bg_obj = new Biz_Group();
        $b_obj = new Biz();
        $Flag = $bg_obj->destroy($id);
        if($Flag){
            $b_obj->where('Group_ID', $id)->update(['Group_ID' => 0]);
            return redirect()->back()->with('success', '保存成功');
        }else{
            return redirect()->back()->with('errors', '保存失败');
        }
    }


}
