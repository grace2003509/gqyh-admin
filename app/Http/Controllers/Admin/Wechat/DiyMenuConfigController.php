<?php

namespace App\Http\Controllers\Admin\Wechat;

use App\Models\UsersConfig;
use App\Models\WechatMaterial;
use App\Models\WechatMenu;
use App\Services\WechatToken;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DiyMenuConfigController extends Controller
{
    public function index()
    {
        $MsgType = array(0 => "文字消息", 1 => "图文消息", 2 => "连接网址");

        $menu_obj = new WechatMenu();
        $ParentMenu = $menu_obj->where('Menu_ParentID', 0)
            ->orderBy('Menu_Index', 'asc')
            ->get();

        foreach ($ParentMenu as $key => $value) {
            $value["Menu_MsgType"] = $MsgType[$value["Menu_MsgType"]];
            $rsMenu = $menu_obj->where('Menu_ParentID', $value['Menu_ID'])
                ->orderBy('Menu_Index', 'asc')
                ->get();
            foreach ($rsMenu as $rk => $rv) {
                $rv['Menu_MsgType'] = $MsgType[$rv['Menu_MsgType']];
            }
            $value['rsMenu'] = $rsMenu;
        }

        return view('admin.wechat.diy_menu', compact('ParentMenu'));
    }


    public function add()
    {
        $menu_obj = new WechatMenu();
        $rsPmenu = $menu_obj->where('Menu_ParentID', 0)
            ->orderBy('Menu_Index', 'asc')
            ->get();
        $wm_obj = new WechatMaterial();
        $sys_material = $wm_obj->get_sys_material(1);//系统图文
        $diy_material = $wm_obj->get_sys_material(0);//自定义图文
        return view('admin.wechat.diy_menu_add', compact('sys_material', 'diy_material', 'rsPmenu'));
    }


    public function store(Request $request)
    {
        $input = $request->input();
        $rules = [
            'Name' => 'required',
            'Url' => 'nullable|url',
        ];
        $messages = [
            'Name.required' => '菜单名称不能为空',
            'Url.url' => '链接网址格式不正确'
        ];
        $des = [
            'Name' => '菜单名称',
            'Url' => '链接网址'
        ];
        $validate = Validator::make($input, $rules, $messages, $des);
        if ($validate->fails()) {
            return redirect()->back()->with('errors', $validate->messages());
        }

        $Data = array(
            "Menu_Index" => $input['Index'],
            "Menu_Name" => $input["Name"],
            "Menu_ParentID" => $input["ParentID"],
            "Menu_MsgType" => $input["MsgType"] == 3 ? 0 : $input["MsgType"],
            "Menu_TextContents" => $input["MsgType"] == 3 ? 'myqrcode' : $input['TextContents'],
            "Menu_MaterialID" => empty($input['MaterialID']) ? 0 : $input['MaterialID'],
            "Menu_Url" => $input["Url"],
            "Users_ID" => USERSID
        );

        $obj = new WechatMenu();
        $Flag = $obj->create($Data);
        if ($Flag) {
            return redirect()->route('admin.wechat.menu_index')->with('success', '添加成功');
        } else {
            return redirect()->back()->with('errors', '添加失败');
        }

    }


    /**
     * 修改菜单页面
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $menu_obj = new WechatMenu();
        $rsMenu = $menu_obj->find($id);
        $rsMenu["Menu_MsgType"] = ($rsMenu["Menu_MsgType"]==0 && $rsMenu["Menu_TextContents"]=="myqrcode") ? 3 : $rsMenu["Menu_MsgType"];
        $rsMenu["Menu_TextContents"] = $rsMenu["Menu_TextContents"]=="myqrcode" ? '' : $rsMenu["Menu_TextContents"];

        $rsPmenu = $menu_obj->where('Menu_ParentID', 0)
            ->orderBy('Menu_Index', 'asc')
            ->get();
        $wm_obj = new WechatMaterial();
        $sys_material = $wm_obj->get_sys_material(1);//系统图文
        $diy_material = $wm_obj->get_sys_material(0);//自定义图文
        return view('admin.wechat.diy_menu_edit',
            compact('rsMenu', 'sys_material', 'diy_material', 'rsPmenu'));
    }


    /**
     * 修改菜单
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {

        $input = $request->input();
        $rules = [
            'Name' => 'required',
            'Url' => 'nullable|url',
        ];
        $messages = [
            'Name.required' => '菜单名称不能为空',
            'Url.url' => '链接网址格式不正确'
        ];
        $des = [
            'Name' => '菜单名称',
            'Url' => '链接网址'
        ];
        $validate = Validator::make($input, $rules, $messages, $des);
        if ($validate->fails()) {
            return redirect()->back()->with('errors', $validate->messages());
        }

        $Data = array(
            "Menu_Index"=>$input['Index'],
            "Menu_Name"=>$input["Name"],
            "Menu_ParentID"=>$input["ParentID"],
            "Menu_MsgType"=>$input["MsgType"]==3 ? 0 : $input["MsgType"],
            "Menu_TextContents"=>$input["MsgType"]==3 ? 'myqrcode' : $input['TextContents'],
            "Menu_MaterialID"=>empty($input['MaterialID'])?0:$input['MaterialID'],
            "Menu_Url"=>$input['Url'],
        );
        $obj = new WechatMenu();
        $s = $obj->find($id);
        $Flag = $s->update($Data);
        if ($Flag) {
            return redirect()->route('admin.wechat.menu_index')->with('success', '修改成功');
        } else {
            return redirect()->back()->with('errors', '修改失败');
        }
    }


    /**
     * 删除菜单
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function del($id)
    {
        $obj = new WechatMenu();
        $Flag = $obj->destroy($id);
        if ($Flag) {
            return redirect()->back()->with('success', '删除成功');
        } else {
            return redirect()->back()->with('errors', '删除失败');
        }
    }


    /**
     * 发布菜单
     * @return \Illuminate\Http\RedirectResponse
     */
    public function push()
    {
        $ACCESS_TOKEN = $this->get_token();
        if($ACCESS_TOKEN == 'errors'){
            return redirect()->back()->with('errors', '您还未设置AppId和AppSecret，请先到【微信授权配置】中进行设置');
        }
        if($ACCESS_TOKEN == 'fails'){
            return redirect()->back()->with('errors', '通讯失败');
        }

        $Menu=array();
        $wm_obj = new WechatMenu();
        $ParentMenu = $wm_obj->where('Menu_ParentID', 0)
            ->orderBy('Menu_Index', 'asc')
            ->get();
        foreach($ParentMenu as $value){
            $rsMenu = $wm_obj->where('Menu_ParentID', $value["Menu_ID"])
                ->orderBy('Menu_Index', 'asc')
                ->get();
            if(count($rsMenu)){
                $Data=array(
                    "name"=>$value["Menu_Name"],
                    "sub_button"=>array()
                );
                foreach($rsMenu as $k => $v){
                    if($v['Menu_MsgType'] == 0){
                        $Data["sub_button"][]=array(
                            "type"=>"click",
                            "name"=>$v["Menu_Name"],
                            "key"=>strlen($v["Menu_TextContents"])>=120 ? "changwenben_".$v["Menu_ID"] : $v["Menu_TextContents"]
                        );
                    }elseif($v["Menu_MsgType"]==1){
                        $Data["sub_button"][]=array(
                            "type"=>"click",
                            "name"=>$v["Menu_Name"],
                            "key"=>"MaterialID_".$v["Menu_MaterialID"]
                        );
                    }elseif($v["Menu_MsgType"]==2){
                        $Data["sub_button"][]=array(
                            "type"=>"view",
                            "name"=>$v["Menu_Name"],
                            "url"=>$v["Menu_Url"]
                        );
                    }
                }
                $Menu["button"][]=$Data;
            }else{
                if($value["Menu_MsgType"]==0){
                    $Data=array(
                        "type"=>"click",
                        "name"=>$value["Menu_Name"],
                        "key"=>strlen($value["Menu_TextContents"])>=120 ? "changwenben_".$value["Menu_ID"] : $value["Menu_TextContents"]
                    );
                }elseif($value["Menu_MsgType"]==1){
                    $Data=array(
                        "type"=>"click",
                        "name"=>$value["Menu_Name"],
                        "key"=>"MaterialID_".$value["Menu_MaterialID"]
                    );
                }elseif($value["Menu_MsgType"]==2){
                    $Data=array(
                        "type"=>"view",
                        "name"=>$value["Menu_Name"],
                        "url"=>$value["Menu_Url"]
                    );
                }
                $Menu["button"][]=$Data;
            }
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$ACCESS_TOKEN);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_redir_exec($ch);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($Menu,JSON_UNESCAPED_UNICODE));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $return = json_decode(curl_exec($ch),true);
        $errors = curl_errno($ch);

        curl_close($ch);

        if($errors){
            return redirect()->back()->with('errors', $errors);
        }else{
            if(isset($return['errcode']) && empty($return["errcode"])){
                return redirect()->back()->with('success', '菜单发布成功');
            }else{
                return redirect()->back()->with('errors', '发布失败');
            }
        }
    }



    public function cancel()
    {
        $ACCESS_TOKEN = $this->get_token();
        if($ACCESS_TOKEN == 'errors'){
            return redirect()->back()->with('errors', '您还未设置AppId和AppSecret，请先到【微信授权配置】中进行设置');
        }
        if($ACCESS_TOKEN == 'fails'){
            return redirect()->back()->with('errors', '通讯失败');
        }

        $err_config = config('config.error_code');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".$ACCESS_TOKEN);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_redir_exec($ch);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = json_decode(curl_exec($ch),true);

        if($json){
            $return = json_decode($json,true);

            if(empty($return["errcode"])){
                return redirect()->back()->with('success', '菜单删除成功');
            }else{
                return redirect()->back()->with('errors', $err_config["err_".$return["errcode"]]);
            }
        }else{
            return redirect()->back()->with('success', '菜单删除成功');
        }

    }


    private function get_token()
    {
        $users_obj = new UsersConfig();
        $rsUsers = $users_obj->select('Users_WechatAppId','Users_WechatAppSecret')->first();
        if(empty($rsUsers["Users_WechatAppId"]) || empty($rsUsers["Users_WechatAppSecret"])){
            return 'errors';
        }else{
            $weixin_token = new WechatToken();
            $ACCESS_TOKEN = $weixin_token->get_access_token();
            if(!$ACCESS_TOKEN){
                return 'fails';
            }
        }

        return $ACCESS_TOKEN;
    }
}
