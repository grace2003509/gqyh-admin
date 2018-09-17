@extends('admin.layouts.main')
@section('ancestors')
    <li>产品管理</li>
@endsection
@section('page', '产品退货单列表')
@section('subcontent')

    <link href='/static/css/bootstrap.min.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />
    <link href='/static/css/daterangepicker.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script src="/static/js/moment.js"></script>
    <script type='text/javascript' src='/static/js/daterangepicker.js'></script>
    <script type='text/javascript' src='/admin/js/shop.js'></script>

<div class="box">
    <div id="iframe_page">
        <div class="iframe_content">

            <div id="orders" class="r_con_wrap">
                <form class="search" id="search_form" method="get" action="{{route('admin.product.back_index')}}">

                    退货单状态：
                    <select name="Status">
                        <option value="all">--请选择--</option>
                        <option value='0'>申请中</option>
                        <option value='1'>卖家同意</option>
                        <option value='2'>买家发货</option>
                        <option value='3'>卖家收货</option>
                        <option value='4'>已完成</option>
                        <option value='5'>卖家驳回申请</option>
                    </select>&nbsp;
                    网站是否退款：
                    <select name="IsCheck">
                        <option value="all">--请选择--</option>
                        <option value='0'>未退款</option>
                        <option value='1'>已退款</option>
                    </select>

                    时间：
                    <span id="reportrange">
                        <input type="text" id="reportrange-input" name="date-range-picker" value="" placeholder="日期间隔">
                    </span>
                    <input type="hidden" value="1" name="search" />
                    <input type="submit" class="search_btn" value="搜索" />

                </form>

                <table border="0" cellpadding="5" cellspacing="0" class="r_con_table" id="order_list">
                    <thead>
                    <tr>
                        <td width="8%" nowrap="nowrap">序号</td>
                        <td width="20%" nowrap="nowrap">退货单号</td>
                        <td width="18%" nowrap="nowrap">所属商家</td>
                        <td width="8%" nowrap="nowrap">退货数量</td>
                        <td width="8%" nowrap="nowrap">退款金额</td>
                        <td width="8%" nowrap="nowrap">状态</td>
                        <td width="8%" nowrap="nowrap">是否退款</td>
                        <td width="12%" nowrap="nowrap">时间</td>
                        <td width="10%" nowrap="nowrap" class="last">操作</td>
                    </tr>
                    </thead>
                        <tbody>
                        @foreach($lists as $key => $rsBack)
                            <tr>
                                <td nowrap="nowrap">{{$key+1}}</td>
                                <td nowrap="nowrap">
                                    {{$rsBack["Back_Sn"]}}&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="{{route('admin.product.order_show', ['id' => $rsBack['Order_ID']])}}">
                                        相关订单&nbsp;&nbsp;<img src="/admin/images/ico/jt.gif"/>
                                    </a>
                                </td>
                                <td nowrap="nowrap">{{$rsBack["Biz_Name"]}}</td>
                                <td nowrap="nowrap">{{$rsBack["Back_Qty"]}}</td>
                                <td nowrap="nowrap">{{$rsBack["Back_Amount"]}}</td>
                                <td nowrap="nowrap">{{$status[$rsBack["Back_Status"]]}}</td>
                                <td nowrap="nowrap">{{$tuikuan[$rsBack["Back_IsCheck"]]}}</td>
                                <td nowrap="nowrap">{{date("Y-m-d H:i:s",$rsBack["Back_CreateTime"])}}></td>
                                <td class="last" nowrap="nowrap">
                                    <a href="{{route('admin.product.back_show', ['id'=> $rsBack["Back_ID"]])}}">[查看详情]</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                <div class="blank20"></div>
                {{ $lists->links() }}
            </div>

        </div>
    </div>

</div>


<script language="javascript">

    $(function(){
        var ranges  =  {
            '今日': [moment(), moment()],
            '昨日': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '本月': [moment().startOf('month'), moment().endOf('month')]
        };
        var locale = {
            'applyLabel':'确定',
            'cancelLabel':'取消',
            'customRangeLabel':'日历指定',
        };
        //初始化时间间隔插件
        $("#reportrange").daterangepicker({
            locale: locale,
            ranges: ranges,
            opens: 'left',
            startDate: moment(),
            endDate: moment(),
        }, function (startDate, endDate) {
            var range = startDate.format('YYYY/MM/DD') + "-" + endDate.format('YYYY/MM/DD');
            $("#reportrange #reportrange-inner").html(range);
            $("#reportrange #reportrange-input").attr('value', range);
        });

    });
</script>


@endsection