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
                                <?php foreach($perm_config as $ky=>$value){?>
                                <input type="hidden" name="" class="Permission_ID" value="<?=$value['Permission_ID']?>">
                                <td><?=$value['Perm_Name']?></td>
                                <td>
                                    <div class="photo_config">
                                        <?php if($value['Perm_Field'] == 'withdraw') {?>
						                <?php } else {?>
                                        <img src="<?=$value['Perm_Picture']?>" style="width:30px;height:30px;">
                                        <?php }?>
                                    </div>
                                </td>
                                <td><?=$value['Perm_Url']?></td>
                                <td><?=$switchplace[$value['Perm_Tyle']]?></td>
                                <td>
                                    <?php if($value['Perm_On'] == 1){?>
                                    <img src="/admin/images/ico/off.gif" class="Withdraw" Perm_On="0"  Status="<?=$value['Permission_ID']?>" />
                                    <?php }else{?>
                                    <img src="/admin/images/ico/on.gif" class="Withdraw" Perm_On="1" Status="<?=$value['Permission_ID']?>" />
                                    <?php }?>
                                    <img src="/admin/images/ico/xiugai.png" style="width:25px;height:25px;" class="modification" Permission_ID="<?=$value['Permission_ID']?>" />
                                    <?php if(empty($value['Perm_Field'])){?>
                                    <img src="/admin/images/ico/del.gif" style="width:25px;height:25px;" class="deleted" Permission_ID="<?=$value['Permission_ID']?>"/>
                                    <?php }?>
                                </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <form class="r_con_form" action="{{route('admin.shop.on_off_update')}}" style="margin-top:10px" method="post">
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
                                                    <td>操作</td>
                                                </tr>
                                            </thead>
                                            <tbody class="form_list">
                                                <tr>
                                                    <td><input type="text" class="sun_input" name="name[]" value=""></td>
                                                    <td>
                                                        <div class="photo_config">
                                                            <input name="LogoUpload[]" class="file_input LogoUpload" type="button"  value="上传图标" />
                                                            <input name="logo_num" type="hidden" value="">
                                                            <div class="img LogoDetail"></div>
                                                            <input type="hidden" class="Logo" name="Logo[]" value="" />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="http_url[]" value="" class="sun_input menu_url" size="30" maxlength="200"  />
                                                        <img src="/admin/images/ico/search.png" style="width:22px; height:22px; margin:0px 0px 0px 5px; vertical-align:middle; cursor:pointer" id="btn_select_url" class="http_url_sun" key=""/>
                                                    </td>
                                                    <td>
                                                        <select name="Tyle_IS[]">
                                                            <option value="1">分销中心</option>
                                                            <option value="2">个人中心</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0);" class="form_add">
                                                            <img src="/admin/images/ico/add.gif" />
                                                        </a>
                                                    </td>
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
                                        <a href="index.php" class="btn_cancel">返回</a>
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


        $('.form_add').click(function(){
            var num = $(".form_list tr").length;
            var TelHtml='<tr><td>' +
                '<input type="text" class="sun_input" name="name[]" value="">' +
                '</td>' +
                '<td>' +
                '<div class="photo_config">' +
                '<input name="LogoUpload[]" class="file_input  LogoUpload" type="button"  value="上传图标" />' +
                '<input name="logo_num" type="hidden" value="'+num+'">' +
                '<div class="img LogoDetail LogoDetail'+num+'"></div>' +
                '<input type="hidden" class="Logo Logo'+num+'" name="Logo[]" value="" />' +
                '</div></td><td>' +
                '<input type="text" name="http_url[]" value="" class="sun_input menu_url'+num+'" size="30" maxlength="200" />' +
                '<img src="/admin/images/ico/search.png" style="width:22px; height:22px; margin:0px 0px 0px 5px; vertical-align:middle; cursor:pointer" id="btn_select_url" class="http_url_sun" key="'+num+'"/>' +
                '</td><td>' +
                '<select name="Tyle_IS[]">' +
                '<option value="1">分销中心</option>' +
                '<option value="2">个人中心</option>' +
                '</select></td><td>' +
                '<a href="javascript:void(0);" onclick="TelDel(this)">' +
                '<img src="/admin/images/ico/del.gif" />' +
                '</a></td></tr>';
            $('.form_list tr:last').after(TelHtml);
        });
        function TelDel(DelDem){
            $(DelDem).parent().parent().remove();
        }

        $(".deleted").click(function(){
            var Perm_ID = $(this).attr('Permission_ID');
            if(confirm('您确定要删除吗？')){
                $.get('?','action=get_delete&Perm_ID='+Perm_ID,function(data){
                    if(data.status == 1){
                        alert('删除成功！');
                        window.location.href= "";
                    }else{
                        alert('删除失败！');
                    }
                },'json');
            }
        });
        $(".Withdraw").click(function(){
            var Perm_ID = $(this).attr('Status');
            var Perm_On = $(this).attr('Perm_On');
            $.get('?','action=get_Withdraw&Perm_ID='+Perm_ID+'&Perm_On='+Perm_On,function(data){
                if(data.status == 1){
                    alert('修改成功！');
                    window.location.href= "";
                }else{
                    alert('修改失败！');
                }
            },'json');
        });
        /*$('.modification').click(function(){
            var Permission_ID = $(this).attr('Permission_ID');
            create_layer('选择链接', '/admin/shop/on_off_edit?dialog=1&Permission_ID='+Permission_ID,1100,600);
        });*/
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