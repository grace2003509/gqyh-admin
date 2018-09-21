<?php

namespace App\Http\Controllers\Admin\Distribute;

use App\Models\Area;
use App\Models\Dis_Account;
use App\Models\Dis_Account_Record;
use App\Models\Dis_Agent_Area;
use App\Models\Dis_Config;
use App\Models\Dis_Level;
use App\Models\Dis_Point_Record;
use App\Models\Member;
use App\Models\UserOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DisAccountController extends Controller
{
    /**
     * 分销账号列表页
     */
    public function index(Request $request)
    {
        $dc_obj = new Dis_Config();
        $dl_obj = new Dis_Level();
        $da_obj = new Dis_Account();
        $uo_obj = new UserOrder();
        $dar_obj = new Dis_Account_Record();
        $m_obj = new Member();
        $dpr_obj = new Dis_Point_Record();

        $rsConfig = $dc_obj->find(1);

        $dis_title_level = $dc_obj->get_dis_pro_rate_title();

        $dis_title_level = !$dis_title_level ? [] : $dis_title_level;
        $rsDis_Level = $dl_obj->select('Level_ID','Level_Name')->get();

        //搜索
        $input = $request->input();
        if(isset($input["search"]) && $input["search"] == 1){

            if(!empty($input["Keyword"])&&strlen(trim($input["Keyword"]))>0){
                $a_user = $m_obj->select('User_ID')
                    ->where('User_Mobile','like','%'. $input['Keyword'].'%')
                    ->get();
                $aids = [];
                foreach($a_user as $k => $v){
                    $aids[] = $v['User_ID'];
                }
                $da_obj = $da_obj->whereIn("invite_id",$aids);
            }
            if(!empty($input["Mobile"])&& strlen(trim($input["Mobile"]))>0){
                $a_user = $m_obj->select('User_ID')
                    ->where('User_Mobile','like','%'. $input['Mobile'].'%')
                    ->get();
                $aids = [];
                foreach($a_user as $k => $v){
                    $aids[] = $v['User_ID'];
                }
                $da_obj = $da_obj->whereIn("User_ID",$aids);
            }
            if($input['level'] != 'all'){
                $da_obj = $da_obj->where('Professional_Title',$input['level']);
            }
            if(!empty($input['dis_level'])){
                $da_obj = $da_obj->where('Level_ID',$input['dis_level']);
            }

        }

        $account_list = $da_obj->orderBy('Account_CreateTime', 'desc')->paginate(15);
        foreach($account_list as $key => $account){
            $account['Total_Sales'] = $uo_obj->where(['Owner_ID'=>$account['User_ID'],'Order_Status'=>4])
                ->sum('Order_TotalPrice');

            $level_name = $dl_obj->select('Level_Name')->where('Level_ID', $account['Level_ID'])->first();
            $account['Level_Name'] = $level_name['Level_Name'];

            $account['Total_Income'] = $dar_obj->get_my_leiji_income($account['User_ID']);//累计佣金

            if($account['invite_id'] == 0){
                $account['inviter_name'] = '顶级';
            }else{
                $upuser = $m_obj->select('User_Mobile')->find($account['invite_id']);
                $account['inviter_name'] =  !empty($upuser) ? $upuser['User_Mobile'] : '信息缺失';
            }

            $account['nobi_Total'] = $dpr_obj->where(['User_ID'=> $account['User_ID'], 'type' => 4])->sum('money');

            //团队销售额
            $da_obj1 = new Dis_Account();
            $posterity = $da_obj1->getPosterity();
            $account['Sales_Group'] = $uo_obj->get_my_leiji_vip_sales($account['User_ID'],$posterity, 0, 1);
        }

        $base_url = 'http://'.$_SERVER['HTTP_HOST'].'/';

        return view('admin.distribute.account', compact(
            'dis_title_level', 'rsDis_Level', 'account_list', 'rsConfig', 'base_url'));

    }

    /**
     * 修改分销账号状态
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * 删除分销账号
     */
    public function del($id)
    {

    }


    /**
     * 获得代理区域信息
     */
    public function get_dis_agent_area(Request $request)
    {
        $input = $request->input();
        $a_obj = new Area();
        $daa_obj = new Dis_Agent_Area();
        $account_id = $input['account_id'];

        $region_list = $a_obj->getRegionList(array(35));//获得分区列表，不包括海外
        $province_list = $a_obj->where('area_deep', 1)->whereNotIn('area_id',[35])->get();
        $city_list = $a_obj->select('area_id', 'area_parent_id', 'area_name')
            ->where('area_deep', 2)->get();
        $county_list = $a_obj->select('area_id', 'area_parent_id', 'area_name')
            ->where('area_deep', 3)->get();

        //获取已被占用的代理地区信息
        $agent_provinces = $daa_obj->where('type',1)->get();
        $agent_citys = $daa_obj->whereIn('type',[2,3])->get();
        $agent_countys = $daa_obj->where('type',4)->get();
        $agent_provinces_dropdown = get_dropdown_list($agent_provinces,'area_id');
        $agent_citys_dropdown = get_dropdown_list($agent_citys,'area_id');
        $agent_countys_dropdown = get_dropdown_list($agent_countys,'area_id');

        $province_data_list = [];
        foreach($province_list as $key => $value){
            //标记是否已被申请
            if(in_array($value['area_id'], array_keys($agent_provinces_dropdown))){
                $value['checked'] = 1;
                //标记是否是自己申请的
                if($agent_provinces_dropdown[$value['area_id']]['Account_ID'] == $account_id){
                    $value['self'] = 1;
                }else{
                    $value['self'] = 0;
                }
            }else{
                $value['checked'] = 0;
            }
            $province_data_list[] = $value;
        }

        $city_data_list = [];
        foreach($city_list as $key => $value){
            //标记是否已被申请
            if(in_array($value['area_id'], array_keys($agent_citys_dropdown))){
                $value['checked'] = 1;
                //标记是否是自己申请的
                if($agent_citys_dropdown[$value['area_id']]['Account_ID'] == $account_id){
                    $value['self'] = 1;
                }else{
                    $value['self'] = 0;
                }
            }else{
                $value['checked'] = 0;
            }

            $city_data_list[] = $value;
        }

        $county_data_list = [];
        foreach($county_list as $key => $value){
            //标记是否已被申请
            if(in_array($value['area_id'], array_keys($agent_countys_dropdown))){
                $value['checked'] = 1;
                //标记是否是自己申请的
                if($agent_countys_dropdown[$value['area_id']]['Account_ID'] == $account_id){
                    $value['self'] = 1;
                }else{
                    $value['self'] = 0;
                }
            }else{
                $value['checked'] = 0;
            }

            $county_data_list[] = $value;
        }

        //计算每个级别下有多少个已经被代理
        $province_data_list = get_dropdown_list($province_data_list,'area_id');
        $city_data_list = get_dropdown_list($city_data_list,'area_id');
        $county_data_list = get_dropdown_list($county_data_list,'area_id');

        //模板赋值
        $smarty = [
            'account_id' => $account_id,
            'region_list' => $region_list,
            'province_data_list' => $province_data_list,
            'city_data_list' => $city_data_list,
            'county_data_list' => $county_data_list,
        ];

        $content = $this->dis_agent_form($smarty);

        $response = array('status'=>1,'content'=>$content,'msg'=>'获取信息成功');
        echo json_encode($response,JSON_UNESCAPED_UNICODE);
    }


    /**
     * 组装区域代理信息列表表单
     * @param $data
     */
    private function dis_agent_form($data)
    {
        $html = '<div>
   <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#province" aria-controls="province" role="tab" data-toggle="tab">省级代理</a>
        </li>
        <li role="presentation">
            <a href="#city" aria-controls="city" role="tab" data-toggle="tab">市级代理</a>
        </li>
        <li role="presentation">
            <a href="#county" aria-controls="county" role="tab" data-toggle="tab">县(区)级代理</a>
        </li>
   </ul>
   <form class="form-horizontal" id="dis_agent_form">
      <input type="hidden" name="account_id" id="account_id" value="'.$data['account_id'].'"/>
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="province">
        	<div id="dis_privince_area">
        	画红色删除线表示此省代理资格已被获得,绿色字代表此账号获得代理资格
     <br/><br/>
     <ul id="J_ProvinceList">';
     $i = 0;
	 foreach($data['region_list'] as $key => $item) {
         $html .= '<li>
         <div class="dcity clearfix">
    		<div class="ecity gcity" style="float: left">
                <span class="group-label">
					<label for="J_Group_' . $i . '">' . $key . '</label>
				</span>
			</div>
    		<div class="province-list" style="float: left">';
       			foreach($item as $k => $p) {
                    $html .= '<div class="ecity">
					<span class="gareas">';
                    $province = $data['province_data_list'][$p];
                    if($province['checked'] == 1){
                        $checked = 'checked';
                        $disabled = 'disabled';
                        $class = "del-line";
                    }else{
                        $checked = '';
                        $disabled = '';
                        $class = '';
                    }
                    $style = $province['self']==1 ?  'color: green' : '';
                    $html .='<input value="'.$p['area_id'].'_'.$province['area_name'].'" id="J_Province_'.$p['area_id'].'" name="J_Province" 
                        class="J_Province" type="checkbox" '.$checked.' '.$disabled.'>
                        <label for="J_Province_'.$p['area_id'].'" class="'.$class.'" style="'.$style.'">'.$province['area_name'].'</label>
  			  		</span>
				</div>';
                }
			$html .= '</div>
    	</div>         	
     </li>';
         $i ++;
     }
$html .= '</ul>	
    		</div>
        </div>
  	    <div role="tabpane2" class="tab-pane" id="city">	
            <div id="dis_city_area">	        
                <span>画红色删除线表示此省代理资格已被获得,绿色字代表此账号获得代理资格</span>
                <br/><br/>
                <ul id="K_CityList">';
	 $i = 0;
	 foreach($data['region_list'] as $key => $item) {
         $html .= '<li>
         <div class="dcity clearfix">
    		<div class="ecity gcity">									
                <span class="group-label">
                    <label for="K_Group_'.$i.'">'.$key.'</label>
                </span>
			</div>
    		<div class="province-list">';
            foreach($item as $k => $p) {
                $html .= '<div class="ecity">
					<span class="gareas">';
                $province = $data['province_data_list'][$p];
                $html .= '<label for="K_Province_' . $province['area_id'] . '">' . $province['area_name'] . '</label>
                        <img class="trigger" src="/admin/images/shop/city_down_icon.gif">
  			  		</span>
                    
                <div class="citys">';
                foreach($data['city_data_list'] as $c_id => $citys) {
                    if($citys['area_parent_id'] == $p){
                        $city = $citys;
                        if ($city['checked'] == 1) {
                            $checked = 'checked';
                            $disabled = 'disabled';
                            $class = "del-line";
                        } else {
                            $checked = '';
                            $disabled = '';
                            $class = '';
                        }
                        $style = $city['self']==1 ?  'color: green' : '';
                        $html .= '<span class="areas">
                                <input value="' . $city['area_id'] . '_' . $city['area_name'] . '" id="K_City_' . $city['area_id'] . '" 
                                name="K_City" class="K_City" type="checkbox" '.$checked.' '.$disabled.'>
                                <label for="K_City_' . $city['area_id'] . '" class="'.$class.'" style="'.$style.'">' . $city['area_name'] . '</label>
                        </span>';
                    }
                }
				$html .= '<p style="text-align:right;"><input value="关闭" class="close_button" type="button"></p>
		        </div>
			</div>';
            }
			$html .= '</div>
    	</div>         	
     </li>';
         $i++;
     }
$html .= '</ul>
            </div>  	
        </div>
        
        <div role="tabpane3" class="tab-pane" id="county"> 	
            <div id="dis_county_area">
            <span>画红色删除线表示此省代理资格已被获得,绿色字代表此账号获得代理资格</span>        
                <br/><br/>
            <ul id="K_CityList">';
	 $i = 0;
	 foreach($data['province_data_list'] as $r => $province) {
         $html .= '<li>
         <div class="dcity clearfix">
    		<div class="ecity gcity">									
                <span class="group-label">
                    <label for="K_Group_'.$i.'">'.$province['area_name'].'</label>
                </span>
			</div>
    		<div class="province-list">';
       			foreach($data['city_data_list'] as $key => $city) {
       			    if($city['area_parent_id'] == $province['area_id']) {
                        $html .= '<div class="ecity" style="width: 180px">
                        <span class="gareas">
                            <label for="K_Province_' . $key . '">' . $city['area_name'] . '</label>
                            <img class="trigger" src="/admin/images/shop/city_down_icon.gif">
                        </span>
                    
                        <div class="citys">';
                        foreach ($data['county_data_list'] as $k => $county) {
                            if ($county['area_parent_id'] == $city['area_id']) {
                                if ($county['checked'] == 1) {
                                    $checked = 'checked';
                                    $disabled = 'disabled';
                                    $class = "del-line";
                                } else {
                                    $checked = '';
                                    $disabled = '';
                                    $class = '';
                                }
                                $style = $county['self'] == 1 ? 'color: green' : '';
                                $html .= '<span class="areas">
                                    <input value="' . $k . '_' . $county['area_name'] . '" id="K_County_' . $k . '" name="K_County_" class="K_City_" type="checkbox"   ' . $checked . ' ' . $disabled . '>
				                    <label for="K_County_' . $k . '"  style="' . $style . '" class="' . $class . '">' . $county['area_name'] . '</label>
				                </span>';
                            }
                        }
                        $html .= '<p style="text-align:right;"><input value="关闭" class="close_button" type="button"></p>';

                            $html .= '</div>
				        </div>';
                    }
                }
			$html .='</div>
    	    </div>         	
        </li>';
         $i++;
        }
        $html .= '</ul>
            </div>     	
        </div>
     </div>
   </form>
</div>';
        return $html;
    }
}
