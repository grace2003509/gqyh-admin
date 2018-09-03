@extends('admin.layouts.main')
@section('ancestors')
    <li>商城设置</li>
@endsection
@section('page', '底部菜单设置')
@section('subcontent')
    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

    <link rel="stylesheet" href="/static/tubiao/css/font-awesome.css" type="text/css">
    <link rel="stylesheet" href="/static/tubiao/css/font-awesome-ie7.css" type="text/css">

    <style type="text/css">
        div.m_righter { width: 900px; display: block; background: #eee; border: 1px solid #ccc; padding: 10px 20px 20px; clear: both; }
        div.m_righter h1 { display: block; overflow: hidden; height: 30px; line-height: 30px; font-size: 14px; font-weight: bold; }
        .r_con_form .rows .input .form_input { width: 200px; }
        .r_con_form .rows .input .long_form_input { width: 400px; }
        .r_con_form .no-border, .r_con_form .rows .no-border { border: 0; }
        .menu_list { display: block; overflow: hidden; margin-bottom: -1px; }
        .menu_list a  { display: inline-block; float: left; padding: 1px 5px; background: #eee; color: #000; width: 112px; text-align: center; font-size: 16px; border: 1px solid #ccc; margin-right: -1px; height: 50px; line-height: 50px; margin-top: 20px; margin-right: 20px; margin-bottom: 21px; position: relative; }
        .menu_list a.current { background: #1584D5; color: #fff; }
        .menu_list a.current span.arrow { width: 0px; height: 0px; border-left: 15px solid transparent; border-right: 15px solid transparent; border-bottom: 22px solid #ccc; font-size: 0px; line-height: 0px; position: absolute; top: 52px; left: 40px; }

        .menu_list a span.delete { position: absolute; top: 0px; right: 0px; background: #333; height: 20px; line-height: 20px; font-size: 11px; padding: 0 3px; z-index: 1000; filter: alpha(opacity=70); -moz-opacity: 0.7; -khtml-opacity: 0.7; opacity: 0.7; color: #FFF; }

        .img { margin-top: 5px; }
        .img div { width: 90px; height: 90px; border: 1px solid #ddd; float: left; position: relative; margin-right: 8px; }
        .img div img { width: 90px; height: 90px; position: absolute; }
        .img div span { width: 90px; display: block; height: 20px; line-height: 20px; text-align: center; position: absolute; top: 70px; background: #000; color: #fff; font-size: 12px; filter: alpha(opacity=70); -moz-opacity: 0.7; -khtml-opacity: 0.7; opacity: 0.7; cursor: pointer; }
        .menu_config_list { display: none; }
        .menu_config_list_0 { display: block; }
    </style>
<div class="box">
    <div id="iframe_page">
        <div class="iframe_content">

            <div id="home" class="r_con_wrap">
                <div class="menu_list">
                    @foreach ($ShopMenu['menu'] as $k => $v)
                    <a href="javascript:void(0);" onclick="show_tabs_contents({{$k}})" @if($k == 0) class="current" @endif >
                        {{$v['menu_name']}}
                        <span class="arrow"></span>
                        @if($k > 0)<span class="delete" data-id="{{$k}}">删除</span>@endif
                    </a>
                    @endforeach

                    @if (count($ShopMenu['menu']) < 6)
                    <a href="javascript:void(0);" onclick="show_tabs_contents('add')" style="font-size:24px;">＋</a>
                    @endif
                </div>
                <div class="m_righter">

                    <h1>设置商城前台导航菜单配置</h1>
                    <form action="{{route('admin.shop.foot_menu_update')}}" name="category_form" id="category_form" class="r_con_form" method="post">
                        {{csrf_field()}}
                    @foreach ($ShopMenu['menu'] as $k => $v)
                    <!--配置项列表start-->
                        <div class="menu_config_list menu_config_list_{{$k}}">
                            <div class="opt_item rows">
                                <label>菜单名称：</label>
                                <span class="input">
                                    <input type="text" name="menu[{{$k}}][menu_name]" value="{{$v['menu_name']}}" class="form_input" size="5" maxlength="30" required />
                                    <span class="fc_red">*</span>前台首页展示名称，不设置则使用系统默认名称；
                                </span>
                                <div class="clear"></div>
                            </div>

                            <div class="opt_item rows">
                                <label>登录状态名称：</label>
                                <span class="input">
                                    <input type="text" name="menu[{{$k}}][login_menu_name]" value="@if(isset($v['login_menu_name'])) {{$v['login_menu_name']}} @endif" class="form_input" size="5" maxlength="30" required />
                                    <span class="fc_red">*</span>用户登录之后将使用该名称
                                </span>
                                <div class="clear"></div>
                            </div>
                            @if($Shop_Config['Bottom_Style'] == 1)
                            <div class="opt_item rows">
                                <label>菜单图标：</label>
                                <span class="input" style="width:40%">
                                    <div class="up_input">
                                        <input type="button" class="ImgUpload_On" data-id="{{$k}}" value="添加图片" style="width:80px;" />
                                    </div>
                                    <div class="tips">请上传前台显示的当前菜单图标</div>
                                    <div class="img PicDetail">
                                        @if (isset($v['icon_on']) && !empty($v['icon_on']))
                                            <div>
                                                <a href="{{$v['icon_on']}}" target="_blank">
                                                    <img src="{{$v['icon_on']}}" />
                                                </a>
                                                <span>删除</span>
                                                <input type="hidden" name="menu[{{$k}}][icon_on]" value="{{$v['icon_on']}}" /></div>
                                        @endif
                                    </div>
					            </span>
                                @if(isset($v['icon']))
                                    <input type="hidden" name="menu[{{$k}}][icon]" value="{{$v['icon']}}" />
                                @endif
                                <span class="input" style="width:40%">
                                    <div class="up_input">
                                        <input type="button" class="ImgUpload_Up" data-id="{{$k}}" value="添加图片" style="width:80px;" />
                                    </div>
                                    <div class="tips">请上传前台显示的当前菜单图标</div>
                                    <div class="img PicDetail_Up">
                                        @if (isset($v['icon_up']) && !empty($v['icon_up']))
                                            <div>
                                                <a href="{{$v['icon_up']}}" target="_blank">
                                                    <img src="{{$v['icon_up']}}" />
                                                </a>
                                                <span>删除</span>
                                                <input type="hidden" name="menu[{{$k}}][icon_up]" value="{{$v['icon_up']}}" />
                                            </div>
                                        @endif
                                    </div>
                                </span>
                                <div class="clear"></div>
                            </div>
                            @else
                                @if(isset($v['icon_on']))
                                    <input type="hidden" name="menu[{{$k}}][icon_on]" value="{{$v['icon_on']}}" />
                                @endif
                                @if(isset($v['icon_up']))
                                    <input type="hidden" name="menu[{{$k}}][icon_up]" value="{{$v['icon_up']}}" />
                                @endif
                                <div class="opt_item rows">
                                    <label>菜单图标：</label>
                                    <span class="input" id="span_type_sun">
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-home fa-2x") checked @endif
                                               value="fa fa-home fa-2x"/> <span class="fa fa-home fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-th-list fa-2x") checked @endif
                                               value="fa fa-th-list fa-2x"/> <span class="fa fa-th-list fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-sitemap fa-2x")checked @endif
                                               value="fa fa-sitemap fa-2x"/> <span class="fa fa-sitemap fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-cart-arrow-down fa-2x")checked @endif
                                               value="fa fa-cart-arrow-down fa-2x"/> <span class="fa fa-cart-arrow-down fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-user fa-2x")checked @endif
                                               value="fa fa-user fa-2x" /> <span class="fa fa-user fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-cart-plus fa-2x")checked @endif
                                               value="fa fa-cart-plus fa-2x" /> <span class="fa fa-cart-plus fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-bar-chart fa-2x")checked @endif
                                               value="fa fa-bar-chart fa-2x" /> <span class="fa fa-bar-chart fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-cloud fa-2x")checked @endif
                                               value="fa fa-cloud fa-2x" /> <span class="fa fa-cloud fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-heart fa-2x")checked @endif
                                               value="fa fa-heart fa-2x" /> <span class="fa fa-heart fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-hourglass fa-2x")checked @endif
                                               value="fa fa-hourglass fa-2x" /> <span class="fa fa-hourglass fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-user-plus fa-2x")checked @endif
                                               value="fa fa-user-plus fa-2x" /> <span class="fa fa-user-plus fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-spinner fa-2x")checked @endif
                                               value="fa fa-spinner fa-2x" /> <span class="fa fa-spinner fa-2x"></span><br/>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-cog fa-2x")checked @endif
                                               value="fa fa-cog fa-2x" /> <span class="fa fa-cog fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-refresh fa-2x")checked @endif
                                               value="fa fa-refresh fa-2x" /> <span class="fa fa-refresh fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-plus-square fa-2x")checked @endif
                                               value="fa fa-plus-square fa-2x" /> <span class="fa fa-plus-square fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-line-chart fa-2x")checked @endif
                                               value="fa fa-line-chart fa-2x" /> <span class="fa fa-line-chart fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-align-justify fa-2x")checked @endif
                                               value="fa fa-align-justify fa-2x" /> <span class="fa fa-align-justify fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-ambulance fa-2x")checked @endif
                                               value="fa fa-ambulance fa-2x" /> <span class="fa fa-ambulance fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-car fa-2x")checked @endif
                                               value="fa fa-car fa-2x" /> <span class="fa fa-car fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-bicycle fa-2x")checked @endif
                                               value="fa fa-bicycle fa-2x" /> <span class="fa fa-bicycle fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-bus fa-2x")checked @endif
                                               value="fa fa-bus fa-2x" /> <span class="fa fa-bus fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-random fa-2x")checked @endif
                                               value="fa fa-random fa-2x" /> <span class="fa fa-random fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-apple fa-2x")checked @endif
                                               value="fa fa-apple fa-2x" /> <span class="fa fa-apple fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-android fa-2x")checked @endif
                                               value="fa fa-android fa-2x" /> <span class="fa fa-android fa-2x"></span>  <br/>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-hourglass fa-2x")checked @endif
                                               value="fa fa-hourglass fa-2x" /> <span class="fa fa-hourglass fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-qq fa-2x")checked @endif
                                               value="fa fa-qq fa-2x" /> <span class="fa fa-qq fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-rebel fa-2x")checked @endif
                                               value="fa fa-rebel fa-2x" /> <span class="fa fa-rebel fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-reddit-alien fa-2x")checked @endif
                                               value="fa fa-reddit-alien fa-2x" /> <span class="fa fa-reddit-alien fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-reddit-square fa-2x")checked @endif
                                               value="fa fa-reddit-square fa-2x" /> <span class="fa fa-reddit-square fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-renren fa-2x")checked @endif
                                               value="fa fa-renren fa-2x" /> <span class="fa fa-renren fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-pied-piper fa-2x")checked @endif
                                               value="fa fa-pied-piper fa-2x" /> <span class="fa fa-pied-piper fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-snapchat-ghost fa-2x")checked @endif
                                               value="fa fa-snapchat-ghost fa-2x" /> <span class="fa fa-snapchat-ghost fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-pied-piper-alt fa-2x")checked @endif
                                               value="fa fa-pied-piper-alt fa-2x" /> <span class="fa fa-pied-piper-alt fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-snapchat-square fa-2x")checked @endif
                                               value="fa fa-snapchat-square fa-2x" /> <span class="fa fa-snapchat-square fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-weixin fa-2x")checked @endif
                                               value="fa fa-weixin fa-2x" /> <span class="fa fa-weixin fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-twitter fa-2x")checked @endif
                                               value="fa fa-twitter fa-2x" /> <span class="fa fa-twitter fa-2x"></span>  <br/>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-envira fa-2x")checked @endif
                                               value="fa fa-envira fa-2x" /> <span class="fa fa-envira fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-sign-language fa-2x")checked @endif
                                               value="fa fa-sign-language fa-2x" /> <span class="fa fa-sign-language fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-volume-control-phone fa-2x")checked @endif
                                               value="fa fa-volume-control-phone fa-2x" /> <span class="fa fa-volume-control-phone fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-balance-scale fa-2x")checked @endif
                                               value="fa fa-balance-scale fa-2x" /> <span class="fa fa-balance-scale fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-bell fa-2x")checked @endif
                                               value="fa fa-bell fa-2x" /> <span class="fa fa-bell fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-birthday-cake fa-2x")checked @endif
                                               value="fa fa-birthday-cake fa-2x" /> <span class="fa fa-birthday-cake fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-book fa-2x")checked @endif
                                               value="fa fa-book fa-2x" /> <span class="fa fa-book fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-camera fa-2x")checked @endif
                                               value="fa fa-camera fa-2x" /> <span class="fa fa-camera fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-cloud-download fa-2x")checked @endif
                                               value="fa fa-cloud-download fa-2x" /> <span class="fa fa-cloud-download fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-comment-o fa-2x")checked @endif
                                               value="fa fa-comment-o fa-2x" /> <span class="fa fa-comment-o fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-comment fa-2x")checked @endif
                                               value="fa fa-comment fa-2x" /> <span class="fa fa-comment fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-commenting fa-2x")checked @endif
                                               value="fa fa-commenting fa-2x" /> <span class="fa fa-commenting fa-2x"></span>  <br/>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-commenting-o fa-2x")checked @endif
                                               value="fa fa-commenting-o fa-2x" /> <span class="fa fa-commenting-o fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-comments fa-2x")checked @endif
                                               value="fa fa-comments fa-2x" /> <span class="fa fa-comments fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-comments-o fa-2x")checked @endif
                                               value="fa fa-comments-o fa-2x" /> <span class="fa fa-comments-o fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-diamond fa-2x")checked @endif
                                               value="fa fa-diamond fa-2x" /> <span class="fa fa-diamond fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-desktop fa-2x")checked @endif
                                               value="fa fa-desktop fa-2x" /> <span class="fa fa-desktop fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-cutlery fa-2x")checked @endif
                                               value="fa fa-cutlery fa-2x" /> <span class="fa fa-cutlery fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-envelope-o fa-2x")checked @endif
                                               value="fa fa-envelope-o fa-2x" /> <span class="fa fa-envelope-o fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-rss fa-2x")checked @endif
                                               value="fa fa-rss fa-2x" /> <span class="fa fa-rss fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-gift fa-2x")checked @endif
                                               value="fa fa-gift fa-2x" /> <span class="fa fa-gift fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-folder fa-2x")checked @endif
                                               value="fa fa-folder fa-2x" /> <span class="fa fa-folder fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-users fa-2x")checked @endif
                                               value="fa fa-users fa-2x" /> <span class="fa fa-users fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-key fa-2x")checked @endif
                                               value="fa fa-key fa-2x" /> <span class="fa fa-key fa-2x"></span>  <br/>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-lock fa-2x")checked @endif
                                               value="fa fa-lock fa-2x" /> <span class="fa fa-lock fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-money fa-2x")checked @endif
                                               value="fa fa-money fa-2x" /> <span class="fa fa-money fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-recycle fa-2x")checked @endif
                                               value="fa fa-recycle fa-2x" /> <span class="fa fa-recycle fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-search fa-2x")checked @endif
                                               value="fa fa-search fa-2x" /> <span class="fa fa-search fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-shopping-cart fa-2x")checked @endif
                                               value="fa fa-shopping-cart fa-2x" /> <span class="fa fa-shopping-cart fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-sliders fa-2x")checked @endif
                                               value="fa fa-sliders fa-2x" /> <span class="fa fa-sliders fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-smile-o fa-2x")checked @endif
                                               value="fa fa-smile-o fa-2x" /> <span class="fa fa-smile-o fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-television fa-2x")checked @endif
                                               value="fa fa-television fa-2x" /> <span class="fa fa-television fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-trophy fa-2x")checked @endif
                                               value="fa fa-trophy fa-2x" /> <span class="fa fa-trophy fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-wheelchair fa-2x")checked @endif
                                               value="fa fa-wheelchair fa-2x" /> <span class="fa fa-wheelchair fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-wheelchair-alt fa-2x")checked @endif
                                               value="fa fa-wheelchair-alt fa-2x" /> <span class="fa fa-wheelchair-alt fa-2x"></span><br/>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-hand-o-down fa-2x")checked @endif
                                               value="fa fa-hand-o-downfa-2x" /> <span class="fa fa-hand-o-down fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-hand-o-left fa-2x")checked @endif
                                               value="fa fa-hand-o-left fa-2x" /> <span class="fa fa-hand-o-left fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-hand-o-right fa-2x")checked @endif
                                               value="fa fa-hand-o-right fa-2x" /> <span class="fa fa-hand-o-right fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-hand-o-up fa-2x")checked @endif
                                               value="fa fa-hand-o-up fa-2x" /> <span class="fa fa-hand-o-up fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-area-chart fa-2x")checked @endif
                                               value="fa fa-area-chart fa-2x" /> <span class="fa fa-area-chart fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-jpy fa-2x")checked @endif
                                               value="fa fa-jpy fa-2x" /> <span class="fa fa-jpy fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-usd fa-2x")checked @endif
                                               value="fa fa-usd fa-2x" /> <span class="fa fa-usd fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-user-md fa-2x")checked @endif
                                               value="fa fa-user-md fa-2x" /> <span class="fa fa-user-md fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-stethoscope fa-2x")checked @endif
                                               value="fa fa-stethoscope fa-2x" /> <span class="fa fa-stethoscope fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-medkit fa-2x")checked @endif
                                               value="fa fa-medkit fa-2x" /> <span class="fa fa-medkit fa-2x"></span>
                                        <input type="radio" name="menu[{{$k}}][icon]"
                                               @if(!empty($v['icon']) && $v['icon'] == "fa fa-shopping-bag fa-6x")checked @endif
                                               value="fa fa-shopping-bag fa-6x" /> <span class="fa fa-shopping-bag fa-6x"></span>
                                    </span>
                                    <div class="clear"></div>
                                </div>
                            @endif
                            <div class="opt_item rows">
                                <label>链接地址：</label>
                                <span class="input"><input type="text" name="menu[{{$k}}][menu_href]" value="<?php echo $v['menu_href']; ?>" class="form_input long_form_input" size="5" maxlength="150"  />
                                    <span class="fc_red">*</span>点击菜单将跳转到该地址
                                </span>
                                <div class="clear"></div>
                            </div>

                            <div class="opt_item rows">
                                <label>登录链接地址：</label>
                                <span class="input">
                                    <input type="text" name="menu[{{$k}}][login_menu_href]" value="<?php echo $v['login_menu_href']; ?>" class="form_input long_form_input" size="5" maxlength="150"  />
                                    <span class="fc_red">*</span>用户登录成功菜单的链接地址;
                                </span>
                                <div class="clear"></div>
                            </div>

                            <div class="opt_item rows">
                                <label>绑定属性：</label>
                                <span class="input">
                                    <select name="menu[{{$k}}][bind_action_attr]">
                                        <option value="0" @if($v['bind_action_attr'] == 0)selected="selected"@endif>不绑定</option>
                                        <option value="1" @if($v['bind_action_attr'] == 1)selected="selected"@endif>绑定分销模块</option>
                                        <option value="2" @if($v['bind_action_attr'] == 2)selected="selected"@endif>绑定购物车模块</option>
                                    </select>
                                </span>
                                <div class="clear"></div>
                            </div>

                            <div class="opt_item rows">
                                <label>排序：</label>
                                <span class="input"><input type="text" name="menu[{{$k}}][menu_order]" value="<?php echo !empty($v['menu_order'])?$v['menu_order'] : 0; ?>" class="form_input" size="5" maxlength="30" required />
                                    <span class="fc_red">*</span>请输入排序数字（首页必须放在第一个）
                                </span>
                                <div class="clear"></div>
                            </div>
                        </div><!--配置项列表end-->
                        @endforeach

                    @if (count($ShopMenu['menu']) < 6)
                    <!--配置项列表start-->
                        <div class="menu_config_list menu_config_list_add">
                            <div class="opt_item rows">
                                <label>菜单名称：</label>
                                <span class="input">
                                    <input type="text" name="menu[<?php echo count($ShopMenu['menu']); ?>][menu_name]" value="" class="form_input" size="5" maxlength="30" notnull />
                                    <span class="fc_red">*</span>前台首页展示名称，不设置则使用系统默认名称；
                                </span>
                                <div class="clear"></div>
                            </div>

                            <div class="opt_item rows">
                                <label>登录状态名称：</label>
                                <span class="input">
                                    <input type="text" name="menu[<?php echo count($ShopMenu['menu']); ?>][login_menu_name]" value="" class="form_input" size="5" maxlength="30" notnull />
                                    <span class="fc_red">*</span>用户登录之后将使用该名称
                                </span>
                                <div class="clear"></div>
                            </div>
                            @if($Shop_Config['Bottom_Style'] == 1) {?>
                            <div class="opt_item rows">
                                <label>菜单图标：</label>
                                <span class="input" style="width:40%">
                                    <div class="up_input">
                                        <input type="button" class="ImgUpload_On" data-id="<?php echo count($ShopMenu['menu']); ?>" value="添加图片" style="width:80px;" />
                                    </div>
                                    <div class="tips">请上传前台显示的当前菜单图标</div>
                                    <div class="img PicDetail">
                                    </div>
                                </span>
                                <span class="input" style="width:40%">
                                    <div class="up_input">
                                        <input type="button" class="ImgUpload_Up" data-id="<?php echo count($ShopMenu['menu']); ?>" value="添加图片" style="width:80px;" />
                                    </div>
                                    <div class="tips">请上传前台显示的当前菜单图标</div>
                                    <div class="img PicDetail_Up">
                                    </div>
                                </span>
                                <div class="clear"></div>
                            </div>
                            @else
                            <div class="opt_item rows">
                                <label>菜单图标：</label>
                                <span class="input" id="span_type_sun">
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-home fa-2x"/> <span class="fa fa-home fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-th-list fa-2x"/> <span class="fa fa-th-list fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-sitemap fa-2x"/> <span class="fa fa-sitemap fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-cart-arrow-down fa-2x"/> <span class="fa fa-cart-arrow-down fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-user fa-2x" /> <span class="fa fa-user fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-cart-plus fa-2x" /> <span class="fa fa-cart-plus fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-bar-chart fa-2x" /> <span class="fa fa-bar-chart fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-cloud fa-2x" /> <span class="fa fa-cloud fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-heart fa-2x" /> <span class="fa fa-heart fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-hourglass fa-2x" /> <span class="fa fa-hourglass fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-user-plus fa-2x" /> <span class="fa fa-user-plus fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-spinner fa-2x" /> <span class="fa fa-spinner fa-2x"></span><br/>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-cog fa-2x" /> <span class="fa fa-cog fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-refresh fa-2x" /> <span class="fa fa-refresh fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-plus-square fa-2x" /> <span class="fa fa-plus-square fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-line-chart fa-2x" /> <span class="fa fa-line-chart fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-align-justify fa-2x" /> <span class="fa fa-align-justify fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-ambulance fa-2x" /> <span class="fa fa-ambulance fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-car fa-2x" /> <span class="fa fa-car fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-bicycle fa-2x" /> <span class="fa fa-bicycle fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-bus fa-2x" /> <span class="fa fa-bus fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-random fa-2x" /> <span class="fa fa-random fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-apple fa-2x" /> <span class="fa fa-apple fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-android fa-2x" /> <span class="fa fa-android fa-2x"></span>  <br/>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-hourglass fa-2x" /> <span class="fa fa-hourglass fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-qq fa-2x" /> <span class="fa fa-qq fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-rebel fa-2x" /> <span class="fa fa-rebel fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-reddit-alien fa-2x" /> <span class="fa fa-reddit-alien fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-reddit-square fa-2x" /> <span class="fa fa-reddit-square fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-renren fa-2x" /> <span class="fa fa-renren fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-pied-piper fa-2x" /> <span class="fa fa-pied-piper fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-snapchat-ghost fa-2x" /> <span class="fa fa-snapchat-ghost fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-pied-piper-alt fa-2x" /> <span class="fa fa-pied-piper-alt fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-snapchat-square fa-2x" /> <span class="fa fa-snapchat-square fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-weixin fa-2x" /> <span class="fa fa-weixin fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-twitter fa-2x" /> <span class="fa fa-twitter fa-2x"></span>  <br/>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-envira fa-2x" /> <span class="fa fa-envira fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-sign-language fa-2x" /> <span class="fa fa-sign-language fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-volume-control-phone fa-2x" /> <span class="fa fa-volume-control-phone fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-balance-scale fa-2x" /> <span class="fa fa-balance-scale fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-bell fa-2x" /> <span class="fa fa-bell fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-birthday-cake fa-2x" /> <span class="fa fa-birthday-cake fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-book fa-2x" /> <span class="fa fa-book fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-camera fa-2x" /> <span class="fa fa-camera fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-cloud-download fa-2x" /> <span class="fa fa-cloud-download fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-comment-o fa-2x" /> <span class="fa fa-comment-o fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-comment fa-2x" /> <span class="fa fa-comment fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-commenting fa-2x" /> <span class="fa fa-commenting fa-2x"></span>  <br/>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-commenting-o fa-2x" /> <span class="fa fa-commenting-o fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-comments fa-2x" /> <span class="fa fa-comments fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-comments-o fa-2x" /> <span class="fa fa-comments-o fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-diamond fa-2x" /> <span class="fa fa-diamond fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-desktop fa-2x" /> <span class="fa fa-desktop fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-cutlery fa-2x" /> <span class="fa fa-cutlery fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-envelope-o fa-2x" /> <span class="fa fa-envelope-o fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-rss fa-2x" /> <span class="fa fa-rss fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-gift fa-2x" /> <span class="fa fa-gift fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-folder fa-2x" /> <span class="fa fa-folder fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-users fa-2x" /> <span class="fa fa-users fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-key fa-2x" /> <span class="fa fa-key fa-2x"></span>  <br/>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-lock fa-2x" /> <span class="fa fa-lock fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-money fa-2x" /> <span class="fa fa-money fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-recycle fa-2x" /> <span class="fa fa-recycle fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-search fa-2x" /> <span class="fa fa-search fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-shopping-cart fa-2x" /> <span class="fa fa-shopping-cart fa-2x"></span>

                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-sliders fa-2x" /> <span class="fa fa-sliders fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-smile-o fa-2x" /> <span class="fa fa-smile-o fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-television fa-2x" /> <span class="fa fa-television fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-trophy fa-2x" /> <span class="fa fa-trophy fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-wheelchair fa-2x" /> <span class="fa fa-wheelchair fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-wheelchair-alt fa-2x" /> <span class="fa fa-wheelchair-alt fa-2x"></span><br/>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-hand-o-downfa-2x" /> <span class="fa fa-hand-o-down fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-hand-o-left fa-2x" /> <span class="fa fa-hand-o-left fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-hand-o-right fa-2x" /> <span class="fa fa-hand-o-right fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-hand-o-up fa-2x" /> <span class="fa fa-hand-o-up fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-area-chart fa-2x" /> <span class="fa fa-area-chart fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-jpy fa-2x" /> <span class="fa fa-jpy fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-usd fa-2x" /> <span class="fa fa-usd fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-user-md fa-2x" /> <span class="fa fa-user-md fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-stethoscope fa-2x" /> <span class="fa fa-stethoscope fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-medkit fa-2x" /> <span class="fa fa-medkit fa-2x"></span>
                                    <input type="radio" name="menu[<?php echo count($ShopMenu['menu']); ?>][icon]" value="fa fa-shopping-bag fa-6x" /> <span class="fa fa-shopping-bag fa-6x"></span>
                                </span>
                                <div class="clear"></div>
                            </div>
                            @endif



                            <div class="opt_item rows">
                                <label>链接地址：</label>
                                <span class="input">
                                    <input type="text" name="menu[<?php echo count($ShopMenu['menu']); ?>][menu_href]" value="" class="form_input long_form_input" size="5" maxlength="150" />
                                    <span class="fc_red">*</span>点击菜单将跳转到该地址
                                </span>
                                <div class="clear"></div>
                            </div>

                            <div class="opt_item rows">
                                <label>登录链接地址：</label>
                                <span class="input">
                                    <input type="text" name="menu[<?php echo count($ShopMenu['menu']); ?>][login_menu_href]" value="" class="form_input long_form_input" size="5" maxlength="150" />
                                    <span class="fc_red">*</span> 用户登录成功菜单的链接地址;
                                </span>
                                <div class="clear"></div>
                            </div>

                            <div class="opt_item rows">
                                <label>绑定属性：</label>
                                <span class="input">
                                    <select name="menu[<?php echo count($ShopMenu['menu']); ?>][bind_action_attr]">
                                        <option value="0">不绑定</option>
                                        <option value="1">绑定分销模块</option>
                                        <option value="2">绑定购物车模块</option>
                                    </select>
                                </span>
                                <div class="clear"></div>
                            </div>

                            <div class="opt_item rows">
                                <label>排序：</label>
                                <span class="input">
                                    <input type="text" name="menu[<?php echo count($ShopMenu['menu']); ?>][menu_order]" value="<?php echo count($ShopMenu['menu']); ?>" class="form_input" size="5" maxlength="30" required />
                                    <span class="fc_red">*</span>请输入排序数字（首页必须放在第一个）
                                </span>
                                <div class="clear"></div>
                            </div>
                        </div><!--配置项列表end-->
                        @endif

                        <div class="opt_item rows no-border">
                            <label></label>
                            <span class="input no-border">
                                <input type="submit" id="submit_button" class="btn_green" value="提交保存">
                            </span>
                            <div class="clear"></div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>

    $(function(){
        $('.menu_list a span.delete').click(function(){
            if (confirm('确定删除该菜单？删除后将无法恢复！')) {
                menu_id = $(this).attr('data-id');
                $.get('{{route('admin.shop.foot_menu_del')}}', {'menuId':menu_id, 'method' : 'ajaxpost'}, function(data){
                    alert(data.msg);
                    window.location.reload();
                }, 'json');
            };
        });
    });

    function show_tabs_contents(numId)
    {
        $('.menu_list a').removeClass('current');
        $('.menu_list a').each(function(index){
            if(index == numId) {
                $(this).addClass('current');
            }
        });
        $('.menu_config_list').hide();
        $('.menu_config_list_'+numId).show();
    }

</script>

@endsection