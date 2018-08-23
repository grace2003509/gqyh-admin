<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopConfig extends Model
{
    protected  $primaryKey = "Users_ID";
    protected  $table = "shop_config";
    public $timestamps = false;


    // 多where
    public function scopeMultiwhere($query, $arr)
    {
        if (!is_array($arr)) {
            return $query;
        }

        foreach ($arr as $key => $value) {
            $query = $query->where($key, $value);
        }
        return $query;
    }


    //无需日期转换
    public function getDates()
    {
        return array();
    }


    public function get_one($fields='*'){
        $r = $this->select($fields)->find(USERSID);
        return $r;
    }

    public function get_home($skinid)
    {
        $r = $this->where('Users_ID', USERSID)
            ->where('Skin_ID', $skinid)
            ->first();
        return $r;
    }

    public function set_config($data){
        $flag = $this->where('Users_ID', USERSID)->update($data);
        return $flag;
    }

    public function set_skin($skinid){
        $data = array(
            "Skin_ID"=>$skinid
        );
        $flag = $this->where('Users_ID', USERSID)->update($data);

        $data = array();
        $home = $this->get_home($skinid);
        if(!$home){
            $skin = ShopSkin::select('Skin_Json')->where('Skin_ID', $skinid)->first();
            $data = array(
                "Users_ID"=>$this->usersid,
                "Skin_ID"=>$skinid,
                "Home_Json"=>$skin["Skin_Json"]
            );
            $Add = ShopHome::create($data);
            $flag = $flag && $Add;
        }
        return $flag;
    }

    public function set_home($skinid, $data)
    {
        $flag = ShopHome::where('Users_ID', USERSID)
            ->where('Skin_ID', $skinid)
            ->update($data);
        return $flag;
    }

    public function set_homejson_array($array){
        $data = array();
        if (empty($array)) {
            return 110;
        }
        foreach($array as $value){
            if(is_array($value['Title'])){
                $value['Title'] = json_encode($value['Title']);
            }
            if(is_array($value['ImgPath'])){
                $value['ImgPath'] = json_encode($value['ImgPath']);
            }
            if(is_array($value['Url'])){
                $value['Url'] = json_encode($value['Url']);
            }
            $data[] = $value;
        }
        return $data;
    }

    public function get_skin_list()
    {
        $lists = ShopSkin::select('Skin_ID', 'Skin_ImgPath')
            ->where('Skin_Status', 1)
            ->orderBy('Skin_ID', 'asc')
            ->get();

        return $lists;
    }
}
