@extends('admin.layouts.main')
@section('ancestors')
    <li>微官网</li>
@endsection
@section('page', '编辑栏目')
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
                    <form id="column_form" class="r_con_form" method="post"
                          action="{{route('admin.web.column_update', ['id' => $rsColumn["Column_ID"]])}}">
                        {{csrf_field()}}
                        <div class="rows">
                            <label>栏目排序</label>
                            <span class="input">
                              <input name="Index" value="{{$rsColumn["Column_Index"]}}" type="number" class="form_input" size="20" required>
                              <span class="fc_red">*</span>越大越靠后
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>上级栏目</label>
                            <span class="input">
                                <select name="ParentID" class="parent">
                                  <option value="0">一级栏目</option>
                                    @foreach($columns as $key => $r)
                                        <option value="{{$r["Column_ID"]}}" @if($rsColumn["Column_ParentID"] == $r['Column_ID']) selected @endif>{{$r["Column_Name"]}}</option>
                                    @endforeach
                                </select>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>栏目名称</label>
                            <span class="input">
                              <input name="Name" value="{{$rsColumn["Column_Name"]}}" type="text" class="form_input" size="20" required>
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
                                        <input type="hidden" id="ImgPath" name="ImgPath" value="{{$rsColumn["Column_ImgPath"]}}" />
                                    </div>
                                    <div class="tips">大图尺寸建议：420*300px</div>
                                    <div class="clear"></div>
                                  </div>
                                  <div class="img" id="ImgDetail">
                                      <img src="{{$rsColumn["Column_ImgPath"]}}" width="120">
                                  </div>
                                </span>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>栏目链接</label>
                            <span class="input opt">
                              <input type="checkbox" value="1" name="Link" @if($rsColumn["Column_Link"] == 1) checked @endif />
                              <span id="LinkUrl_span">
                                  <input name="LinkUrl" value="{{$rsColumn["Column_LinkUrl"]}}" type="url" class="form_input" size="40" id="web_common_url" >
                              </span>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows" id="Option_rows">
                            <label>相关选项</label>
                            <span class="input opt">
                                <span class="pop_sub_menu">弹出二级菜单:
                                    <input type="checkbox" value="1" name="PopSubMenu" @if($rsColumn["Column_PopSubMenu"] == 1) checked @endif />
                                </span> 导航显示:
                                <input type="checkbox" value="1" name="NavDisplay" @if($rsColumn["Column_NavDisplay"] == 1) checked @endif />
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows" id="Description_rows">
                            <label>详细内容</label>
                            <span class="input">
                              <textarea name="Description">{{$rsColumn["Column_Description"]}}</textarea>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>页面显示</label>
                            <span class="input">
                                <input type="radio" name="PageType" value="0" id="PageType0" @if($rsColumn["Column_PageType"] == 0) checked @endif/>
                                <label for="PageType0">内容列表</label>&nbsp;&nbsp;
                                <input type="radio" name="PageType" value="1" id="PageType1" @if($rsColumn["Column_PageType"] == 1) checked @endif />
                                <label for="PageType1">子栏目列表</label>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows" id="ListType_rows" style="display:block">
                            <label>列表形式</label>
                            <span class="input">
                              <ul id="column-article-list-type">
                                <li>
                                      <input name="ListTypeID" type="radio" value="0"  @if($rsColumn["Column_ListTypeID"] == 0) checked @endif>
                                      <div class="item" ListTypeID="0">
                                        <div class="img">
                                            <img src="/static/member/images/web/column-article-list-0.jpg" />
                                        </div>
                                        <div class="filter"></div>
                                        <div class="bg"></div>
                                      </div>
                                </li>
                                <li>
                                      <input name="ListTypeID" type="radio" value="1" @if($rsColumn["Column_ListTypeID"] == 1) checked @endif>
                                      <div class="item" ListTypeID="1">
                                        <div class="img">
                                            <img src="/static/member/images/web/column-article-list-1.jpg" />
                                        </div>
                                        <div class="filter"></div>
                                        <div class="bg"></div>
                                      </div>
                                </li>
                                <li>
                                      <input name="ListTypeID" type="radio" value="2" @if($rsColumn["Column_ListTypeID"] == 2) checked @endif>
                                      <div class="item" ListTypeID="2">
                                        <div class="img">
                                            <img src="/static/member/images/web/column-article-list-2.jpg" />
                                        </div>
                                        <div class="filter"></div>
                                        <div class="bg"></div>
                                      </div>
                                </li>
                                <li>
                                      <input name="ListTypeID" type="radio" value="3" @if($rsColumn["Column_ListTypeID"] == 3) checked @endif>
                                      <div class="item" ListTypeID="3">
                                        <div class="img">
                                            <img src="/static/member/images/web/column-childlist-list-0.jpg" />
                                        </div>
                                        <div class="filter"></div>
                                        <div class="bg"></div>
                                      </div>
                                </li>
                              </ul>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows" id="ListType_child" style="display:none">
                            <label>列表形式</label>
                            <span class="input">
                              <ul id="column-article-list-type">
                                <li>
                                  <input name="ChildTypeID" type="radio" value="0"  @if($rsColumn["Column_ChildTypeID"] == 0) checked @endif>
                                  <div class="item" ListTypeID="0">
                                    <div class="img">
                                        <img src="/static/member/images/web/column-childlist-list-0.jpg" />
                                    </div>
                                    <div class="filter"></div>
                                    <div class="bg"></div>
                                  </div>
                                </li>
                                <li>
                                  <input name="ChildTypeID" type="radio" value="1" @if($rsColumn["Column_ChildTypeID"] == 1) checked @endif>
                                  <div class="item" ListTypeID="1">
                                    <div class="img">
                                        <img src="/static/member/images/web/column-childlist-list-1.jpg" />
                                    </div>
                                    <div class="filter"></div>
                                    <div class="bg"></div>
                                  </div>
                                </li>
                              </ul>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label></label>
                            <span class="input">
                              <input type="submit" class="btn_green" value="提交保存" name="submit_btn">
                              <a href="{{route('admin.web.column_index')}}" class="btn_gray">返回</a>
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
        });

        $(document).ready(function(){
            web_obj.column_edit_init();
        });
    </script>
@endsection