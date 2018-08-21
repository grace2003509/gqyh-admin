@extends('admin.layouts.main')
@section('ancestors')
    <li>我的微信</li>
@endsection
@section('page', '添加单图文消息')
@section('subcontent')

    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/material.css' rel='stylesheet' type='text/css' />
    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script type='text/javascript' src='/admin/js/material.js'></script>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">
                <div id="material" class="r_con_wrap" style="min-height: 500px">
                    <form method="post" action="{{route('admin.wechat.material_store')}}" id="material_form">

                        <div class="m_lefter one">
                            <div class="title">消息标题</div>
                            <div><?php date("Y-m-d",time());?></div>
                            <div class="img" id="ImgDetail">封面图片</div>
                            <div class="txt"></div>
                        </div>
                        <div class="m_righter">
                            <div class="mod_form">
                                <div class="jt"><img src="/admin/images/material/jt.gif" /></div>
                                <div class="m_form">
                                    <span class="fc_red">*</span> 标题<br />
                                    <div class="input">
                                        <input name="Title" value="" type="text" />
                                    </div>
                                    <div class="blank20" style="height: 20px"></div>
                                    <span class="fc_red">*</span> 封面图片 <span class="tips">大图尺寸建议：640*360px</span><br />
                                    <div class="blank6"></div>
                                    <div>
                                        <input id="ImgUpload" name="ImgUpload" type="file">
                                        <input type="hidden" id="ImgPath" name="ImgPath" value="" />
                                    </div>
                                    <div class="blank12" style="height: 20px"></div>
                                    简短介绍<br />
                                    <div>
                                        <textarea name="TextContents"></textarea>
                                    </div>
                                    <div class="blank20" style="height: 20px"></div>
                                    <span class="fc_red">*</span> 链接页面<br />
                                    <div class="input">
                                        <input name="Url" value="" type="text" id="tuwen_url" />
                                        <img src="/admin/images/ico/search.png" style="width:22px; height:22px; margin:0px 0px 0px 5px; vertical-align:middle; cursor:pointer" id="btn_select_url" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div style="height: 260px"></div>
                        <div class="button" >
                            <input type="submit" class="btn_green" name="submit_button" value="提交保存" />
                            <a href="{{route('admin.wechat.material_index')}}" class="btn_gray">返回</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div style="height: 20px"></div>
    </div>

    <script language="javascript">$(document).ready(material_obj.material_one_init);</script>

@endsection