@extends('admin.layouts.main')
@section('ancestors')
    <li>会员管理</li>
@endsection
@section('page', '会员详情与余额流水列表')
@section('subcontent')

<link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/user.css' rel='stylesheet' type='text/css' />

<script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<script type='text/javascript' src='/admin/js/user.js'></script>
<link href='/static/js/plugins/lean-modal/style.css' rel='stylesheet' type='text/css' />
<script type='text/javascript' src='/static/js/plugins/lean-modal/lean-modal.min.js'></script>

<div class="box">
    <div id="iframe_page">
        <div class="iframe_content">

            <div id="user" class="r_con_wrap">
                <table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                    <thead>
                    <tr>
                        <td width="10%" nowrap="nowrap">手机号</td>
                        <td width="12%" nowrap="nowrap">所在地区</td>
                        <td width="10%" nowrap="nowrap">会员号</td>
                        <td width="10%" nowrap="nowrap">会员等级</td>
                        <td width="7%" nowrap="nowrap">余额</td>
                        <td width="7%" nowrap="nowrap">积分</td>
                        <td width="12%" nowrap="nowrap">注册时间</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr UserID="{{$rsUser['User_ID']}}">
                        {{--<td nowrap="nowrap" class="upd_rows" field="2"><span class="upd_txt">{{$rsUser['User_Mobile']}}</span></td>--}}
                        <td nowrap="nowrap" >{{$rsUser['User_Mobile']}}</td>
                        <td nowrap="nowrap">{{$rsUser['User_Province'].$rsUser['User_City']}}</td>
                        {{--<td nowrap="nowrap" class="upd_rows" field="0">No. <span class="upd_txt">{{$rsUser['User_No']}}</span></td>--}}
                        <td nowrap="nowrap">No. {{$rsUser['User_No']}}</td>
                        {{--<td nowrap="nowrap" class="upd_select" field="5">
                            <span class="upd_txt">{{$UserLevel[$rsUser['Dis_Level']]}}</span>
                        </td>--}}
                        <td nowrap="nowrap">{{$UserLevel[$rsUser['Dis_Level']]}}</td>
                        <td nowrap="nowrap" class="upd_points" field="3"><span class="upd_txt">{{$rsUser['User_Money']}}</span></td>
                        <td nowrap="nowrap" class="upd_points" field="3"><span class="upd_txt">{{$rsUser['User_Integral']}}</span></td>
                        <td nowrap="nowrap">{{date("Y-m-d H:i:s",$rsUser['User_CreateTime'])}}</td>
                    </tr>
                    </tbody>
                </table>
                <div class="blank20"></div>
                <table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                    <thead>
                    <tr>
                        <td width="15%" nowrap="nowrap">序号</td>
                        <td width="25%" nowrap="nowrap">资金动向</td>
                        <td width="20%" nowrap="nowrap">资金状态</td>
                        <td width="20%" nowrap="nowrap">帐户余额</td>
                        <td width="20%" nowrap="nowrap">时间</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($rsRecord as $key => $value)
                    <tr>
                        <td nowrap="nowrap">{{$key+1}}</td>
                        <td nowrap="nowrap">{{$value["Note"]}}</td>
                        @if($value["Type"] == 1)
                            <td style="color:#CD0000;"  nowrap="nowrap"><span style="font-weight: bold"> ＋ {{$value["Amount"]}}</span></td>
                            <td style="color:#CD0000;" nowrap="nowrap">{{$value["Total"]}}</td>
                        @elseif($value["Type"] == 0)
                            <td style="color:#8E8E38;"nowrap="nowrap">- {{' '.abs($value["Amount"])}}</td>
                            <td style="color:#8E8E38;" nowrap="nowrap">{{$value["Total"]}}</td>
                        @endif
                        <td nowrap="nowrap">{{date("Y-m-d H:i:s",$value["CreateTime"])}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="blank20"></div>
                {{ $rsRecord->links() }}
            </div>
        </div>
    </div>
</div>
<script language="javascript">
    var level_ary=Array();
    @foreach($UserLevel as $k=>$v)
        level_ary['{{$k}}']="{{$v}}";
    @endforeach
    $(document).ready(function(){user_obj.user_init();});

</script>
@endsection