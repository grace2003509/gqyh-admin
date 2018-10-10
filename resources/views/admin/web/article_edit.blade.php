@extends('admin.layouts.main')
@section('ancestors')
    <li>微官网</li>
@endsection
@section('page', '编辑内容')
@section('subcontent')
    <link href='/admin/css/global.css' rel='stylesheet' type='text/css'/>
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css'/>
    <link href='/admin/css/web.css' rel='stylesheet' type='text/css'/>

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script src="/admin/js/global.js"></script>
    <script src="/admin/js/web.js"></script>
    <link rel="stylesheet" href="/admin/js/kindeditor/themes/default/default.css" />
    <script type='text/javascript' src="/admin/js/kindeditor/kindeditor-min.js"></script>
    <script type='text/javascript' src="/admin/js/kindeditor/lang/zh_CN.js"></script>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">

                <div id="column" class="r_con_wrap">
                    <form class="r_con_form" method="post" action="/admin/web/article_update/{{$rsArticle["Article_ID"]}}" id="article_form">
                        {{csrf_field()}}
                        <div class="rows">
                            <label>排序</label>
                            <span class="input">
                                <input name="Index" value="{{$rsArticle["Article_Index"]}}" type="number" class="form_input" size="10" required>
                                越大越靠后
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>内容标题</label>
                            <span class="input">
                                <input name="Title" value="{{$rsArticle["Article_Title"]}}" type="text" class="form_input" size="40" maxlength="50" required>
                                <span class="fc_red">*</span>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>隶属栏目</label>
                            <span class="input">
                                <select name="Column_ID" required>
                                    @foreach($Columns as $Column){
                                          <option value="{{$Column['Column_ID']}}" @if($rsArticle["Column_ID"] == $Column['Column_ID']) selected @endif>{{$Column['Column_Name']}}</option>
                                          @foreach($Column['child'] as $item)
                                              <option value="{{$item['Column_ID']}}" @if($rsArticle["Column_ID"] == $item['Column_ID']) selected @endif> └ {{$item['Column_Name']}}</option>
                                          @endforeach
                                    @endforeach
                                </select>
                                <span class="fc_red">*</span>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>上传图片</label>
                            <span class="input">
                                <span class="upload_file">
                                    <div>
                                        <div class="up_input">
                                            <input id="ImgUpload" name="ImgUpload" type="button" style="width:80px" value="上传图片">
                                            <input type="hidden" id="ImgPath" name="ImgPath" value="{{$rsArticle["Article_ImgPath"]}}" />
                                        </div>
                                        <div class="tips">大图尺寸建议：420*300px</div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="img" id="ImgDetail">
                                        <img src="{{$rsArticle["Article_ImgPath"]}}" width="120">
                                    </div>
                                </span>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>页面链接</label>
                            <span class="input opt">
                              <input type="checkbox" value="1" name="Link" @if($rsArticle["Article_Link"] == 1) checked @endif />
                              <span id="LinkUrl_span">
                                  <input name="LinkUrl" value="{{$rsArticle["Article_LinkUrl"]}}" type="url" class="form_input" size="40" id="web_common_url" >
                              </span>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows" id="BriefDescription_rows">
                            <label>简短介绍</label>
                            <span class="input">
                                <textarea class="txetarea" name="BriefDescription">{{$rsArticle["Article_BriefDescription"]}}</textarea>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows" id="Description_rows">
                            <label>详细内容</label>
                            <span class="input">
                                <textarea name="Description" style="width:100%;height:400px;visibility:hidden;">{{$rsArticle["Article_Description"]}}</textarea>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label></label>
                            <span class="input">
                                <input type="submit" class="btn_green" value="提交保存" name="submit_btn">
                                <a href="/admin/web/article_index" class="btn_gray">返回</a>
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
                uploadJson : '/admin/upload_json/TableField=web_column',
                fileManagerJson : '/admin/file_manager_json',
                allowFileManager : true,
                items : [
                    'source', '|', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                    'removeformat', 'undo', 'redo', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist', 'insertunorderedlist', '|', 'emoticons', 'image', 'link' , '|', 'preview']
            });
        });
        KindEditor.ready(function(K){
            var editor = K.editor({
                uploadJson : '/admin/upload_json?TableField=web_column',
                fileManagerJson : '/admin/file_manager_json',
                showRemote : true,
                allowFileManager : true,
            });
            K('#ImgUpload').click(function() {
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl : K('#ImgPath').val(),
                        clickFn : function(url, title, width, height, border, align) {
                            K('#ImgPath').val(url);
                            K('#ImgDetail').html('<img src="'+url+'" />');
                            editor.hideDialog();
                        }
                    });
                });
            });
            K('#FUpload').click(function() {
                editor.loadPlugin('image', function() {
                    editor.plugin.imageDialog({
                        imageUrl : K('#FPath').val(),
                        clickFn : function(url, title, width, height, border, align) {
                            K('#FPath').val(url);
                            K('#FDetail').html('<img src="'+url+'" />');
                            editor.hideDialog();
                        }
                    });
                });
            });
        });

        $(document).ready(function(){
            web_obj.article_edit_init();
        });
    </script>
@endsection