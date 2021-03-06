@extends('admin.layouts.main')
@section('ancestors')
  <li>微官网</li>
@endsection
@section('page', '首页设置')
@section('subcontent')
<?php
$Dwidth = array('640','190','190','190','120','120','120','120','120','120','120','120');
$DHeight = array('313','280','280','280','120','120','120','120','120','120','120','120');

for($no=1;$no<=count($Home_Json);$no++){
	$json[$no-1]=array(
		"ContentsType"=>$no==1?"1":"0",
		"Title"=>$no==1?json_encode($Home_Json[$no-1]['Title']):$Home_Json[$no-1]['Title'],
		"ImgPath"=>$no==1?json_encode($Home_Json[$no-1]['ImgPath']):$Home_Json[$no-1]['ImgPath'],
		"Url"=>$no==1?json_encode($Home_Json[$no-1]['Url']):$Home_Json[$no-1]['Url'],
		"Postion"=>$no>9 ? "t".$no : "t0".$no,
		"Width"=>$Dwidth[$no-1],
		"Height"=>$DHeight[$no-1],
		"NeedLink"=>"1"
	);
}
$json = json_encode($json);
?>
<link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/web.css' rel='stylesheet' type='text/css' />
<link href="/admin/js/uploadify/uploadify.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/admin/js/kindeditor/themes/default/default.css" />
<link href='/static/js/plugins/lean-modal/style.css' rel='stylesheet' type='text/css' />
<link href='/static/api/web/skin/{{$rsConfig['Skin_ID']}}/page.css' rel='stylesheet' type='text/css' />

<script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<script type='text/javascript' src='/admin/js/global.js'></script>
<script type='text/javascript' src='/admin/js/uploadify/jquery.uploadify.min.js'></script>
<script type='text/javascript' src="/admin/js/kindeditor/kindeditor-diy.js"></script>
<script type='text/javascript' src="/admin/js/kindeditor/lang/zh_CN.js"></script>
<script type='text/javascript' src='/static/js/plugins/lean-modal/lean-modal.min.js'></script>
<script type='text/javascript' src='/admin/js/web.js'></script>
<script language="javascript">
    var web_skin_data = {!! $json !!};
    var Dwidth = <?php echo json_encode($Dwidth);?>;
    var DHeight = <?php echo json_encode($DHeight)?>;
    $(document).ready(web_obj.home_init);
</script>

<div class="box">
    <div id="iframe_page">
      <div class="iframe_content">

        <div id="home" class="r_con_wrap">
          <div class="m_lefter">
            <div id="web_skin_index">
              <div class="web_skin_index_list banner" rel="edit-t01">
                  <div class="img"></div>
              </div>
              <div class="web_warp">
                  <div class="item">
                      <div class="box web_skin_index_list m0" rel="edit-t02"><div class="img"></div></div>
                      <div class="box web_skin_index_list" rel="edit-t03"><div class="img"></div></div>
                      <div class="box web_skin_index_list" rel="edit-t04"><div class="img"></div></div>
                      <div class="clear"></div>
                  </div>
              </div>
              <div class="web_nav">
                  <div class="item">
                      <div class="box web_skin_index_list" rel="edit-t05">
                          <div class="img"></div>
                          <div class="text"></div>
                      </div>
                      <div class="box web_skin_index_list" rel="edit-t06">
                          <div class="img"></div>
                          <div class="text"></div>
                      </div>
                      <div class="box web_skin_index_list" rel="edit-t07">
                          <div class="img"></div>
                          <div class="text"></div>
                      </div>
                      <div class="box web_skin_index_list" rel="edit-t08">
                          <div class="img"></div>
                          <div class="text"></div>
                      </div>
                      <div class="clear"></div>
                  </div>
                  <div class="item">
                      <div class="box web_skin_index_list" rel="edit-t09">
                          <div class="img"></div>
                          <div class="text"></div>
                      </div>
                      <div class="box web_skin_index_list" rel="edit-t10">
                          <div class="img"></div>
                          <div class="text"></div>
                      </div>
                      <div class="box web_skin_index_list" rel="edit-t11">
                          <div class="img"></div>
                          <div class="text"></div>
                      </div>
                      <div class="box web_skin_index_list" rel="edit-t12">
                          <div class="img"></div>
                          <div class="text"></div>
                      </div>
                      <div class="clear"></div>
                  </div>
              </div>
          </div>
          </div>
          <div class="m_righter">
            <form id="home_form">
              <div id="setbanner">
                <div class="item">
                  <div class="rows">
                    <div class="b_l"> <strong>图片(1)</strong><span class="tips">大图建议尺寸：
                      <label></label>
                      px</span><a href="#web_home_img_del" value="0"><img src="/admin/images/ico/del.gif" align="absmiddle" /></a><br />
                      <div class="blank6"></div>
                      <input type="hidden" name="Title[]" value="" />
                      <div>
                        <input name="FileUpload" id="HomeFileUpload_0" type="file" />
                      </div>
                    </div>
                    <div class="b_r"></div>
                    <input type="hidden" name="ImgPathList[]" value="" />
                  </div>
                  <div class="blank9"></div>
                  <div class="rows url_select">
                    <div class="u_l">链接页面</div>
                    <div class="u_r">
                      <select name='UrlList[]'>
                        {!! $url_list !!}
                      </select>
                    </div>
                  </div>
                </div>
                <div class="item">
                  <div class="rows">
                    <div class="b_l"> <strong>图片(2)</strong><span class="tips">大图建议尺寸：
                      <label></label>
                      px</span><a href="#web_home_img_del" value="1"><img src="/admin/images/ico/del.gif" align="absmiddle" /></a><br />
                      <div class="blank6"></div>
                      <input type="hidden" name="Title[]" value="" />
                      <div>
                        <input name="FileUpload" id="HomeFileUpload_1" type="file" />
                      </div>
                    </div>
                    <div class="b_r"></div>
                    <input type="hidden" name="ImgPathList[]" value="" />
                  </div>
                  <div class="blank9"></div>
                  <div class="rows url_select">
                    <div class="u_l">链接页面</div>
                    <div class="u_r">
                      <select name='UrlList[]'>
                        {!! $url_list !!}
                      </select>
                    </div>
                  </div>
                </div>
                <div class="item">
                  <div class="rows">
                    <div class="b_l"> <strong>图片(3)</strong><span class="tips">大图建议尺寸：
                      <label></label>
                      px</span><a href="#web_home_img_del" value="2"><img src="/admin/images/ico/del.gif" align="absmiddle" /></a><br />
                      <div class="blank6"></div>
                      <input type="hidden" name="Title[]" value="" />
                      <div>
                        <input name="FileUpload" id="HomeFileUpload_2" type="file" />
                      </div>
                    </div>
                    <div class="b_r"></div>
                    <input type="hidden" name="ImgPathList[]" value="" />
                  </div>
                  <div class="blank9"></div>
                  <div class="rows url_select">
                    <div class="u_l">链接页面</div>
                    <div class="u_r">
                      <select name='UrlList[]'>
                        {!! $url_list !!}
                      </select>
                    </div>
                  </div>
                </div>
                <div class="item">
                  <div class="rows">
                    <div class="b_l"> <strong>图片(4)</strong><span class="tips">大图建议尺寸：
                      <label></label>
                      px</span><a href="#web_home_img_del" value="3"><img src="/admin/images/ico/del.gif" align="absmiddle" /></a><br />
                      <div class="blank6"></div>
                      <input type="hidden" name="Title[]" value="" />
                      <div>
                        <input name="FileUpload" id="HomeFileUpload_3" type="file" />
                      </div>
                    </div>
                    <div class="b_r"></div>
                    <input type="hidden" name="ImgPathList[]" value="" />
                  </div>
                  <div class="blank9"></div>
                  <div class="rows url_select">
                    <div class="u_l">链接页面</div>
                    <div class="u_r">
                      <select name='UrlList[]'>
                        {!! $url_list !!}
                      </select>
                    </div>
                  </div>
                </div>
                <div class="item">
                  <div class="rows">
                    <div class="b_l"> <strong>图片(5)</strong><span class="tips">大图建议尺寸：
                      <label></label>
                      px</span><a href="#web_home_img_del" value="4"><img src="/admin/images/ico/del.gif" align="absmiddle" /></a><br />
                      <div class="blank6"></div>
                      <input type="hidden" name="Title[]" value="" />
                      <div>
                        <input name="FileUpload" id="HomeFileUpload_4" type="file" />
                      </div>
                    </div>
                    <div class="b_r"></div>
                    <input type="hidden" name="ImgPathList[]" value="" />
                  </div>
                  <div class="blank9"></div>
                  <div class="rows url_select">
                    <div class="u_l">链接页面</div>
                    <div class="u_r">
                      <select name='UrlList[]'>
                        {!! $url_list !!}
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div id="setimages">
                <div class="item">
                  <div value="title"> <span class="fc_red">*</span> 标题<br />
                    <div class="input">
                      <input name="Title" value="" type="text" />
                    </div>
                    <div class="blank20"></div>
                  </div>
                  <div value="images"> <span class="fc_red">*</span> 图片<span class="tips">大图建议尺寸：
                    <label></label>
                    px</span><br />
                    <div class="blank6"></div>
                    <div>
                      <input name="FileUpload" id="HomeFileUpload" type="file" />
                    </div>
                    <div class="blank20"></div>
                  </div>
                  <div class="url_select"> <span class="fc_red">*</span> 链接页面<br />
                    <div class="input">
                      <select name='Url'>
                        {!! $url_list !!}
                      </select>
                    </div>
                  </div>
                  <input type="hidden" name="ImgPath" value="" />
                </div>
              </div>
              <div class="button">
                <input type="submit" class="btn_green" name="submit_button" style="cursor:pointer" value="提交保存" />
              </div>
              <input type="hidden" name="PId" value="" />
              <input type="hidden" name="SId" value="" />
              <input type="hidden" name="ContentsType" value="" />
              <input type="hidden" name="no" value="" />
            </form>
          </div>
          <div class="clear"></div>
        </div>
        <div id="home_mod_tips" class="lean-modal pop_win">
          <div class="h">首页设置<a class="modal_close" href="#"></a></div>
          <div class="tips">首页设置成功</div>
        </div>
      </div>
    </div>
</div>
@endsection