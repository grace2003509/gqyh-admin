@extends('admin.layouts.main')
@section('ancestors')
    <li>产品管理</li>
@endsection
@section('page', '产品审核')
@section('subcontent')

<link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

<script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<script type='text/javascript' src='/admin/js/shop.js'></script>
<script type='text/javascript' src='/static/js/plugins/layer/layer.js'></script>
<link rel="stylesheet" href="/admin/js/kindeditor/themes/default/default.css" />
<script type='text/javascript' src="/admin/js/kindeditor/kindeditor-min.js"></script>
<script type='text/javascript' src="/admin/js/kindeditor/lang/zh_CN.js"></script>
<link href='/static/js/plugins/lean-modal/style.css' rel='stylesheet' type='text/css' />
<script type='text/javascript' src='/static/js/plugins/lean-modal/lean-modal.min.js'></script>

<style type="text/css">
    .disnone { display: none; background: #EEE; }
    .custom { position: fixed; top: 30%; background: blue; color: #FFF; padding: 5px 10px; right: 25px; width: 105px; height: 30px; line-height: 20px; overflow: hidden; }
    .custom a { color: #FFF; }
    .dislevelcss{float:left;margin:5px 0px 0px 8px;text-align:center;border:solid 1px #858585;padding:5px;}
    .dislevelcss th{border-bottom:dashed 1px #858585;font-size:16px;}
</style>

<div class="box">
    <div id="iframe_page">
        <div class="iframe_content">

            <div id="products" class="r_con_wrap">

                <form class="r_con_form" id="product_edit_form" method="post"
                      action="{{route('admin.product.product_update', ['id' => $rsProducts["Products_ID"]])}}">
                    {{csrf_field()}}
                    <div class="rows">
                        <label>产品排序</label>
                        <span class="input">
                            <input type="text" name="Index" value="{{$rsProducts["Products_Index"]}}" class="form_input" size="10" maxlength="100" />
                            <span class="tips"> 注：数字越小，越往前（必须大于0），为0则表示默认</span>
                        </span>
                        <div class="clear"></div>
                    </div>

                    <div class="rows">
                        <label>产品名称</label>
                        <span class="input">
                            <input type="text" name="Name" value="{{$rsProducts["Products_Name"]}}" class="form_input_disable" size="35" maxlength="100" disabled="disabled" />
                            <span class="fc_red">*</span>
                        </span>
                        <div class="clear"></div>
                    </div>
                    @if ($rsProducts['Products_Union_ID'] == 0)
                    <div class="rows">
                        <label>产品分类</label>
                        <span class="input">
				            <a href="#select_category">[选择分类]</a><br />
				            <p style="margin:5px 0px; padding:0px; font-size:12px; color:#999">已选择分类：</p>
				            <div id="classs">{{$rsProducts['category_name']}}</div>
			            </span>
                        <div class="clear"></div>
                    </div>
                    @else
                        <div class="rows">
                            <label>产品分类</label>
                            <span class="input">
				                <div id="classs">{{$rsProducts['category_name']}}</div>
                            </span>
                            <div class="clear"></div>
                        </div>
                    @endif
                    <div class="rows">
                        <label>产品价格</label>
                        <span class="input price"> 原价:￥
                            <input type="text" name="PriceY" value="{{$rsProducts["Products_PriceY"]}}"
                                   class="form_input_disable" size="5" maxlength="10" disabled="disabled" />
                            <span class="fc_red">*</span>
                            &nbsp;&nbsp;现价:￥
                            <input type="text" name="PriceX" value="{{$rsProducts["Products_PriceX"]}}"
                                   class="form_input_disable" size="5" maxlength="10" disabled="disabled" />
                            <span class="fc_red">*</span>
                        </span>
                        <div class="clear"></div>
                    </div>
                    @if($rsBiz["Finance_Type"]==1)
                    <div class="rows">
                        <label>财务结算类型</label>
                        <span class="input">
                            <input type="radio" name="FinanceType" value="0" id="FinanceType_0" @if($rsProducts["Products_FinanceType"] == 0) checked @endif disabled="disabled" />
                            <label for="FinanceType_0"> 按交易额比例</label>&nbsp;&nbsp;
                            <input type="radio" name="FinanceType" value="1" id="FinanceType_1" @if($rsProducts["Products_FinanceType"]==1) checked @endif disabled="disabled" />
                            <label for="FinanceType_1"> 按供货价</label><br />
                            <span class="tips">注：若按交易额比例，则网站提成为：产品售价*比例%</span>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows" id="FinanceRate" @if($rsProducts["Products_FinanceType"]==1) style="display:none" @endif >
                        <label>网站提成</label>
                        <span class="input">
                            <input type="text" name="FinanceRate" value="{{$rsProducts["Products_FinanceRate"]}}"
                                   class="form_input" size="10" disabled="disabled" /> %
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows" id="PriceS" @if($rsProducts["Products_FinanceType"]==0) style="display:none" @endif >
                        <label>供货价</label>
                        <span class="input">
                            <input type="text" name="PriceS" value="{{$rsProducts["Products_PriceS"]}}" class="form_input" size="10" disabled="disabled" /> 元&nbsp;&nbsp;
                            <span class="tips">此产品网站提成
                                <span style="color:#F60"> {{$rsProducts["Products_PriceX"]-$rsProducts["Products_PriceS"]}} </span>元
                            </span>
                        </span>
                        <div class="clear"></div>
                    </div>
                    @endif
                <!--edit in 20160321-->
                    <div class="rows disnone">
                        <label>发放比例</label>
                        <span class="input price">
                            <span>%</span>
                            <input type="text" name="platForm_Income_Reward" value="{{$rsProducts["platForm_Income_Reward"]}}" class="form_input" size="5" maxlength="10" required />
                            <span>(发放金额所占网站利润的百分比；小于等于100%大于等0%；)</span>
                        </span>
                        <div class="clear"></div>
                    </div>

                    <div class="rows disnone">
                        <label>佣金比例</label>
                        <span class="input price">
                            <span>%</span>
                                <input type="text" name="commission_ratio" value="{{$rsProducts["commission_ratio"]}}" class="form_input" size="5" maxlength="10" required />
                            <span>(佣金所占发放比例的百分比)</span>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows disnone">
                        <label>佣金返利<b class="red mousehand" id="allchange">（全部统一）</b></label>
                        <span class="input">
			                @foreach($dislevelarrs as $key=>$disinfo)
                            <div class="dislevelcss">
                                <table id="11" class="item_data_table" border="0" cellpadding="3" cellspacing="0">
                                    <tr>
                                        <th>{{$disinfo['Level_Name']}}</th>
                                    </tr>
                                    @for($i=0;$i<$level;$i++)
                                    <tr>
                                        <td>
                                        @if($dis_config['Dis_Self_Bonus']==1 && $i==$dis_config['Dis_Level'])
                                            自销佣金
                                        @else
                                            {{$arr[$i]}}级
                                        @endif
                                            <input id="dischange{{$disinfo['Level_ID'].$i}}"
                                               name="Distribute[{{$disinfo['Level_ID']}}][{{$i}}]" value="{{$distribute_list[$disinfo['Level_ID']][$i]}}"
                                               class="form_input" size="5" maxlength="10" type="text">元(佣金比例的金额)
                                        </td>
                                    </tr>
                                    @endfor
                                    <tr>
                                        <td>
                                            多级
                                            &nbsp;&nbsp;
                                            <input  name="Distribute[{{$disinfo['Level_ID']}}][999]" value="{{$distribute_list[$disinfo['Level_ID']][999]}}"
                                                class="form_input" size="5" maxlength="10" type="text">元(三级以后佣金比例的金额)
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            @endforeach
                        </span>
                        <div class="clear"></div>
                    </div>
                    <input type="hidden" value="0" name="salesman_level_ratio[0]">
                    <input type="hidden" value="0" name="salesman_level_ratio[1]">
                    <input type="hidden" value="0" name="salesman_level_ratio[2]">

                    <div class="custom">
                        <a href="javascript:void(0);" class="show_commision">显示佣金设置</a>
                        <a href="javascript:void(0);" class="close_commision">隐藏佣金设置</a>
                    </div>

                    <div class="rows">
                        <label>库存</label>
                        <span class="input">
                            <input type="text" name="Count" value="{{$rsProducts["Products_Count"]}}" class="form_input_disable" size="5" maxlength="10" disabled="disabled" />
                            <span class="tips">&nbsp;注:若不限则填写10000.</span>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows">
                        <label>产品重量</label>
                        <span class="input">
                            <input type="text" name="Weight" value="{{$rsProducts["Products_Weight"]}}" class="form_input_disable" size="5" disabled="disabled" />&nbsp;&nbsp;千克
                        </span>
                        <div class="clear"></div>
                    </div>

                    <div class="rows">
                        <label>购买送积分</label>
                        <span class="input price">
                            <input type="text" name="Products_Integration" value="{{$rsProducts["Products_Integration"]}}" class="form_input" size="5" maxlength="10" required data-type="number" />&nbsp;&nbsp;
                            <span>分</span><span class="msg"></span>
                        </span>
                        <div class="clear"></div>
                    </div>

                    <div class="rows">
                        <label>需要多少积分</label>
                        <span class="input">
			                <input type="text" name="Products_PayCoin" value="{{$rsProducts["Products_PayCoin"]}}" class="form_input_disable" size="5" disabled="disabled"  />&nbsp;&nbsp;该产品需要多少积分
			            </span>
                        <div class="clear"></div>
                    </div>

                    <div class="rows">
                        <label>产品图片</label>
                        <span class="input">
                            <span class="upload_file">
                                <div><div class="clear"></div></div>
                            </span>
                            <div class="img" id="PicDetail">
                                @if(isset($rsProducts['json']["ImgPath"]))
                                  @foreach($rsProducts['json']["ImgPath"] as $key=>$value)
                                  <div>
                                      <a target="_blank" href="{{$value}}"> <img src="{{$value}}"></a>
                                      <input type="hidden" name="JSON[ImgPath][]" value="{{$value}}">
                                  </div>
                                  @endforeach
                                @endif
                            </div>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows">
                        <label>简短介绍</label>
                        <span class="inputdisable">
                            <textarea name="BriefDescription" class="briefdesc" disabled="disabled">
                                {{strip_tags($rsProducts["Products_BriefDescription"])}}
                            </textarea>
                        </span>
                        <div class="clear"></div>
                    </div>

                    <div class="rows" id="type_html">
                        <label>产品类型</label>
                        <span class="input">
                            <select name="TypeID" style="width:180px;cursor: not-allowed;background:#e3e3e3" id="Type_ID" disabled="disabled" >
                                <option value="0" @if($rsProducts["Products_Type"]==0) selected @endif >无属性</option>
                                @foreach($rsTypes as $rsType)
                                   <option value="{{$rsType["Type_ID"]}}" @if($rsProducts["Products_Type"]==$rsType["Type_ID"]) selected @endif >{{$rsType["Type_Name"]}}</option>
                                @endforeach
                            </select>
                            <span class="fc_red">*</span>
                        </span>
                        <div class="clear"></div>
                    </div>

                    <div class="rows">
                        <label>产品属性</label>
                        <span class="input" id="attrs">
                            {!! $rsProducts['tableeval'] !!}
                        </span>
                        <div class="clear"></div>
                    </div>

                    @if(!empty($parameter_list))
                        @foreach ($parameter_list as $kk=>$vv)
                        <div class="rows form-group">
                            <label>产品参数</label>
                            <span class="input">
                                <input type="text" class="ProductsParametername disable" name="Products_Parameter[<?=$kk?>][name]" value="<?=$vv["name"]?>" class="form_input" size="15" maxlength="30" disabled="disabled"/>
                                <input type="text" class="ProductsParametervalue disable" name="Products_Parameter[<?=$kk?>][value]" value="<?=$vv["value"]?>" class="form_input" size="15" maxlength="30" disabled="disabled"/>
                            </span>
                            <div class="clear"></div>
                        </div>
                        @endforeach
                    @endif

                    <div class="rows">
                        <label>其他属性</label>
                        <span class="input attr">
                          <label>新品:
                          <input type="checkbox" value="1" name="IsNew" <?php echo empty($rsProducts["Products_IsNew"])?"":" checked" ?> /></label>&nbsp;|&nbsp;
                          <label>热卖:
                          <input type="checkbox" value="1" name="IsHot" <?php echo empty($rsProducts["Products_IsHot"])?"":" checked" ?> /></label>&nbsp;|&nbsp;
                          <label>推荐:
                           <input type="checkbox" value="1" name="IsRecommend" <?php echo empty($rsProducts["Products_IsRecommend"])?"":" checked" ?> /></label>&nbsp;|&nbsp;
                          <label>会员门槛商品:
                           <input type="checkbox" value="1" name="IsMember" <?php echo empty($rsProducts["Products_IsMember"])?"":" checked" ?> /></label>&nbsp;|&nbsp;
                          <label>VIP会员门槛商品:
                           <input type="checkbox" value="1" name="IsVip" <?php echo empty($rsProducts["Products_IsVip"])?"":" checked" ?> /></label>&nbsp;|&nbsp;
                          <label>总代门槛商品:
                           <input type="checkbox" value="1" name="IsZongDai" <?php echo empty($rsProducts["Products_IsZongDai"])?"":" checked" ?> /></label>&nbsp;
                        </span>
                        <div class="clear"></div>
                    </div>

                    <div class="rows">
                        <label>特殊属性</label>
                        <span class="input attr">
                            @if($rsConfig["Payment_RmainderEnabled"]==1)
                            余额支付:
                                <input type="checkbox" value="1" name="IsPaysBalance" @if($rsProducts["Products_IsPaysBalance"] == 1) checked @endif />&nbsp;|&nbsp;
                            @endif
                            到店自提:
                            <input type="checkbox" value="1" name="store_mention" @if($rsProducts["store_mention"] == 1) checked @endif />&nbsp;|&nbsp;
                        </span>
                        <div class="clear"></div>
                    </div>

                    <div class="rows">
                        <label>订单流程</label>
                        <span class="input disable" style="font-size:12px; line-height:22px;">
                              <input type="radio" id="order_0" value="0" name="ordertype"<?php echo $ordertype==0 ? ' checked' : '';?> disabled="disabled" /><label for="order_0"> 实物订单&nbsp;&nbsp;( 买家下单 -> 买家付款 -> 商家发货 -> 买家收货 -> 订单完成 ) </label><br />
                              <input type="radio" id="order_1" value="1" name="ordertype"<?php echo $ordertype==1 ? ' checked' : '';?> disabled="disabled" /><label for="order_1"> 虚拟订单&nbsp;&nbsp;( 买家下单 -> 买家付款 -> 系统发送消费券码到买家手机 -> 商家认证消费 -> 订单完成 ) </label><br />
                              <input type="radio" id="order_2" value="2" name="ordertype"<?php echo $ordertype==2 ? ' checked' : '';?> disabled="disabled" /><label for="order_2"> 其他&nbsp;&nbsp;( 买家下单 -> 买家付款 -> 订单完成 ) </label>
                        </span>
                        <div class="clear"></div>
                    </div>

                    <div class="rows">
                        <label>详细介绍</label>
                        <span class="input">
                            <textarea class="ckeditor" name="Description" style="width:600px; height:300px;">
                                <h1>注：商家编辑才能生效，在这里编辑是无效的！</h1>
                                {!! $rsProducts["Products_Description"] !!}
                            </textarea>
                        </span>
                        <div class="clear"></div>
                    </div>

                    <div class="rows">
                        <label>积分抵用开关</label>
                        <span class="input" style="font-size:12px;">
                              <input type="radio" id="status_0" value="0" name="Integrationswitch"<?php echo $rsProducts["Integrationswitch"]==0 ? ' checked' : '';?> /><label for="status_0"> 关闭 </label>&nbsp;&nbsp;
                              <input type="radio" id="status_1" value="1" name="Integrationswitch"<?php echo $rsProducts["Integrationswitch"]==1 ? ' checked' : '';?> /><label for="status_1"> 开启 </label><span class="tips">&nbsp;注:默认为关闭，开启后该商品将不能进行积分抵用.</span>
                        </span>
                        <div class="clear"></div>
                    </div>

                    <div class="rows">
                        <label>是否审核</label>
                        <span class="input" style="font-size:12px;">
                              <input type="radio" id="status_0" value="0" name="Status"<?php echo $rsProducts["Products_Status"]==0 ? ' checked' : '';?> /><label for="status_0"> 待审核 </label>&nbsp;&nbsp;
                              <input type="radio" id="status_1" value="1" name="Status"<?php echo $rsProducts["Products_Status"]==1 ? ' checked' : '';?> /><label for="status_1"> 通过审核 </label>
                        </span>
                        <div class="clear"></div>
                    </div>

                    <div id="select_category" class="lean-modal lean-modal-form">
                        <div class="h">产品分类<a class="modal_close" href="#"></a></div>
                        <div class="catlist" style="height:350px; overflow:auto">
                            <dl>
                                @foreach($shop_category as $first=>$items)
                                    <dt><qq544731308>{{$items["Category_Name"]}}</qq544731308></dt>
                                    <dd>
                                        @if(!empty($items["child"]))
                                            @foreach($items["child"] as $second=>$item)
                                                <span>
                                                    <input type="radio" rel="0" name="Category" value="{{$item["Category_ID"]}}"
                                                           @if($item["Category_ID"] == $rsProducts['Products_Category']) checked @endif id="cate_{{$item["Category_ID"]}}"/>
                                                    <label for="cate_{{$item["Category_ID"]}}">
                                                        <qq544731308son>{{$item["Category_Name"]}}</qq544731308son>
                                                    </label>
                                                </span>
                                            @endforeach
                                        @endif
                                    </dd>
                                @endforeach
                            </dl>
                        </div>
                        <div class="rows">
                            <label></label>
                            <span class="submit">
                                <a class="modal_close" style="border-radius:8px;padding:5px 20px; color:#FFF; text-align:center; background:#3AA0EB" href="#">选好了</a>
                            </span>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="rows">
                        <label></label>
                        <span class="input">
                            <input type="hidden" name="ProductsID" id="ProductsID"  value="{{$rsProducts["Products_ID"]}}">
                            <input type="hidden" name="Products_Union_ID" id="ProductsID"  value="{{$rsProducts["Products_Union_ID"]}}">
                            <input type="submit" class="btn_green" name="submit_button" value="提交保存" /></span>
                        <div class="clear"></div>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>


<script>

    $(document).ready(shop_obj.products_form_init);

    KindEditor.ready(function(K) {
        K.create('textarea[name="Description"]', {
            themeType : 'simple',
            filterMode : false,
            uploadJson : '/admin/upload_json?TableField=web_column',
            fileManagerJson : '/admin/file_manager_json',
            allowFileManager : true
        });

    });

    var level = '{{$level}}';
    var dislevelcont = '{{$dislevelcont}}';
    var disidarr = '{{$jsondisidarr}}';
    var fistarr = new Array();
    $("#allchange").click(function(){
        for(i=0;i<dislevelcont;i++){
            if(i == 0){
                for(j=0;j<level;j++){
                    fistarr[j] = $("#dischange"+disidarr[i]+j).val();
                }
            }else{
                for(j=0;j<level;j++){
                    $("#dischange"+disidarr[i]+j).val(fistarr[j]);
                }
            }
        }
    })

    $('.custom .show_commision').click(function(){ $('.disnone').show(); $(this).hide(); $('.custom .close_commision').show(); });
    $('.custom .close_commision').click(function(){ $('.disnone').hide(); $(this).hide(); $('.custom .show_commision').show();
        $('.commision_config').each(function(){
            $(this).val($(this).attr('data-value'));
        });
    });


    $(document).on('click','.modal_close',function(){
        var select_class = '';
        var son = '';
        var fson = '';
        var sonid = '';
        $('#select_category dd input:radio:checked').each(function(){
            son += $(this).next('label').children('qq544731308son').html();
            sonid = $(this).val();
            fson = $(this).parent('span').parent('dd').prev('dt').find('qq544731308').html();
        });
        select_class += '<p style="margin:5px 0px; padding:0px; font-size:14px; color:#666">' +
            '<span style="color:#333; font-size:12px;">' + fson +'</span>&nbsp;'+son+'</p>';
        $('#classs').html(select_class);
    })

</script>

@endsection