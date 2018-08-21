@extends('admin.layouts.main')
@section('ancestors')
    <li>我的微信</li>
@endsection
@section('page', '添加多图文消息')
@section('subcontent')

    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/material.css' rel='stylesheet' type='text/css' />
    <link href="/admin/js/uploadify/uploadify.css" rel="stylesheet" type="text/css">
    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script type='text/javascript' src='/admin/js/global.js'></script>
    <script type='text/javascript' src='/admin/js/material.js'></script>
    <script type="text/javascript" src="/admin/js/uploadify/jquery.uploadify.min.js"></script>


    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">
                <div id="material" class="r_con_wrap" style="min-height: 600px">
                    <form id="material_form" method="post" action="{{route('admin.wechat.material_madd')}}">

                        <div class="m_lefter multi">
                            <div class="time"><?php date("Y-m-d",time());?></div>
                            <div class="first" id="multi_msg_0">
                                <div class="info">
                                    <div class="img">封面图片</div>
                                    <div class="title">消息标题</div>
                                </div>
                                <div class="control">
                                    <a href="#mod">
                                        <img src="/admin/images/ico/mod.gif" />
                                    </a>
                                </div>
                                <input type="hidden" name="Title[]" value="" />
                                <input type="hidden" name="Url[]" value="" />
                                <input type="hidden" name="ImgPath[]" value="" />
                            </div>
                            <div class="list" id="multi_msg_1">
                                <div class="info">
                                    <div class="title">标题</div>
                                    <div class="img">缩略图</div>
                                </div>
                                <div class="control">
                                    <a href="#mod">
                                        <img src="/admin/images/ico/mod.gif" />
                                    </a>
                                    <a href="#del">
                                        <img src="/admin/images/ico/del.gif" />
                                    </a>
                                </div>
                                <input type="hidden" name="Title[]" value="" />
                                <input type="hidden" name="Url[]" value="" />
                                <input type="hidden" name="ImgPath[]" value="" />
                            </div>
                            <div class="add">
                                <a href="#add">
                                    <img src="/admin/images/ico/add.gif" align="absmiddle" />
                                    增加一条
                                </a>
                            </div>
                        </div>
                        <div class="m_righter">
                            <div class="mod_form">
                                <div class="jt"><img src="/admin/images/material/jt.gif" /></div>
                                <div class="m_form"> <span class="fc_red">*</span> 标题<br />
                                    <div class="input">
                                        <input name="inputTitle" value="" type="text" />
                                    </div>
                                    <div class="blank9" style="height: 20px"></div>
                                    <span class="fc_red">*</span>
                                    封面图片
                                    <span class="tips">大图尺寸建议：
                                        <span class="big_img_size_tips">640*360px</span>
                                    </span><br />
                                    <div class="blank6"></div>
                                    <div>
                                        <input id="ImgUpload" name="ImgUpload" type="file">
                                    </div>
                                    <div class="blank3" style="height: 20px"></div>
                                    <span class="fc_red">*</span> 链接页面<br />
                                    <div class="input">
                                        <input name="inputUrl" value="" type="text" id="url_multi_msg_0" />
                                        <img src="/admin/images/ico/search.png" style="width:22px; height:22px; margin:0px 0px 0px 5px; vertical-align:middle; cursor:pointer" class="btn_select_url" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div style="height: 450px"></div>
                        <div class="button">
                            <input type="submit" class="btn_green" name="submit_button" value="提交保存" />
                            <a href="{{route('admin.wechat.material_index')}}" class="btn_gray">返回</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div style="height: 20px"></div>
    </div>

    <script language="javascript">$(document).ready(material_obj.material_multi_init);</script>

@endsection