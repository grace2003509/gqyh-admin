@extends('admin.layouts.main')
@section('ancestors')
    <li>产品管理</li>
@endsection
@section('page', '产品订单列表')
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
                <form class="search" id="search_form" method="get" action="{{route('admin.product.order_index')}}">
                    <select name="Fields">
                        <option value='Order_CartList'>商品</option>
                        <option value='Address_Name'>收货人</option>
                        <option value='Address_Mobile'>收货手机</option>
                        <option value='Address_Detailed'>收货地址</option>
                    </select>
                    <input type="text" name="Keyword" value="" class="form_input" size="15" />&nbsp;

                    订单号：<input type="text" name="OrderNo" value="" class="form_input" size="15" />&nbsp;
                    商家：
                    <select name='BizID'>
                        <option value='0'>--请选择--</option>
                        @foreach($bizs as $value)
                            <option value="{{$value["Biz_ID"]}}">{{$value["Biz_Name"]}}</option>
                        @endforeach
                    </select>&nbsp;
                    订单状态：
                    <select name="Status">
                        <option value="">--请选择--</option>
                        <option value='0'>待确认</option>
                        <option value='1'>待付款</option>
                        <option value='2'>已付款</option>
                        <option value='3'>已发货</option>
                        <option value='4'>已完成</option>
                        <option value='5'>申请退款中</option>
                    </select>

                    时间：
                    <span id="reportrange">
                            <input type="text" id="reportrange-input" name="date-range-picker" value="" placeholder="日期间隔">
                    </span>
                    <input type="hidden" value="1" name="search" />
                    <input type="submit" class="search_btn" value="搜索" />
                    <input type="button" class="output_btn" value="导出" />
                </form>
                <form name="form1" method="post" action="?">
                    <table border="0" cellpadding="5" cellspacing="0" class="r_con_table" id="order_list" style="font-size: 12px">
                        <thead>
                        <tr>
                            <td width="3%" nowrap="nowrap">
                                <input type="checkbox" id="checkall"/>
                            </td>
                            <td width="5%" nowrap="nowrap">序号</td>
                            <td width="10%" nowrap="nowrap">订单号</td>
                            <td width="11%" nowrap="nowrap">商家</td>
                            <td width="7%" nowrap="nowrap">会员号</td>
                            <td width="12%" nowrap="nowrap">手机号(姓名)</td>
                            <td width="8%" nowrap="nowrap">金额</td>
                            <td width="8%" nowrap="nowrap">配送方式</td>
                            <td width="8%" nowrap="nowrap">送货地址</td>
                            <td width="7%" nowrap="nowrap">订单状态</td>
                            <td width="11%" nowrap="nowrap">时间</td>
                            <td width="10%" nowrap="nowrap" class="last">操作</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rsOrderlist as $k=>$rsOrder)
                        <tr class="@if($rsOrder["Order_IsRead"] == 0) is_not_read @endif"
                            IsRead="{{$rsOrder["Order_IsRead"]}}" OrderId="{{$rsOrder["Order_ID"]}}">
                            <td nowrap="nowrap">
                                <input type="checkbox" name="OrderID[]" value="{{$rsOrder["Order_ID"]}}" />
                            </td>
                            <td nowrap="nowrap">{{$rsOrder["Order_ID"]}}</td>
                            <td nowrap="nowrap">{{date("Ymd",$rsOrder["Order_CreateTime"]).$rsOrder["Order_ID"]}}</td>
                            <td nowrap="nowrap"> @if(!empty($rsOrder["biz"])) {{$rsOrder["biz"]["Biz_Name"]}} @endif </td>
                            <td>{{$rsOrder["user"]['User_No']}}</td>
                            <td>{{$rsOrder["Address_Mobile"]}} @if(!empty($rsOrder["Address_Name"])) ({{$rsOrder["Address_Name"]}}) @endif </td>
                            <td nowrap="nowrap">
                                ￥{{$rsOrder["Order_TotalPrice"]}}
                                @if($rsOrder["Back_Amount"]>0) <br />
                                    <span style="text-decoration:line-through; color:#999">&nbsp;退款金额：￥{{$rsOrder["Back_Amount"]}}'&nbsp;</span>
                                @endif
                            </td>
                            <td nowrap="nowrap">{{$rsOrder['shipping']}}</td>
                            <td nowrap="nowrap">
                                @if (!empty($rsOrder['store_mention']))
                                    到店自提
                                @else
                                    {{$rsOrder['city']['area_name']}}
                                @endif
                            </td>
                            <td nowrap="nowrap">{{$rsOrder['status']}}</td>
                            <td nowrap="nowrap">{{date("Y-m-d H:i:s",$rsOrder["Order_CreateTime"])}}</td>
                            <td class="last" nowrap="nowrap">
                                <a href="{{route('admin.product.order_show', ['id' => $rsOrder["Order_ID"]])}}">
                                    <img src="/admin/images/ico/view.gif" align="absmiddle" alt="修改" />
                                </a>
                                @if($rsOrder['Order_Status']==1)
                                <a href="{{route('admin.product.order_show', ['id' => $rsOrder["Order_ID"]])}}">
                                    [确认收款]
                                </a><br />
                                @endif

                                @if($rsOrder["Order_Status"]==2 && $rsOrder["Order_IsVirtual"]<>1)
                                    <a href="javascript:void(0);" class="send_print" ret="{{$rsOrder["Order_ID"]}}">[打印发货单]</a>
                                @elseif($rsOrder["Order_Status"]==0||$rsOrder["Order_Status"]==31)
                                    <a href="orders_confirm.php?OrderID={{$rsOrder["Order_ID"]}}">[确认订单]</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div style="height:10px; width:100%;"></div>
                    <label style="display:block; width:120px; border-radius:5px; height:32px; line-height:30px; background:#3AA0EB; color:#FFF; text-align:center; font-size:12px; cursor:pointer" id="print">打印订单</label>
                    <input type="hidden" name="templateid" value="" />
                </form>
                <div class="blank20"></div>
                {{ $rsOrderlist->links() }}
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

        //导出
        $("#search_form .output_btn").click(function(){
            window.location='/admin/product/order_index?'+$('#search_form').serialize()+'&action=output';
        });

        //全选，反选
        $("#checkall").click(function(){
            if($(this).prop("checked") === true){
                $("input[type='checkbox']").prop("checked",true);
            }else{
                $("input[type='checkbox']").removeAttr("checked");
            }
        });

        //打印订单
        $("#print").click(function(){
            var ids = new Array;
            $("input[name='OrderID[]']:checked").each(function(){
                ids.push($(this).val());
            });
            if(ids.length<1){
                alert("至少选择1个");
                return false;
            }
            var idlist = "";
            for(var i=0;i<ids.length;i++){
                if(i===ids.length-1){
                    idlist +=ids[i];
                }else{
                    idlist +=ids[i]+",";
                }
            }
            window.location = "/admin/product/order_print/"+idlist;
        });
    });
</script>


@endsection