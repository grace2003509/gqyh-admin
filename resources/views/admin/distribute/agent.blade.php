@extends('admin.layouts.main')
@section('ancestors')
    <li>分销管理</li>
@endsection
@section('page', '区域代理人列表')
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

                    <form class="search" id="search_form" method="get" action="{{route('admin.distribute.agent_index')}}">
                        <select name="Fields">
                            <option value='area_name'>代理区域</option>
                            <option value='Account_ID'>分销商ID</option>
                        </select>
                        <input type="text" name="Keyword" value="" class="form_input" size="15" />&nbsp;
                        代理类型：
                        <select name="Status">
                            <option value="all">--请选择--</option>
                            <option value='1'>省代理</option>
                            <option value='2'>市代理</option>
                            <option value='3'>县（区）代理</option>
                        </select>
                        时间：
                        <span id="reportrange">
                            <input type="text" id="reportrange-input" name="date-range-picker" value="" placeholder="日期间隔">
                        </span>
                        <input type="hidden" value="1" name="search" />
                        <input type="submit" class="search_btn" value="搜索" />
                    </form>

                    <table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                        <thead>
                        <tr>
                            <td width="5%" nowrap="nowrap">序号</td>
                            <td width="10%" nowrap="nowrap">分销商ID</td>
                            <td width="15%" nowrap="nowrap">分销商</td>
                            <td width="25%" nowrap="nowrap">代理区域</td>
                            <td width="10%" nowrap="nowrap">代理区域所获金额</td>
                            <td width="10%" nowrap="nowrap">代理类型</td>
                            <td width="15%">时间</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($agent_list as $key=>$area)
                        <tr>
                            <td nowrap="nowrap">{{$key+1}}</td>
                            <td nowrap="nowrap">{{$area['Account_ID']}}</td>
                            <td nowrap="nowrap">{{$area['user']['User_Mobile']}}</td>
                            <td nowrap="nowrap">{{$area['area']}}</td>
                            <td nowrap="nowrap">{{$area['money']}}</td>
                            <td nowrap="nowrap">{{$area['type']}}</td>
                            <td nowrap="nowrap">{{date("Y-m-d H:i:s",$area['create_at'])}}</td>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="page">{{$agent_list->links()}}</div>
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