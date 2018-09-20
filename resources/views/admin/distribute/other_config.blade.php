@extends('admin.layouts.main')
@section('ancestors')
    <li>分销管理</li>
@endsection
@section('page', '其他设置')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <link rel="stylesheet" href="/admin/js/kindeditor/themes/default/default.css?t=1" />
    <script type='text/javascript' src="/admin/js/kindeditor/kindeditor-min.js?t=1"></script>
    <script type='text/javascript' src="/admin/js/kindeditor/lang/zh_CN.js?t=1"></script>

    <style>
        .level_for_level > div { float: left; margin-top: 5px; margin-right: 10px; }
        .level_for_level > div:nth-child(even) { margin-right: 20px; }
        li {list-style-type: none}
    </style>
    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">

                <div class="r_con_wrap">
                    <div class="control_btn">
                        <a href="{{route('admin.distribute.base_config_index')}}" class="btn_green btn_w_120">基础设置</a>
                        <a href="{{route('admin.distribute.home_config_index')}}" class="btn_green btn_w_120">分销首页设置</a>
                        <a href="{{route('admin.distribute.withdraw_config_index')}}" class="btn_green btn_w_120">提现设置</a>
                        <a href="{{route('admin.distribute.protitle_config_index')}}" class="btn_green btn_w_120">爵位设置</a>
                        <a href="{{route('admin.distribute.agent_config_index')}}" class="btn_green btn_w_120">区域代理设置</a>
                        <a href="{{route('admin.distribute.other_config_index')}}" class="btn_green btn_w_120">其他设置</a>
                    </div>

                        <form id="distribute_config_form" class="r_con_form" method="post"
                              action="{{route('admin.distribute.other_config_update')}}">
                            {{csrf_field()}}
                            <h2 style="height:40px; line-height:40px; font-size:14px; font-weight:bold; background:#eee; text-indent:15px;">分销相关设置</h2>
                            <div class="rows">
                                <label>自定义店名和头像</label>
                                <span class="input">
                                   <input type="radio" name="Customize" id="c_0" value="0" @if($rsConfig["Distribute_Customize"]==0) checked @endif />
                                    <label for="c_0"> 关闭</label>&nbsp;&nbsp;
                                   <input type="radio" name="Customize" id="c_1" value="1" @if($rsConfig["Distribute_Customize"]==1) checked @endif />
                                    <label for="c_1"> 开启</label>
                                   <span class="tips">&nbsp;&nbsp;(设置分销商能否自定义店名与头像)</span>
                                </span>
                                <div class="clear"></div>
                            </div>

                            <div class="rows">
                                <label>分销中心强制绑定手机号</label>
                                <span class="input">
                                   <input type="radio" name="Bindmobile" id="d_0" value="0" @if($rsConfig["Bindmobile"]==0) checked @endif />
                                    <label for="d_0"> 否</label>&nbsp;&nbsp;
                                   <input type="radio" name="Bindmobile" id="d_1" value="1" @if($rsConfig["Bindmobile"]==1) checked @endif />
                                    <label for="d_1"> 是</label>
                                   <span class="tips">&nbsp;&nbsp;(进分销中心点击任意按钮是否会强制要求绑定手机)</span>
                                </span>
                                <div class="clear"></div>
                            </div>

                            <div class="rows">
                                <label>是否显示下级名称</label>
                                <span class="input">
                                   <input type="radio" name="Fbonsnameswitch" id="d_0" value="0" @if($rsConfig["Fbonsnameswitch"]==0) checked @endif />
                                    <label for="d_0"> 否</label>&nbsp;&nbsp;
                                   <input type="radio" name="Fbonsnameswitch" id="d_1" value="1" @if($rsConfig["Fbonsnameswitch"]==1) checked @endif />
                                    <label for="d_1"> 是</label>
                                   <span class="tips">&nbsp;&nbsp;(发佣金时消息模版上是否显示下级名称)</span>
                                </span>
                                <div class="clear"></div>
                            </div>

                            <div class="rows">
                                <label>昵称后的“的店”</label>
                                <span class="input">
                                    <input type="text" name="nicheng_after" value="{{$rsConfig["nicheng_after"]}}" class="form_input" size="8" maxlength="10" />
                                    <span class="tips">&nbsp;注:图片上昵称后的字符.</span>
                                </span>
                                <div class="clear"></div>
                            </div>

                            <div class="rows">
                                <label>分销中心顶部banner图片</label>
                                <span class="input">
                                   <span class="upload_file">
                                        <div>
                                             <div class="up_input">
                                                 <input type="button" id="ApplyBannerUpload" value="上传图片" style="width:80px;" />
                                             </div>
                                             <div class="tips">图片建议尺寸：640*322px</div>
                                             <div class="clear"></div>
                                        </div>
                                        <div class="img" id="ApplyBannerDetail" style="padding-top:8px;">
                                            <img @if($rsConfig["ApplyBanner"]) src="{{$rsConfig["ApplyBanner"]}}" @else src="/admin/images/apply_distribute.png" @endif />
                                        </div>
                                   </span>
                                </span>
                                <div class="clear"></div>
                            </div>

                            <div class="rows">
                                <label>我的二维码背景图片</label>
                                <span class="input">
                                   <span class="upload_file">
                                        <div>
                                             <div class="up_input">
                                                 <input type="button" id="QrcodeBgUpload" value="上传图片" style="width:80px;" />
                                             </div>
                                             <div class="tips">图片建议尺寸：640*1010px</div>
                                             <div class="clear"></div>
                                        </div>
                                        <div class="img" id="QrcodeBgDetail" style="padding-top:8px;">
                                            <img @if($rsConfig["QrcodeBg"]) src="{{$rsConfig["QrcodeBg"]}}" @else src="/admin/images/qrcode_bg.jpg" @endif />
                                        </div>
                                   </span>
                                </span>
                                <div class="clear"></div>
                            </div>

                            <h2 style="height:40px; line-height:40px; font-size:14px; font-weight:bold; background:#eee; text-indent:15px;">分销商排行设置</h2>
                            <div class="rows">
                                <label>总部分销商排行榜</label>
                                <span class="input">
                                    <input type="radio" id="z_0" name="HIncomelist_Open"
                                         value="1" @if($rsConfig["HIncomelist_Open"]==1) checked @endif />
                                    <label for="z_0">公开</label>&nbsp;&nbsp;
                                    <input type="radio" id="z_1" name="HIncomelist_Open"  value="0" @if($rsConfig["HIncomelist_Open"]==0) checked @endif />
                                    <label for="z_1">不公开</label>
                                    <span class="tips">&nbsp;&nbsp;(仅上榜后才有权限查看)</span>
                                </span>
                                <div class="clear"></div>
                            </div>

                            <div class="rows">
                                <label>入榜最低佣金</label>
                                <span class="input">
                                    <input type="text" name="H_Incomelist_Limit" value="{{$rsConfig["H_Incomelist_Limit"]}}" class="form_input" size="8" maxlength="10" />
                                    <span class="tips">&nbsp;注:单位是元.</span>
                                </span>
                                <div class="clear"></div>
                            </div>

                            <h2 style="height:40px; line-height:40px; font-size:14px; font-weight:bold; background:#eee; text-indent:15px;">邀请人限制</h2>
                            <div class="rows">
                                <label>必须通过邀请人成为会员</label>
                                <span class="input">
            	                    <input type="radio" id="b_0" name="Distribute_Limit" id="distribute_limit_0"
                                           value="0" @if($rsConfig["Distribute_Limit"]==0) checked @endif />
                                    <label for="b_0"> 关闭</label>&nbsp;&nbsp;
                                    <input type="radio" id="b_1" name="Distribute_Limit" id="distribute_limit_1"
                                           value="1" @if($rsConfig["Distribute_Limit"]==1) checked @endif />
                                    <label for="b_1"> 开启</label>
                                </span>
                                <div class="clear"></div>
                            </div>

                            <h2 style="height:40px; line-height:40px; font-size:14px; font-weight:bold; background:#eee; text-indent:15px;">进入商城限制</h2>
                            <div class="rows">
                                <label>必须成为分销商</label>
                                <span class="input">
                                    <input type="radio" id="w_0" name="Distribute_ShopOpen" id="distribute_shop_0"
                                           value="0" @if($rsConfig["Distribute_ShopOpen"]==0) checked @endif />
                                    <label for="w_0"> 关闭</label>&nbsp;&nbsp;
                                    <input type="radio" id="w_1" name="Distribute_ShopOpen" id="distribute_shop_1"
                                           value="1" @if($rsConfig["Distribute_ShopOpen"]==1) checked @endif />
                                    <label for="w_1"> 开启</label>
                                </span>
                                <div class="clear"></div>
                            </div>

                            <div class="rows">
                                <label></label>
                                <span class="input">
                                    <input type="submit" class="btn_green" name="submit_button" value="提交保存" />
                                </span>
                                <div class="clear"></div>
                            </div>
                            <input type="hidden" name="QrcodeBg" id="QrcodeBg"
                                   @if($rsConfig["QrcodeBg"])
                                           value="{{$rsConfig["QrcodeBg"]}}"
                                   @else
                                           value="/admin/images/qrcode_bg.jpg"
                                   @endif />
                            <input type="hidden" name="ApplyBanner" id="ApplyBanner"
                                   @if($rsConfig["ApplyBanner"])
                                   value="{{$rsConfig["ApplyBanner"]}}"
                                   @else
                                   value="/admin/images/apply_distribute.png"
                                   @endif />
                        </form>
                    </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">

        KindEditor.ready(function(K) {
            K.create('textarea[name="Agreement"]', {
                themeType : 'simple',
                filterMode : false,
                uploadJson : '/admin/upload_json?TableField=web_column',
                fileManagerJson : '/admin/file_manager_json',
                allowFileManager : true,
            });
            var editor = K.editor({
                uploadJson : '/admin/upload_json?TableField=web_column',
                fileManagerJson : '/admin/file_manager_json',
                showRemote : true,
                allowFileManager : true,
            });

            K('#QrcodeBgUpload').click(function(){
                editor.loadPlugin('image', function(){
                    editor.plugin.imageDialog({
                        imageUrl : K('#QrcodeBg').val(),
                        clickFn : function(url, title, width, height, border, align){
                            K('#QrcodeBg').val(url);
                            K('#QrcodeBgDetail').html('<img src="'+url+'" />');
                            editor.hideDialog();
                        }
                    });
                });
            });

            K('#ApplyBannerUpload').click(function(){
                editor.loadPlugin('image', function(){
                    editor.plugin.imageDialog({
                        imageUrl : K('#ApplyBanner').val(),
                        clickFn : function(url, title, width, height, border, align){
                            K('#ApplyBanner').val(url);
                            K('#ApplyBannerDetail').html('<img src="'+url+'" />');
                            editor.hideDialog();
                        }
                    });
                });
            });
        });

    </script>

@endsection