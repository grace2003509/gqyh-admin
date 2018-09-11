<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserOrder extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'user_order';
    protected $primaryKey = 'Order_ID';
    public $timestamps = false;

    protected $fillable = [
        'Users_ID','User_ID','Order_ID','Order_Type','Address_Name','Address_Mobile','Address_Province','Address_City',
        'Address_Area','Address_Detailed','Address_TrueName','Address_Certificate','Order_Remark','Order_Shipping',
        'Order_ShippingID','Order_CartList','Order_TotalPrice','order_coin','Order_CreateTime','Order_DefautlPaymentMethod',
        'Order_PaymentMethod','Order_PaymentInfo','Order_Status','Order_IsRead','Coupon_ID','Coupon_Discount','Coupon_Cash',
        'Order_TotalAmount','Owner_ID','Is_Commit','Is_Backup','Order_Code','Order_IsVirtual','Integral_Consumption',
        'Integral_Money','Integral_Get','Message_Notice','Order_IsRecieve','deleted_at','Biz_ID','Order_NeedInvoice',
        'Order_InvoiceInfo','Back_Amount','Order_SendTime','Order_Virtual_Cards','Front_Order_Status',
        'transaction_id','Is_Factorage','Web_Price','Web_Pricejs','curagio_money','Back_Integral','muilti','Is_Backup_js',
        'addtype','All_Qty','Is_User_Distribute','Back_salems','back_qty','back_qty_str','Back_Amount_Source',
        'cash_str','Web_Pricejs_new','store_mention','store_mention_time'
    ];


    /*一个订单属于一个用户*/
    public function User()
    {
        return $this->belongsTo(Member::class, 'User_ID', 'User_ID');
    }

    /*一个订单对应多条分销记录*/
    public function disRecord()
    {
        return $this->hasMany(Dis_Record::class, 'Order_ID', 'Order_ID');
    }

    /*一个订单拥有多条分销账号记录*/
    public function disAccountRecord()
    {
        return $this->hasManyThrough(Dis_Account_Record::class, Dis_Record::class, 'Order_ID', 'Ds_Record_ID');
    }

    /**
     * 一个订单包含多个点位奖记录
     */
    public function pointRecord()
    {
        return $this->hasMany('Dis_Point_Record', 'orderid', 'Order_ID');
    }

    /**
     * 确认收货
     * @param  $Order_ID 指定订单的ID
     * @return bool  $flag 确认收货操作是否成功
     */
    public function confirmReceive($orderid)
    {
        $flag_a = $this->where('Order_ID', $orderid)->update(['Order_Status' => 4]);
        $this->fireModelEvent('confirmed', false);

        return $flag_a;
    }

    /**
     * 统计订单信息
     * @param  string $Users_ID 店铺唯一标识
     * @param  string $type 统计类型 num订单数目  sales 订单销售额
     * @param  int $begin_time 开始时间戳
     * @param  int $end_time 结束时间戳
     * @return int  $res           返回结果
     */
    public function statistics($type, $begin_time, $end_time, $Order_Status = '')
    {

        $builder = $this->whereBetween('Order_CreateTime', [$begin_time, $end_time]);

        if (strlen($Order_Status) > 0) {
            $builder->where('Order_Status', '>=', $Order_Status);
        }

        if ($type == 'num') {
            $res = $builder->count();
        } else {
            $res = $builder->sum('Order_TotalAmount');
        }

        return $res;
    }
    /*edit数据统计20160408--start--*/
    /**
     * 统计订单信息
     * @param  string $Users_ID 店铺唯一标识
     * @param  string $type 统计类型 num订单数目  sales 订单销售额
     * @param  int $begin_time 开始时间戳
     * @param  int $end_time 结束时间戳
     * @return int  $res           返回结果
     */
    public function statistics2($type, $begin_time, $end_time, $Order_Status = '')
    {

        $builder = $this->whereBetween('Order_CreateTime', [$begin_time, $end_time]);

        if (strlen($Order_Status) > 0) {
            $builder->where('Order_Status', '=', $Order_Status);
        }

        if ($type == 'num') {
            $res = $builder->count();
        } else {
            $res = $builder->sum('Order_TotalAmount');
        }

        return $res;
    }

    public function statistics3($type, $begin_time, $end_time, $Order_Status = '')
    {
        $builder = $this->whereBetween('Order_CreateTime', [$begin_time, $end_time]);

        if (strlen($Order_Status) > 0) {
            $builder->where('Is_Backup', '=', $Order_Status);
        }

        if ($type == 'num') {
            $res = $builder->count();
        } else {
            $res = $builder->sum('Back_Amount');
        }

        return $res;
    }
    /*edit数据统计20160408--end--*/


    /**
     * 指定时间内的订单
     * @param  $Users_ID 店铺唯一标识
     * @param  $Begin_Time 开始时间
     * @param  $End_Time 结束时间
     * @return array 订单列表
     */
    public function ordersBetween($Begin_Time, $End_Time, $Order_Status)
    {
        if ($Order_Status != 'all') {
            $builder = $this->where('Order_Status', $Order_Status);
        }

        $builder->whereBetween('Order_CreateTime', [$Begin_Time, $End_Time])
            ->orderBy('Order_CreateTime', 'desc');

        return $builder;
    }


    //生成进账记录信息
    public function order_input_record($Begin_Time, $End_Time)
    {

        $fields = array('Order_ID', 'Order_CreateTime', 'Order_TotalAmount', 'Order_Status', 'Order_IsVirtual');

        $input_record_builder = $this->ordersBetween($Begin_Time, $End_Time, 4);
        $paginate_obj = $input_record_builder->paginate(5, $fields);

        $res = array(
            'sum' => $input_record_builder->sum('Order_TotalAmount'),
            'input_paginate' => $paginate_obj,
            'total_pages' => $paginate_obj->lastPage()
        );

        return $res;

    }


    //获取订单编号
    public function getorderno($oid)
    {
        $rsOrder = $this->select('Order_Type','Order_CreateTime','Order_Code')
            ->where('Order_ID',$oid)
            ->first();
        if (!$rsOrder) {
            return false;
        }
        if($rsOrder['Order_Type'] == 'pintuan' || $rsOrder['Order_Type'] == 'dangou'){
            $orderno = $rsOrder['Order_Code'];
        }else{
            $orderno = date("Ymd", $rsOrder["Order_CreateTime"]) . $oid;
        }
        return $orderno;
    }

    //获取虚拟订单消费券码
    public function get_virtual_confirm_code($orderid)
    {
        for($i = 0; $i <= 1; $i++) {
            $temchars = virtual_randcode(10);
            $r = $this->where('Order_Code', $temchars)->find($orderid);
            $i = $r ? 0 : 1;
        }
        return $temchars;
    }


    public function update_order($orderid,$data)
    {
        $this->where('Order_ID', $orderid)->update($data);
    }

}
