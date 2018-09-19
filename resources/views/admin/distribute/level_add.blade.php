<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
</head>
<body>
<link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

<script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<script type='text/javascript' src='/admin/js/dis_level.js'></script>

<div id="iframe_page">
    <div class="iframe_content">
        <div id="level" class="r_con_wrap">
            <form id="level_form" class="r_con_form" method="post" action="{{route('admin.distribute.level_store')}}">
                {{csrf_field()}}
                <h2 style="height:40px; line-height:40px; font-size:14px; font-weight:bold; background:#eee; text-indent:15px;">基本设置</h2>
                <div class="rows">
                    <label>级别名称</label>
                    <span class="input">
                      <input name="Name" value="" type="text" class="form_input" size="20">
                      <span class="fc_red">*</span>
                    </span>
                    <div class="clear"></div>
                </div>
                <div class="rows">
                    <label>级别描述</label>
                    <span class="input">
                        <textarea name="Level_Description"></textarea>
                    </span>
                    <div class="clear"></div>
                </div>
                {{--<div class="rows">
                    <label>级别图片</label>
                    <span class="input">
                        <span class="upload_file">
                            <div>
                                <div class="up_input">
                                    <input type="button" id="ImgUpload" value="添加图片" style="width:80px;" />
                                </div>
                                <div class="tips">图片建议尺寸：200*120</div>
                                <div class="clear"></div>
                            </div>
                            <div class="img" id="ImgDetail"></div>
                        </span>
                    </span>
                    <input name="ImgPath" id="ImgPath" type="hidden" value="">
                    <div class="clear"></div>
                </div>--}}
                <div class="rows">
                    <label>佣金人数限制</label>
                    <span class="input">
                        <table class="item_data_table" border="0" cellpadding="3" cellspacing="0">
                        @for($i=0;$i<$level;$i++)
                            <tr>
                                <td>
                                    {{$arr[$i]}}级&nbsp;&nbsp;
                                    <input name="PeopleLimit[{{$i+1}}]" value="0" class="form_input" size="5" maxlength="10" type="number">个
                                </td>
                            </tr>
                        @endfor
                        </table>
                        <div class="tips" style="height:80px; line-height:20px;">
                            注：此级别的分销商获得佣金的人数限制。<br />
                            如：一级 3、二级 -1、三级 -1，说明此级别分销商只能获得3个下属的一级佣金，不能获得二级、三级佣金；<br />
                            0表示不限制，-1 表示禁止获得此级别佣金。<br />
                            此设置对于发展下级会员人数不起作用
                        </div>
                    </span>
                    <div class="clear"></div>
                </div>
                @if($type==2)<!--购买商品-->
                <div class="rows">
                    <label>选择商品</label>
                    <span class="input">
                        <input type="radio" name="Fanwei" id="Fanwei_0" value="0" checked />
                        <label> 任意商品</label>&nbsp;&nbsp;
                        <input type="radio" name="Fanwei" id="Fanwei_1" value="1" />
                        <label> 特定商品</label>
                        <div class="products_option" style="display:none">
                            <div class="search_div">
                                  <select>
                                  <option value=''>--请选择--</option>
                                      @foreach($category_list as $key=>$item)
                                        <option value="{{$key}}">{{$item['Category_Name']}}</option>
                                        @if(!empty($item['child']))
                                            @foreach($item['child'] as $cate_id=>$child)
                                                <option value="{{$child["Category_ID"]}}">&nbsp;&nbsp;&nbsp;&nbsp;{{$child["Category_Name"]}}</option>
                                            @endforeach
                                        @endif
                                      @endforeach
                                 </select>
                                 <input type="text" placeholder="关键字" value="" class="form_input" size="35" maxlength="30" />
                                 <button type="button" class="button_search">搜索</button>
                           </div>

                           <div class="select_items" >
                                 <select size='10' class="select_product0" style="width:240px; height:100px; display:block; float:left"></select>
                                 <button type="button" class="button_add">=></button>
                                 <select size='10' class="select_product1" multiple style="width:240px; height:100px; display:block; float:left"></select>
                                 <input type="hidden" name="BuyIDs" value="" />
                           </div>

                           <div class="options_buttons">
                                <button type="button" class="button_remove">移除</button>
                                <button type="button" class="button_empty">清空</button>
                           </div>
                        </div>

                    </span>
                    <div class="clear"></div>
                </div>
                @endif
                <div class="rows">
                    <label></label>
                    <span class="input">
                        <input type="submit" class="btn_green" value="确定" name="submit_btn">
                        <a href="/admin/distribute/level?level={{$level}}&type={{$type}}" class="btn_gray">返回</a>
                    </span>
                    <div class="clear"></div>
                </div>
                <input type="hidden" name="level" value="{{$level}}">
                <input type="hidden" name="type" value="{{$type}}">
            </form>

        </div>
    </div>
</div>

<script>
    var Update_switch = 0;
    var type = @if($type > 0){{$type}} @else 0 @endif;
    $(document).ready(dis_level.level_edit);
</script>

</body>
</html>