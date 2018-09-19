<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
</head>
<body>
<link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

<script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<style>
    .control_btn{margin:5px 10px 15px 0px; height:30px; clear:both;}
</style>

<div id="orders" class="r_con_wrap">
    <input type="hidden" name="count" value="{{count($lists)}}" />
    <input type="hidden" id="dis_type" value="{{$type}}" />
    <div class="control_btn">
        <a href="/admin/distribute/level_add?level={{$level}}&type={{$type}}" class="btn_green btn_w_120">添加级别</a>
    </div>
    @if($type==0)<!--直接购买-->
    <table border="0" cellpadding="5" cellspacing="0" class="r_con_table"  style="border-left: 1px #ddd solid">
        <thead>
        <tr>
            <td width="6%" nowrap="nowrap">序号</td>
            <td width="16%" nowrap="nowrap">级别名称</td>
            <td width="10%" nowrap="nowrap">门槛</td>
            <td width="16%" nowrap="nowrap">价格</td>
            <td width="16%" nowrap="nowrap">人数限制</td>
            <td width="16%" nowrap="nowrap">佣金明细</td>
            <td width="12%" nowrap="nowrap">更新状态</td>
            <td width="8%" nowrap="nowrap">操作</td>
        </tr>
        </thead>
        <tbody>
        @foreach($lists as $key => $value)
        <tr>
            <td nowrap="nowrap">{{$key+1}}</td>
            <td nowrap="nowrap">{{$value["Level_Name"]}}</td>
            <td nowrap="nowrap"> @if($key==0) {{$_TYPE[$value["Level_LimitType"]]}} @else {{$_TYPE[$type]}} @endif </td>
            <td nowrap="nowrap"><span style="color:#F60">{{$value["Level_LimitValue"]}}</span></td>
            <td nowrap="nowrap">
                @foreach($value['PeopleLimit'] as $k=>$v)
                    @if($k>1) <br /> @endif {{$arr[$k-1]}}级&nbsp;&nbsp;
                    @if($v==0) 无限制 @elseif($v==-1) 禁止 @else {{$v}}&nbsp;个 @endif
                @endforeach
            </td>
            <td nowrap="nowrap">
                @foreach($value['Distributes'] as $k=>$v)
                    @if($k>1) <br /> @endif
                    {{$arr[$k-1]}} 级&nbsp;&nbsp;{{$v}}&nbsp;元';
                @endforeach
            </td>
            <td nowrap="nowrap">
                @if(in_array($key,$complete)) <span style="color:blue">已更新</span> @else <span style="color:red">未更新</span> @endif
            </td>
            <td nowrap="nowrap">
                <a href="/admin/distribute/level_edit/{{$value['Level_ID']}}?level={{$level}}&type={{$type}}">[修改]</a>
                @if($key>0)
                <a href="/admin/distribute/level_del/{{$value['Level_ID']}}?level={{$level}}&type={{$type}}"
                    onclick="if(!confirm('确定删除此分销级别吗？')) return false" >[删除]</a>
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @elseif($type==1)<!--消费额-->
    <table border="0" cellpadding="5" cellspacing="0" class="r_con_table" style="border-left: 1px #ddd solid">
        <thead>
        <tr>
            <td width="8%" nowrap="nowrap">序号</td>
            <td width="16%" nowrap="nowrap">级别名称</td>
            <td width="16%" nowrap="nowrap">门槛</td>
            <td width="19%" nowrap="nowrap">消费额</td>
            <td width="16%" nowrap="nowrap">人数限制</td>
            <td width="15%" nowrap="nowrap">更新状态</td>
            <td width="10%" nowrap="nowrap">操作</td>
        </tr>
        </thead>
        <tbody>
        @foreach($lists as $key=>$value)
        <tr>
            <td nowrap="nowrap">{{$key+1}}</td>
            <td nowrap="nowrap">{{$value["Level_Name"]}}</td>
            <td nowrap="nowrap">@if($key==1) {{$_TYPE[$value["Level_LimitType"]]}} @else {{$_TYPE[$type]}} @endif </td>
            <td nowrap="nowrap"><span style="color:#F60">{!! $limit[$key] !!}</span></td>
            <td nowrap="nowrap">
                @foreach($value['PeopleLimit'] as $k=>$v)
                    @if($k>1) <br /> @endif
                    {{$arr[$k-1]}}级&nbsp;&nbsp;
                    @if($v==0) 无限制 @elseif($v==-1) 禁止 @else {{$v}}&nbsp;个 @endif
                @endforeach
            </td>
            <td nowrap="nowrap">
                @if(in_array($key,$complete)) <span style="color:blue">已更新</span> @else <span style="color:red">未更新</span> @endif
            </td>
            <td nowrap="nowrap">
                <a href="/admin/distribute/level_edit/{{$value['Level_ID']}}?level={{$level}}&type={{$type}}">[修改]</a>
                @if($key>0)
                <a href="/admin/distribute/level_del/{{$value['Level_ID']}}?level={{$level}}&type={{$type}}"
                   onclick="if(!confirm('确定删除此分销级别吗？')) return false" >[删除]</a>
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @elseif($type==2)<!--购买商品-->
    <table border="0" cellpadding="5" cellspacing="0" class="r_con_table" style="border-left: 1px #ddd solid">
        <thead>
        <tr>
            <td width="8%" nowrap="nowrap">序号</td>
            <td width="16%" nowrap="nowrap">级别名称</td>
            <td width="12%" nowrap="nowrap">门槛</td>
            <td width="24%" nowrap="nowrap">商品</td>
            <td width="16%" nowrap="nowrap">人数限制</td>
            {{--<td width="12%" nowrap="nowrap">更新状态</td>--}}
            <td width="10%" nowrap="nowrap">操作</td>
        </tr>
        </thead>
        <tbody>
        @foreach($lists as $key=>$value)
        <tr>
            <td nowrap="nowrap">{{$key+1}}</td>
            <td nowrap="nowrap">{{$value["Level_Name"]}}</td>
            <td nowrap="nowrap">@if($key==1) {{$_TYPE[$value["Level_LimitType"]]}} @else {{$_TYPE[$type]}} @endif </td>
            <td nowrap="nowrap"><span style="color:#F60">{!! $limit[$key] !!}</span></td>
            <td nowrap="nowrap">
                @foreach($value['PeopleLimit'] as $k=>$v)
                    @if($k>1) <br /> @endif
                    {{$arr[$k-1]}}级&nbsp;&nbsp;
                    @if($v==0) 无限制 @elseif($v==-1) 禁止 @else {{$v}}&nbsp;个 @endif
                @endforeach
            </td>
            {{--<td nowrap="nowrap">
                @if(in_array($key,$complete)) <span style="color:blue">已更新</span> @else <span style="color:red">未更新</span> @endif
            </td>--}}
            <td nowrap="nowrap">
                <a href="/admin/distribute/level_edit/{{$value['Level_ID']}}?level={{$level}}&type={{$type}}">[修改]</a>
                @if($key>0)
                    <a href="/admin/distribute/level_del/{{$value['Level_ID']}}?level={{$level}}&type={{$type}}"
                       onclick="if(!confirm('确定删除此分销级别吗？')) return false" >[删除]</a>
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @endif
</div>

</body>
</html>