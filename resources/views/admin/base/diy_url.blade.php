@extends('admin.layouts.main')
@section('ancestors')
    <li>基础设置</li>
@endsection
@section('page', '自定义URL')
@section('subcontent')

    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/material.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">

                <div id="url" class="r_con_wrap">

                    <form id="add_form" class="@if(!empty($url_edit)) add_form mod_form @else add_form @endif" method="post"
                          action="@if(!empty($url_edit)){{route('admin.base.diy_url_update', ['id'=>$url_edit['Url_ID']])}} @else {{route('admin.base.diy_url_store')}} @endif">
                        {{csrf_field()}}
                        <table border="0" cellpadding="5" cellspacing="0">
                            <tr>
                                <td>名称
                                    <input type="text" name="Name" value="@if(!empty($url_edit)){{$url_edit['Url_Name']}} @endif" size="25" class="form_input" /></td>
                                <td>Url
                                    <input type="text" name="Value" value="@if(!empty($url_edit)){{$url_edit['Url_Value']}} @endif" size="40" class="form_input" /></td>
                                <td><input type="submit" class="submit" value="@if(!empty($url_edit)) 更新URL @else 添加URL @endif" name="submit_btn"></td>
                            </tr>
                        </table>
                    </form>

                    <table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                        <thead>
                        <tr>
                            <td width="10%" nowrap="nowrap">序号</td>
                            <td width="30%" nowrap="nowrap">名称</td>
                            <td width="50%" nowrap="nowrap">Url</td>
                            <td width="10%" nowrap="nowrap" class="last">操作</td>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($rsUrls as $key=>$rsUrl)
                            <tr>
                                <td nowrap="nowrap">{{$rsUrl["Url_ID"]}}</td>
                                <td>{{$rsUrl["Url_Name"]}}</td>
                                <td>
                                    <a href="{{$rsUrl["Url_Value"]}}" target="_blank">{{$rsUrl["Url_Value"]}}</a>
                                </td>
                                <td class="last" nowrap="nowrap">
                                    <a href="{{route('admin.base.diy_url', ['id' => $rsUrl["Url_ID"]])}}">
                                        <img src="/admin/images/ico/mod.gif" align="absmiddle" alt="编辑" />
                                    </a>
                                    <a href="{{route('admin.base.diy_url_del', ['id' => $rsUrl["Url_ID"]])}}" onClick="if(!confirm('删除后不可恢复，继续吗？')){return false};">
                                        <img src="/admin/images/ico/del.gif" align="absmiddle" alt="删除" />
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="blank20"></div>
                    {{ $rsUrls->links() }}
                </div>

            </div>
        </div>

    </div>


@endsection