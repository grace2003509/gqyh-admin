@extends('admin.layouts.main')
@section('ancestors')
    <li>财务统计</li>
@endsection
@section('page', '自动结算配置')
@section('subcontent')
    <!-- statistics start -->

    <link href='/static/css/bootstrap.min.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/static/css/jquery.datetimepicker.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script type='text/javascript' src='/admin/js/global.js'></script>
    <script type='text/javascript' src='/static/js/jquery.datetimepicker.js'></script>

    <div class="box" >
        <div id="iframe_page">
            <div class="iframe_content">

                <div id="payment" class="r_con_wrap">

                    <form id="payment_form" class="r_con_form" method="post" action="{{route('admin.statistics.balance_update')}}">
                        {{csrf_field()}}

                        <div class="rows">
                            <label>结算类型</label>
                            <span class="input time">
                                <select name='RunType'>
                                    <option value="1" @if($type == 1) selected @endif >按周结算</option>
                                    <option value="2" @if($type == 2) selected @endif >按天结算</option>
                                    <option value="3" @if($type == 3) selected @endif >按月结算</option>
						        </select>&nbsp; (若按天结算，请手动填写天数)
                                <span class="fc_red">*</span>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>选择结算时间</label>
                            <span class="input time">
                                <input name="Time" type="text" value="@if(isset($sch['time'])) {{$sch['time']}} @else {{date('H:i')}} @endif" class="form_input" size="40" required />
                                <span class="fc_red">*</span>
                                <span class="tips">需要结算的销售记录的时间段</span>
                            </span>
                            <div class="clear"></div>
                            <label>结算天数</label>
                            <span class="input time">
                                <input name="day" type="text" value="@if(isset($sch['day'])) {{$sch['day']}} @else 2 @endif" class="form_input" size="40" required />
                                <span class="fc_red">*</span>
                                <span class="tips">每隔N天进行结算</span>
                            </span>
                        </div>
                        <div class="rows" style="border-top: 1px #ddd solid">
                            <label></label>
                            <span class="input">
                                <input type="submit" class="btn_green" value="确定" name="submit_btn">
                                {{--<input type="button" class="btn_green" value="删除计划任务" name="removeTask">--}}
                            </span>
                            <div class="clear"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- /.box-body -->

    <script type="text/javascript">

        $(document).ready( payment.payment_edit_init);
        $(function(){

            {{--$("input[name='removeTask']").click(function(){--}}
                {{--location.href = "{{route('admin.statistics.balance_del')}}";--}}
            {{--});--}}

            $("select[name='RunType']").change(function(){

                var RunType = $("select[name='RunType']").val();
                if(RunType==1){
                    $("input[name='day']").val("7");
                }else if(RunType==3){
                    $("input[name='day']").val("{{date("t",time())}}");
                }
            });

            $('#payment_form input[name=Time]').datetimepicker({
                datepicker:false,
                format:'H:i',
                step:5
            });
        });


    </script>

@endsection