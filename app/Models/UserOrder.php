<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model
{
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
}
