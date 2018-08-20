@extends('admin.layouts.main')
@section('ancestors')
    <li>我的微信</li>
@endsection
@section('page', '微信接口设置')
@section('subcontent')

    <link href='/admin/css/wechat.css' rel='stylesheet' type='text/css' />
    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

    <div class="box">
        <div class="well" style="margin: 20px;">
            <p>1. 在公众平台申请接口使用的AppId和AppSecret，然后填入下边表单。<p/>
            <p>2. <span style="color:#F00; font-size:12px;">服务认证号</span>请在<span style="color:#F00; font-size:12px;">微信公众平台开发者中心->网页服务->网页账号->网页授权获取用户基本信息</span>设置授权回调页面域名为 <span style="color:#F00; font-size:12px;">{{$host}}</span></p>
            <p>3. 请在<span style="color:#F00; font-size:12px;">微信公众平台公众号设置->功能设置->JS接口安全域名</span>设置域名为 <span style="color:#F00; font-size:12px;">{{$host}}</span></p>
        </div>

        <div id="iframe_page">
            <div class="iframe_content">

                <div id="token" >
                    <form class="r_con_form" action="{{route('admin.wechat.api_edit')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="rows">
                            <label>接口URL</label>
                            <span class="input">
                                <span class="tips">http://{{$host}}/Api/</span>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>接口Token</label>
                            <span class="input"><span class="tips">{{$rsUsers["Users_WechatToken"]}}</span></span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>公众号类型</label>
                            <span class="input">
                                <input style="float: left" type="radio" name="WechatType" value="0" id="type_0" @if($rsUsers["Users_WechatType"]==0) checked @endif />
                                <label for="type_0" >订阅号未认证</label>
                                <input type="radio" style="float: left;" name="WechatType" value="1" id="type_1" @if($rsUsers["Users_WechatType"]==1) checked @endif/>
                                <label for="type_1">订阅号已认证</label>
                                <input type="radio" name="WechatType" value="2" id="type_2" @if($rsUsers["Users_WechatType"]==2) checked @endif/>
                                <label for="type_2">服务号未认证</label>
                                <input type="radio" name="WechatType" value="3" id="type_3" @if($rsUsers["Users_WechatType"]==3) checked @endif/>
                                <label for="type_3">服务号已认证</label>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>AppId <span class="fc_red">*</span></label>
                            <span class="input">
                                <input name="WechatAppId" value="{{$rsUsers["Users_WechatAppId"]}}" type="text" class="form_input" size="35" maxlength="18" notnull>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>AppSecret <span class="fc_red">*</span></label>
                            <span class="input">
                                <input name="WechatAppSecret" value="{{$rsUsers["Users_WechatAppSecret"]}}" type="text" class="form_input" size="35" maxlength="32" notnull>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>微信认证</label>
                            <span class="input">
                              <input type="checkbox" value="1" name="WechatAuth" @if($rsUsers["Users_WechatAuth"] == 1) checked @endif />
                              <span class="tips">如果您的公众号已通过微信认证，请勾选此选项</span><br />
                              <input type="checkbox" value="1" name="WechatVoice" @if($rsUsers["Users_WechatVoice"] == 1) checked @endif />
                              <span class="tips">开启语音关键词回复，需同时开启微信认证选项</span>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>公众号名称</label>
                            <span class="input">
                                <input name="WechatName" id="WechatName" value="{{$rsUsers["Users_WechatName"]}}" type="text" class="form_input" size="35" maxlength="100">
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>公众号邮箱</label>
                            <span class="input">
                                <input name="WechatEmail" id="WechatEmail" value="{{$rsUsers["Users_WechatEmail"]}}" type="text" class="form_input" size="35" maxlength="100" >
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>公众号原始ID</label>
                            <span class="input">
                                <input name="WechatID" id="WechatID" value="{{$rsUsers["Users_WechatID"]}}" type="text" class="form_input" size="35" maxlength="100" >
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>微信号</label>
                            <span class="input">
                                <input name="WechatAccount" id="WechatAccount" value="{{$rsUsers["Users_WechatAccount"]}}" type="text" class="form_input" size="35" maxlength="100" notnull>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>EncodingAESKey</label>
                            <span class="input">
                                <input name="EncodingAESKey" id="EncodingAESKey" value="{{$rsUsers["Users_EncodingAESKey"]}}" type="text" class="form_input" size="35" maxlength="100" />
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>消息加解密方式</label>
                            <span class="input">
                              <select name="EncodingAESKeyType" id="EncodingAESKeyType">
                                  <option value="0" @if($rsUsers["Users_EncodingAESKeyType"]==0) selected @endif>明文模式</option>
                                  <option value="1" @if($rsUsers["Users_EncodingAESKeyType"]==1) selected @endif>兼容模式</option>
                                  <option value="2" @if($rsUsers["Users_EncodingAESKeyType"]==2) selected @endif>安全模式（推荐）</option>
                              </select>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>微信认证文件</label>
                            <span class="input">
                                 <input type="text" name="imgFile"  class="textbox" value="{{$rsUsers['weixinfile']}}" id="fileName"/>
                                 {{--<a href="javascript:void(0);" id="look_file" class="link">浏览</a>--}}
                                 <input type="file" id="file" name="imgFile" onchange="handleFile()" />
                                 <span class="text_red">注：认证文件将在24小时后自动删除,请及时进行认证</span>
				            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows" style="background: #fff; height: 50px; line-height: 50px; border-top: 1px #ddd solid">
                            <label></label>
                            <span class="input">
                                <input type="submit" class="btn_green" name="submit_button" value="设置" />
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
        var file = document.getElementById("file");
        var fileName = document.getElementById("fileName");
        function handleFile(){
            fileName.value = file.value;
        }
    </script>

@endsection