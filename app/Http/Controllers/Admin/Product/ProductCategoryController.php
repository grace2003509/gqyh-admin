<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\ShopCategory;
use App\Models\ShopProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $sc_obj = new ShopCategory();
        $ParentMenu = $sc_obj->where('Category_ParentID', 0)
            ->orderBy('Category_Index', 'asc')
            ->get();
        foreach($ParentMenu as $key => $value){
            $sonCategory = $sc_obj->where('Category_ParentID', $value['Category_ID'])
                ->orderBy('Category_Index', 'asc')
                ->get();
            if(count($sonCategory) > 0){
                $value['child'] = $sonCategory;
            }
        }

        return view('admin.product.product_category', compact('ParentMenu'));
    }


    public function create()
    {
        $sc_obj = new ShopCategory();
        $pcategory = $sc_obj->where('Category_ParentID', 0)
            ->orderBy('Category_Index', 'asc')
            ->get();

        return view('admin.product.category_create', compact('pcategory'));
    }


    public function store(Request $request)
    {
        $input = $request->input();
        $rules = [
            'Index' => 'required|integer|min:1',
            'Name' => "required|string|max:30|unique:shop_category,Category_Name,0,Category_ID,Category_ParentID,{$input['ParentID']}"
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
            "Category_Img"=>!empty($input['ImgPath']) ? $input['ImgPath'] : '',
            "Category_Bond"=>!empty($input["Category_Bond"])?$input["Category_Bond"]:'0',
        );
        $sc_obj = new ShopCategory();
        $Flag=$sc_obj->create($Data);
        if($Flag){
            return redirect()->route('admin.product.product_category_index')->with('success', '添加成功');
        }else{
            return redirect()->back()->with('errors', '保存失败')->withInput();
        }
    }


    public function edit($id)
    {
        $sc_obj = new ShopCategory();
        $rsCategory = $sc_obj->find($id);
        $pcategory = $sc_obj->where('Category_ParentID', 0)
            ->where('Category_ID', '<>', $id)
            ->orderBy('Category_Index', 'asc')
            ->get();
        return view('admin.product.category_edit', compact('rsCategory', 'pcategory'));
    }


    public function update(Request $request, $id)
    {
        $input = $request->input();
        $rules = [
            'Index' => 'required|integer|min:1',
            'Name' => "required|string|max:30|unique:shop_category,Category_Name,{$id},Category_ID,Category_ParentID,{$input['ParentID']}"
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
            "Category_Img"=>!empty($input['ImgPath']) ? $input['ImgPath'] : '',
            "Category_Bond"=>!empty($input["Category_Bond"])?$input["Category_Bond"]:'0',
        );
        $sc_obj = new ShopCategory();
        $sc_obj->where('Category_ID', $id)->update($Data);

        return redirect()->route('admin.product.product_category_index')->with('success', '编辑成功');

    }


    public function del($id)
    {
        $sc_obj = new ShopCategory();
        $sp_obj = new ShopProduct();

        $snum = $sc_obj->where('Category_ParentID', $id)->count('*');
        if($snum > 0){
            return redirect()->back()->with('errors', '该分类下有子类不能删除');
        }
        $pnum = $sp_obj->where('Products_Category', $id)->count('*');
        if($pnum > 0){
            return redirect()->back()->with('errors', '该分类下有产品不能删除');
        }
        $flag = $sc_obj->destroy($id);
        if($flag){
            return redirect()->back()->with('success', '删除成功');
        }
    }


}
