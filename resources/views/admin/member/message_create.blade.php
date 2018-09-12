@extends('admin.layouts.main')
@section('ancestors')
    <li>消息管理</li>
@endsection
@section('page', '发布消息')
@section('subcontent')

<link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/user.css' rel='stylesheet' type='text/css' />

<script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<link rel="stylesheet" href="/admin/js/kindeditor/themes/default/default.css" />
<script type='text/javascript' src="/admin/js/kindeditor/kindeditor-min.js"></script>
<script type='text/javascript' src="/admin/js/kindeditor/lang/zh_CN.js"></script>

<div class="box">
    <div id="iframe_page">
        <div class="iframe_content">

            <div id="user_message" class="r_con_wrap">

                <form id="user_message_form" class="r_con_form" method="post" action="{{route('admin.member.message_store')}}">
                    {{csrf_field()}}
                    <div class="rows">
                        <label>内容标题</label>
                        <span class="input">
                          <input name="Title" value="{{old('Title')}}" type="text" class="form_input" size="40" maxlength="100" required>
                          <span class="fc_red">*</span>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows">
                        <label>详细内容</label>
                        <span class="input">
                          <textarea class="ckeditor" name="Description" style="width:500px; height:300px;">{{old('Description')}}</textarea>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows">
                        <label></label>
                        <span class="input">
                          <input type="submit" class="btn_green" value="提交保存" name="submit_btn">
                          <a href="{{route('admin.member.message_index')}}" class="btn_gray">返回</a>
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
            K.create('textarea[name="Description"]', {
                themeType : 'simple',
                filterMode : false,
                uploadJson : '/member/upload_json.php?TableField=message',
                fileManagerJson : '/member/file_manager_json.php',
                allowFileManager : true,
                items : [
                    'source', '|', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                    'removeformat', 'undo', 'redo', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist', 'insertunorderedlist', '|', 'emoticons', 'image', 'link' , '|', 'preview']
            });
        })
    </script>
@endsection