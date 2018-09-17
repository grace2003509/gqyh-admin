@extends('admin.layouts.main')
@section('ancestors')
    <li>产品管理</li>
@endsection
@section('page', '产品订单详情')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

<div class="box">
    <div id="iframe_page">
        <div class="iframe_content">
            <div id="orders" class="r_con_wrap">
                <div class="control_btn">
                    <a href="{{route('admin.product.order_index')}}" class="btn_gray" style="margin-right: 20px">返 回</a>
                    <a href="{{route('admin.product.order_print', ['ids' => $rsOrder["Order_ID"]])}}" target="blank" class="btn_gray" id="order_print">打印订单</a>
                </div>
                <div class="detail_card">
                    <form method="post" action="{{route('admin.product.order_update', ['id' => $rsOrder["Order_ID"]])}}">
                        {{csrf_field()}}
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="order_info">
                            <tr>
                                <td width="10%" nowrap style="text-align: right">订单编号：</td>
                                <td width="90%" style="text-align: left">{{date("Ymd",$rsOrder["Order_CreateTime"]).$rsOrder["Order_ID"]}}</td>

                            </tr>
                            @if($rsOrder["Order_Type"]!='offline_charge')
                            <tr>
                                <td nowrap style="text-align: right">物流费用：</td>
                                <td style="text-align: left">
                                    @if(!isset($Shipping) || empty($Shipping["Price"]))
                                        免运费
                                    @else
                                        {{$Shipping["Price"]}}
                                    @endif
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td nowrap style="text-align: right">订单总价：</td>
                                <td style="text-align: left">￥{{$rsOrder["Order_TotalPrice"]}}
                                    @if($rsOrder["Back_Amount"]>0)
                                        &nbsp;&nbsp;<span style="text-decoration:line-through; color:#999">&nbsp;退款金额：￥{{$rsOrder["Back_Amount"]}}&nbsp;</span>&nbsp;&nbsp;
                                    @endif
                                </td>
                            </tr>
                            @if($rsOrder["Coupon_ID"]>0)
                            <tr>
                                <td nowrap style="text-align: right">优惠详情</td>
                                <td style="text-align: left">
                                    <span style="color:blue;">已使用优惠券</span>
                                    (@if($rsOrder["Coupon_Discount"]>0)
                                        享受{{$rsOrder["Coupon_Discount"]*10}}折
                                     @endif
                                     @if($rsOrder["Coupon_Cash"]>0)
                                        抵现金{{$rsOrder["Coupon_Cash"]}}元
                                     @endif )
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td nowrap style="text-align: right">订单时间：</td>
                                <td style="text-align: left">{{date("Y-m-d H:i:s",$rsOrder["Order_CreateTime"])}}</td>
                            </tr>
                            @if( $rsOrder["Order_Status"] ==1 && $rsOrder['Order_PaymentMethod']=='线下支付')
                            <tr>
                                <td nowrap style="text-align: right">订单状态：</td>
                                <td style="text-align: left">
                                    <input type="hidden" name="Status" @if($rsOrder["Order_Status"]>=2) disabled @endif value="2">已付款
                                </td>
                            </tr>
                            @else
                            <tr>
                                <td nowrap style="text-align: right">订单状态：</td>
                                <td style="text-align: left">
                                    <select name="Status" @if($rsOrder["Order_Status"]>=2) disabled @endif>
                                        <option value="0" @if($rsOrder["Order_Status"]==0) selected @endif >待确认</option>
                                        <option value="1" @if($rsOrder["Order_Status"]==1) selected @endif >待付款</option>
                                        <option value="2" @if($rsOrder["Order_Status"]==2) selected @endif >已付款</option>
                                        <option value="3" @if($rsOrder["Order_Status"]==3) selected @endif >已发货</option>
                                        <option value="4" @if($rsOrder["Order_Status"]==4) selected @endif >已完成</option>
                                        <option value="5" @if($rsOrder["Order_Status"]==5) selected @endif >退款/退款退货</option>
                                        <option value="6" @if($rsOrder["Order_Status"]==6) selected @endif >换货</option>
                                        <option value="7" @if($rsOrder["Order_Status"]==7) selected @endif >维修</option>
                                    </select>
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td nowrap style="text-align: right">支付方式：</td>
                                <td style="text-align: left">
                                    @if(empty($rsOrder["Order_PaymentMethod"]) || $rsOrder["Order_PaymentMethod"]=="0")
                                        暂无
                                    @else
                                        {{$rsOrder["Order_PaymentMethod"]}}
                                    @endif
                                </td>
                            </tr>
                            @if($rsOrder["Order_PaymentMethod"]=="线下支付"||$rsOrder["Order_PaymentMethod"]=="余额充值线下支付")
                            <tr>
                                <td nowrap style="text-align: right">付款信息：</td>
                                <td style="text-align: left">转账方式：{{$PaymentInfo[0]}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    转账时间：{{$PaymentInfo[1]}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    转出账号：{{$PaymentInfo[2]}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    姓名：{{$PaymentInfo[3]}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    联系方式：{{$PaymentInfo[4]}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td nowrap style="text-align: right">联系人：</td>
                                <td style="text-align: left">{{$rsOrder["Address_Name"]}}</td>
                            </tr>
                            @if($rsOrder["Order_Type"]!='offline_charge')
                            <tr>
                                <td nowrap style="text-align: right">手机号码：</td>
                                <td style="text-align: left">{{$rsOrder["Address_Mobile"]}}</td>
                            </tr>
                            <tr>
                                <td nowrap style="text-align: right">配送方式：</td>
                                <td style="text-align: left">
                                    @if(isset($shipping) && isset($shipping["Express"]))
                                        {{$shipping["Express"]}}
                                    @endif
                                    快递单号：{{$rsOrder["Order_ShippingID"]}}
                                </td>
                            </tr>
                            <tr>
                                <td nowrap style="text-align: right">地址信息：</td>
                                <td style="text-align: left">{{$address}}【{{$rsOrder["Address_Name"]}}，{{$rsOrder["Address_Mobile"]}}】&nbsp;&nbsp;&nbsp;&nbsp;详细地址: {{$rsOrder["Address_Detailed"]}}</td>
                            </tr>
                            <tr>
                                <td nowrap style="text-align: right">是否需要发票：</td>
                                <td style="text-align: left">
                                    @if($rsOrder["Order_NeedInvoice"]==1)
                                        <span style="color:#F60">是</span>
                                    @else 否 @endif
                                </td>
                            </tr>
                            @if($rsOrder["Order_NeedInvoice"]==1)
                            <tr>
                                <td nowrap style="text-align: right">发票抬头：</td>
                                <td style="text-align: left">{{$rsOrder["Order_InvoiceInfo"]}}</td>
                            </tr>
                            @endif
                            @endif
                            <tr>
                                <td nowrap style="text-align: right">订单备注：</td>
                                <td style="text-align: left">{{$rsOrder["Order_Remark"]}}</td>
                            </tr>
                            @if($rsOrder["Order_Status"]<2)
                            <tr>
                                <td nowrap style="text-align: right">&nbsp;</td>
                                <td style="text-align: left">
                                    <input type="submit" name="submit" class="btn_green" value="确定" />
                                </td>
                            </tr>
                            @endif
                        </table>
                    </form>
                    <div class="blank12"></div>
                    <div class="item_info">物品清单</div>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="order_item_list">
                        <tr class="tb_title">
                            <td width="20%">图片</td>
                            <td width="35%">产品信息</td>
                            <td width="15%">价格</td>
                            <td width="15%">数量</td>
                            <td width="15%" class="last">小计</td>
                        </tr>
                        @foreach($CartList as $key=>$value)
                            @foreach($value as $k=>$v)
                              <tr class="item_list" align="center">
					            <td valign="top"><img src="{{$v["ImgPath"]}}" width="100" height="100" /></td>
					            <td align="left" class="flh_180">
                                    {{$v["ProductsName"]}}<br>
                                    <dd>{{$v['attr']}}</dd>
                                </td>
                                <td>￥{{$v['ProductsPriceX']}}</td>
                                <td>{{$v["Qty"]}}</td>
                                <td>￥{{$v['ProductsPriceX']*$v["Qty"]}}</td>
                              </tr>
                            @endforeach
                        @endforeach
                        @if(!empty($lists_back))
                            @foreach($lists_back as $item)
                                <tr class="item_list" align="center">
					                <td valign="top"><img src="{{$item["ImgPath"]}}" width="100" height="100" /></td>
					                <td align="left" class="flh_180">
                                        {{$item["ProductsName"]}}<br>
                                        <dd>{{$item['attr']}}</dd>
                                    </td>
                                    <td>{{$item["ProductsPriceX"]}}</td>
                                    <td>{{$item["Qty"]}}</td>
                                    <td>￥{{$item["ProductsPriceX"]*$item["Qty"]}}<br />
                                        <span style="text-decoration:line-through; font-size:12px; color:#999">&nbsp;退款金额：￥{{$item["Back_Amount"]}}&nbsp;</span>
                                        <br />{{$status[$item["Back_Status"]]}}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection