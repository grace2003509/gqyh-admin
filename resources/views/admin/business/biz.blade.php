@extends('admin.layouts.main')
@section('ancestors')
    <li>商家管理</li>
@endsection
@section('page', '普通商家列表')
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
                    <a href="{{route('admin.business.biz_create')}}" class="btn_green btn_w_120">添加商家</a>
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
                    所属分组：
                    <select name="GroupID">
                        <option value="0">全部</option>
                        @foreach($groups as $GroupID=>$g)
                            <option value="{{$g['Group_ID']}}">{{$g["Group_Name"]}}</option>
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
                        <td width="5%" nowrap="nowrap">ID</td>
                        <td width="10%" nowrap="nowrap">登录账号</td>
                        {{--<td width="5%" nowrap="nowrap">邀请码</td>
                        <td width="7%" nowrap="nowrap">业务员</td>--}}
                        <td width="12%" nowrap="nowrap">商家名称</td>
                        <td width="8%" nowrap="nowrap">所属分组</td>
                        <td width="8%" nowrap="nowrap">联系人</td>
                        <td width="8%" nowrap="nowrap">联系电话</td>
                        <td width="8%" nowrap="nowrap">保证金</td>
                        <td width="8%" nowrap="nowrap">到期时间</td>
                        <td width="8%" nowrap="nowrap">添加时间</td>
                        <td width="8%" nowrap="nowrap">类型</td>
                        <td width="8%" nowrap="nowrap">状态</td>
                        <td width="10%" nowrap="nowrap" class="last">操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lists as $k=>$rsBiz)
                    <tr>
                        <td nowrap="nowrap">{{$rsBiz["Biz_ID"]}}</td>
                        <td>{{$rsBiz["Biz_Account"]}}</td>
                        {{--<td>{{$rsBiz['Invitation_Code']}}</td>
                        <td>
                            @if(isset($salesman_array[$rsBiz["Invitation_Code"]]))
                                @if($is_salesman_array[$rsBiz["Invitation_Code"]]!= 1)
                                    业务员被删除
                                @else
                                    @if(strlen($salesman_array[$rsBiz["Invitation_Code"]])>0)
                                        {{$salesman_array[$rsBiz["Invitation_Code"]]}}
                                    @else
                                        无昵称
                                    @endif
                                @endif
                            @endif
                        </td>--}}
                        <td>{{$rsBiz["Biz_Name"]}}</td>
                        <td>{{$rsBiz["group"]["Group_Name"]}}</td>
                        <td nowrap="nowrap">{{$rsBiz['Biz_Contact']}}</td>
                        <td nowrap="nowrap">@if($rsBiz["Biz_Phone"] != '') {{$rsBiz["Biz_Phone"]}} @else 暂无 @endif</td>
                        <td nowrap="nowrap">{{$rsBiz["bond_free"]}}</td>
                        <td nowrap="nowrap">{{$rsBiz["expiredate"]}}</td>
                        <td nowrap="nowrap">{{date("Y-m-d",$rsBiz["Biz_CreateTime"])}}</td>
                        <td nowrap="nowrap">{{$rsBiz["addtype"]}}</td>
                        <td nowrap="nowrap">{{$rsBiz["Biz_Status"]}}</td>
                        <td class="last" nowrap="nowrap">
                            <a href="/admin/business/biz_edit/{{$rsBiz["Biz_ID"]}}">
                                <img src="/admin/images/ico/mod.gif" align="absmiddle" alt="修改" />
                            </a>
                            <a href="/admin/business/biz_del/{{$rsBiz["Biz_ID"]}}" onClick="if(!confirm('删除后不可恢复，继续吗？')){return false};">
                                <img src="/admin/images/ico/del.gif" align="absmiddle" alt="删除" />
                            </a>
                            <a href="/admin/business/biz_index?action=upgrade&id={{$rsBiz["Biz_ID"]}}">[升级]</a>
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