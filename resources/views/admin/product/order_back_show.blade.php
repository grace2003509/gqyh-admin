@extends('admin.layouts.main')
@section('ancestors')
    <li>产品管理</li>
@endsection
@section('page', '产品退货单详情')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

    <style type="text/css">
        .back_btn_blue{display:block; width:86px; line-height:28px; height:30px; text-align:center; background:#1584D5; color:#FFF; border-radius:5px; float:left; margin-right:5px;}
        .back_btn_grey{display:block; width:86px; line-height:28px; height:30px; text-align:center; background:#888; color:#FFF; border-radius:5px; float:left; margin-right:5px;}
        .back_btn_blue a:hover,.back_btn_grey a:hover{text-decoration:none; color:#FFF}
        #reject,#recieve{display:none}
    </style>

<div class="box">
    <div id="iframe_page">
        <div class="iframe_content">

            <div id="orders" class="r_con_wrap">
                <div class="cp_title">
                    <div id="cp_view" class="cur">退货单详情</div>
                </div>
                <div class="detail_card">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="order_info">
                        <tr>
                            <td width="7%" nowrap  style="text-align: right">退货单编号：</td>
                            <td width="93%" style="text-align: left">{{$rsBack["Back_Sn"]}}</td>
                        </tr>
                        <tr>
                            <td nowrap  style="text-align: right">所属商家：</td>
                            <td style="text-align: left">{{$rsBack["Biz_Name"]}}</td>
                        </tr>
                        <tr>
                            <td nowrap  style="text-align: right">退货单时间：</td>
                            <td style="text-align: left">{{date("Y-m-d H:i:s",$rsBack["Back_CreateTime"])}}</td>
                        </tr>
                        <tr>
                            <td nowrap  style="text-align: right">退款数量：</td>
                            <td style="text-align: left">{{$rsBack["Back_Qty"]}}</td>
                        </tr>
                        <tr>
                            <td nowrap  style="text-align: right">退款总价：</td>
                            <td style="text-align: left"><span style="color:red">{{$rsBack["Back_Amount"]}}</span></td>
                        </tr>
                        <tr>
                            <td nowrap  style="text-align: right">退款账号：</td>
                            <td style="text-align: left">{{$rsBack["Back_Account"]}}</td>
                        </tr>
                        <tr>
                            <td nowrap  style="text-align: right">商家收货地址：</td>
                            <td style="text-align: left">{{$address}} 【{{$rsBack["Biz_RecieveAddress"]}}，{{$rsBack["Biz_RecieveName"]}}，{{$rsBack["Biz_RecieveMobile"]}}】</td>
                        </tr>
                        <tr>
                            <td nowrap  style="text-align: right">退货单状态：</td>
                            <td style="text-align: left">{{$status[$rsBack["Back_Status"]]}}</td>
                        </tr>
                        <tr>
                            <td nowrap  style="text-align: right">网站是否退款：</td>
                            <td style="text-align: left">{{$tuikuan[$rsBack["Back_IsCheck"]]}}</td>
                        </tr>
                        <tbody id="btns">
                        <tr>
                            <td nowrap  style="text-align: right">&nbsp;</td>
                            <td style="text-align: left">
                                @if($rsBack["Back_Status"]==0)
                                    @if ($rsBack['allow_back_money'])
                                        <a href="/admin/product/back_update/{{$rsBack["Back_ID"]}}?action=agree" class="back_btn_blue">同意</a>&nbsp;&nbsp;
                                    @endif
                                    <a href="/admin/product/back_update/{{$rsBack["Back_ID"]}}?action=reject" id="reject_btn" class="back_btn_grey">驳回</a>
                                @endif

                                @if ($rsBack["Back_Status"]==2 && $rsBack['allow_back_money'])
                                    <a href="/admin/product/back_update/{{$rsBack["Back_ID"]}}?action=recieve" class="back_btn_blue">收货</a>&nbsp;&nbsp;
                                @endif

                                @if ($rsBack["Back_Status"]==3)
                                        <a href="/admin/product/back_update/{{$rsBack["Back_ID"]}}?action=agree" class="back_btn_blue">同意</a>&nbsp;&nbsp;
                                    <a href="/admin/product/back_update/{{$rsBack["Back_ID"]}}?action=back_money" class="back_btn_blue">退款给买家</a>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="blank12"></div>
                    <div class="item_info">退款流程</div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="order_info">
                        @foreach($rsBack['detail'] as $r)
                            <tr>
                                <td width="150"  style="text-align: right">{{date("Y-m-d H:i:s",$r["createtime"])}}</td>
                                <td style="color:#777; text-align: left">{{$r["detail"]}}</td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="blank12"></div>
                    <div class="item_info">物品清单</div>
                    <table class="order_item_list" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr class="tb_title">
                            <td width="20%">图片</td>
                            <td width="35%">产品信息</td>
                            <td width="15%">价格</td>
                            <td width="15%">数量</td>
                            <td class="last" width="15%">小计</td>
                        </tr>
                        <tr class="item_list" align="center">
                            <td valign="top"><img src="{{$ProductList['ImgPath']}}" height="100" width="100"></td>
                            <td class="flh_180" align="left">{{$ProductList['ProductsName']}}</td>
                            <td>{{$ProductList['ProductsPriceX']}}</td>
                            <td>{{$ProductList['Qty']}}</td>
                            <td>{{$ProductList['ProductsPriceX']*$ProductList['Qty']}}</td>
                        </tr>
                        </tbody></table>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection