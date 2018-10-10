@extends('admin.layouts.main')
@section('ancestors')
    <li>商家管理</li>
@endsection
@section('page', '一键导航')
@section('subcontent')

<link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/web.css' rel='stylesheet' type='text/css' />

<script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<script type='text/javascript' src='/admin/js/global.js'></script>
<link rel="stylesheet" href="/admin/js/kindeditor/themes/default/default.css" />
<script type='text/javascript' src="/admin/js/kindeditor/kindeditor-min.js"></script>
<script type='text/javascript' src="/admin/js/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript" src="/admin/js/web.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak={{$ak_baidu}}"></script>

<div class="box">
    <div id="iframe_page">
        <div class="iframe_content">

            <div id="lbs" class="r_con_wrap">
                <form id="lbs_form" class="r_con_form" method="post" action="/admin/web/lbs_save">
                    {{csrf_field()}}
                    <div class="rows">
                        <label>商家名称</label>
                        <span class="input">
                            <input name="StoresName" value="{{$rsConfig["Stores_Name"]}}" type="text" class="form_input" size="30" maxlength="100" required>
                            <span class="fc_red">*</span>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows not_lbs">
                        <label>详细地址</label>
                        <span class="input">
                            <input name="Address" id="Address" value="{{$rsConfig["Stores_Address"]}}" type="text" class="form_input" size="45" maxlength="100" required>
                            <span class="primary" id="Primary">定位</span> <span class="fc_red">*</span><br />
                            <div class="tips">如果输入地址后点击定位按钮无法定位，请在地图上直接点击选择地点</div>
                            <div id="map"></div>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows not_lbs">
                        <label>门店图片</label>
                        <span class="input">
                            <div class="upload_file">
                                <div>
                                    <div class="file" style="margin:10px;">
                                        <input name="ImgUploadUpload" id="ImgUploadUpload" type="button" style="width:120px" value="上传图片" />
                                        <input type="hidden" name="ImgUpload" id="ImgUpload" value=" @if($rsConfig["Stores_ImgPath"]) {{$rsConfig["Stores_ImgPath"]}} @else /static/api/web/images/leader.jpg @endif" />
                                    </div>
                                    <div class="tips">大图尺寸建议：640*360px</div>
                                    <div class="clear"></div>
                                </div>
                                <div class="img" id="ImgUploadDetail">
                                    <img src="{{$rsConfig["Stores_ImgPath"]}}" />
                                </div>
                            </div>
                          </span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows not_lbs">
                        <label>门店介绍</label>
                        <span class="input">
                            <textarea name="StoresDescription">{{$rsConfig["Stores_Description"]}}</textarea>
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

                    <input type="hidden" name="PrimaryLng" value="@if(empty($rsConfig["Stores_PrimaryLng"]))113.676832 @else {{$rsConfig["Stores_PrimaryLng"]}} @endif">
                    <input type="hidden" name="PrimaryLat" value="@if(empty($rsConfig["Stores_PrimaryLat"]))34.780696 @else {{$rsConfig["Stores_PrimaryLat"]}} @endif">
                    <input type="hidden" name="do_action" value="web.lbs">
                </form>
            </div>

        </div>
    </div>

</div>

<script>

    KindEditor.ready(function(K) {
        var editor = K.editor({
            uploadJson : '/admin/upload_json?TableField=web_article',
            fileManagerJson : '/admin/file_manager_json',
            showRemote : true,
            allowFileManager : true,
        });

        K('#ImgUploadUpload').click(function(){
            editor.loadPlugin('image', function(){
                editor.plugin.imageDialog({
                    imageUrl : K('#ImgUpload').val(),
                    clickFn : function(url, title, width, height, border, align){
                        K('#ImgUpload').val(url);
                        K('#ImgUploadDetail').html('<img src="'+url+'" />');
                        editor.hideDialog();
                    }
                });
            });
        });

    });

    $(document).ready(web_obj.lbs_init);
</script>

@endsection