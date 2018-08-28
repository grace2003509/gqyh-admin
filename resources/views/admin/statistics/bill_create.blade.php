@extends('admin.layouts.main')
@section('ancestors')
    <li>财务统计</li>
@endsection
@section('page', '生成付款单')
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

                <div id="payment" class="r_con_wrap">

                    <form id="payment_form" class="r_con_form" method="post" action="{{route('admin.statistics.bill_store')}}">
                        {{csrf_field()}}
                        <div class="rows">
                            <label>商家</label>
                            <span class="input time">
                                <select name='BizID' class="selectbiz">
                                  @foreach($bizs as $value)
                                        <option value="{{$value["Biz_ID"]}}">{{$value["Biz_Name"]}}</option>;
                                  @endforeach
                                </select>&nbsp;
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>付款方式</label>
                            <span class="input time">
                                <select name='PaymentID' >
                                    <option value="3">银行转账</option>
						        </select>&nbsp; <span class="fc_red">*</span>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>结算时间</label>
                            <span class="input time">
                                <span id="reportrange">
                                    <input type="text" id="reportrange-input" name="date-range-picker" value="" placeholder="日期间隔" required>
                                </span>
                                <span class="fc_red">*</span>
                                <span class="tips">需要结算的销售记录的时间段</span>
                            </span>
                            <div class="clear"></div>
                        </div>

                        <div class="rows">
                            <label>银行类型</label>
                            <span class="input">
                                <input name="Bank" value="" type="text" class="form_input" size="40" maxlength="100" required>
                                <span class="fc_red">*</span> <span class="tips">如交通银行，***分行</span>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>银行卡号</label>
                            <span class="input">
                                <input name="BankNo" value="" type="text" class="form_input" size="40" maxlength="100" required>
                                <span class="fc_red">*</span>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>收款人</label>
                            <span class="input">
                                <input name="BankName" value="" type="text" class="form_input" size="40" maxlength="100" required>
                                <span class="fc_red">*</span>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>付款账户</label>
                            <span class="input">
                                <input name="aliPayNo" value="" type="text" class="form_input" size="40" maxlength="100" required>
                                <span class="fc_red">*</span>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>付款账户名</label>
                            <span class="input">
                                <input name="aliPayName" value="" type="text" class="form_input" size="40" maxlength="100" required>
                                <span class="fc_red">*</span>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>收款人手机</label>
                            <span class="input">
                                <input name="BankMobile" value="" type="text" class="form_input" size="40" maxlength="100" required>
                                <span class="fc_red">*</span>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label></label>
                            <span class="input">
                                <input type="submit" class="btn_green" value="一键生成" name="submit_btn">
                            </span>
                            <div class="clear"></div>
                        </div>
                    </form>
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