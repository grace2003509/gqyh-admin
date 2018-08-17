@extends('admin.layouts.main')
@section('ancestors')
    <li>基础设置</li>
@endsection
@section('page', '微信授权设置')
@section('subcontent')

    <link href='/admin/css/wechat.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

    <div class="box">
        <div class="well" style="margin: 20px;">
            <p>1. 您的公众平台帐号类型必须为<span>服务号</span>。<p/>
            <p>2. 在公众平台申请接口使用的<span>AppId</span>和<span>AppSecret</span>，然后填入下边表单。</p>
        </div>

        <form action="{{route('admin.base.wechat_edit')}}" method="post" class="r_con_form">
            {{csrf_field()}}
            <div class="rows">
                <label>AppId <span class="fc_red">*</span></label>
                <span class="input">
                    <input name="WechatAppId" value="{{$rsUsers["Users_WechatAppId"]}}" type="text" class="form_input" size="35" maxlength="18" >
                </span>
                <div class="clear"></div>
            </div>
            <div class="rows">
                <label>AppSecret <span class="fc_red">*</span></label>
                <span class="input">
                    <input name="WechatAppSecret" value="{{$rsUsers["Users_WechatAppSecret"]}}" type="text" class="form_input" size="35" maxlength="32" >
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
                    <div class="oauth_tips">
                    <h5><strong>这个有什么用？</strong></h5>
                    通过微信认证的公众号可以使用微信最新推出的9大新接口<br />
                    请在微信公众平台高级接口处的"<span class="fc_red">OAuth2.0网页授权</span>​"设置授权回调页面域名为"<span class="fc_red"><?php echo $_SERVER['HTTP_HOST'];?></span>"<br />
                    <span class="fc_red">开微信认证选项后，客户端中所有需要用户登录的页面，将直接读取用户的微信资料进行一键登录，免去用户注册的步骤</span><br />
                    <span class="fc_red">开启语音关键词回复，您的微信帐号必须已通过微信认证并在高级接口中开启了语音识别，系统将自动识别出语音内容并启用模糊匹配方式进行关键字回复</span> </div>
                </span>
                <div class="clear"></div>
            </div>
            <div class="rows" style="background: white; height: 50px; border-top: 1px solid #ddd;">
                <label></label>
                <span class="input">
                    <input type="submit" class="btn_green" name="submit_button" value="提交保存" />
                </span>
                <div class="clear"></div>
            </div>
        </form>

        <div style="height: 20px"></div>
    </div>




@endsection