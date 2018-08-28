@extends('admin.layouts.main')
@section('ancestors')
    <li>财务统计</li>
@endsection
@section('page', '付款单详情')
@section('subcontent')
    <!-- statistics start -->

    <link href='/static/css/bootstrap.min.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script type='text/javascript' src='/admin/js/payment.js'></script>

    <div class="box" >

        <div id="iframe_page">
            <div class="iframe_content">
                <div id="payment" class="r_con_wrap">
                    <div class="control_btn">
                        <a href="#" class="btn_green btn_w_120" onclick="PrintPage1();">打印</a>
                    </div>
                    <div id="printPage">
                        <table cellspacing="0" cellpadding="0" width="90%" style="border:2px #000 solid;">
                            <tr>
                                <td style="text-align:center; height:30pt; width:25%; border-right:1px #000 solid; border-bottom:1px #000 solid; font-family:宋体;font-size:12pt; color:#000">单号</td>
                                <td style="text-align:center; height:30pt; width:25%; border-right:1px #000 solid; border-bottom:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">{{$rsPayment["Payment_Sn"]}}</td>
                                <td style="text-align:center; height:30pt; width:25%; border-right:1px #000 solid; border-bottom:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">时间</td>
                                <td style="text-align:center; height:28pt; width:25%; border-bottom:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">{{$rsPayment["CreateTime"]}}</td>
                            </tr>
                            <tr>
                                <td style="text-align:center; height:30pt; width:25%; border-right:1px #000 solid; border-bottom:1px #000 solid; font-family:宋体;font-size:12pt; color:#000">商家名称</td>
                                <td style="text-align:center; height:30pt; width:25%; border-right:1px #000 solid; border-bottom:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">{{$rsPayment["Biz"]}}</td>
                                <td style="text-align:center; height:30pt; width:25%; border-right:1px #000 solid; border-bottom:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">结算时间</td>
                                <td style="text-align:center; height:28pt; width:25%; border-bottom:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">{{$rsPayment["FromTime"]}} - {{$rsPayment["EndTime"]}}</td>
                            </tr>
                            <tr>
                                <td style="text-align:center; height:30pt; width:25%; border-right:1px #000 solid; border-bottom:1px #000 solid; font-family:宋体;font-size:12pt; color:#000">合计金额</td>
                                <td colspan="3" style="text-align:left; padding-left:15px; height:30pt; border-bottom:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">人民币：（大写）{{$dtotalmoney}}  ￥{{$totalmoney}}</td>
                            </tr>
                            <tr>
                                <td style="text-align:center; height:30pt; width:25%; border-right:1px #000 solid; border-bottom:1px #000 solid; font-family:宋体;font-size:12pt; color:#000">收款银行</td>
                                <td style="text-align:center; height:30pt; width:25%; border-right:1px #000 solid; border-bottom:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">{{$rsPayment["Bank"]}}</td>
                                <td style="text-align:center; height:30pt; width:25%; border-right:1px #000 solid; border-bottom:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">银行卡号</td>
                                <td style="text-align:center; height:28pt; width:25%; border-bottom:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">{{$rsPayment["BankNo"]}}</td>
                            </tr>
                            <tr>
                                <td style="text-align:center; height:30pt; width:25%; border-right:1px #000 solid; border-bottom:1px #000 solid; font-family:宋体;font-size:12pt; color:#000">收款人</td>
                                <td style="text-align:center; height:30pt; width:25%; border-right:1px #000 solid; border-bottom:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">{{$rsPayment["BankName"]}}</td>
                                <td style="text-align:center; height:30pt; width:25%; border-right:1px #000 solid; border-bottom:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">收款人手机</td>
                                <td style="text-align:center; height:28pt; width:25%; border-bottom:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">{{$rsPayment["BankMobile"]}}</td>
                            </tr>
                            <tr>
                                <td style="text-align:center; height:30pt; width:25%; border-right:1px #000 solid; border-bottom:1px #000 solid; font-family:宋体;font-size:12pt; color:#000">备注</td>
                                <td style="text-align:center; height:30pt; width:25%; border-bottom:1px #000 solid; font-family:宋体; font-size:12pt; color:#000" colspan="3">总计:{{$totalmoney}}(转账{{$zhuanzz}}+转向余额{{$zhuanyy}})</td>
                            </tr>
                            <tr>
                                <td style="text-align:center; height:30pt; width:25%; border-right:1px #000 solid; font-family:宋体;font-size:12pt; color:#000">审批</td>
                                <td style="text-align:center; height:30pt; width:25%; font-family:宋体; font-size:12pt; color:#000" colspan="3"></td>
                            </tr>
                        </table>

                        <table cellspacing="0" cellpadding="0" width="90%" style="border:1px #000 solid; margin-top:30px;">
                            <tr>
                                <td style="text-align:center; height:30pt; width:25%; border-bottom:1px #000 solid; font-family:宋体;font-size:12pt; color:#000" colspan="8">{{$rsPayment["Payment_Sn"]}}号付款单销售明细</td>
                            </tr>
                            <tr>
                                <td style="text-align:center; height:30pt; width:12.5%; border-right:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">订单号</td>
                                <td style="text-align:center; height:30pt; width:12.5%; border-right:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">商品总额</td>
                                <td style="text-align:center; height:30pt; width:12.5%; border-right:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">运费费用</td>
                                <td style="text-align:center; height:30pt; width:12.5%; border-right:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">订单应收</td>
                                <td style="text-align:center; height:28pt; width:12.5%; border-right:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">优惠金额</td>
                                <td style="text-align:center; height:30pt; width:12.5%; border-right:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">订单实收</td>
                                <td style="text-align:center; height:28pt; width:12.5%; border-right:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">网站提成</td>
                                <td style="text-align:center; height:28pt; width:12.5%; font-family:宋体; font-size:12pt; color:#000">结算金额</td>
                            </tr>
                            @foreach($data as $value)
                            <tr>
                                <td style="text-align:center; height:30pt; width:12.5%; border-right:1px #000 solid; border-top:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">{{$value["Order_Sn"]}}</td>
                                <td style="text-align:center; height:30pt; width:12.5%; border-right:1px #000 solid; border-top:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">{{$value["Order_Amount"]}}</td>
                                <td style="text-align:center; height:30pt; width:12.5%; border-right:1px #000 solid; border-top:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">{{$value["Order_Shipping"]}}</td>
                                <td style="text-align:center; height:30pt; width:12.5%; border-right:1px #000 solid; border-top:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">{{$value["Order_Amount"] + $value["Order_Shipping"]}}</td>
                                <td style="text-align:center; height:30pt; width:12.5%; border-right:1px #000 solid; border-top:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">{{$value["Order_Diff"]}}</td>
                                <td style="text-align:center; height:28pt; width:12.5%; border-right:1px #000 solid; border-top:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">{{$value["Order_Amount"] + $value["Order_Shipping"] - $value["Order_Diff"]}}</td>
                                <td style="text-align:center; height:28pt; width:12.5%; border-right:1px #000 solid; border-top:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">{{$value["Web_Price"]}}</td>
                                <td style="text-align:center; height:28pt; width:12.5%; border-top:1px #000 solid; font-family:宋体; font-size:12pt; color:#000">{{$value["Order_Amount"] + $value["Order_Shipping"] - $value["Order_Diff"] - $value["Web_Price"]}}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- /.box-body -->

    <script language=javascript>
        function PrintPage1(){
            var newstr = document.getElementById("printPage").innerHTML;
            var oldstr = document.body.innerHTML;
            document.body.innerHTML = newstr;
            window.print();
            document.body.innerHTML = oldstr;
            return false;
        }
    </script>

@endsection