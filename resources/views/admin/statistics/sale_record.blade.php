@extends('admin.layouts.main')
@section('ancestors')
    <li>财务统计</li>
@endsection
@section('page', '销售记录')
@section('subcontent')
    <!-- statistics start -->

    <link href='/static/css/bootstrap.min.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />
    <link href='/static/css/daterangepicker.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script src="/static/js/moment.js"></script>
    <script type='text/javascript' src='/static/js/daterangepicker.js'></script>
    <script type='text/javascript' src='/admin/js/payment.js'></script>

    <div class="box" >
        <div id="iframe_page">
            <div class="iframe_content">

                <div id="orders" class="r_con_wrap">
                    <form class="search" id="search_form" method="get" action="{{route('admin.statistics.sale_record')}}">
                        结算状态：
                        <select name="Status">
                            <option value="all">全部</option>
                            @foreach($Status as $k => $v)
                            <option value='{{$k}}'>{{$v}}</option>
                            @endforeach
                        </select>&nbsp;
                        商家
                        <select name='BizID'>
                            <option value='0'>--请选择--</option>
                            @foreach($biz as $value)
                                <option value="{{$value["Biz_ID"]}}">{{$value["Biz_Name"]}}</option>';
                            @endforeach
                        </select>&nbsp;
                        时间：
                        <span id="reportrange">
                            <input type="text" id="reportrange-input" name="date-range-picker" value="" placeholder="日期间隔">
                        </span>
                        <input type="submit" class="search_btn" value="搜索" />
                        <input style="display:none;" type="button" class="output_btn" value="导出" />
                        <input type="hidden" value="1" name="search" />
                    </form>
                    <table border="0" cellpadding="5" cellspacing="0" class="r_con_table" id="order_list">
                        <thead>
                        <tr>
                            <td width="6%" nowrap="nowrap">序号</td>
                            <td width="20%" nowrap="nowrap">商家</td>
                            <td width="8%" nowrap="nowrap">订单号</td>
                            <td width="8%" nowrap="nowrap">订单类型</td>
                            <td width="7%" nowrap="nowrap">商品总额</td>
                            <td width="7%" nowrap="nowrap">运费费用</td>
                            <td width="7%" nowrap="nowrap">应收金额</td>
                            <td width="7%" nowrap="nowrap">优惠</td>
                            <td width="7%" nowrap="nowrap">实收金额</td>
                            <td width="7%" nowrap="nowrap">网站提成</td>
                            <td width="7%" nowrap="nowrap">结算金额</td>
                            <td width="7%" nowrap="nowrap">结算状态</td>
                            <td width="10%" nowrap="nowrap">时间</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sale_records as $key => $value)
                        <!--结算 = 实收 - 网站所得 -->
                        <tr>
                            <td nowrap="nowrap">{{$key+1}}</td>
                            <td nowrap="nowrap">{{$value["Biz_Name"]}}</td>
                            <td nowrap="nowrap">{{$value['ordersn']}}</td>
                            <td nowrap="nowrap">{{@$order_type[$value['rsorder']["Order_Type"]]}}</td>
                            <td nowrap="nowrap">{{$value["Order_Amount"]}}</td>
                            <td nowrap="nowrap">{{$value["Order_Shipping"]}}</td>
                            <td nowrap="nowrap"><span style="color:#F60">{{$value["Order_Amount"] + $value["Order_Shipping"]}}</span></td>
                            <td nowrap="nowrap">{{$value["Order_Diff"]}}</td>
                            <td nowrap="nowrap"><span style="color:#FF0000">{{$value["Order_Amount"] + $value["Order_Shipping"] - $value["Order_Diff"]}}</span></td>
                            <td nowrap="nowrap">{{$value["Web_Price"]}}</td>
                            <td nowrap="nowrap"><span style="color:blue">{{$value["Order_Amount"] + $value["Order_Shipping"] - $value["Order_Diff"] - $value["Web_Price"]}}</span></td>
                            <td nowrap="nowrap">{{$Status[$value["Record_Status"]]}}</td>
                            <td nowrap="nowrap">{{$value["Record_CreateTime"]}}</td>
                        </tr>
                        @endforeach

                        @if(count($sale_records) > 0)
                        <tr style="background:#f5f5f5">
                            <td nowrap="nowrap" colspan="4">总计</td>
                            <td nowrap="nowrap">{{$b[0]}}</td>
                            <td nowrap="nowrap">{{$b[1]}}</td>
                            <td nowrap="nowrap"><span style="color:#F60">{{$b[2]}}</span></td>
                            <td nowrap="nowrap"><span style="color:#FF0000">{{$b[3]}}</span></td>
                            <td nowrap="nowrap">{{$b[4]}}</td>
                            <td nowrap="nowrap">{{$b[5]}}</td>
                            <td nowrap="nowrap"><span style="color:blue">{{$b[6]}}</span></td>
                            <td nowrap="nowrap" colspan="2"></td>
                        </tr>
                        @endif
                        </tbody>
                    </table>
                    <div class="blank20"></div>
                    {{ $sale_records->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
    <script language="javascript">
        var ranges  =  {
            '今日': [moment(), moment()],
            '昨日': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '本月': [moment().startOf('month'), moment().endOf('month')]
        };
        //初始化时间间隔插件
        $("#reportrange").daterangepicker({
            ranges: ranges,
            startDate: moment(),
            endDate: moment()
        }, function (startDate, endDate) {
            var range = startDate.format('YYYY/MM/DD') + "-" + endDate.format('YYYY/MM/DD');
            $("#reportrange #reportrange-inner").html(range);
            $("#reportrange #reportrange-input").attr('value', range);
        });
    </script>

@endsection