@extends('admin.layouts.main')
@section('ancestors')
    <li>微官网</li>
@endsection
@section('page', '栏目列表')
@section('subcontent')
    <link href='/admin/css/global.css' rel='stylesheet' type='text/css'/>
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css'/>
    <link href='/admin/css/web.css' rel='stylesheet' type='text/css'/>

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

    <style>
        .mytable {
            -moz-border-bottom-colors: none;
            -moz-border-left-colors: none;
            -moz-border-right-colors: none;
            -moz-border-top-colors: none;
            border-color: #CCCCCC;
            border-image: none;
            border-style: solid;
            border-width: 1px 0 0 1px;
        }
        .mytable td {
            -moz-border-bottom-colors: none;
            -moz-border-left-colors: none;
            -moz-border-right-colors: none;
            -moz-border-top-colors: none;
            border-color: #CCCCCC;
            border-image: none;
            border-style: solid;
            border-width: 0 1px 1px 0;
            padding: 5px;
        }
    </style>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">

                <div id="column" class="r_con_wrap">
                    <div class="control_btn">
                        <a href="{{route('admin.web.column_create')}}" class="btn_green btn_w_120">添加栏目</a>
                    </div>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="mytable">
                        <tr>
                            <td width="8%" align="center"><strong>排序</strong></td>
                            <td width="12%" align="center"><strong>栏目名称</strong></td>
                            <td width="10%" align="center">相关选项</td>
                            <td align="center"><strong>栏目链接</strong></td>
                            <td width="10%" align="center"><strong>操作</strong></td>
                        </tr>
                        @foreach($Columns as $rsColumn)
                        <tr onMouseOver="this.bgColor='#D8EDF4';" onMouseOut="this.bgColor='';">
                            <td align="center">{{$rsColumn["Column_Index"]}}</td>
                            <td>{{$rsColumn["Column_Name"]}}</td>
                            <td align="center">
                                @if(!empty($rsColumn["Column_PopSubMenu"])) 弹出二级菜单<br> @endif
                                @if(!empty($rsColumn["Column_NavDisplay"])) 导航显示 @endif
                            </td>
                            <td>
                                @if(empty($rsColumn["Column_Link"]))
                                    无
                                @else
                                    @if(strpos($rsColumn["Column_LinkUrl"],"http://")>-1)
                                        {{$rsColumn["Column_LinkUrl"]}}
                                    @else
                                        http://{{$_SERVER['HTTP_HOST'].$rsColumn["Column_LinkUrl"]}}
                                    @endif
                                @endif
                            </td>
                            <td align="center">
                                <a href="{{route('admin.web.column_edit', ['id' => $rsColumn["Column_ID"]])}}" title="修改">
                                    <img src="/admin/images/ico/mod.gif" align="absmiddle" />
                                </a>
                                <a href="{{route('admin.web.column_del', ['id' => $rsColumn["Column_ID"]])}}" title="删除" onClick="if(!confirm('删除后不可恢复，继续吗？')){return false};">
                                    <img src="/admin/images/ico/del.gif" align="absmiddle" />
                                </a>
                            </td>
                        </tr>
                            @if(isset($rsColumn['child']))
                                @foreach($rsColumn['child'] as $k => $items)
                                <tr onMouseOver="this.bgColor='#D8EDF4';" onMouseOut="this.bgColor='';">
                                    <td align="center">{{$items["Column_Index"]}}</td>
                                    <td> └ {{$items["Column_Name"]}}</td>
                                    <td align="center">
                                        @if(!empty($items["Column_PopSubMenu"]))弹出二级菜单<br> @endif
                                        @if(!empty($items["Column_NavDisplay"]))导航显示 @endif
                                    </td>
                                    <td>
                                        @if(empty($items["Column_Link"]))
                                            无
                                        @else
                                            @if(strpos($items["Column_LinkUrl"],"http://")>-1)
                                                {{$items["Column_LinkUrl"]}}
                                            @else
                                                http://{{$_SERVER['HTTP_HOST'].$items["Column_LinkUrl"]}}
                                            @endif
                                        @endif
                                    </td>
                                    <td align="center">
                                        <a href="{{route('admin.web.column_edit', ['id' => $items["Column_ID"]])}}" title="修改">
                                            <img src="/admin/images/ico/mod.gif" align="absmiddle" />
                                        </a>
                                        <a href="{{route('admin.web.column_del', ['id' => $items["Column_ID"]])}}" title="删除" onClick="if(!confirm('删除后不可恢复，继续吗？')){return false};">
                                            <img src="/admin/images/ico/del.gif" align="absmiddle" />
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        @endforeach
                    </table>
                    <div class="clear"></div>
                </div>

            </div>
        </div>
    </div>

@endsection