@extends('admin.layouts.main')
@section('ancestors')
    <li>我的微信</li>
@endsection
@section('page', '编辑关键词')
@section('subcontent')

    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/wechat.css' rel='stylesheet' type='text/css' />
    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script src="/admin/js/wechat.js"></script>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">
                <div id="reply_keyword" class="r_con_wrap">

                    <form action="{{route('admin.wechat.keyword_update', ['id' => $rsReply['Reply_ID']])}}" method="post" class="r_con_form">
                        {{csrf_field()}}
                        <div class="rows">
                            <label>关键词</label>
                            <span class="input">
		                        <input type="text" class="form_input" size="60" name="Keywords" value="{{$rsReply["Reply_Keywords"]}}" maxlength="100" />
                                {{--<div class="tips"></div>--}}
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>匹配模式</label>
                            <span class="input">
                              <input type="radio" name="PatternMethod" value="0" @if($rsReply["Reply_PatternMethod"]==0) checked @endif />
                              精确匹配<span class="tips">（用户输入的文字和此关键词一样才会触发,一般用于一个关键词.）</span><br />
                              <input type="radio" name="PatternMethod" value="1" @if($rsReply["Reply_PatternMethod"]== 1) checked @endif />
                              模糊匹配<span class="tips">（只要用户输入的文字包含此关键词就触）</span><br />
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>回复类型</label>
                            <span class="input">
                              <select name="ReplyMsgType">
                                <option value="0" @if($rsReply["Reply_MsgType"] == 0) selected @endif>文字消息</option>
                                <option value="1" @if($rsReply["Reply_MsgType"] == 1) selected @endif>图文消息</option>
                              </select>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows" id="text_msg_row">
                            <label>回复内容</label>
                            <span class="input">
                              <textarea name='TextContents'>{{$rsReply["Reply_TextContents"]}}</textarea>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows" id="img_msg_row">
                            <label>回复内容</label>
                            <span class="input">
                                <select name='MaterialID'>
                                    <option value=''>--请选择--</option>
                                    <optgroup label='---------------系统业务模块---------------'></optgroup>
                                    @foreach($sys_material as $value)
                                        <option value="{{$value['Material_ID']}}" @if($rsReply["Reply_MaterialID"]==$value['Material_ID']) selected @endif>{{$value['Title']}}</option>
                                    @endforeach
                                    <optgroup label="---------------自定义图文消息---------------"></optgroup>
                                    @foreach($diy_material as $value)
                                        <option value="{{$value['Material_ID']}}" @if($rsReply["Reply_MaterialID"]==$value['Material_ID']) selected @endif>
                                            @if($value['Material_Type'])
                                                【多图文】
                                            @else
                                                【单图文】
                                            @endif
                                            {{$value['Title']}}
                                        </option>
                                    @endforeach
                                </select>
                                {{--<a href="#" class="material">图文消息管理</a>--}}
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows" style="background: #fff; height: 50px; line-height: 50px; border-top: 1px #ddd solid">
                            <label></label>
                            <span class="input">
                              <input type="submit" class="btn_green" name="submit_button" value="提交保存" />
                              <a href="{{route('admin.wechat.keyword_index')}}" class="btn_gray">返回</a>
                            </span>
                            <div class="clear"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div style="height: 20px"></div>
    </div>
    <script language="javascript">$(document).ready(wechat_obj.reply_keyword_init);</script>

@endsection