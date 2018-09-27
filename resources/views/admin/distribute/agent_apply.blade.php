@extends('admin.layouts.main')
@section('ancestors')
    <li>分销管理</li>
@endsection
@section('page', '区域代理申请列表')
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
                        <a href="{{route('admin.distribute.agent_index')}}" class="btn_green btn_w_120">区域代理列表</a>
                        <a href="{{route('admin.distribute.agent_apply')}}" class="btn_green btn_w_120">区域代理申请列表</a>
                    </div>
                    <form class="search" id="search_form" method="get" action="{{route('admin.distribute.agent_apply')}}">
                        <select name="Fields">
                            <option value='Applyfor_Name'>申请人</option>
                            <option value='Applyfor_Mobile'>申请人电话</option>
                        </select>
                        <input type="text" name="Keyword" value="" class="form_input" size="15" />&nbsp;
                        订单号：<input type="text" name="OrderNo" value="" class="form_input" size="15" />&nbsp;
                        订单状态：
                        <select name="Status">
                            <option value="all">--请选择--</option>
                            <option value='0'>待审核</option>
                            <option value='1'>待付款</option>
                            <option value='2'>已付款</option>
                            <option value='3'>已取消</option>
                            <option value='4'>已拒绝</option>
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
                            <td width="8%" nowrap="nowrap">序号</td>
                            <td width="10%" nowrap="nowrap">订单号</td>
                            <td width="10%" nowrap="nowrap">申请人</td>
                            <td width="8%" nowrap="nowrap">申请人电话</td>
                            <td width="10%" nowrap="nowrap">金额</td>
                            <td width="10%" nowrap="nowrap">申请类型</td>
                            <td width="10%" nowrap="nowrap">申请地域</td>
                            <td width="10%" nowrap="nowrap">状态</td>
                            <td width="12%" nowrap="nowrap">申请时间</td>
                            <td width="10%" nowrap="nowrap" class="last">操作</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($agent_order_list as $key=>$rsOrder)
                        <tr>
                            <td nowrap="nowrap">{{$key+1}}</td>
                            <td nowrap="nowrap">{{$rsOrder["order_no"]}}</td>
                            <td>{{$rsOrder["Applyfor_Name"]}}</td>
                            <td>{{$rsOrder["Applyfor_Mobile"]}}</td>
                            <td>{{$rsOrder["Order_TotalPrice"]}}</td>
                            <td>{{$rsOrder["AreaMark"]}}</td>
                            <td>{{$rsOrder["Area_Concat"]}}</td>
                            <td nowrap="nowrap">{{$rsOrder["status"]}}</td>
                            <td nowrap="nowrap">{{date("Y-m-d H:i:s",$rsOrder["Order_CreateTime"])}}</td>
                            <td class="last" nowrap="nowrap">
                                @if($rsOrder["Order_Status"] == 0)
                                    <a href="{{route('admin.distribute.agent_apply_view', ['id' => $rsOrder["Order_ID"]])}}">[审核]</a>
                                @else
                                    <a href="{{route('admin.distribute.agent_apply_view', ['id'=>$rsOrder["Order_ID"]])}}">[详情]</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="page">{{$agent_order_list->links()}}</div>
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