@extends('admin.layouts.main')
@section('ancestors')
    <li>活动管理</li>
@endsection
@section('page', '商家活动列表')
@section('subcontent')

    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />
    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">

                <div id="user" class="r_con_wrap">
                    <div class="control_btn" style="margin-left: 0px">
                        <a href="{{route('admin.active.index')}}" class="btn_green">返回活动列表</a>
                    </div>
                    <table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                        <thead>
                            <tr>
                                <td align="center" width="5%"><strong>ID</strong></td>
                                <td align="center" width="10%"><strong>活动名称</strong></td>
                                <td align="center" width="8%"><strong>活动类型</strong></td>
                                <td align="center" width="12%"><strong>商家</strong></td>
                                <td align="center" ><strong>推荐产品</strong></td>
                                <td align="center" width="10%"><strong>审核</strong></td>
                                <td align="center" width="10%"><strong>申请时间</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($actives as $k => $v)
                            <tr>
                                <td nowrap="nowrap" class="id">{{$v["ID"]}}</td>
                                <td nowrap="nowrap" class="id">{{$v->active->Active_Name}}</td>
                                <td nowrap="nowrap">{{$typelist[$v->active->Type_ID]}}</td>
                                <td nowrap="nowrap">{{$v->biz->Biz_Name}}</td>
                                <td nowrap="nowrap">product_list</td>
                                <td>
                                    <a href="{{route('admin.active.biz_active', ['id' => $v['Active_ID'], 'action' => 'audit'])}}">审核</a>({{$status[$v['Status']]}})
                                </td>
                                <td nowrap="nowrap">{{date("Y-m-d",$v["starttime"])}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="blank20"></div>
                    {{ $actives->links() }}
                </div>

            </div>
        </div>

    </div>


@endsection