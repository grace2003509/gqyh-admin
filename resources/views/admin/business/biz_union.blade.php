@extends('admin.layouts.main')
@section('ancestors')
    <li>商家管理</li>
@endsection
@section('page', '联盟商家列表')
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
                <div class="control_btn">
                    <a href="{{route('admin.business.biz_union_create')}}" class="btn_green btn_w_120">添加联盟商家</a>
                </div>
                <form class="search" method="get" action="?">
                    <select name="Fields">
                        <option value="Biz_Name">名称</option>
                        <option value="Biz_Account">登录名</option>
                        <option value="Biz_Address">地址</option>
                        <option value="Biz_Contact">联系人</option>
                        <option value="Biz_Phone">联系电话</option>
                    </select>
                    <input type="text" name="Keyword" value="" class="form_input" size="15" />
                    行业分类：
                    <select name='SearchCateId'>
                        <option value=''>--请选择--</option>
                        @foreach($category_list as $catid=>$value)
                            <option value="{{$value["Category_ID"]}}">{{$value["Category_Name"]}}</option>
                            @if(isset($value["child"]))
                                @foreach($value["child"] as $k=>$v)
                                    <option value="{{$v["Category_ID"]}}">└{{$v["Category_Name"]}}</option>
                                @endforeach
                            @endif
                        @endforeach
                    </select>
                    状态：
                    <select name="Status">
                        <option value="all">全部</option>
                        <option value="0">正常</option>
                        <option value="1">禁用</option>
                    </select>
                    排序：
                    <select name="OrderBy">
                        <option value="">默认</option>
                        <option value="DESC">添加时间降序</option>
                        <option value="ASC">添加时间升序</option>
                    </select>
                    <input type="hidden" name="search" value="1" />
                    <input type="submit" class="search_btn" value="搜索" />
                </form>
                <table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                    <thead>
                    <tr>
                        <td width="6%" nowrap="nowrap">ID</td>
                        <td width="10%" nowrap="nowrap">登录账号</td>
                        <td width="12%" nowrap="nowrap">商家名称</td>
                        <td width="10%" nowrap="nowrap">联系人</td>
                        <td width="10%" nowrap="nowrap">联系电话</td>
                        <td width="10%" nowrap="nowrap">添加时间</td>
                        <td width="10%" nowrap="nowrap">状态</td>
                        <td width="12%" nowrap="nowrap">二维码</td>
                        <td width="10%" nowrap="nowrap" class="last">操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lists as $k=>$rsBiz)
                    <tr>
                        <td nowrap="nowrap">{{$rsBiz["Biz_ID"]}}</td>
                        <td>{{$rsBiz["Biz_Account"]}}</td>
                        <td>{{$rsBiz["Biz_Name"]}}</td>
                        <td nowrap="nowrap">{{$rsBiz['Biz_Contact']}}</td>
                        <td nowrap="nowrap">@if($rsBiz["Biz_Phone"] != '') {{$rsBiz["Biz_Phone"]}} @else 暂无 @endif</td>
                        <td nowrap="nowrap">{{date("Y-m-d",$rsBiz["Biz_CreateTime"])}}</td>
                        <td nowrap="nowrap">{{$rsBiz["Biz_Status"]}}</td>
                        <td nowrap="nowrap">
                            <img width="80" height="80" src="{{$rsBiz['Biz_Qrcode']}}" />
                        </td>
                        <td class="last" nowrap="nowrap">
                            <a href="/admin/business/biz_union_edit/{{$rsBiz["Biz_ID"]}}">
                                <img src="/admin/images/ico/mod.gif" align="absmiddle" alt="修改" />
                            </a>
                            <a href="/admin/business/biz_union_del/{{$rsBiz["Biz_ID"]}}" onClick="if(!confirm('删除后不可恢复，继续吗？')){return false};">
                                <img src="/admin/images/ico/del.gif" align="absmiddle" alt="删除" />
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="blank20"></div>
                {{$lists->links()}}
                <div style="background:#F7F7F7; border:1px #dddddd solid; height:40px; line-height:40px; font-size:12px; margin:10px 0px; padding-left:15px; color:#ff0000">提示：商家登录地址 <a href="/biz/login.php" target="_blank">http://{{$_SERVER['HTTP_HOST']}}/biz/login.php</a></div>
            </div>

        </div>
    </div>

</div>

@endsection