@extends('admin.layouts.main')
@section('ancestors')
    <li>我的微信</li>
@endsection
@section('page', '修改自定义菜单')
@section('subcontent')

    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/wechat.css' rel='stylesheet' type='text/css' />
    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script src="/admin/js/wechat.js"></script>

    <div class="box">

                <div id="wechat_menu" class="r_con_wrap" style="min-height:500px">
                    <div class="m_menu">
                        <div class="m_righter" >
                            <form action="{{route('admin.wechat.menu_update', ['id'=>$rsMenu['Menu_ID']])}}" method="post" id="menu_form">
                                {{csrf_field()}}
                                <h1>修改菜单</h1>
                                <table class="table">
                                    <tr>
                                        <td width="15%">菜单排序：</td>
                                        <td>
                                            <select name="Index">
                                                <option value="1" @if($rsMenu["Menu_Index"]==1) selected @endif>1</option>
                                                <option value="2" @if($rsMenu["Menu_Index"]==2) selected @endif>2</option>
                                                <option value="3" @if($rsMenu["Menu_Index"]==3) selected @endif>3</option>
                                                <option value="4" @if($rsMenu["Menu_Index"]==4) selected @endif>4</option>
                                                <option value="5" @if($rsMenu["Menu_Index"]==5) selected @endif>5</option>
                                            </select>
                                            <span class="fc_red">*</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>菜单名称：</td>
                                        <td>
                                            <input type="text" name="Name" value="{{$rsMenu['Menu_Name']}}" class="form_input" size="15" maxlength="15" />
                                            <span class="fc_red" style="margin-left: 5px; line-height: 28px">*</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>添加到：</td>
                                        <td>
                                            <select name="ParentID">
                                                <option value="0">一级菜单</option>
                                                @foreach($rsPmenu as $key => $value)
                                                    <option value="{{$value['Menu_ID']}}" @if($value['Menu_ID'] == $rsMenu['Menu_ParentID']) selected @endif>
                                                        {{$value['Menu_Name']}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>消息类型：</td>
                                        <td>
                                            <select name="MsgType" id="msgtype">
                                                <option value="0" @if($rsMenu["Menu_MsgType"]==0) selected @endif>文字消息</option>
                                                <option value="1" @if($rsMenu["Menu_MsgType"]==1) selected @endif >图文消息</option>
                                                <option value="2" @if($rsMenu["Menu_MsgType"]==2) selected @endif >连接网址</option>
                                                <option value="3" @if($rsMenu["Menu_MsgType"]==3) selected @endif>我的二维码</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr id="menu0" @if($rsMenu["Menu_MsgType"]!=0) style="display: none" @endif>
                                        <td>文字内容：</td>
                                        <td>
                                            <textarea name="TextContents">{{$rsMenu["Menu_TextContents"]}}</textarea>
                                        </td>
                                    </tr>
                                    <tr id="menu1"  @if($rsMenu["Menu_MsgType"]!=1) style="display: none" @endif>
                                        <td>图文内容：</td>
                                        <td>
                                            <select name='MaterialID'>
                                                <option value=''>--请选择--</option>
                                                <optgroup label='---------------系统业务模块---------------'></optgroup>
                                                @foreach($sys_material as $value)
                                                    <option value="{{$value['Material_ID']}}" @if($rsMenu["Menu_MaterialID"]==$value['Material_ID']) selected @endif>
                                                        {{$value['Title']}}
                                                    </option>
                                                @endforeach
                                                <optgroup label="--------------自定义图文消息--------------"></optgroup>
                                                @foreach($diy_material as $value)
                                                    <option value="{{$value['Material_ID']}}" @if($rsMenu["Menu_MaterialID"]==$value['Material_ID']) selected @endif>
                                                        @if($value['Material_Type'])
                                                            【多图文】
                                                        @else
                                                            【单图文】
                                                        @endif
                                                        {{$value['Title']}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr id="menu2" @if($rsMenu["Menu_MsgType"]!=2) style="display: none" @endif>
                                        <td>链接网址：</td>
                                        <td>
                                            <input type="text" name="Url" value="{{$rsMenu["Menu_Url"]}}" class="form_input" size="30" maxlength="200" id="menu_url" />
                                            <img src="/admin/images/ico/search.png" id="btn_select_url" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <input type="submit" class="btn_green" style="width: 120px" name="submit_button" value="修改菜单" />
                                        </td>
                                    </tr>
                                </table>

                            </form>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>


        <div style="height: 20px"></div>
    </div>
    <script language="javascript">$(document).ready(wechat_obj.menu_init);</script>

@endsection