@extends('admin.layouts.main')
@section('ancestors')
    <li>商城设置</li>
@endsection
@section('page', '基本设置')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script src="/admin/js/global.js"></script>
    <link rel="stylesheet" href="/static/js/kindeditor/themes/default/default.css" />
    <script type='text/javascript' src="/static/js/kindeditor/kindeditor-min.js"></script>
    <script type='text/javascript' src="/static/js/kindeditor/lang/zh_CN.js"></script>
    <script type='text/javascript' src="/static/js/jscolor/jscolor.js"></script>

    <script type='text/javascript' src="/static/js/select2.js"></script>
    <script type="text/javascript" src="/static/js/location.js"></script>
    <script type="text/javascript" src="/static/js/area.js"></script>
    <link href="/static/css/select2.css" rel="stylesheet"/>

    <style type="text/css">
        #config_form img{width:100px; height:100px; font-size: 14px}
    </style>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">

                <div class="r_con_config r_con_wrap">
                    <form id="config_form" action="{{route('admin.shop.base_update')}}" method="post">
                        {{csrf_field()}}
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="50%" valign="top">
                                    <h1><span class="fc_red" >*</span> <strong>商城名称</strong></h1>
                                    <input type="text" class="input" name="ShopName" value="{{$rsConfig["ShopName"]}}" maxlength="30" required />
                                </td>
                                <td width="50%" valign="top">
                                    <h1><strong>分销总开关</strong><span class="tips">（默认为开启状态,如果关闭后将不再显示分销相关功能和文字）</span></h1>
                                    <div class="input">
                                        <label>关闭<input type="radio" @if($rsConfig["DisSwitch"] == 0)) checked @endif value="0" name="DisSwitch"></label>&nbsp;&nbsp;
                                        <label>开启<input type="radio" @if($rsConfig["DisSwitch"] == 1)) checked @endif value="1" name="DisSwitch"></label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" valign="top">
                                    <h1><strong>订单确认</strong><span class="tips">（关闭后下订单可直接付款，无需经过卖家确认）</span></h1>
                                    <div class="input">
                                        <label>关闭<input type="radio" @if($rsConfig["CheckOrder"] == 1)) checked @endif value="1" name="CheckOrder"></label>&nbsp;&nbsp;
                                        <label>开启<input type="radio" @if($rsConfig["CheckOrder"] == 0)) checked @endif value="0" name="CheckOrder"></label>
                                        <span class="tips">(只针对在线付款有效)</span>
                                    </div>
                                </td>
                                <td width="50%" valign="top">
                                    <h1><strong>评论审核</strong><span class="tips">（关闭后客户评论可不经过审核直接显示在前台页面）</span></h1>
                                    <div class="input">
                                        <label>关闭<input type="radio" @if($rsConfig["Commit_Check"] == 1) checked @endif value="1" name="CommitCheck"></label>&nbsp;&nbsp;
                                        <label>开启<input type="radio" @if($rsConfig["Commit_Check"] == 0) checked @endif value="0" name="CommitCheck"></label>
                                        <span class="tips"></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" valign="top">
                                    <h1><span class="fc_red">*</span> <strong>订单自动确认收货时间(单位是天)</strong></h1>
                                    <input type="text" class="input" name="Confirm_Time" value="{{$rsConfig["Confirm_Time"]/86400}}" size="10" required />

                                </td>
                                <td width="50%" valign="top">
                                    <h1><span class="fc_red">*</span> <strong>图标切换颜色</strong></h1>
                                    <input type="text" class="input jscolor" name="icon_color" style="width: 150px;" value="@if(!empty($rsConfig['Icon_Color'])){{$rsConfig['Icon_Color']}} @else E30C0C @endif" />
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" valign="top">
                                    <h1><span class="fc_red">*</span> <strong>底部菜单样式</strong></h1>
                                    <div class="input">
                                        <label><input type="radio"  name="Bottom_Style" value="0" @if($rsConfig["Bottom_Style"] == 0) checked @endif /> 图标</label>
                                        <label><input type="radio"  name="Bottom_Style" value="1"  @if($rsConfig["Bottom_Style"] == 1) checked @endif /> 图片</label>
                                    </div>
                                </td>
                                <td width="50%" valign="top">
                                    <h1>
                                        <strong>会员转移开关</strong>
                                        <span class="tips" style="color:#f00;">（默认为关闭状态,开启此开关后,会员在成为分销商之前如果扫描其他分销商二维码会变成其他分销商下级）</span>
                                    </h1>
                                    <div class="input">
                                        <label>开启<input type="radio" @if($rsConfig["user_trans_switch"] == 1) checked @endif value="1" name="user_trans_switch"></label>&nbsp;&nbsp;
                                        <label>关闭<input type="radio" @if($rsConfig["user_trans_switch"] == 0) checked @endif value="0" name="user_trans_switch"></label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" valign="top">
                                    <h1><strong>logo</strong><span class="tips" style="color:#f00;">　(请上传png透明格式&nbsp;&nbsp;尺寸建议：100*100px)</span></h1>
                                    <div id="card_style">
                                        <div class="file">
                                            <input name="LogoUpload" id="LogoUpload" type="button" style="width:80px;" value="上传图片" /><br /><br />
                                            <div class="img" id="LogoDetail">
                                                @if($rsConfig && $rsConfig['ShopLogo'] != '')
                                                    <img src="{{$rsConfig['ShopLogo']}}" />
                                                @endif
                                            </div>
                                            <input type="hidden" id="Logo" name="Logo" value="@if($rsConfig && $rsConfig['ShopLogo'] != ''){{$rsConfig['ShopLogo']}} @endif" />
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </td>
                                <td width="50%" valign="top">
                                    <h1><strong>自定义分享图片</strong><span class="tips"> (尺寸建议：100*100px)</span></h1>
                                    <div id="card_style">
                                        <div class="file">
                                            <input name="ShareLogoUpload" id="ShareLogoUpload" type="button" style="width:80px;" value="上传图片" /><br /><br />
                                            <div class="img" id="ShareLogoDetail">
                                                @if($rsConfig && $rsConfig['ShareLogo'] != '')
                                                        <img src="{{$rsConfig['ShareLogo']}}" />
                                                @endif
                                            </div>
                                            <input type="hidden" id="ShareLogo" name="ShareLogo" value="@if($rsConfig && $rsConfig['ShareLogo'] != '') {{$rsConfig['ShareLogo']}} @endif" />
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" valign="top">
                                    <h1><strong>商城公告</strong></h1>
                                    <div class="input">
                                        <label>关闭<input type="radio" value="0" name="ShopAnnounce" @if($rsConfig["ShopAnnounce"] == 0) checked @endif></label>&nbsp;&nbsp;
                                        <label>开启<input type="radio" value="1" name="ShopAnnounce" @if($rsConfig["ShopAnnounce"] == 1) checked @endif></label>
                                    </div>
                                </td>
                                <td width="50%" valign="top">
                                    <h1><strong>自定义分享语</strong></h1>
                                    <textarea name="ShareIntro">{{$rsConfig["ShareIntro"]}}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" valign="top">
                                    <h1><strong>默认地区</strong></h1>
                                    <select name="Province" id="loc_province" style="width:120px" required>
                                    </select>
                                    <select name="City" id="loc_city" style="width:120px" required>
                                    </select>
                                    <select name="Area" id="loc_town" style="width:120px; display:none">
                                    </select>
                                </td>
                                <td width="50%" valign="top">
                                    <h1><span class="fc_red"></span> <strong>默认距离(单位km)</strong></h1>
                                    <input type="text" class="input" name="DefaultLng" value="{{$rsConfig["DefaultLng"]}}" size="10"/>
                                </td>
                            </tr>
                        </table>

                        <div style="margin: 20px auto 20px 0">
                            <input type="submit" name="submit_button" class="btn_green" value="提交保存" />
                        </div>

                        <div class="clearfix"></div>
                    </form>
                </div>

            </div>
        </div>

    </div>

    <script>
        KindEditor.ready(function(K) {
            var editor = K.editor({
                uploadJson : '{{route('admin.upload_json')}}',
                fileManagerJson : '{{route('admin.file_manager_json')}}',
                showRemote : true,
                allowFileManager : true,
            });

            K('#LogoUpload').click(function(){
                editor.loadPlugin('image', function(){
                    editor.plugin.imageDialog({
                        imageUrl : K('#Logo').val(),
                        clickFn : function(url, title, width, height, border, align){
                            K('#Logo').val(url);
                            K('#LogoDetail').html('<img src="'+url+'" />');
                            editor.hideDialog();
                        }
                    });
                });
            });

            K('#SubscribeQrcodeUpload').click(function(){
                editor.loadPlugin('image', function(){
                    editor.plugin.imageDialog({
                        imageUrl : K('#SubscribeQrcodeDetail').val(),
                        clickFn : function(url, title, width, height, border, align){
                            K('#SubscribeQrcodeDetail').val(url);
                            K('#SubscribeQrcode').html('<img src="'+url+'" />');
                            editor.hideDialog();
                        }
                    });
                });
            });

            K('#ShareLogoUpload').click(function(){
                editor.loadPlugin('image', function(){
                    editor.plugin.imageDialog({
                        imageUrl : K('#ShareLogo').val(),
                        clickFn : function(url, title, width, height, border, align){
                            K('#ShareLogo').val(url);
                            K('#ShareLogoDetail').html('<img src="'+url+'" />');
                            editor.hideDialog();
                        }
                    });
                });
            });

            K('#ReplyImgUpload').click(function(){
                editor.loadPlugin('image', function(){
                    editor.plugin.imageDialog({
                        imageUrl : K('#ReplyImgPath').val(),
                        clickFn : function(url, title, width, height, border, align){
                            K('#ReplyImgPath').val(url);
                            K('#ReplyImgDetail').html('<img src="'+url+'" />');
                            editor.hideDialog();
                        }
                    });
                });
            });
        });

        $(function() {
            $("#clearSubscribeQrcode").on('click', function () {
                $("#SubscribeQrcode").html('');
                $("#SubscribeQrcodeDetail").val('');
            })
        })


        $(document).ready(function(){
            showLocation(@if(empty($areaids["province"])) 0 @else {{$areaids["province"]}} @endif,
                    @if(empty($areaids["city"])) 0 @else {{$areaids["city"]}} @endif,
                    @if(empty($areaids["area"])) 0 @else {{$areaids["area"]}} @endif );

            global_obj.config_setcheck_init();
        });
    </script>

@endsection