@extends('admin.layouts.main')
@section('ancestors')
    <li>商城设置</li>
@endsection
@section('page', '开关设置')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <link rel="stylesheet" href="/admin/js/kindeditor/themes/default/default.css" />
    <script type='text/javascript' src="/admin/js/kindeditor/kindeditor-min.js"></script>
    <script type='text/javascript' src="/admin/js/kindeditor/lang/zh_CN.js"></script>
    <script type='text/javascript' src='/static/js/plugins/layer/layer.js'></script>
    <script type='text/javascript' src='/static/js/plugins/layer/layer.js'></script>
    <script type='text/javascript' src='/admin/js/material.js'></script>
    {{--<script type='text/javascript' src='/admin/js/global.js'></script>--}}

    <style>
        .sun_input{height: 28px;line-height: 28px; border: 1px solid #ddd;background: #fff;border-radius: 5px; padding: 0 5px;}
        .file_input{background: #1584D5; height: 30px;color: #fff;border: none;border-radius: 2px;cursor: pointer;width:80px;}
        .LogoUpload{float: left;}
        .LogoDetail{float: left;}
        .LogoDetail img{width:30px;height:30px;}
        .photo_config{width:110px;height:40px; margin:0 auto;}
        .form_select_sun{height:32px;border:1px solid #ddd;padding:5px;vertical-align:middle;border-radius: 5px;}

    　　 td a:link { text-decoration: none;}
    　　 td a:active { text-decoration:none}
    　　 td a:hover { text-decoration:none;}
    　　 td a:visited { text-decoration: none;}
    </style>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">

                <div id="iframe_page">
                    <div class="iframe_content">

                        <div id="user_profile" class="r_con_wrap">
                            <table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                                <thead>
                                    <tr>
                                        <td>标题</td>
                                        <td>图片</td>
                                        <td>URL</td>
                                        <td>类型</td>
                                        <td>操作</td>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($perm_config as $key=>$value)
                                    <tr>
                                        <input type="hidden" name="" class="Permission_ID" value="{{$value['Permission_ID']}}">
                                        <td>{{$value['Perm_Name']}} </td>
                                        <td>
                                            <div class="photo_config">
                                                @if($value['Perm_Field'] != 'withdraw')
                                                <img src="{{$value['Perm_Picture']}}" style="width:30px;height:30px;">
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{$value['Perm_Url']}}</td>
                                        <td>{{$switchplace[$value['Perm_Tyle']]}}</td>
                                        <td>
                                            @if($value['Perm_On'] == 1)
                                                <a href="{{route('admin.shop.on_off_edit', ['id'=>$value['Permission_ID']])}}">
                                                    <img src="/admin/images/ico/off.gif" class="Withdraw" Perm_On="0"  Status="{{$value['Permission_ID']}}" />
                                                </a>
                                            @else
                                                <a href="{{route('admin.shop.on_off_edit', ['id'=>$value['Permission_ID']])}}">
                                                    <img src="/admin/images/ico/on.gif" class="Withdraw" Perm_On="1" Status="{{$value['Permission_ID']}}" />
                                                </a>
                                            @endif
                                            <img src="/admin/images/ico/xiugai.png"  data-target="#edit_url_btn" data-toggle= 'modal' onclick="Values({{$value}})"
                                                 style="width:25px;height:25px;" class="modification" Permission_ID="{{$value['Permission_ID']}}" />
{{--                                            @if(empty($value['Perm_Field']))--}}
                                                <a href="{{route('admin.shop.on_off_del', ['id' => $value['Permission_ID']])}}">
                                                    <img src="/admin/images/ico/del.gif" style="width:25px;height:25px;" class="deleted" Permission_ID="{{$value['Permission_ID']}}"/>
                                                </a>
                                            {{--@endif--}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <form class="r_con_form" action="{{route('admin.shop.on_off_store')}}" style="margin-top:10px" method="post">
                                {{csrf_field()}}
                                <div class="rows">
                                    <label>其他字段</label>
                                    <span class="input">
				                        <div class="tips"></div>
                                        <table border="0" cellpadding="5" cellspacing="0" style="width: 100%;text-align: center;" class="reverve_field_table">
                                            <thead>
                                                <tr>
                                                    <td>标题</td>
                                                    <td>图片</td>
                                                    <td>URL</td>
                                                    <td>类型</td>
                                                    {{--<td>操作</td>--}}
                                                </tr>
                                            </thead>
                                            <tbody class="form_list">
                                                <tr>
                                                    <td><input type="text" class="sun_input" name="name" value=""></td>
                                                    <td>
                                                        <div class="photo_config">
                                                            <input name="LogoUpload" class="file_input LogoUpload" type="button"  value="上传图标" />
                                                            <input name="logo_num" type="hidden" value="">
                                                            <div class="img LogoDetail"></div>
                                                            <input type="hidden" class="Logo" name="Logo" value="" />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="http_url" value="" class="sun_input menu_url" size="30" maxlength="200"  />
                                                        {{--<img src="/admin/images/ico/search.png" style="width:22px; height:22px; margin:0px 0px 0px 5px; vertical-align:middle; cursor:pointer" id="btn_select_url" class="http_url_sun" key=""/>--}}
                                                    </td>
                                                    <td>
                                                        <select name="Tyle_IS">
                                                            <option value="1">分销中心</option>
                                                            <option value="2">个人中心</option>
                                                        </select>
                                                    </td>
                                                    {{--<td>
                                                        <a href="javascript:void(0);" class="form_add">
                                                            <img src="/admin/images/ico/add.gif" />
                                                        </a>
                                                    </td>--}}
                                                </tr>
                                            </tbody>
                                        </table>
			                        </span>
                                    <div class="clear"></div>
                                </div>
                                <div class="rows">
                                    <label>&nbsp;</label>
                                    <span class="input">
                                        <input type="submit" class="btn_ok" style="margin-left: 30%;" name="submit_button" value="提交保存" />
                                        {{--<a href="index.php" class="btn_cancel">返回</a>--}}
                                    </span>
                                    <div class="clear"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{--//修改路径窗口弹出--}}
    <div class="modal fade" id="edit_url_btn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="width: 700px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        修改路径信息
                    </h4>
                </div>

                <form class="r_con_form" id="edit_url_form" action="" style="margin-top:10px" method="post">
                    {{csrf_field()}}
                    <div class="rows">
                        <span class="input" style="width: 95%;float: none">
                            <table border="0" cellpadding="5" cellspacing="0" style="width: 100%;text-align: center;" class="reverve_field_table">
                                <thead>
                                    <tr>
                                        <td>标题</td>
                                        <td>图片</td>
                                        <td>URL</td>
                                        <td>类型</td>
                                        {{--<td>操作</td>--}}
                                    </tr>
                                </thead>
                                <tbody class="form_list">
                                    <tr>
                                        <td>
                                            <input type="text" class="sun_input" id="edit_name_default" name="name" value="">
                                        </td>
                                        <td>
                                            <div class="photo_config">
                                                <input name="LogoUpload" class="file_input LogoUpload" type="button"  value="上传图标" />
                                                <input name="logo_num" id="edit_logo_num" type="hidden" value="">
                                                <div class="img LogoDetail">
                                                    <img id="edit_img_default" src="" style="width:30px;height:30px;">
                                                </div>
                                                <input type="hidden" id="edit_logo_default" class="Logo" name="Logo" value="" />
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" name="http_url" id="edit_http_url_default" value="" class="sun_input menu_url" size="30" maxlength="200"  />
                                            {{--<img src="/admin/images/ico/search.png" style="width:22px; height:22px; margin:0px 0px 0px 5px; vertical-align:middle; cursor:pointer" id="btn_select_url" class="http_url_sun" key=""/>--}}
                                        </td>
                                        <td>
                                            <select name="Tyle_IS" id="edit_Tyle_Is_default">
                                                <option value="1">分销中心</option>
                                                <option value="2">个人中心</option>
                                            </select>
                                        </td>
                                        {{--<td>
                                            <a href="javascript:void(0);" class="form_add">
                                                <img src="/admin/images/ico/add.gif" />
                                            </a>
                                        </td>--}}
                                    </tr>
                                </tbody>
                            </table>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows" style="text-align: center">
                        {{--<label>&nbsp;</label>--}}
                        <span class="input"  style="width: 95%;margin-left: 40%; border-left: 0px">
                            <input type="submit" style="display:block; height:30px; line-height:30px; background-color: #1584D5;  border:none; color:#fff; width:145px; border-radius:5px; text-align:center; text-decoration:none; margin-right:10px;"
                                   name="submit_button" value="提交保存" />
                            {{--<a href="index.php" class="btn_cancel">返回</a>--}}
                        </span>
                        <div class="clear"></div>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>


    <script>
        KindEditor.ready(function(K) {
            var editor = K.editor({
                uploadJson : '{{route('admin.upload_json')}}',
                fileManagerJson : '{{route('admin.file_manager_json')}}',
                showRemote : true,
                allowFileManager : true,
            });

            $(document).on('click', '.LogoUpload', function(){
                var log_num = $(this).next().val();
                var logo = '.Logo'+log_num ;
                var LogoDetail = '.LogoDetail'+log_num ;
                editor.loadPlugin('image', function(){
                    editor.plugin.imageDialog({
                        imageUrl : K(logo).val(),
                        clickFn : function(url, title, width, height, border, align){
                            K(logo).val(url);
                            K(LogoDetail).html('<img src="'+url+'" />');
                            editor.hideDialog();
                        }
                    });
                });
            });

            K('#LogoUpload_er').click(function(){
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
        })

        /*$('.modification').click(function(){
            var Permission_ID = $(this).attr('Permission_ID');
            create_layer('选择链接', '/admin/shop/on_off_edit?dialog=1&Permission_ID='+Permission_ID,1100,600);
        });*/
        function Values(compay) {
            var url = '/admin/shop/on_off_update/'+compay['Permission_ID'];
            $('#edit_name_default').val(compay['Perm_Name']);
            $('#edit_img_default').attr('src',compay['Perm_Picture']);
            $('#edit_logo_default').val(compay['Perm_Picture']);
            $('#edit_http_url_default').val(compay['Perm_Url']);
            $('#edit_Tyle_Is_default').val(compay['Perm_Tyle']);
            $("#edit_url_form").attr('action',url);
        }


        $(document).on('click', '.http_url_sun', function(){
            var key = $(this).attr('key');
            create_layer('选择链接', '/admin/base/sys_url?dialog=1&input=menu&key=' + key,900,500);
        });



        function create_layer(title, url, width, height){
            var callback = arguments[6] ? arguments[6] : function(){};
            layer.open({
                type: 2,
                title: title,
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: [width+'px', height+'px'],
                content: url,
                end:function(){
                    if(callback != undefined){
                        callback();
                    }
                }
            });
        }


        function auto_get_url (obj){
            var num = $(".form_list tr").length;
            $('.menu_url'+num).html($(this).text());
        }

    </script>

@endsection