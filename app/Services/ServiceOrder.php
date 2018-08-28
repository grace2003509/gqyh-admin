<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/28
 * Time: 16:13
 */

namespace App\Services;


use App\Models\Order;

class ServiceOrder
{
    function getorderno($oid) {
        $builder = new Order();
        $builder = $builder->where('Order_ID',$oid);
        $rsOrder = $builder->first(array('Order_Type','Order_CreateTime','Order_Code'));
        if ($rsOrder) {
            $rsOrder->toArray();
        } else {
            return false;
        }
        if($rsOrder['Order_Type'] == 'pintuan' || $rsOrder['Order_Type'] == 'dangou'){
            $orderno = $rsOrder['Order_Code'];
        }else{
            $orderno = date("Ymd", $rsOrder["Order_CreateTime"]) . $oid;
        }
        return $orderno;
    }
}