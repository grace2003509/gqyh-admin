@extends('admin.layouts.main')
@section('ancestors')
    <li>财务统计</li>
@endsection
@section('page', '付款单列表')
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

    <style>
        .btn_greens {
            display: block;
            height: 30px;
            line-height: 30px;
            border: none;
            width: 145px;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            float: left;
        }
    </style>

    <div class="box" >

        <div id="iframe_page">
            <div class="iframe_content">

                <div id="orders" class="r_con_wrap">
                    <form class="search" id="search_form" method="get" action="{{route('admin.statistics.bill_index')}}">
                        <select name="Fields">
                            <option value="Bank">银行</option>
                            <option value='BankNo'>银行卡号</option>
                            <option value='BankName'>收款人</option>
                            <option value='BankMobile'>收款人手机</option>
                        </select>
                        <input type="text" name="Keyword" value="" class="form_input" size="15" />&nbsp;
                        商家： <select name='BizID'>
                            <option value='0'>--请选择--</option>
                            @foreach($BizRs as $value)
                                <option value="{{$value["Biz_ID"]}}">{{$value["Biz_Name"]}}</option>
                            @endforeach
                        </select>&nbsp;
                        结算状态： <select name="Status">
                            <option value="all">全部</option>
                            @foreach($STATUS as $k => $v)
                                <option value={{$k}}>{{$v}}</option>
                            @endforeach
                        </select>&nbsp;
                        时间：
                        <span id="reportrange">
                            <input type="text" id="reportrange-input" name="date-range-picker" value="" placeholder="日期间隔">
                        </span>
                        <input type ="submit" class="search_btn" value="搜索" />

                    </form>
                    <div class="control_btn">
                        <a href="{{route('admin.statistics.bill_create')}}" class="btn_green btn_w_120">生成付款单</a>
                    </div>
                    <table border="0" cellpadding="5" cellspacing="0" class="r_con_table" id="order_list">
                        <thead>
                        <tr>
                            <td width="2%" nowrap="nowrap">序号</td>
                            <td width="2%" nowrap="nowrap">商家</td>
                            <td width="2%" nowrap="nowrap">付款单号</td>
                            <td width="2%" nowrap="nowrap">结算时间</td>
                            <td width="2%" nowrap="nowrap">实收总额</td>
                            <td width="2%" nowrap="nowrap">网站所得</td>
                            <td width="2%" nowrap="nowrap">结算金额</td>
                            <td width="2%" nowrap="nowrap">状态</td>
                            <td width="2%" nowrap="nowrap">支付</td>
                            <td width="2%" nowrap="nowrap">生成时间</td>
                            <td width="10%" nowrap="nowrap">操作</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lists as $key => $value)
                        <tr>
                            <td nowrap="nowrap" class="paymentid">{{$key+1}}</td>
                            <td nowrap="nowrap">{{$value["Biz_Name"]}}</td>
                            <td nowrap="nowrap">
                                <a href="/member/distribute/withdraw.php?Payment_Sn={{$value["Payment_Sn"]}}">
                                    {{$value["Payment_Sn"]}}
                                </a>
                            </td>
                            <td nowrap="nowrap">
                                {{$value["FromTime"]}}
                                <br />~<br />
                                {{$value["EndTime"]}}
                            </td>
                            <td nowrap="nowrap"><span style="color: #F60">{{$value['total_ss']}}</span></td>
                            <td nowrap="nowrap">{{$value["Web"]}}</td>
                            <td nowrap="nowrap">
                                <span style="color:blue">{{$value["Total"]}}</span><br>
                                (转账<span>{{$value["zhuanzhang"]}}</span>
                                 + 转向余额{{$value["zhuan_ye"]}})
                            </td>
                            <td nowrap="nowrap">{{$STATUS[$value["Status"]]}}</td>
                            <td nowrap="nowrap" style="text-align: center;" paymentid="{{$value["Payment_ID"]}}">
                                @if(($value["Status"]==0  ||  $value["Status"]==3) && $value['Payment_Type']==1)
                                    <a href="#" class="btn_green btn_w_120 weixin" style="width: 70px; margin: 0px;">微信转账</a>
                                @elseif($value['Payment_Type']==1)
                                    <a href="#" class="btn_greens" style="width: 70px; margin: 0px; color: #FFF; background-color: #494A4A;">微信转账</a>
                                @elseif($value['Payment_Type']==2)
                                    支付宝
                                @else
                                    银行转账
                                @endif
                            </td>
                            <td nowrap="nowrap" style="display: none;">{{$value["Payment_ID"]}}</td>
                            <td nowrap="nowrap" style="display: none;">{{$value["Payment_Sn"]}}</td>
                            <td nowrap="nowrap" style="display: none;">{{$value["BankMobile"]}}</td>
                            <td nowrap="nowrap">{{$value["CreateTime"]}}</td>
                            <td nowrap="nowrap">
                                <a href="{{route('admin.statistics.bill_show', ['id'=> $value['Payment_ID']])}}">[查看详情]</a>
                                @if($value["Status"]==0 || $value["Status"]==3)
                                    <a href="{{route('admin.statistics.bill_del', ['id'=> $value["Payment_ID"]])}}"
                                       onClick="if(!confirm('删除后不可恢复，继续吗？')){return false};">[删除]</a>
                                @endif
                                @if($value["Status"]==3 && ($value['Payment_Type']==2 || $value['Payment_Type']==3))
                                    <a href="{{route('admin.statistics.bill_okey', ['id'=> $value["Payment_ID"]])}}"
                                       onClick="if(!confirm('确定要打款？')){return false};">[确认打款]</a>&nbsp;
                                @endif
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