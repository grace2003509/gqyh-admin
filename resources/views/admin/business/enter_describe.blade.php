@extends('admin.layouts.main')
@section('ancestors')
    <li>商家设置</li>
@endsection
@section('page', '商家入驻描述设置')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <link rel="stylesheet" href="/static/js/kindeditor/themes/default/default.css" />
    <script type='text/javascript' src="/static/js/kindeditor/kindeditor-min.js"></script>
    <script type='text/javascript' src="/static/js/kindeditor/lang/zh_CN.js"></script>

    <div class="box">

        <div id="iframe_page">
            <div class="iframe_content">

                <div id="products" class="r_con_wrap">

                    @include('admin.business.menu_top')

                    <form class="r_con_form" id="group_edit" method="post" action="{{route('admin.business.describe_update')}}">
                        {{csrf_field()}}
                        <div class="rows">
                            <label>签署协议</label>
                            <span class="input">
                                <textarea class="ckeditor" name="BaoZhengJin" style="width:700px; height:300px;">{{$item["BaoZhengJin"]}}</textarea>
                            </span>
                            <div class="clear"></div>
                        </div>

                        <div class="rows">
                            <label>商家入驻付款页面描述</label>
                            <span class="input">
                                <textarea class="ckeditor" name="NianFei" style="width:700px; height:300px;">{{$item["NianFei"]}}</textarea>
                            </span>
                            <div class="clear"></div>
                        </div>

                        <div class="rows">
                            <label>支付年费页面描述</label>
                            <span class="input">
                                <textarea class="ckeditor" name="JieSuan" style="width:700px; height:300px;">{{$item["JieSuan"]}}</textarea>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>追加保证金页面描述</label>
                            <span class="input">
                              <textarea class="ckeditor" name="bond_desc" style="width:700px; height:300px;">
                                  @if(!empty($item["bond_desc"])) {{$item["bond_desc"]}} @endif
                              </textarea>
                            </span>
                            <div class="clear"></div>
                        </div>

                        <div class="rows">
                            <label>手机端商家入驻提示电脑端完成入驻</label>
                            <span class="input">
                              <textarea class="ckeditor" name="mobile_desc" style="width:700px; height:300px;">
                                  @if(!empty($item["mobile_desc"])) {{$item["mobile_desc"]}} @endif
                              </textarea>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label></label>
                            <span class="input">
                                <input type="submit" class="btn_green" name="submit_button" value="提交保存" />
                                <input type="hidden" name="submit_enter" value="1" />
                            </span>
                            <div class="clear"></div>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>

    <script>
        KindEditor.ready(function(K) {
            K.create('textarea[name="BaoZhengJin"]', {
                themeType : 'simple',
                filterMode : false,
                uploadJson : '/admin/upload_json?TableField=web_column',
                fileManagerJson : '/admin/file_manager_json',
                allowFileManager : true,

            });

            K.create('textarea[name="NianFei"]', {
                themeType : 'simple',
                filterMode : false,
                uploadJson : '/admin/upload_json?TableField=web_column',
                fileManagerJson : '/admin/file_manager_json',
                allowFileManager : true,

            });

            K.create('textarea[name="JieSuan"]', {
                themeType : 'simple',
                filterMode : false,
                uploadJson : '/admin/upload_json?TableField=web_column',
                fileManagerJson : '/admin/file_manager_json',
                allowFileManager : true,

            });

            K.create('textarea[name="bond_desc"]', {
                themeType : 'simple',
                filterMode : false,
                uploadJson : '/admin/upload_json?TableField=web_column',
                fileManagerJson : '/admin/file_manager_json',
                allowFileManager : true,

            });

            K.create('textarea[name="mobile_desc"]', {
                themeType : 'simple',
                filterMode : false,
                uploadJson : '/admin/upload_json?TableField=web_column',
                fileManagerJson : '/admin/file_manager_json',
                allowFileManager : true,

            });
        })
    </script>
@endsection