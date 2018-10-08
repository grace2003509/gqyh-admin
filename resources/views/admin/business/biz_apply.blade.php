@extends('admin.layouts.main')
@section('ancestors')
    <li>商家资质审核管理</li>
@endsection
@section('page', '商家入驻资质审核列表')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <style type="text/css">
        #bizs .search{padding:10px; background:#f7f7f7; border:1px solid #ddd; margin-bottom:8px; font-size:12px;}
        #bizs .search *{font-size:12px;}
        #bizs .search .search_btn{background:#1584D5; color:white; border:none; height:22px; line-height:22px; width:50px;}
    </style>

    <div class="box">

        <div id="iframe_page">
            <div class="iframe_content">

                <div id="bizs" class="r_con_wrap">

                    <form class="search" method="get" action="{{route('admin.business.biz_apply_index')}}">
                        商家账号：
                        <input type="text" name="Biz_Account" value="" placeholder='请输入商家账号' class="form_input" size="15" />
                        状态：
                        <select name="status">
                            <option value="all">全部</option>
                            <option value="1">未审核</option>
                            <option value="2">审核通过</option>
                            <option value="-1">已驳回</option>
                        </select>
                        <input type="hidden" name="search" value="1" />
                        <input type="submit" class="search_btn" value="搜索" />
                    </form>

                    <table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                        <thead>
                        <tr>

                            <td width="6%" nowrap="nowrap">ID</td>
                            <td width="8%" nowrap="nowrap">商家账号</td>
                            <td width="8%" nowrap="nowrap">认证类型</td>
                            <td width="13%" nowrap="nowrap">申请时间</td>
                            <td width="8%" nowrap="nowrap">状态</td>
                            <td width="10%" nowrap="nowrap" class="last">操作</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lists as $k=>$rsBiz)
                        <tr>
                            <td nowrap="nowrap">{{$rsBiz["id"]}}</td>
                            <td>{{@$rsBiz['biz']['Biz_Account']}}</td>
                            <td>@if($rsBiz['authtype']==1) 企业认证 @elseif( $rsBiz['authtype']==2) 个人认证 @endif</td>
                            <td nowrap="nowrap">{{date("Y-m-d H:i:s",$rsBiz["CreateTime"])}}</td>
                            <td nowrap="nowrap">{{$rsBiz["_STATUS"]}}</td>
                            <td class="last" nowrap="nowrap">
                                <a href="{{route('admin.business.biz_apply_show', ['id' => $rsBiz["id"]])}}">[查看]</a>
                                @if($rsBiz["status"] < 2)
                                <a href="{{route('admin.business.biz_apply_index', ['id' => $rsBiz['id'], 'action' => 'read'])}}">[通过]</a>
                                @endif
                                @if($rsBiz["status"] == 1)
                                <a href="{{route('admin.business.biz_apply_index', ['id' => $rsBiz['id'], 'action' => 'back'])}}">[驳回]</a>
                                @endif
                                <a href="{{route('admin.business.biz_apply_del', ['id' => $rsBiz['id']])}}" onClick="if(!confirm('删除后不可恢复，继续吗？')){return false};">[删除]</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="blank20"></div>
                    {{$lists->links()}}
                    <div style="background:#F7F7F7; border:1px #dddddd solid; height:40px; line-height:40px; font-size:12px; margin:10px 0px; padding-left:15px; color:#ff0000">提示：商家入驻地址
                        <a href="/biz/reg.php" target="_blank">
                            http://{{$_SERVER['HTTP_HOST']}}/biz/reg.php
                        </a>
                    </div>


                </div>

            </div>
        </div>

    </div>

@endsection