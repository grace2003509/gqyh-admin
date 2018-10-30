@extends('admin.layouts.main')
@section('ancestors')
    <li>商家设置</li>
@endsection
@section('page', '注册页面描述设置')
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
                            <label>banner图</label>
                            <span class="input">
                                <div class="col-sm-5 must field">
                                    <input type="hidden" id="bannerimgPath"
                                           @if(!empty($item['bannerimg']))
                                                   value="{{$item['bannerimg']}}"
                                           @else
                                                   value=""
                                           @endif data-validate="required:banner图必须填写" name="bannerimg" />
                                    <input type="button" id="bannerimgUpload" value="添加图片" style="width:80px;" />
                                    <span class="tips">&nbsp;&nbsp;建设尺寸：1920px*542px</span>
                                    <div class="img" id="bannerimgDetail" style="margin-top:8px">
                                        @if(!empty($item["bannerimg"]))
                                            <img src="{{$item["bannerimg"]}}" width="120" />
                                        @endif
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <p class="form-control-static">
                                        <span class="help-inline"></span>
                                    </p>
                                </div>
                            </span>
                            <div class="clear"></div>
                        </div>

                        <div class="rows">
                            <label>为什么要加入我们描述</label>
                            <span class="input">
                              <textarea class="ckeditor" name="join_desc" style="width:700px; height:300px;">{{$item["join_desc"]}}</textarea>
                            </span>
                            <div class="clear"></div>
                        </div>

                        <div class="rows">
                            <label></label>
                            <span class="input">
                                <input type="submit" class="btn_green" name="submit_button" value="提交保存" />
                                <input type="hidden" name="submit_register" value="1" />
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
            K.create('textarea[name="join_desc"]', {
                themeType : 'simple',
                filterMode : false,
                uploadJson : '/admin/upload_json?TableField=web_column',
                fileManagerJson : '/admin/file_manager_json',
                allowFileManager : true,

            });
        });

        KindEditor.ready(function(K) {
            var editor = K.editor({
                uploadJson : '/admin/upload_json?TableField=web_article',
                fileManagerJson : '/admin/file_manager_json',
                showRemote : true,
                allowFileManager : true,
            });
            K('#bannerimgUpload').click(function(){
                editor.loadPlugin('image', function(){
                    editor.plugin.imageDialog({
                        imageUrl : K('#bannerimgPath').val(),
                        clickFn : function(url, title, width, height, border, align){
                            K('#bannerimgPath').val(url);
                            K('#bannerimgDetail').html('<img src="'+url+'" width="120" />');
                            editor.hideDialog();
                        }
                    });
                });
            });
        })
    </script>
@endsection