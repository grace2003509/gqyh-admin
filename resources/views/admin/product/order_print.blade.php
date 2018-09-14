@extends('admin.layouts.main')
@section('ancestors')
    <li>产品管理</li>
@endsection
@section('page', '产品订单打印预览')
@section('subcontent')

<script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

<style type="text/css">
    body,td {font-size:14px;}
    .lbl {width:100px;}
    table thead td {  }
    .bold { font-weight:bold;font-size:22px;    border-top: solid 2px #555; }
    .pd100 { margin-right:100px;}
    .pdtop { margin-top:10px;}
    .grypd10 { margin-top:5px;  border-top: solid 1px #999;}
</style>

<div class="box">
    <input type="button" onclick=" PrintPage1()" value="打印" style="margin: 15px" />
    <div id="printArea" class="pdtop">
        @foreach($orderlist as $Key => $order)
        <table width="100%" cellpadding="1" style="margin-bottom: 50px;">
            <thead>
            <td class="bold" style="text-align:center">商家名称：{{$order['Biz_Name']}}</td>
            <td></td>
            </thead>
            <tbody>
            <tr>
                <td colspan="2" style="text-align: left; text-indent: 20px">
                    <p><span class="lbl">订单编号：{{$order['Order_ID']}}</span></p>
                    <p><span class="lbl">订单状态：{{$order['Order_Status_type']}}</span></p>
                    <p><span class="lbl">订单总金额：￥{{$order['Order_TotalPrice']}}</span></p>
                    <p><span class="lbl">收件人：{{$order['Address_Name']}}</span>&nbsp;&nbsp;
                        <span>电话：</span><span>{{$order['Address_Mobile']}}</span></p>
                    <p>
                        <span  class="lbl">收货地址:
                            【{{$order['Address_Province']}} {{$order['Address_City']}} {{$order['Address_Area']}}】&nbsp;
                            {{$order['Address_Detailed']}}&nbsp;
                        </span>
                    </p>
                    @if(!empty($order['Order_CartList']))
                        @foreach($order['Order_CartList'] as $kk => $vv)
                            @foreach($vv as $k => $v)
                            <p>
                                <span  class="lbl">商品名称：</span>
                                <span>{{$v['ProductsName']}}（￥{{$v['ProductsPriceX']}}）</span>
                                <span class="pd100">数量：{{$v['Qty']}}&nbsp;总价：￥{{$v['ProductsPriceX']*$v['Qty']}}</span>
                            </p>
                            @endforeach
                        @endforeach
                    @endif
                    <p>
                        <span  class="lbl">配送费用：</span>
                        <span>￥@if(isset($order['Order_Shipping']['Price'])) {{$order['Order_Shipping']['Price']}} @endif</span>
                    </p>
                    @if ($order['Order_Remark'])
                        <p><span class="lbl">备注：￥{{$order['Order_Remark']}}</span></p>
                    @endif
                </td>
            </tr>
            @if(isset($receiveInfo['RecieveName']) && !empty($receiveInfo['RecieveName']) && isset($receiveInfo['RecieveMobile']) && !empty($receiveInfo['RecieveMobile']) && in_array($order['Order_Status'], [3,4,5,6,7]))
            <tr>
                <td colspan="2" class="grypd10" style="text-align: left; text-indent: 20px">
                    <p >
                        <span class="lbl">发件人：{{$receiveInfo['RecieveName']}}</span>&nbsp;&nbsp;
                        <span>联系方式：</span><span>{{$receiveInfo['RecieveMobile']}}</span>
                    </p>
                    <p>
                        <span  class="lbl">
                            发货地址:【{{$receiveInfo['Address_Province']}} {{$receiveInfo['Address_City']}} {{$receiveInfo['Address_Area']}}】&nbsp;
                            {{$receiveInfo['RecieveAddress']}}&nbsp;
                        </span>
                    </p>
                    <p>
                        <span  class="lbl">
                            配送方式：
                            @if(isset($order['Order_Shipping']['Express'])) {{$order['Order_Shipping']['Express']}} @endif
                        </span>&nbsp;
                        <span>快递单号：@if(isset($order['Order_ShippingID'])) {{$order['Order_ShippingID']}} @endif </span>
                    </p>
                </td>
            </tr>
            @endif
            </tbody>
        </table>
        @endforeach
    </div>

</div>
<script language="javascript">
        function PrintPage1(){
            var newstr = document.getElementById("printArea").innerHTML;
            var oldstr = document.body.innerHTML;
            document.body.innerHTML = newstr;
            window.print();
            document.body.innerHTML = oldstr;
            return false;
        }
</script>

@endsection