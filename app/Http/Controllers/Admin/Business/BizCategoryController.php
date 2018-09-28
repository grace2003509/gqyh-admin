<?php

namespace App\Http\Controllers\Admin\Business;

use App\Models\Biz;
use App\Models\Biz_Category;
use App\Models\Biz_Union_Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BizCategoryController extends Controller
{
    /**
     * 商家行业分类列表
     */
    public function index()
    {
        $buc_obj = new Biz_Union_Category();
        $lists = $buc_obj->where('Category_ParentID', 0)
            ->orderBy('Category_Index', 'asc')
            ->get();
        foreach($lists as $key => $value){
            $sonCategory = $buc_obj->where('Category_ParentID', $value['Category_ID'])
                ->orderBy('Category_Index', 'asc')
                ->get();
            if(count($sonCategory) > 0){
                $value['child'] = $sonCategory;
            }
        }

        return view('admin.business.biz_category', compact('lists'));

    }


    /**
     * 添加商家行业分类页面
     */
    public function create()
    {
        $buc_obj = new Biz_Union_Category();
        $pcategory = $buc_obj->where('Category_ParentID', 0)
            ->orderBy('Category_Index', 'asc')
            ->get();

        return view('admin.business.biz_category_create', compact('pcategory'));
    }


    /**
     * 保存商家行业分类
     */
    public function store(Request $request)
    {
        $input = $request->input();
        $rules = [
            'Index' => 'required|integer|min:1',
            'Name' => "required|string|max:30|unique:biz_union_category,Category_Name,0,Category_ID,Category_ParentID,{$input['ParentID']}"
        ];
        $message = [
            'Index.integer' => '产品类别序号必须是整数',
            'Index.min' => '产品类别序号最小值为1',
            'Name.required' => '产品类别名称不能为空',
            'Name.unique' => '产品类别名称不能重复'
        ];
        $validator = Validator::make($input, $rules, $message);
        if($validator->fails()){
            return redirect()->back()->with('errors', $validator->messages())->withInput();
        }

        $Data=array(
            "Category_Index"=>$input['Index'],
            "Category_Name"=>$input["Name"],
            "Category_ParentID"=>$input["ParentID"],
            "Users_ID"=>USERSID,
            "Category_Img"=>$input['ImgPath'],
        );
        $buc_obj = new Biz_Union_Category();
        $Flag = $buc_obj->create($Data);

        if($Flag){
            return redirect()->route('admin.business.biz_category_index')->with('success', '添加成功');
        }else{
            return redirect()->back()->with('errors', '保存失败')->withInput();
        }
    }


    /**
     * 编辑商家行业分类页面
     */
    public function edit($id)
    {
        $buc_obj = new Biz_Union_Category();
        $rsCategory = $buc_obj->find($id);
        $pcategory = $buc_obj->where('Category_ParentID', 0)
            ->where('Category_ID', '<>', $id)
            ->orderBy('Category_Index', 'asc')
            ->get();
        return view('admin.business.biz_category_edit', compact('rsCategory', 'pcategory'));
    }


    /**
     * 保存编辑商家行业分类
     */
    public function update(Request $request, $id)
    {
        $input = $request->input();
        $rules = [
            'Index' => 'required|integer|min:1',
            'Name' => "required|string|max:30|unique:biz_union_category,Category_Name,{$id},Category_ID,Category_ParentID,{$input['ParentID']}"
        ];
        $message = [
            'Index.integer' => '产品类别序号必须是整数',
            'Index.min' => '产品类别序号最小值为1',
            'Name.required' => '产品类别名称不能为空',
            'Name.unique' => '产品类别名称不能重复'
        ];
        $validator = Validator::make($input, $rules, $message);
        if($validator->fails()){
            return redirect()->back()->with('errors', $validator->messages())->withInput();
        }

        $Data=array(
            "Category_Index"=>$input['Index'],
            "Category_Name"=>$input["Name"],
            "Category_ParentID"=>$input["ParentID"],
        );
        $buc_obj = new Biz_Union_Category();
        $buc_obj->where('Category_ID', $id)->update($Data);

        return redirect()->route('admin.business.biz_category_index')->with('success', '编辑成功');
    }


    /**
     * 删除商家行业分类
     */
    public function del($id)
    {
        $buc_obj = new Biz_Union_Category();

        $r = $buc_obj->where('Category_ParentID', $id)->count();
        if($r > 0){
            return redirect()->back()->with('errors', '该分类下有子分类，不能删除');
        }

        $b_obj = new Biz();
        $r = $b_obj->where('Category_ID', $id)->count();
        if($r > 0){
            return redirect()->back()->with('errors', '该分类下有商家，不能删除');
        }

        $flag = $buc_obj->destroy($id);

        if($flag){
            return redirect()->back()->with('success', '删除成功');
        }else{
            return redirect()->back()->with('errors', '删除失败');
        }

    }



}
