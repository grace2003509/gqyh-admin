<?php

namespace App\Http\Controllers\Admin\Wechat;

use App\Models\WechatMaterial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MaterialController extends Controller
{
    public function index()
    {
        $obj = new WechatMaterial();
        $rsMaterials = $obj->where('Material_TableID', 0)
            ->where('Material_Display', 1)
            ->orderBy('Material_ID', 'desc')
            ->paginate(10);
        foreach($rsMaterials as $key => $value){
            $value['json'] = json_decode($value['Material_Json'], true);
            $value['Material_CreateTime'] = date('Y-m-d', $value['Material_CreateTime']);
        }
        return view('admin.wechat.material', compact('rsMaterials'));
    }

    public function add()
    {

        return view('admin.wechat.material_add');
    }

    public function madd()
    {

        return view('admin.wechat.material_madd');
    }

    public function store(Request $request)
    {

    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function del($id)
    {

    }
}
