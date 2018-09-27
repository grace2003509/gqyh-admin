@extends('admin.layouts.main')
@section('ancestors')
    <li>分销管理</li>
@endsection
@section('page', '区域代理详情')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">

                <div id="orders" class="r_con_wrap">
                    <div class="detail_card">
                        <form id="order_send_form" class="s_con_form" method="post"
                              action="{{route('admin.distribute.agent_apply_audit', ['id' => $rsOrder['Order_ID']])}}">

                            {{csrf_field()}}

                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="order_info">
                            <tr>
                                <td width="5%" nowrap >订单编号：</td>
                                <td width="90%" style="text-align: left">{{$rsOrder["order_no"]}}</td>
                            </tr>
                            <tr>
                                <td nowrap>订单总价：</td>
                                <td style="text-align: left">￥{{$rsOrder["Order_TotalPrice"]}}</td>
                            </tr>
                            <tr>
                                <td nowrap>订单时间：</td>
                                <td style="text-align: left">{{date("Y-m-d H:i:s",$rsOrder["Order_CreateTime"])}}</td>
                            </tr>
                            <tr>
                                <td nowrap>订单状态：</td>
                                <td style="text-align: left">{{$rsOrder["status"]}}</td>
                            </tr>
                            <tr>
                                <td nowrap>支付方式：</td>
                                <td style="text-align: left">{{$rsOrder["Order_PaymentMethod"]}}</td>
                            </tr>
                            <tr>
                                <td nowrap>联系人：</td>
                                <td style="text-align: left">{{$rsOrder["Applyfor_Name"]}}</td>
                            </tr>
                            <tr>
                                <td nowrap>手机号码：</td>
                                <td style="text-align: left">{{$rsOrder["Applyfor_Mobile"]}}</td>
                            </tr>
                            <tr>
                                <td nowrap>申请类型：</td>
                                <td style="text-align: left">{{$rsOrder["AreaMark"]}}</td>
                            </tr>
                            <tr>
                                <td nowrap>申请地域：</td>
                                <td style="text-align: left">{{$rsOrder["Area_Concat"]}}</td>
                            </tr>
                            <tr>
                            @if($rsOrder["Order_Status"] == 4)
                            <tr>
                                <td nowrap>拒绝原因：</td>
                                <td style="text-align: left">{{$rsOrder["Refuse_Be"]}}</td>
                            </tr>
                            @endif
                            @if($rsOrder["Order_Status"] == 0)
                                <tr>
                                    <td nowrap>是否拒绝：</td>
                                    <td style="text-align: left">
                                        <input class="input" type="radio" name="refuse" value="1" checked />
                                        <label for="c_0">通过</label>&nbsp;&nbsp;
                                        <input class="input" type="radio" name="refuse"  value="0" />
                                        <label for="c_1">不通过</label>
                                    </td>
                                </tr>
                                <tr id='refuseshow' style="display:none">
                                    <td nowrap>原因：</td>
                                    <td style="text-align: left">
                                        <textarea name="refusebe" style="width:30%;height:80px;"></textarea>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td colspan="2">
                                    @if($rsOrder["Order_Status"] == 0)
                                        <input type="submit" class="btn_green" style="height: 30px" name="submit_button" value="通过审核" />
                                    @endif
                                    <a href="javascript:void(0);" class="btn_gray" onClick="history.go(-1);">返 回</a>
                                </td>
                            </tr>
                        </table>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        $("input[name=refuse]").click(function(){
            var type = $(this).attr('value');
            if(type === 1){
                $("#refuseshow").hide();
                $('#order_send_form input:submit').val('通过审核');
            }else{
                $("#refuseshow").show();
                $('#order_send_form input:submit').val('提交');
            }
        });
    </script>

@endsection