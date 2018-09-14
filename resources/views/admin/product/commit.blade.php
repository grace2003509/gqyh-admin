@extends('admin.layouts.main')
@section('ancestors')
    <li>产品管理</li>
@endsection
@section('page', '产品评论列表')
@section('subcontent')

<link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/main.css' rel='stylesheet' type='text/css' />

<script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

<div class="box">
    <div id="iframe_page">
        <div class="iframe_content">
            <div id="reviews" class="r_con_wrap">
                <table border="0" cellpadding="5" cellspacing="0" class="r_con_table" id="review_list">
                    <thead>
                    <tr>
                        <td width="5%" nowrap="nowrap">序号</td>
                        <td width="8%" nowrap="nowrap">类型</td>
                        <td width="20%" nowrap="nowrap">评论产品</td>
                        <td width="5%" nowrap="nowrap">分数</td>
                        <td width="35%" nowrap="nowrap">评论内容</td>
                        <td width="12%" nowrap="nowrap">时间</td>
                        <td width="8%" nowrap="nowrap">状态</td>
                        <td width="10%" nowrap="nowrap" class="last">操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lists as $k=>$rsCommit)
                    <tr>
                        <td nowrap="nowrap">{{$k+1}}</td>
                        <td nowrap="nowrap">{{$commtype[$rsCommit["MID"]]}}</td>
                        <td nowrap="nowrap">{{$rsCommit["product"]['Products_Name']}}</td>
                        <td nowrap="nowrap">{{$rsCommit["Score"]}}</td>
                        <td>{{$rsCommit["Note"]}}</td>
                        <td nowrap="nowrap">{{date("Y-m-d H:i:s",$rsCommit["CreateTime"])}}</td>
                        <td nowrap="nowrap">
                            <a href="{{route('admin.product.commit_audit', ['id' => $rsCommit["Item_ID"]])}}" title="点击更改审核状态">
                                {{$status[$rsCommit["Status"]]}}
                            </a>
                        </td>
                        <td class="last" nowrap="nowrap">
                            <a href="{{route('admin.product.commit_del', ['id' => $rsCommit["Item_ID"]])}}" title="删除" onClick="if(!confirm('删除后不可恢复，继续吗？')){return false};">
                                <img src="/admin/images/ico/del.gif" align="absmiddle" />
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