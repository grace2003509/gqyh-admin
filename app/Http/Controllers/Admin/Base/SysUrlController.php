<?php
/**
 * 系统url查询
 */
namespace App\Http\Controllers\Admin\Base;

use App\Models\UsersConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SysUrlController extends Controller
{
    public function index(Request $request)
    {
        $get = $request->input();

        $type = isset($get["type"]) ? $get["type"] : 'shop_category';

        $uc_obj = new UsersConfig();
        $users_dominfo = $uc_obj->get_dominfo();
        if(!empty($users_dominfo['domname']) && $users_dominfo['domenable'] == 1){
            $rulreal = $users_dominfo['domname'];
        }else{
            $rulreal = $_SERVER["HTTP_HOST"];
        }

        return view('admin.base.sys_url', compact('type', 'rulreal'));
    }
}
