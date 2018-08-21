@extends('admin.layouts.main')
@section('ancestors')
    <li>我的微信</li>
@endsection
@section('page', '首次关注设置')
@section('subcontent')

    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/wechat.css' rel='stylesheet' type='text/css' />
    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script type='text/javascript' src='/admin/js/wechat.js'></script>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">
                <div id="attention" class="r_con_wrap">
                    <form id="attention_reply_form" class="r_con_form" method="post" action="{{route('admin.wechat.reply_edit')}}">
                        {{csrf_field()}}
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
                                <textarea name="ReplyTextContents">{{$rsReply["Reply_TextContents"]}}</textarea>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows" id="img_msg_row">
                            <label>回复内容</label>
                            <span class="input">
                                  <select name='ReplyMaterialID'>
                                      <option value=''>--请选择--</option>
                                      <optgroup label='--------------系统业务模块-------------'></optgroup>
                                      @foreach($sys_material as $key => $value)
                                          <option value="{{$value['Material_ID']}}" @if($rsReply["Reply_MaterialID"]==$value['Material_ID']) selected @endif>
                                              {{$value['Title']}}
                                          </option>
                                      @endforeach
                                      <optgroup label="-------------自定义图文消息------------"></optgroup>
                                      @foreach($diy_material as $key => $value)
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
                        <div class="rows" id="img_msg_row">
                            <label>成为会员提醒</label>
                            <span class="input">
                                <input type="checkbox" value="1" name="MemberNotice" @if($rsReply["Reply_MemberNotice"]== 1) checked @endif />
                                <span class="tips">开启（开启后，用户关注公众收到的消息中会包含会员信息，例如：您好**，您已成为第***位会员。此设置仅对“文字消息”有效）</span>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows" id="img_msg_row">
                            <label>任意关键词</label>
                            <span class="input">
                                <input type="checkbox" value="1" name="ReplySubscribe" @if($rsReply["Reply_Subscribe"] == 1) checked @endif />
                                <span class="tips">开启（开启后，当输入的关键字无相关的匹配内容时，则使用本设置回复）</span>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows" style="border-bottom: 1px #ddd solid">
                            <label></label>
                            <span class="input">
                                <input type="submit" class="btn_green" name="submit_button" value="提交保存" />
                            </span>
                            <div class="clear"></div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div style="height: 20px"></div>
    </div>

    <script>
        $(document).ready(wechat_obj.attention_init);
    </script>



@endsection