@extends('admin.layouts.main')
@section('ancestors')
    <li>分销管理</li>
@endsection
@section('page', '分销佣金记录')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />
    <link href='/static/css/daterangepicker.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script src="/static/js/moment.js"></script>
    <script type='text/javascript' src='/static/js/daterangepicker.js'></script>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">

                <div id="orders" class="r_con_wrap">
                    <div class="control_btn">
                        <a href="{{route('admin.distribute.account_record')}}" class="btn_green btn_w_120">分销佣金记录</a>
                        <a href="{{route('admin.distribute.point_record')}}" class="btn_green btn_w_120">重消奖记录</a>
                        <a href="{{route('admin.distribute.protitle_record')}}" class="btn_green btn_w_120">团队奖记录</a>
                    </div>

                    <form class="search" id="search_form" method="get" action="{{route('admin.distribute.account_record')}}">
                        状态：
                        <select name="Status">
                            <option value="all">--请选择--</option>
                            <option value='0'>已生成</option>
                            <option value='1'>已付款</option>
                            <option value='2'>已完成</option>

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
                            <td width="5%" nowrap="nowrap">序号</td>
                            <td width="8%" nowrap="nowrap">订单号</td>
                            <td width="7%" nowrap="nowrap">购买者</td>
                            <td width="10%" nowrap="nowrap">分销产品</td>
                            <td width="20%" nowrap="nowrap">所获奖金</td>
                            <td width="5%" nowrap="nowrap">状态</td>
                            <td width="10%" nowrap="nowrap">时间</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($record_list as $k=>$rsRecord)
                        <tr>
                            <td nowrap="nowrap">{{$rsRecord["Record_ID"]}}</td>
                            <td nowrap="nowrap">{{$rsRecord["order_no"]}}</td>
                            <td nowrap="nowrap">{{$rsRecord["buyer"]}}</td>
                            <td nowrap="nowrap">{{$rsRecord["Product_Name"]}}</td>
                            <td nowrap="nowrap" style=" word-wrap:break-word; width: 200px">
                                <img src="/admin/images/yong.png" width="15">&nbsp;
                                {{$rsRecord['money_des']}}
                            </td>
                            <td nowrap="nowrap">{{$rsRecord["status"]}}</td>
                            <td nowrap="nowrap">{{date("Y-m-d H:i:s",$rsRecord['Record_CreateTime'])}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="blank20"></div>
                    {{$record_list->links()}}
                </div>

            </div>
        </div>
    </div>


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