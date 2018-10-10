<?php

namespace App\Http\Controllers\Admin\Web;

use App\Models\ShopCategory;
use App\Models\Web_Column;
use App\Models\Web_Config;
use App\Models\Web_Home;
use App\Models\Web_Skin;
use App\Models\WechatUrl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeConfigController extends Controller
{
    /**
     * 微官网首页设置页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $wc_obj = new Web_Config();
        $wh_obj = new Web_Home();

        $rsConfig = $wc_obj->find(USERSID);
        $rsSkin = $wh_obj->where('Skin_ID', $rsConfig['Skin_ID'])->first();
        $Home_Json = json_decode($rsSkin['Home_Json'], true);

        $url_list = $this->UrlList();

        return view("admin.web.skin.{$rsConfig['Skin_ID']}", compact(
            'rsConfig', 'Home_Json', 'url_list', 'rsSkin', 'json'));

    }


    /**
     * 保存首页设置
     * @param Request $request
     */
    public function update(Request $request)
    {
        $input = $request->input();
        $wc_obj = new Web_Config();
        $wh_obj = new Web_Home();

        $rsConfig = $wc_obj->find(USERSID);

        //自定义模版保存
        if ($input['do_action'] == 'home_diy') {
            $data = [
                'Home_Json' => str_replace('undefined', '', $input["gruopPackage"])
            ];
            $Flag = $wh_obj->where('Skin_ID', $rsConfig['Skin_ID'])->update($data);

            if ($Flag) {
                $json = array(
                    "status" => "1"
                );
                echo json_encode($json);
            } else {
                $json = array(
                    "status" => "0"
                );
                echo json_encode($json);
            }
            exit;
        }

        if ($input['do_action'] == 'set_home_mod') {
            $no = intval($input["no"]) + 1;
            if (empty($input["ImgPath"])) {
                $input["TitleList"] = array();
                foreach ($input["ImgPathList"] as $key => $value) {
                    $input["TitleList"][$key] = "";
                    if (empty($value)) {
                        unset($input["TitleList"][$key]);
                        unset($input["ImgPathList"][$key]);
                        unset($input["UrlList"][$key]);
                    }
                }
            }

            $wid = explode(',', $input['Dwidth']);
            $hei = explode(',', $input['DHeight']);
            $Home_Json[$no - 1] = array(
                "ContentsType" => $no == 1 ? "1" : "0",
                "Title" => $no == 1 ? array_merge($input["TitleList"]) : $input['Title'],
                "ImgPath" => $no == 1 ? array_merge($input["ImgPathList"]) : $input["ImgPath"],
                "Url" => $no == 1 ? array_merge($input["UrlList"]) : $input['Url'],
                "Postion" => $no > 9 ? "t" . $no : "t0" . $no,
                "Width" => $wid[$no - 1],
                "Height" => $hei[$no - 1],
                "NeedLink" => "1"
            );
            $Data = array(
                "Home_Json" => json_encode($Home_Json, JSON_UNESCAPED_UNICODE),
            );
            $Flag = $wh_obj->where('Skin_ID', $rsConfig['Skin_ID'])->update($Data);

            if ($Flag) {
                $json = array(
                    "Title" => $no == 1 ? json_encode(array_merge($input["TitleList"])) : $input['Title'],
                    "ImgPath" => $no == 1 ? json_encode(array_merge($input["ImgPathList"])) : $input["ImgPath"],
                    "Url" => $no == 1 ? json_encode(array_merge($input["UrlList"])) : $input['Url'],
                    "status" => "1"
                );
                echo json_encode($json);
            } else {
                $json = array(
                    "status" => "0"
                );
                echo json_encode($json);
            }
            exit;
        }

    }


    private function UrlList()
    {
        $wc_obj = new Web_Column();
        $sc_obj = new ShopCategory();
        $wu_obj = new WechatUrl();

        $html = '<option value="">--请选择--</option>';

        $html .= '<optgroup label="------------------微官网二级页面------------------"></optgroup>';
        $rsColumn = $wc_obj->orderBy('Column_Index', 'asc')->get();
        foreach ($rsColumn as $key => $value) {
            $html .= '<option value="/">' . $value['Column_Name'] . '</option>';
        }
        $html .= '<option value="/">一键导航(LBS)</option>';

        $html .= '<optgroup label="------------------微商城产品分类页面------------------"></optgroup>';
        $ParentCategory = $sc_obj->where('Category_ParentID', 0)
            ->orderBy('Category_Index', 'asc')->get();
        foreach ($ParentCategory as $key => $value) {
            $rsCategory = $sc_obj->where('Category_ParentID', $value["Category_ID"])
                ->orderBy('Category_Index', 'asc')->get();
            if (count($rsCategory) > 0) {
                $html .= '<option value="/">' . $value["Category_Name"] . '</option>';
                foreach ($rsCategory as $k => $v) {
                    $html .= '<option value="/">&nbsp;&nbsp;├' . $v["Category_Name"] . '</option>';
                }
            } else {
                $html .= '<option value="/">' . $value["Category_Name"] . '</option>';
            }
        }

        $html .= '<optgroup label="------------------自定义URL------------------"></optgroup>';
        $rsUrl = $wu_obj->all();
        foreach ($rsUrl as $key => $value) {
            $html .= '<option value="' . $value['Url_Value'] . '">' . $value['Url_Name'] . '(' . $value['Url_Value'] . ')</option>';
        }

        return $html;

    }
}
