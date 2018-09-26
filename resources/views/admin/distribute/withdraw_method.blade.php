@extends('admin.layouts.main')
@section('ancestors')
    <li>分销管理</li>
@endsection
@section('page', '提现方法列表')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/user.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">

                <div id="user" class="r_con_wrap">
                    <div class="control_btn">
                        <a href="{{route('admin.distribute.withdraw_method_create')}}" class="btn_green btn_w_120">添加方法</a>
                    </div>

                    <table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                        <thead>
                        <tr>
                            <td width="5%" nowrap="nowrap">序号</td>
                            <td width="8%" nowrap="nowrap">类型</td>
                            <td width="10%" nowrap="nowrap">银行名</td>
                            <td width="10%" nowrap="nowrap">状态</td>
                            <td width="10%" nowrap="nowrap">添加时间</td>
                            <td width="8%" nowrap="nowrap" class="last"><strong>操作</strong></td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($method_list as $key=>$rsMethod)
                        <tr>
                            <td>{{$rsMethod['Method_ID']}}</td>
                            <td>{{$rsMethod['Method_Type']}}</td>
                            <td>{{$rsMethod['Method_Name']}}</td>
                            <td>
                                @if($rsMethod['Status'] == 1)
                                    <span style="color: blue">已启用</span>
                                @else
                                    未启用
                                @endif
                            </td>
                            <td nowrap="nowrap">{{$rsMethod['Method_CreateTime']}}</td>
                            <td nowrap="nowrap" class="last">
                                <a href="{{route('admin.distribute.withdraw_method_edit', ['id'=>$rsMethod['Method_ID']])}}">
                                    <img src="/admin/images/ico/mod.gif" alt="修改" align="absmiddle">
                                </a>
                                <a href="{{route('admin.distribute.withdraw_method_del', ['id'=>$rsMethod['Method_ID']])}}" onClick="if(!confirm('删除后不可恢复，继续吗？')){return false};">
                                    <img src="/admin/images/ico/del.gif" align="absmiddle" />
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="blank20"></div>
                    {{ $method_list->links() }}
                </div>

            </div>
        </div>
    </div>

@endsection