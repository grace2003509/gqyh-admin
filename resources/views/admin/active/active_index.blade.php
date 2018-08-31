@extends('admin.layouts.main')
@section('ancestors')
    <li>活动管理</li>
@endsection
@section('page', '活动列表')
@section('subcontent')

    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />
    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">

                <div id="user" class="r_con_wrap">
                    <div class="control_btn" style="margin-left: 0px">
                        <a href="{{route('admin.active.create')}}" class="btn_green btn_w_120">添加活动</a>
                    </div>

                    <table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                        <thead>
                        <tr>
                            <td width="48px" align="center"><strong>活动ID</strong></td>
                            <td width="48px" align="center"><strong>活动名称</strong></td>
                            <td align="center" width="66px"><strong>活动类型</strong></td>
                            <td align="center" width="66px"><strong>商家最多参与商品数</strong></td>
                            <td align="center" width="66px"><strong>最多允许参与商家数</strong></td>
                            <td align="center" width="66px"><strong>商家活动列表</strong></td>
                            <td align="center" width="66px"><strong>活动时间</strong></td>
                            <td width="50px" align="center"><strong>活动状态</strong></td>
                            <td width="70px" align="center"><strong>操作</strong></td>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($lists as $k=>$v)
                            <tr>
                                <td nowrap="nowrap" class="id">{{$v["Active_ID"]}}</td>
                                <td nowrap="nowrap" class="id">{{$v["Active_Name"]}}</td>
                                <td nowrap="nowrap">
                                    @if(isset($typelist[$v["Type_ID"]]['Type_Name']))
                                        {{$typelist[$v["Type_ID"]]['Type_Name']}}
                                    @else
                                        活动类别不存在
                                    @endif
                                </td>
                                <td nowrap="nowrap">{{$v["MaxGoodsCount"]}}</td>
                                <td nowrap="nowrap">{{$v["MaxBizCount"]}}</td>
                                <td nowrap="nowrap"><a href="{{route('admin.active.biz_active', ['id' => $v['Active_ID']])}}">查看</a></td>
                                <td nowrap="nowrap">{{$v["starttime"]}} 至 {{$v["stoptime"]}}</td>
                                <td nowrap="nowrap">@if($v["Status"]==0)
                                        <span style="color:red">已关闭</span>@else<span style="color:blue">已开启</span>@endif
                                </td>
                                <td class="last" nowrap="nowrap">
                                    <a href="{{route('admin.active.edit', ['id' => $v["Active_ID"]])}}">
                                        <img src="/admin/images/ico/mod.gif" align="absmiddle" alt="修改" />
                                    </a>&nbsp;&nbsp;
                                    <a href="{{route('admin.active.del', ['id' => $v["Active_ID"]])}}" onclick="if(!confirm('删除后不能恢复，确定删除吗？')) return false;">
                                        <img src="/admin/images/ico/del.gif" align="absmiddle" alt="删除" />
                                    </a>
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


@endsection