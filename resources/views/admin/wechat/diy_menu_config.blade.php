@extends('admin.layouts.main')
@section('ancestors')
    <li>我的微信</li>
@endsection
@section('page', '微信接口设置')
@section('subcontent')

    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/wechat.css' rel='stylesheet' type='text/css' />
    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script src="/admin/js/wechat.js"></script>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">
                <div id="wechat_menu" class="r_con_wrap">
                    <div class="m_menu">
                        <div class="tips_info">
                            1. 您的公众平台帐号类型必须为<span>服务号</span>或<span>已通过认证的订阅号</span>。<br />
                            2. 在微信公众平台申请接口使用的<span>AppId</span>和<span>AppSecret</span>，然后在【<a href="{{route('admin.base.wechat_set')}}">微信授权配置</a>】中设置。<br />
                            3. 最多创建<span>3</span>个一级菜单，每个一级菜单下最多可以创建<span>5</span>个二级菜单，菜单最多支持两层。<br />
                            4. 对菜单重新排序后，只有"<span>发布菜单</span>"后才会生效，公众平台限制了每天的发布次数，请勿频繁操作。<br />
                            5. 微信公众平台规定，<span>菜单发布24小时后生效</span>。您也可先取消关注，再重新关注即可马上看到菜单。<br />
                            6. 点击"<span>取消发布的菜单</span>"操作只删除微信公众平台上的菜单，并不是删除本系统已经设置好的菜单。
                        </div>
                        <div class="control_btn">
                            <a href="{{route('admin.wechat.menu_add')}}" class="btn_green btn_w_120">添加菜单</a>
                            <a href="{{route('admin.wechat.menu_push')}}" class="btn_green btn_w_120">发布菜单</a>
                            <input type="button" class="btn_green btn_w_120" name="del_btn" value="取消发布的菜单" onClick="location.href='{{route('admin.wechat.menu_del')}}" />
                        </div>
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="mytable">
                            <tr>
                                <td width="50" align="center"><strong>排序</strong></td>
                                <td width="100" align="center"><strong>消息类型</strong></td>
                                <td align="center"><strong>菜单名称</strong></td>
                                <td width="60" align="center"><strong>操作</strong></td>
                            </tr>

                            @foreach($ParentMenu as $key=>$value)
                            <tr onMouseOver="this.bgColor='#D8EDF4';" onMouseOut="this.bgColor='';" onDblClick="location.href='menu_edit.php?MenuID={{$value["Menu_ID"]}}'">
                                <td align="center">{{$key+1}}&nbsp;&nbsp;</td>
                                <td align="center">
                                    @if($value["Menu_TextContents"]=='myqrcode' && $value["Menu_MsgType"]==0)
                                        我的二维码
                                    @else
                                        {{$value["Menu_MsgType"]}}
                                    @endif
                                </td>
                                <td style="text-align: left">{{$value["Menu_Name"]}}</td>
                                <td align="center">
                                    <a href="menu_edit.php?MenuID={{$value["Menu_ID"]}}" title="修改">
                                        <img src="/admin/images/ico/mod.gif" align="absmiddle" />
                                    </a>
                                    <a href="menu.php?action=del&MenuID={{$value["Menu_ID"]}}" title="删除" onClick="if(!confirm('删除后不可恢复，继续吗？')){return false};">
                                        <img src="/admin/images/ico/del.gif" align="absmiddle" />
                                    </a>
                                </td>
                            </tr>
                                @foreach($value['rsMenu'] as $k => $v)
                                <tr onMouseOver="this.bgColor='#D8EDF4';" onMouseOut="this.bgColor='';" onDblClick="location.href='menu_edit.php?MenuID={{$v["Menu_ID"]}}'">
                                    <td align="center">{{$key+1}}.{{$key+1}}</td>
                                    <td align="center">{{$v["Menu_MsgType"]}}</td>
                                    <td style="text-align: left">——{{$v["Menu_Name"]}}</td>
                                    <td align="center">
                                        <a href="{{route('admin.wechat.menu_edit',['id' => $v["Menu_ID"]])}}" title="修改">
                                            <img src="/admin/images/ico/mod.gif" align="absmiddle" />
                                        </a>
                                        <a href="{{route('admin.wechat.menu_del',['id' => $v["Menu_ID"]])}}" title="删除" onClick="if(!confirm('删除后不可恢复，继续吗？')){return false};">
                                            <img src="/admin/images/ico/del.gif" align="absmiddle" />
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div style="height: 20px"></div>
    </div>
    <script language="javascript">$(document).ready(wechat_obj.menu_init);</script>

@endsection