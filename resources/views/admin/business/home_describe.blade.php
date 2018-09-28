@extends('admin.layouts.main')
@section('ancestors')
    <li>商家设置</li>
@endsection
@section('page', '首页设置')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/page.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script type='text/javascript' src='/admin/js/global.js'></script>
    <script src="/admin/js/uploadify/jquery.uploadify.min.js" type="text/javascript"></script>
    <link href="/admin/js/uploadify/uploadify.css" rel="stylesheet" type="text/css">
    <script type='text/javascript' src='/admin/js/shop.js'></script>

    <div class="box">

        <div id="iframe_page">
            <div class="iframe_content">

                <div id="home" class="r_con_wrap" style="height: 750px;">

                    <div class="control_btn">
                        <a href="{{route('admin.business.home_describe')}}" class="btn_green btn_w_120">首页设置</a>
                        <a href="{{route('admin.business.enter_describe')}}" class="btn_green btn_w_120">入驻描述设置</a>
                        <a href="{{route('admin.business.register_describe')}}" class="btn_green btn_w_120">注册描述设置</a>
                        <a href="{{route('admin.business.fee_describe')}}" class="btn_green btn_w_120">年费设置</a>
                    </div>

                    <div class="m_lefter" style="width: 350px">
                        <div id="shop_skin_index">
                            <div class="shop_skin_index_list i1" rel="edit-t02">
                                <div class="img"></div>
                            </div>
                            <div class="shop_skin_index_list i2" rel="edit-t03">
                                <div class="img"></div>
                            </div>
                            <div class="shop_skin_index_list i3" rel="edit-t04">
                                <div class="img"></div>
                            </div>
                            <div class="shop_skin_index_list i4" rel="edit-t05">
                                <div class="img"></div>
                            </div>
                        </div>
                    </div>

                    <div class="m_righter">
                        <form id="home_form" method="post" action="{{route('admin.business.describe_update')}}" >
                            {{csrf_field()}}
                            <div id="setbanner">
                                @for($i=0; $i<5; $i++)
                                <div class="item">
                                    <div class="rows">
                                        <div class="b_l">
                                            <strong>图片(<?php echo $i+1;?>)</strong>
                                            <span class="tips">大图建议尺寸：<label></label>px</span>
                                            <?php if($i>0){?>
                                            <a href="#shop_home_img_del" value='<?php echo $i;?>'>
                                                <img src="/admin/images/ico/del.gif" align="absmiddle" />
                                            </a>
                                            <?php }?><br />
                                            <div class="blank6"></div>
                                            <div><input name="FileUpload" id="HomeFileUpload_<?php echo $i;?>" type="file" /></div>
                                        </div>
                                        <div class="b_r"></div>
                                        <input type="hidden" name="ImgPathList[]" value="" />
                                        <input type="hidden" name="TitleList[]" value="" />
                                    </div>
                                    <div class="blank9"></div>
                                    <div class="rows url_select">
                                        <div class="input">
                                            <input name="UrlList[]" value="" type="text" size="30" id="shop_home_url_<?php echo $i;?>" placeholder="输入页面链接" />
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                @endfor
                            </div>
                            <div id="setimages">
                                <div class="item">
                                    <div value="title">
                                        <span class="fc_red">*</span> 标题<br />
                                        <div class="input"><input name="Title" value="" type="text" /></div>
                                        <div class="blank20"></div>
                                    </div>
                                    <div value="images">
                                        <span class="fc_red">*</span> 图片<span class="tips">大图建议尺寸：<label></label>px</span><br />
                                        <div class="blank6"></div>
                                        <div><input name="FileUpload" id="HomeFileUpload" type="file" /></div>
                                        <div class="blank20"></div>
                                    </div>
                                    <div class='b_images' ></div>
                                    <div class="url_select">
                                        <span class="fc_red">*</span> 链接页面<br />
                                        <div class="input">
                                            <input name="Url" value="" type="text" size="30" id="shop_home_url_6" placeholder="输入页面链接" />
                                        </div>
                                    </div>
                                    <input type="hidden" name="ImgPath" value="" />
                                </div>
                            </div>
                            <div class="button">
                                <input type="submit" class="btn_green" name="submit_button" value="提交保存" />
                                <input type="hidden"  name="submit_home" value="1" />
                            </div>
                            <input type="hidden" name="PId" value="" />
                            <input type="hidden" name="SId" value="" />
                            <input type="hidden" name="ContentsType" value="" />
                            <input type="hidden" name="no" value="" />
                        </form>
                    </div>


                </div>

            </div>
        </div>

    </div>

    <script language="javascript">
        var shop_skin_data = {!! json_encode($json) !!};
        $(document).ready(shop_obj.home_init);
    </script>
@endsection