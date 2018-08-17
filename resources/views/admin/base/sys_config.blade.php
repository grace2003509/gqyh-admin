@extends('admin.layouts.main')
@section('ancestors')
    <li>基础设置</li>
@endsection
@section('page', '系统设置')
@section('subcontent')

    <link href='/static/css/bootstrap.min.css' rel='stylesheet' type='text/css' />
    <link href="/admin/css/main.css" rel="stylesheet" type="text/css">
    <link href="/admin/css/global.css" rel="stylesheet" type="text/css">

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <link rel="stylesheet" href="/admin/js/kindeditor/themes/default/default.css" />
    <script type='text/javascript' src="/admin/js/kindeditor/kindeditor-min.js"></script>
    <script type='text/javascript' src="/admin/js/kindeditor/lang/zh_CN.js"></script>
    <script>
        KindEditor.ready(function(K) {
            var editor = K.editor({
                uploadJson : '{{route('admin.upload_json')}}',
                fileManagerJson : '{{route('admin.file_manager_json')}}',
                showRemote : true,
                allowFileManager : true,
            });
            K('#ImgUpload').click(function(){
                editor.loadPlugin('image', function(){
                    editor.plugin.imageDialog({
                        imageUrl : K('#Img').val(),
                        clickFn : function(url, title, width, height, border, align){
                            K('#Img').val(url);
                            K('#ImgDetail').html('<img src="'+url+'" />');
                            editor.hideDialog();
                        }
                    });
                });
            });
        })
    </script>
    <div class="box">
        <div class="r_con_wrap">
            <form class="r_con_form" method="post" action="{{route('admin.base.sys_edit')}}">
                {{csrf_field()}}
                <div class="rows">
                    <label>系统名称</label>
                    <span class="input">
                        <input type="text" name="name" value="{{$setting['sys_name']}}" size="30" class="form_input"/>
                    </span>
                    <div class="clear"></div>
                </div>

                <div class="rows">
                    <label>logo图</label>
                    <span class="input">
                        <span class="upload_file">
                            <div>
                                <div class="up_input">
                                  <input type="button" id="ImgUpload" value="上传图片" style="width:80px;" />
                                </div>
                                <div class="tips">图片建议尺寸：150*50px</div>
                                <div class="clear"></div>
                            </div>
                            <div class="img" id="ImgDetail" style="padding-top:8px;">
                                  @if($setting['sys_logo'])
                                    <img src="{{$setting['sys_logo']}}" />
                                  @endif
                            </div>
                        </span>
                    </span>
                    <div class="clear"></div>
                </div>

                <div class="rows">
                    <label>域名</label>
                    <span class="input">
                        <input type="text" name="dommain" value="{{$setting['sys_dommain']}}" size="30" class="form_input" />
                    </span>
                    <div class="clear"></div>
                </div>
                <div class="rows">
                    <label>百度地图密钥</label>
                    <span class="input">
                        <input type="text" name="baidukey" value="{{$setting['sys_baidukey']}}" size="30" class="form_input" />
                    </span>
                    <div class="clear"></div>
                </div>
                <div class="rows">
                    <label>版权信息</label>
                    <span class="input">
                        <textarea name="copyright" style="width:300px;" rows="5">{{$setting['sys_copyright']}}</textarea><br />
                        <span style="font-size:12px; color:red">注：支持HTML代码</span>
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
                <input type="hidden" name="Img" id="Img" value="{{$setting['sys_logo']}}" />
            </form>
        </div>
    </div>

@endsection