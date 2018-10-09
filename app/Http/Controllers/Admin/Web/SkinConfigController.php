<?php

namespace App\Http\Controllers\Admin\Web;

use App\Models\Web_Config;
use App\Models\Web_Home;
use App\Models\Web_Skin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SkinConfigController extends Controller
{
    /**
     * 微官网风格列表
     */
    public function index(Request $request)
    {
        $input = $request->input();
        $ws_obj = new Web_Skin();
        $wc_obj = new Web_Config();
        $wh_obj = new Web_Home();

        $TradeID = empty($input['TradeID']) ? 0 : $input['TradeID'];

        if ($TradeID > 0) {
            $skins = $ws_obj->where('Skin_Status', 1)
                ->where('Trade_ID', $TradeID)
                ->orderBy('Skin_Index', 'asc')
                ->get();
        } else {
            $skins = $ws_obj->where('Skin_Status', 1)->where('Trade_ID', 0)
                ->orderBy('Skin_Index', 'asc')
                ->get();
        }

        $rsConfig = $wc_obj->select('Skin_ID', 'Trade_ID')->where('Users_ID', USERSID)->first();
        if (!$rsConfig) {
            return redirect()->back()->with('errors', '请先初始化设置');
        }

        if (isset($input['action'])) {
            if ($input["action"] == "set") {
                $Data = array(
                    "Skin_ID" => $input["Skin_ID"],
                    "Trade_ID" => $input["Trade_ID"]
                );
                $wc_obj->where('Users_ID', USERSID)->update($Data);

                //判断web_home表中是否有记录
                $rsSkin = $wh_obj->where('Users_ID', USERSID)
                    ->where('Skin_ID', $input["Skin_ID"])
                    ->first();
                if (empty($rsSkin)) {
                    $rsHome = $ws_obj->select('Skin_Json')->find($input["Skin_ID"]);
                    $Data = array(
                        "Skin_ID" => $input["Skin_ID"],
                        "Home_Json" => $rsHome["Skin_Json"],
                        "Users_ID" => USERSID
                    );
                    $wh_obj->create($Data);
                }

                return redirect()->back()->with('success', '选择成功');

            } elseif ($input["action"] == "setre") {
                $rsHome = $ws_obj->select('Skin_Json')->find($input["Skin_ID"]);
                $Data = array(
                    "Home_Json" => $rsHome["Skin_Json"]
                );
                $wh_obj->where('Users_ID', USERSID)
                    ->where('Skin_ID', $input["Skin_ID"])
                    ->update($Data);

                return redirect()->back()->with('success', '重置成功');
            }
        }

        return view('admin.web.skin_config', compact('TradeID', 'skins', 'rsConfig'));
    }
}
