<?php

namespace App\Http\Controllers\Admin\Distribute;

use App\Models\Dis_Account;
use App\Models\Dis_Config;
use App\Models\Dis_Level;
use App\Models\ShopCategory;
use App\Models\ShopProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BaseConfigController extends Controller
{
    /**
     * 分销基础设置展示页
     */
    public function index()
    {
        $dc_obj = new Dis_Config();
        $dl_obj = new Dis_Level();

        $rsConfig = $dc_obj->find(1);
        if (!$rsConfig) {
            $Data = ['Users_ID' => USERSID];
            $rsConfig = $dc_obj->create($Data);
        }

        //获取分销商级别列表
        $list_level = $dl_obj->all();
        //分销商级别不存在，插入默认值
        if (empty($list_level)) {
            $Data = array(
                "Users_ID" => USERSID,
                "Level_Name" => "普通分销商",
                "Level_LimitType" => 3,
                "Level_PeopleLimit" => json_encode(array(1 => '0'), JSON_UNESCAPED_UNICODE),
                "Level_CreateTime" => time()
            );
            $list_level[] = $dl_obj->create($Data);
        }

        $max_level = 3;

        return view('admin.distribute.base_config', compact('rsConfig', 'list_level', 'max_level'));

    }

    /**
     * 保存分销基础设置
     */
    public function update(Request $request)
    {
        $input = $request->input();
        $dc_obj = new Dis_Config();
        $dis_config = $dc_obj->find(1);

        //分销商门槛
        $dis_config->Distribute_Type = $input['Distribute_Type'];
        //提现门槛
        $dis_config->Dis_Level = $input['Dis_Level'];
        $dis_config->Dis_Mobile_Level = $input['Dis_Mobile_Level'];
        $dis_config->Dis_Self_Bonus = !empty($input['Dis_Self_Bonus']) ? $input['Dis_Self_Bonus'] : 0;
        //分销商升级方式
        $dis_config->Distribute_UpgradeWay = $input['Distribute_UpgradeWay'];

        $dis_config->save();

        return redirect()->back()->with('success', '设置成功');

    }


    /**
     * 分销商级别设置显示页
     * @param Request $request
     */
    public function get_dis_level(Request $request)
    {
        $input = $request->input();
        $dc_obj = new Dis_Config();
        $dl_obj = new Dis_Level();
        $sp_obj = new ShopProduct();

        if ($input['action'] == 'get_dis_level') {
            $type = $input['type'];
            $arr = array('一', '二', '三', '四', '五', '六', '七', '八', '九', '十');
            $_TYPE = array('直接购买', '消费额', '购买商品', '无门槛');

            $dc_obj->where('id', 1)->update(['Distribute_Type' => $type]);

            $lists = $dl_obj->all();
            $html = '<table width="100%" cellpadding="0" cellspacing="0">';
            $i = 0;
            if ($type == 2) {//购买商品
                $html .= '<tr>
                    <th width="12%" nowrap="nowrap">序号</th>
                    <th width="22%" nowrap="nowrap">级别名称</th>
                    <th width="22%" nowrap="nowrap">门槛</th>
                    <th width="22%" nowrap="nowrap">商品</th>
                    <th width="22%" nowrap="nowrap" class="last">人数限制</th>
                  </tr>';
                foreach ($lists as $key => $value) {
                    $i++;
                    $PeopleLimit = json_decode($value['Level_PeopleLimit'], true);
                    if ($i == 1 && $value['Level_LimitType'] == 3) {//第一个无门槛
                        $limit = '';
                    } elseif ($value['Level_LimitType'] != 2) {
                        $limit = '';
                    } else {
                        $limit_arr = explode('|', $value['Level_LimitValue']);
                        if ($limit_arr[0] == 0) {//任意商品
                            $limit = '购买任意商品';
                        } else {
                            $limit = '购买以下商品：';
                            $pids = explode(',', $limit_arr[1]);
                            foreach ($pids as $id) {
                                $product = $sp_obj->select('Products_ID', 'Products_Name')->find($id);
                                $limit .= empty($product) ? '' : '<br />' . $product['Products_Name'];
                            }
                        }
                    }
                    $html .= '<tr>
                        <td nowrap="nowrap">' . $i . '</td>
                        <td nowrap="nowrap">' . $value["Level_Name"] . '</td>
                        <td nowrap="nowrap">' . ($i == 1 ? $_TYPE[$value["Level_LimitType"]] : $_TYPE[$type]) . '</td>
                        <td nowrap="nowrap"><span style="color:#F60">' . $limit . '</span></td>
                        <td nowrap="nowrap" class="last">';
                    foreach ($PeopleLimit as $k => $v) {
                        if ($k > 1) {
                            $html .= '<br />';
                        }
                        $html .= $arr[$k - 1] . '级&nbsp;&nbsp;';
                        if ($v == 0) {
                            $html .= '无限制';
                        } elseif ($v == -1) {
                            $html .= '禁止';
                        } else {
                            $html .= $v . '&nbsp;个';
                        }
                    }
                    $html .= '</td></tr>';
                }
            }
            $html .= '</table>';
            echo json_encode(array("html" => $html, "type" => $type), JSON_UNESCAPED_UNICODE);
            exit;
        }
    }


    /**
     * 设置级别页面
     */
    public function level(Request $request)
    {
        $input = $request->input();

        $dl_obj = new Dis_Level();
        $sp_obj = new ShopProduct();

        $level = $input['level'];
        $type = $input['type'];

        //查询级别
        $lists = $dl_obj->orderBy('Level_ID', 'asc')->get();
        foreach ($lists as $key => $value) {
            $value['PeopleLimit'] = json_decode($value['Level_PeopleLimit'], true);

            if ($type == 2) {//购买商品
                if (($key == 0 && $value['Level_LimitType'] == 3) || $value['Level_LimitType'] != 2) {//第一个无门槛
                    $limit[$key] = '';
                } else {
                    $limit_arr = explode('|', $value['Level_LimitValue']);
                    if ($limit_arr[0] == 0) {
                        $limit[$key] = '购买任意商品';
                    } else {
                        $limit[$key] = '购买以下商品：';
                        $pids = explode(',', $limit_arr[1]);
                        foreach ($pids as $id) {
                            $product = $sp_obj->select('Products_ID', 'Products_Name')->find($id);
                            $limit[$key] .= empty($product) ? '' : '<br />' . $product['Products_Name'];
                        }

                    }
                }
            }

        }

        $arr = array('一', '二', '三', '四', '五', '六', '七', '八', '九', '十');
        $_TYPE = array('直接购买', '消费额', '购买商品', '无门槛');

        return view('admin.distribute.level', compact(
            'lists', 'arr', '_TYPE', 'type', 'level', 'limit'));

    }


    /**
     * 添加级别设置页面
     * @param Request $request
     */
    public function level_add(Request $request)
    {
        $input = $request->input();

        $dl_obj = new Dis_Level();
        $sc_obj = new ShopCategory();

        $level = $input['level'];
        $type = $input['type'];
        $arr = array('一', '二', '三', '四', '五', '六', '七', '八', '九', '十');

        //获取第一个分销商级别
        $first['one'] = $dl_obj->select('Level_LimitType', 'Present_type')
            ->orderBy('Level_ID', 'asc')
            ->first();
        $first['new'] = $first['one'];
        if ($first['one']['Level_LimitType'] == 3) {
            //获取第一个分销商级别
            $first['two'] = $dl_obj->select('Level_ID', 'Level_LimitType', 'Present_type')
                ->where('Level_LimitType', '<>', 3)
                ->orderBy('Level_ID', 'asc')
                ->first();
            $first['new'] = $first['two'];
        }

        //获取商品类别
        $category_list = $sc_obj->where('Category_ParentID', 0)
            ->orderBy('Category_ParentID', 'asc')
            ->orderBy('Category_Index', 'asc')
            ->get();
        foreach ($category_list as $key => $value) {
            $child = $sc_obj->where('Category_ParentID', $value['Category_ID'])
                ->orderBy('Category_Index', 'asc')
                ->orderBy('Category_ID', 'asc')
                ->get();
            if ($child) {
                $value['child'] = $child;
            } else {
                $value['child'] = [];
            }
        }

        return view('admin.distribute.level_add', compact(
            'arr', 'level', 'type', 'first', 'category_list'));

    }


    /**
     * 保存新的分销级别
     * @param Request $request
     */
    public function level_store(Request $request)
    {
        $input = $request->input();

        $rules = [
            'level' => 'required',
            'type' => 'required|in:0,1,2',
            'Name' => 'required|string|max:30|unique:distribute_level,Level_Name'
        ];
        $message = [
            'level.required' => '缺少必要的参数',
            'type.required' => '缺少必要的参数',
            'Name.required' => '级别名称不能为空',
            'Name.unique' => '级别名称不能重复',
        ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->fails()) {
            echo '<script language="javascript">alert("' . $validator->messages()->first() . '");history.back();</script>';
            exit;
        }

        $PeopleLimit = array();
        foreach ($input['PeopleLimit'] as $k => $v) {
            $PeopleLimit[$k] = empty($v) ? 0 : intval($v);
        }

        $Data = array(
            "Users_ID" => USERSID,
            "Level_Name" => $input['Name'],
            "Level_LimitType" => $input['type'],
            "Level_PeopleLimit" => empty($PeopleLimit) ? '' : json_encode($PeopleLimit, JSON_UNESCAPED_UNICODE),
            "Level_CreateTime" => time()
        );
        if (!empty($input['Level_Description'])) {
            $Data['Level_Description'] = $input['Level_Description'];
        }
        if ($input['type'] == 2) {//购买商品
            if ($input['Fanwei'] == 1) {
                if ($input['BuyIDs'] == '') {
                    echo '<script language="javascript">alert("请选择商品");history.back();</script>';
                    exit;
                }
                $Data['Level_LimitValue'] = $input['Fanwei'] . '|' . substr($input['BuyIDs'], 1, -1);
            }
        }

        $dl_obj = new Dis_Level();
        $Flag = $dl_obj->create($Data);

        if ($Flag) {
            echo '<script language="javascript">alert("添加成功");
                window.location.href="' . route('admin.distribute.level', ['level' => $input['level'], 'type' => $input['type']]) . '";</script>';
            exit;
        } else {
            echo '<script language="javascript">alert("添加失败");history.back();</script>';
            exit;
        }

    }


    /**
     * 修改分销级别
     */
    public function level_edit(Request $request, $id)
    {
        $input = $request->input();
        $dl_obj = new Dis_Level();
        $sc_obj = new ShopCategory();
        $sp_obj = new ShopProduct();

        $rsLevel = $dl_obj->find($id);
        if (empty($rsLevel)) {
            echo "<script>alert('选择的级别不存在');history.back();</script>";
            exit;
        }

        $level = $input['level'];
        $type = $input['type'];

        $arr = array('一', '二', '三', '四', '五', '六', '七', '八', '九', '十');
        $_TYPE = array('直接购买','消费额','购买商品','无门槛');

        //获取第一个分销商级别
        $first['one'] = $dl_obj->select('Level_ID', 'Level_LimitType', 'Present_type')
            ->orderBy('Level_ID', 'asc')
            ->first();
        $first['new'] = $first['one'];
        if ($first['one']['Level_LimitType'] == 3) {
            //获取第一个分销商级别
            $first['two'] = $dl_obj->select('Level_ID', 'Level_LimitType', 'Present_type')
                ->where('Level_LimitType', '<>', 3)
                ->orderBy('Level_ID', 'asc')
                ->first();
            $first['two']['Present_type'] = empty($first['two']['Present_type']) ? 0 : $first['two']['Present_type'];
        }

        $rsLevel['PeopleLimit'] = json_decode($rsLevel['Level_PeopleLimit'], true);
        $rsLevel['DistributesLSX'] = json_decode($rsLevel['Level_DistributesLSX'], true);
        $rsLevel['UpDistributesLSX'] = json_decode($rsLevel['Level_UpDistributesLSX'], true);

        if ($type == 2) {//购买产品
            $products = array();
            if ($rsLevel['Level_LimitType'] == $type) {
                $limit_arr = explode('|', $rsLevel['Level_LimitValue']);
                if (($limit_arr[0] == 1 || $limit_arr[0] == 2) && $limit_arr[1]) {
                    $products = $sp_obj->select('Products_ID', 'Products_Name', 'Products_PriceX')
                        ->whereIN('Products_ID', explode(',', $limit_arr[1]))
                        ->get();
                }
            } else {
                $limit_arr = array('0' => 1, '1' => '');
            }
        }

        $category_list = $sc_obj->where('Category_ParentID', 0)
            ->orderBy('Category_ParentID', 'asc')
            ->orderBy('Category_Index', 'asc')
            ->get();
        foreach ($category_list as $key => $value) {
            $child = $sc_obj->where('Category_ParentID', $value['Category_ID'])
                ->orderBy('Category_ParentID', 'asc')
                ->orderBy('Category_Index', 'asc')
                ->get();
            if ($child) {
                $value['child'] = $child;
            } else {
                $value['child'] = [];
            }
        }

        return view('admin.distribute.level_edit', compact('level', 'type', 'first',
            'category_list','_TYPE', 'arr', 'rsLevel', 'limit_arr', 'products'));

    }


    /**
     * 保存分销级别的修改
     * @param Request $request
     * @param $id
     */
    public function level_update(Request $request, $id)
    {
        $input = $request->input();
        $rules = [
            'level' => 'required',
            'type' => 'required|in:0,1,2',
            'Name' => "required|string|max:30|unique:distribute_level,Level_Name,{$id},Level_ID"
        ];
        $message = [
            'level.required' => '缺少必要的参数',
            'type.required' => '缺少必要的参数',
            'Name.required' => '级别名称不能为空',
            'Name.unique' => '级别名称不能重复',
        ];
        $validator = Validator::make($input, $rules, $message);
        if ($validator->fails()) {
            echo '<script language="javascript">alert("' . $validator->messages()->first() . '");history.back();</script>';
            exit;
        }

        $dl_obj = new Dis_Level();

        $PeopleLimit = array();
        foreach ($input['PeopleLimit'] as $k => $v) {
            $PeopleLimit[$k] = empty($v) ? 0 : intval($v);
        }
        //获取第一个分销商级别
        $first = $dl_obj->select('Level_ID', 'Level_LimitType', 'Present_type')
            ->orderBy('Level_ID', 'asc')
            ->first();

        //级别门槛
        if ($first['Level_ID'] == $id && (isset($input['Come_Type']) && $input['Come_Type'] == 3)) {
            $type_confirm = 3;
        } else {
            $type_confirm = $input['type'];
        }

        $Data = array(
            "Level_Name" => $input['Name'],
//            "Level_ImgPath" => $input['ImgPath'],
            "Level_LimitType" => $type_confirm,
            "Level_PeopleLimit" => empty($PeopleLimit) ? '' : json_encode($PeopleLimit, JSON_UNESCAPED_UNICODE)
        );
        $Data['Level_Description'] = $input['Level_Description'];

        if ($input['type'] == 2) {//购买商品
            if ($first['Level_ID'] == $id) {
                if (isset($input['Come_Type']) && $input['Come_Type'] == 2) {
                    if ($input['Fanwei'] == 1) {
                        if (empty($input['BuyIDs'])) {
                            echo '<script language="javascript">alert("请选择商品！");history.back();</script>';
                            exit;
                        }
                        $Data['Level_LimitValue'] = $input['Fanwei'] . '|' . substr($input['BuyIDs'], 1, -1);
                    } else {
                        $Data['Level_LimitValue'] = $input['Fanwei'];
                    }
                } else {
                    $Data['Level_LimitValue'] = '';
                }
            } else {
                if ($input['Fanwei'] == 1) {
                    if (empty($input['BuyIDs'])) {
                        echo '<script language="javascript">alert("请选择商品！");history.back();</script>';
                        exit;
                    }
                    $Data['Level_LimitValue'] = $input['Fanwei'] . '|' . substr($input['BuyIDs'], 1, -1);
                } else {
                    $Data['Level_LimitValue'] = $input['Fanwei'];
                }
            }
        }

        $dl_obj->where('Level_ID', $id)->update($Data);

        echo '<script language="javascript">alert("修改成功！");
            window.location.href="/admin/distribute/level?level=' . $input['level'] . '&type=' . $input['type'] . '";</script>';
        exit;

    }


    /**
     * 删除分销级别
     */
    public function level_del(Request $request, $id)
    {
        $dl_obj = new Dis_Level();
        $da_obj = new Dis_Account();
        $r = $da_obj->select('Account_ID')->where('Level_ID', $id)->count();
        if ($r > 0) {
            echo '<script language="javascript">alert("该分销级别下有分销商，不能删除");history.back();</script>';
            exit;
        }

        $input = $request->input();

        $flag = $dl_obj->destroy($id);
        if ($flag) {
            echo '<script language="javascript">alert("删除成功");
            window.location.href="/admin/distribute/level?level=' . $input["level"] . '&type=' . $input["type"] . '";</script>';
            exit;
        } else {
            echo '<script language="javascript">alert("删除失败");history.back();</script>';
            exit;
        }
    }


    /**
     * 搜索框联想，返回商品信息
     * @param Request $request
     */
    public function get_product(Request $request)
    {
        $input = $request->input();
        $sp_obj = new ShopProduct();
        if ($input["action"] == 'get_product') {
            if (strlen($input['cate_id']) > 0) {
                $sp_obj = $sp_obj->where('Products_Category', intval($input['cate_id']));
            }
            if (strlen($input['keyword']) > 0) {
                $sp_obj = $sp_obj->where('', 'like', '%' . $input["keyword"] . '%');
            }

            $option_list = '';
            $product_list = $sp_obj->select('Products_ID', 'Products_Name', 'Products_PriceX')->get();
            foreach ($product_list as $v) {
                $option_list .= '<option value="' . $v['Products_ID'] . '">' . $v['Products_Name'] . '---' . $v['Products_PriceX'] . '</option>';
            }
            echo $option_list;
            exit;
        }
    }


}
