@extends('admin.layouts.main')
@section('ancestors')
    <li>产品管理</li>
@endsection
@section('page', '产品列表')
@section('subcontent')

<link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

<script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<script type='text/javascript' src='/admin/js/shop.js'></script>
<script type='text/javascript' src='/static/js/plugins/layer/layer.js'></script>

<div class="box">
    <div id="iframe_page">
        <div class="iframe_content">

            <div id="products" class="r_con_wrap">

                <div class="control_btn">
                    {{--<a id="search" class="btn_green btn_w_120">产品搜索</a>--}}
                    <a href="javascript:void(0);" class="btn_green btn_w_120" id="auditingAll">批量审核</a>
                    <a href="javascript:void(0);" class="btn_green btn_w_120" id="Integrationswitchall">批量设积分抵用</a>
                </div>
                <form class="search" style="display: block;" method="get" action="{{route('admin.product.product_index')}}">
                    商品名称：
                    <input type="text" name="Keyword" value="" class="form_input" size="15" />&nbsp;
                    产品分类：
                    <select name='SearchCateId'>
                        <option value='0'>--请选择--</option>
                        @foreach($shop_cate as $key=>$value)
                            <option value="{{$value["Category_ID"]}}">{{$value["Category_Name"]}}</option>
                            @foreach($value["child"] as $k => $v)
                                <option value="{{$v["Category_ID"]}}">└{{$v["Category_Name"]}}</option>';
                            @endforeach
                        @endforeach
                    </select>&nbsp;
                    商家：
                    <select name='BizID'>
                        <option value='0'>--请选择--</option>
                        @foreach($biz as $key=>$value)
                            <option value="{{$value["Biz_ID"]}}">{{$value["Biz_Name"]}}</option>
                        @endforeach
                    </select>&nbsp;
                    其他属性：
                    <select name="Attr">
                        <option value="0">--请选择--</option>
                        <option value="SoldOut">下架</option>
                        <option value="IsNew">新品</option>
                        <option value="IsHot">热卖</option>
                        <option value="IsMember">会员商品</option>
                        <option value="IsVip">VIP会员商品</option>
                        <option value="IsZongDai">总代商品</option>
                    </select>&nbsp;
                    状态：
                    <select name="Status">
                        <option value="2">全部</option>
                        <option value="0">未审核</option>
                        <option value="1">已审核</option>
                    </select>
                    <input type="hidden" name="search" value="1" />
                    <input type="submit" class="search_btn" value="搜索" />
                </form>
                <table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                    <thead>
                    <tr>
                        <td width="6%" nowrap="nowrap">
                            <input type="checkbox" onclick="selectAll(this);"/>全选
                        </td>
                        <td width="5%" nowrap="nowrap">序号</td>
                        <td nowrap="nowrap">名称</td>
                        <td width="10%" nowrap="nowrap">所属商家</td>
                        <td width="12%" nowrap="nowrap">结算明细</td>
                        <td width="5%" nowrap="nowrap">佣金比例</td>
                        <td width="5%" nowrap="nowrap">价格</td>
                        <td width="8%" nowrap="nowrap">图片</td>
                        <td width="8%" nowrap="nowrap">其他属性</td>
                        <td width="5%" nowrap="nowrap">状态</td>
                        <td width="5%" nowrap="nowrap">积分抵用</td>
                        <td width="5%" nowrap="nowrap">时间</td>
                        <td width="5%" nowrap="nowrap" class="last">操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lists as $k=>$rsProducts)
                    <tr>
                        <td>
                            <input type="checkbox" class="auditingid" name="Products_ID[]" value="{{$rsProducts["Products_ID"]}}" />
                        </td>
                        <td nowrap="nowrap">{{$rsProducts["Products_ID"]}}</td>
                        <td>{{$rsProducts["Products_Name"]}}</td>
                        <td>
                            @if(empty($rsProducts['rsBiz']))商家不存在或已删除 @else {{$rsProducts['rsBiz']["Biz_Name"]}} @endif
                        </td>
                        <td style="text-align:center; padding:5px">
                            @if ($rsProducts['rsBiz']['Finance_Type'] == 1)
                                @if($rsProducts["Products_FinanceType"] == 0)
                                结算类型：按交易额比例<br />
                                网站提成：{{$rsProducts["Products_PriceX"]}} * {{$rsProducts['Products_FinanceRate']}} % = {{$rsProducts['web_money1']}}
                                @else
                                结算类型：按产品供货价<br />
                                供货价：{{$rsProducts["Products_PriceS"]}}<br />
                                网站提成：{{$rsProducts["Products_PriceX"]}} - {{$rsProducts["Products_PriceS"]}} = {{$rsProducts['web_money2']}}
                                @endif
                            @else
                                结算类型：按交易额比例<br />
                                网站提成：{{$rsProducts["Products_PriceX"]}} * {{$rsProducts['rsBiz']["Finance_Rate"]}} % = {{$rsProducts['web_money']}}
                            @endif

                        </td>
                        <td>
                            <label class="mousehand" id="{{$rsProducts["Products_ID"]}}">查看详细</label>
                        </td>
                        <td nowrap="nowrap">
                            <del>￥{{$rsProducts["Products_PriceY"]}}<br>
                            </del>￥{{$rsProducts["Products_PriceX"]}}
                        </td>
                        <td nowrap="nowrap">
                            @if($rsProducts['json']["ImgPath"])
                                <img src="{{$rsProducts['json']['ImgPath'][0]}}" class="proimg" />
                            @endif
                        </td>
                        <td nowrap="nowrap">
                            @if($rsProducts["Products_SoldOut"]==1) 下架<br> @endif
                            @if($rsProducts["Products_IsShippingFree"]==1) 免运费<br> @endif
                            @if($rsProducts["Products_IsNew"]) 新品<br> @endif
                            @if($rsProducts["Products_IsRecommend"]) 推荐<br> @endif
                            @if($rsProducts["Products_IsHot"]) 热卖<br> @endif
                            @if($rsProducts["Products_IsMember"]) 会员门槛商品<br> @endif
                            @if($rsProducts["Products_IsVip"]) VIP会员门槛商品 @endif
                        </td>
                        <td nowrap="nowrap">
                            @if($rsProducts["Products_Status"]==0)
                                <span style="color:red">未审核</span>
                            @else
                                <span style="color:blue">已审核</span>
                            @endif
                        </td>
                        <td nowrap="nowrap">
                            @if($rsProducts["Integrationswitch"]==1)
                                <span style="color:red" dataid="1" proid="{{$rsProducts["Products_ID"]}}" class="Integrationswitch" id="Integrationswitch{{$rsProducts["Products_ID"]}}">否</span>
                            @else
                                <span style="color:blue" dataid="0" proid="{{$rsProducts["Products_ID"]}}" class="Integrationswitch" id="Integrationswitch{{$rsProducts["Products_ID"]}}">是</span>
                            @endif
                        </td>
                        <td nowrap="nowrap">{{date("Y-m-d",$rsProducts["Products_CreateTime"])}}</td>
                        <td class="last" nowrap="nowrap">
                            <a href="{{route('admin.product.product_audit', ['id' => $rsProducts["Products_ID"]])}}">
                                <img src="/admin/images/ico/mod.gif" align="absmiddle" alt="产品审核" />
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="blank20"></div>
                {{ $lists->links() }}
            </div>

        </div>
    </div>

</div>
<script>
$(document).ready(function(){

    $(".mousehand").each(function(){
        $(this).click(function(){
            create_layer('商品佣金详情', '/admin/product/product_commission?ProductsID='+$(this).attr('id'),800,400,0,0);
        })
    })

    //批量审核
    $('#auditingAll').click(function(){
        var postData = $('.auditingid').serialize();
        if(postData === ''){
            alert('请选择要审核的产品！');
            return false;
        }
        postData = postData + '&' + 'action=audit';
        $.post('{{route('admin.product.product_active')}}',postData,function(data){
            if(data.status === 1){
                alert(data.info);
                $('.delid').removeAttr('checked');
                window.location.reload();
            } else {
                alert(data.info);
                $('.delid').removeAttr('checked');
                window.location.reload();
            }
        },'json');
    });

    $('#Integrationswitchall').click(function(){
        var postData = $('.auditingid').serialize();
        if(postData === ''){
            alert('请选择要设置的产品！');
            return false;
        }
        postData = postData + '&' + 'action=inteegratseitch';
        $.post('{{route('admin.product.product_active')}}',postData,function(data){
            if(data.status === 1){
                alert(data.info);
                $('.delid').removeAttr('checked');
                window.location.reload();
            } else {
                alert(data.info);
                $('.delid').removeAttr('checked');
                window.location.reload();
            }
        },'json');
    });

    $('.Integrationswitch').click(function(){
        var dataid = $(this).attr("dataid");
        var proid = $(this).attr("proid");
        if(dataid === ''){
            dataid = 0;
        }
        postData = 'action=inteegratsimp&dataid='+dataid+'&proid='+proid;
        $.post('{{route('admin.product.product_active')}}',postData,function(data){
        if(data.status === 1){
            $('#Integrationswitch'+data.proid).attr('dataid',data.infodataid);
            $('#Integrationswitch'+data.proid).text(data.info);
        } else {
            alert(data.info);
            window.location.reload();
        }
        },'json');
    });
});

function selectAll(checkbox)
{
    $('input[type=checkbox]').prop('checked', $(checkbox).prop('checked'));
}


function create_layer (title, url, width, height){
    var callback = arguments[6] ? arguments[6] : function(){};
    layer.open({
        type: 2,
        title: title,
        fix: false,
        shadeClose: true,
        maxmin: true,
        area: [width+'px', height+'px'],
        content: url,
        end:function(){
            if(callback != undefined){
                callback();
            }
        }
    });
}
</script>
@endsection