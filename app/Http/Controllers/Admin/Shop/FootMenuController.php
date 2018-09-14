<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Models\ShopConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FootMenuController extends Controller
{
    const DEFAULT_MENU = array(
        'menu' => array(
            array(
                'menu_name' => '首页',
                'login_menu_name' => '首页',
                'icon' => 'fa fa-home fa-2x',
                'icon_on' => '/static/api/distribute/images/shouye1.png',
                'icon_up' => '/static/api/distribute/images/shouye.png',
                'menu_href' => '/',
                'login_menu_href' => '/',
                'bind_action_attr' => 0,
                'menu_order' => '1'),
            array(
                'menu_name' => '购物',
                'login_menu_name' => '购物',
                'icon' => 'fa fa-cart-plus fa-2x',
                'icon_on' => '/static/api/distribute/images/gwc1.png',
                'icon_up' => '/static/api/distribute/images/gwc.png',
                'menu_href' => '/',
                'login_menu_href' => '/',
                'bind_action_attr' => 0,
                'menu_order' => '2'),
            array(
                'menu_name' => '开店',
                'login_menu_name' => '开店',
                'icon' => 'fa fa-shopping-bag fa-6x',
                'icon_on' => '/static/api/distribute/images/center_x1.png',
                'icon_up' => '/static/api/distribute/images/center_x.png',
                'menu_href' => '/',
                'login_menu_href' => '/',
                'bind_action_attr' => 1,
                'menu_order' => '3'),
            array(
                'menu_name' => '我的',
                'login_menu_name' => '我的',
                'icon' => 'fa fa-user fa-2x',
                'icon_on' => '/static/api/distribute/images/hyzx1.png',
                'icon_up' => '/static/api/distribute/images/hyzx.png',
                'menu_href' => '/',
                'login_menu_href' => '/',
                'bind_action_attr' => 0,
                'menu_order' => '4'),
        )
    );

    public function index()
    {
        $sc_obj = new ShopConfig();
        $Shop_Config = $sc_obj->find(USERSID);
        $DefaultMenu = self::DEFAULT_MENU;

        if ($Shop_Config['Bottom_Style'] == 0) {
            if (!empty($Shop_Config['ShopMenuJson'])) {
                $ShopMenu = json_decode($Shop_Config['ShopMenuJson'], TRUE);
            } else {
                $ShopMenu = $DefaultMenu;
            }
        } else {
            if (!empty($Shop_Config['ShopMenuJson'])) {
                $ShopMenu = json_decode($Shop_Config['ShopMenuJson'], TRUE);
            } else {
                $ShopMenu = $DefaultMenu;
            }
        }
        return view('admin.shop.foot_menu', compact('ShopMenu', 'Shop_Config'));
    }


    public function update(Request $request)
    {
        $input = $request->input();

        $input['menu'] = array_merge($input['menu']);
        foreach ($input['menu'] as $k => &$v) {
            $v['menu_name'] = trim($v['menu_name']);
            $v['menu_href'] = trim($v['menu_href']);
            $v['menu_order'] = intval($v['menu_order']);
            if (empty($v['menu_name']) || empty($v['menu_href'])) {
                unset($input['menu'][$k]);
            }
        }
        $Data=array(
            "ShopMenuJson"=>json_encode($input,JSON_UNESCAPED_UNICODE),
        );
        $sc_obj = new ShopConfig();
        $Flag = $sc_obj->where('Users_ID', USERSID)->update($Data);

        return redirect()->back()->with('success', '保存成功');

    }


    public function del(Request $request)
    {
        $input = $request->input();

        $sc_obj = new ShopConfig();
        $rsMenuConfig = $sc_obj->select('ShopMenuJson')
            ->where('Users_ID', USERSID)
            ->first();

        $DefaultMenu = self::DEFAULT_MENU;
        $ShopMenu = empty($rsMenuConfig['ShopMenuJson']) ? $DefaultMenu : json_decode($rsMenuConfig['ShopMenuJson'], TRUE);
        unset($ShopMenu['menu'][$input['menuId']]);
        if (!empty($ShopMenu)) {
            $ShopMenu['menu'] = array_merge($ShopMenu['menu']);
            $Data=array(
                "ShopMenuJson"=>json_encode($ShopMenu,JSON_UNESCAPED_UNICODE),
            );
            $Flag=$sc_obj->where('Users_ID', USERSID)->update($Data);
            if ($Flag) {
                echo json_encode(array('status' => 1, 'msg' => '删除成功！'));
            } else {
                echo json_encode(array('status' => 0, 'msg' => '删除失败！'));
            }
        }

    }


}
