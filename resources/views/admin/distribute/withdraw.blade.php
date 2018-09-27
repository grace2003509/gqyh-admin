@extends('admin.layouts.main')
@section('ancestors')
    <li>分销管理</li>
@endsection
@section('page', '提现记录列表')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/user.css' rel='stylesheet' type='text/css' />
    <link href='/static/js/plugins/lean-modal/style.css' rel='stylesheet' type='text/css' />
    <link href='/static/css/daterangepicker.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script type='text/javascript' src='/static/js/plugins/lean-modal/lean-modal.min.js'></script>
    <script src="/static/js/moment.js"></script>
    <script type='text/javascript' src='/static/js/daterangepicker.js'></script>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">

                <div id="update_post_tips"></div>
                <div id="user" class="r_con_wrap">

                    <form class="search" id="search_form" method="get" action="{{route('admin.distribute.withdraw_index')}}">
                        账户名称：
                        <input name="Keyword" value="" class="form_input" size="15" type="text">
                        记录状态：
                        <select name="Status">
                            <option value="all">--请选择--</option>
                            <option value="0">申请中</option>
                            <option value="1">已执行</option>
                            <option value="2">已驳回</option>
                        </select>
                        时间：
                        <span id="reportrange">
                            <input type="text" id="reportrange-input" name="date-range-picker" value="" placeholder="日期间隔">
                        </span>
                        <input value="1" name="search" type="hidden">
                        <input class="search_btn" value="搜索" type="submit">
                        <input type="button" class="output_btn" value="导出" />
                    </form>
                    <table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                        <thead>
                        <tr>
                            <td width="3%" nowrap="nowrap">序号</td>
                            <td width="8%" nowrap="nowrap">用户</td>
                            <td width="5%" nowrap="nowrap">提现方式</td>
                            <td width="8%" nowrap="nowrap">提现账户</td>
                            <td width="8%" nowrap="nowrap">提现账号</td>
                            <td width="8%" nowrap="nowrap">开户行</td>
                            <td width="5%" nowrap="nowrap">提现总金额</td>
                            <td width="5%" nowrap="nowrap">提现手续费</td>
                            <td width="5%" nowrap="nowrap">提现转入余额</td>
                            <td width="5%" nowrap="nowrap">实提金额</td>
                            <td width="5%" nowrap="nowrap">状态</td>
                            <td width="10%" nowrap="nowrap">时间</td>
                            <td width="8%" nowrap="nowrap" class="last"><strong>操作</strong></td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($record_list as $key=>$rsRecord)
                        <tr Record_ID="{{$rsRecord['Record_ID']}}">
                            <td nowarp="nowrap">{{$rsRecord['Record_ID']}}</td>
                            <td nowarp="nowrap">{{$rsRecord['user']['User_Mobile']}}</td>
                            <td nowarp="nowrap">{{$rsRecord['Method_Name']}}</td>
                            <td nowarp="nowrap">{{$rsRecord['Method_Account']}}</td>
                            <td nowarp="nowrap">{{$rsRecord['Method_No']}}</td>
                            <td nowarp="nowrap">{{$rsRecord['Method_Bank']}}</td>
                            <td nowarp="nowrap">{{$rsRecord['Record_Total']}}</td>
                            <td nowarp="nowrap">{{$rsRecord['Record_Fee']}}</td>
                            <td nowarp="nowrap">{{$rsRecord['Record_Yue']}}</td>
                            <td nowarp="nowrap">{{$rsRecord['Record_Total'] - $rsRecord['Record_Fee']}}</td>
                            <td nowrap="nowrap">{{$rsRecord['status']}}</td>
                            <td nowrap="nowrap">{{$rsRecord['Record_CreateTime']}}</td>

                            <td nowrap="nowrap" class="last">
                                @if($rsRecord['Record_Status'] == 0)
                                    @if($rsRecord['Record_Money'] >= 0)
                                        <a href="/admin/distribute/withdraw_update/{{$rsRecord['Record_ID']}}?action=fullfill">执行</a>
                                    @endif
                                    <a class="reject_btn" href="javascript:void(0)">驳回</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="blank20"></div>
                    {{$record_list->links()}}

            </div>
        </div>
    </div>

    <div id="reject_withdraw" class="lean-modal lean-modal-form">
        <div class="h">驳回用户提现理由<a class="modal_close" href="#"></a></div>
        <form class="form" method="get" action="">
            <div class="rows">
                <label>驳回理由：</label>
                <span class="input">
                    <textarea name="Reject_Reason" id="Reject_Reason" cols="40" rows="2" required ></textarea>
                    <span class="fc_red">*</span>
                </span>
                <div class="clear"></div>
            </div>
            <div class="rows">
                <label></label>
                <span class="submit">
                    <input type="submit" class="btn_green" value="确定提交" name="submit_btn">
                    <input type="hidden" value="1" name="reject_btn">
                </span>
                <div class="clear"></div>
            </div>

            <input type="hidden" name="action" value="reject_withdraw">
        </form>
        <div class="tips"></div>
    </div>

        <script language="javascript">
            //弹出驳回用户申请框
            $("a.reject_btn").click(function(){
                var id = $(this).parent().parent().attr('Record_ID');
                $('#reject_withdraw form').attr('action', '/admin/distribute/withdraw_update/'+id);
                $('#reject_withdraw form').show();
                $('#reject_withdraw .tips').hide();
                $('#reject_withdraw').leanModal();
            });

            $("#search_form .output_btn").click(function(){
                window.location='/admin/distribute/withdraw_output?'+$('#search_form').serialize();
            });

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