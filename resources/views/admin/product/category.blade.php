@extends('admin.layouts.main')
@section('ancestors')
    <li>产品管理</li>
@endsection
@section('page', '产品类别列表')
@section('subcontent')

<link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

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

            <div id="products" class="r_con_wrap">
                <div class="category">
                    <div class="control_btn">
                        <a href="{{route('admin.product.category_create')}}" class="btn_green btn_w_120">添加分类</a>
                    </div>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="mytable">
                        <tr bgcolor="#f5f5f5">
                            <td width="100" align="center"><strong>排序</strong></td>
                            <td align="center"><strong>类别名称</strong></td>
                            <td align="center" width="150"><strong>类别图标</strong></td>
                            <td align="center"><strong>保证金</strong></td>
                            <td width="150" align="center"><strong>操作</strong></td>
                        </tr>
                        @foreach($ParentMenu as $key=>$value)
                        <tr onMouseOver="this.bgColor='#D8EDF4';" onMouseOut="this.bgColor='';" >
                            <td align="center">{{$key+1}}</td>
                            <td  style="text-align: left">{{$value["Category_Name"]}}</td>
                            <td>
                                @if($value["Category_ImgPath"] != '')
                                <img src="{{$value["Category_Name"]}}" width="50">
                                @endif
                            </td>
                            <td></td>
                            <td align="center">
                                <a href="{{route('admin.product.category_edit', ['id' => $value["Category_ID"]])}}" title="修改">
                                    <img src="/admin/images/ico/mod.gif" align="absmiddle" />
                                </a>　
                                <a href="{{route('admin.product.category_del', ['id' => $value["Category_ID"]])}}" title="删除" onClick="if(!confirm('删除后不可恢复，继续吗？')){return false};">
                                    <img src="/admin/images/ico/del.gif" align="absmiddle" />
                                </a>
                            </td>
                        </tr>
                            @if(isset($value['child']))
                                @foreach($value['child'] as $k => $v)
                                <tr onMouseOver="this.bgColor='#D8EDF4';" onMouseOut="this.bgColor='';">
                                    <td align="center">{{$key+1}}.{{$k+1}}</td>
                                    <td style="text-align: left">└─{{$v["Category_Name"]}}</td>
                                    <td>
                                        @if($value["Category_ImgPath"] != '')
                                            <img src="{{$value["Category_Name"]}}" width="50">
                                        @endif
                                    </td>
                                    <td>{{$v["Category_Bond"]}}</td>
                                    <td align="center">
                                        <a href="{{route('admin.product.category_edit', ['id' => $v["Category_ID"]])}}" title="修改">
                                            <img src="/admin/images/ico/mod.gif" align="absmiddle" />
                                        </a>　
                                        <a href="{{route('admin.product.category_del', ['id' => $v["Category_ID"]])}}" title="删除" onClick="if(!confirm('删除后不可恢复，继续吗？')){return false};">
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

</div>

@endsection