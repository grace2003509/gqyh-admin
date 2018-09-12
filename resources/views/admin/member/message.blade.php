@extends('admin.layouts.main')
@section('ancestors')
    <li>消息管理</li>
@endsection
@section('page', '消息列表')
@section('subcontent')

<link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/user.css' rel='stylesheet' type='text/css' />

<script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

<div class="box">
    <div id="iframe_page">
        <div class="iframe_content">

            <div id="user_message" class="r_con_wrap">
                <div class="control_btn">
                    <a href="{{route('admin.member.message_create')}}" class="btn_green btn_w_120">发布消息</a>
                </div>
                <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" class="r_con_table">
                    <thead>
                    <tr>
                        <td width="10%"><strong>序号</strong></td>
                        <td><strong>内容标题</strong></td>
                        <td width="20%"><strong>时间</strong></td>
                        <td width="15%" class="last"><strong>操作</strong></td>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($messages as $key => $message)
                    <tr>
                        <td nowrap="nowrap">{{$key+1}}</td>
                        <td>{{$message["Message_Title"]}}</td>
                        <td nowrap="nowrap">{{date("Y-m-d H:i:s",$message["Message_CreateTime"])}}</td>
                        <td nowrap="nowrap" class="last">
                            <a href="{{route('admin.member.message_edit', ['id' => $message['Message_ID']])}}">
                                <img src="/admin/images/ico/mod.gif" />
                            </a>
                            <a href="{{route('admin.member.message_del', ['id' => $message['Message_ID']])}}"
                               onClick="if(!confirm('删除后不可恢复，继续吗？')){return false};">
                                <img src="/admin/images/ico/del.gif" />
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="blank20"></div>
                {{ $messages->links() }}
            </div>
        </div>

</div>

@endsection