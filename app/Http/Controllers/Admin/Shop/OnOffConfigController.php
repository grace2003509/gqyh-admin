<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Models\PermissionConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OnOffConfigController extends Controller
{
    public function index()
    {
        $pc_obj = new PermissionConfig();
        $perm_config = $pc_obj->where('Is_Delete', 0)
            ->orderBy('Perm_On', 'desc')
            ->get();
        $switchplace = array('非法操作','分销中心','个人中心','分销中心-二维码','产品详情','提交订单');
        return view('admin.shop.on_off_config', compact('perm_config', 'switchplace'));
    }

    public function update(Request $request)
    {

    }
}
