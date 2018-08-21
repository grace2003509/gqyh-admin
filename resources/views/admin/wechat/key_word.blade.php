@extends('admin.layouts.main')
@section('ancestors')
    <li>我的微信</li>
@endsection
@section('page', '关键词回复设置')
@section('subcontent')

    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/wechat.css' rel='stylesheet' type='text/css' />
    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script src="/admin/js/wechat.js"></script>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">
                <div id="wechat_menu" class="r_con_wrap" style="min-height: 700px">
                    <div class="m_menu">

                        <div class="control_btn">
                            <a href="{{route('admin.wechat.keyword_add')}}" class="btn_green btn_w_120">添加关键词</a>
                        </div>
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="mytable">
                            <tr>
                                <td width="5%" align="center"><strong>序号</strong></td>
                                <td width="30%" align="center"><strong>触发关键词</strong></td>
                                <td width="10%" align="center"><strong>匹配模式</strong></td>
                                <td width="45%" align="center"><strong>回复内容</strong></td>
                                <td width="10%" align="center"><strong>操作</strong></td>
                            </tr>

                            @foreach($rsReply as $key=>$value)
                            <tr>
                                <td align="center">{{$key+1}}&nbsp;&nbsp;</td>
                                <td align="center">{{$value['Keywords']}}</td>
                                <td style="text-align: left">
                                    @if($value["Reply_PatternMethod"] == 1)
                                        模糊匹配
                                        @else
                                        精确匹配
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($value["Reply_TextContents"]))
                                        {{$value["Reply_TextContents"]}}
                                        @else
                                        &nbsp;
                                    @endif
                                </td>
                                <td align="center">
                                    <a href="{{route('admin.wechat.keyword_edit',['id' => $value["Reply_ID"]])}}" title="修改">
                                        <img src="/admin/images/ico/mod.gif" align="absmiddle" />
                                    </a>
                                    <a href="{{route('admin.wechat.keyword_del',['id' => $value["Reply_ID"]])}}" title="删除" onClick="if(!confirm('删除后不可恢复，继续吗？')){return false};">
                                        <img src="/admin/images/ico/del.gif" align="absmiddle" />
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </table>

                        {{ $rsReply->links() }}
                    </div>
                </div>
            </div>
        </div>

        <div style="height: 20px"></div>
    </div>
    <script language="javascript">$(document).ready(wechat_obj.menu_init);</script>

@endsection