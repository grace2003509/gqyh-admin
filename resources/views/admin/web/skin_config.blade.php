@extends('admin.layouts.main')
@section('ancestors')
    <li>微官网</li>
@endsection
@section('page', '风格设置')
@section('subcontent')
    <link href='/admin/css/global.css' rel='stylesheet' type='text/css'/>
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css'/>
    <link href='/admin/css/web.css' rel='stylesheet' type='text/css'/>

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">

                <div id="skin" class="r_con_wrap">
                    {{--<div class="trade">
                        <a href="?TradeID=0" class="@if($TradeID==0) cur @endif">全部</a>
                        <a href="?TradeID=1" class="@if($TradeID==1) cur @endif">餐饮</a>
                        <a href="?TradeID=2" class="@if($TradeID==2) cur @endif">旅游</a>
                        <a href="?TradeID=3" class="@if($TradeID==3) cur @endif">婚庆</a>
                        <a href="?TradeID=4" class="@if($TradeID==4) cur @endif">教育</a>
                        <a href="?TradeID=5" class="@if($TradeID==5) cur @endif">汽车</a>
                        <a href="?TradeID=6" class="@if($TradeID==6) cur @endif">酒店</a>
                    </div>--}}
                    <div class="list">
                        <ul>
                            @foreach($skins as $key => $rsSkin)
                                <li class="@if($rsConfig['Skin_ID']==$rsSkin['Skin_ID']) cur @endif">
                                    <div class="item">
                                        <div class="img" title="点击选择微官网风格"
                                             onClick="SelectSkinID('{{$rsSkin['Skin_ID']}}','{{$TradeID}}');">
                                            <img src="{{$rsSkin['Skin_ImgPath']}}"/>
                                        </div>
                                        <input type="button"
                                               onClick="ReSkinID('{{$rsSkin['Skin_ID']}}','{{$TradeID}}');"
                                               class="btn_green" name="submit_button"
                                               style="cursor:pointer;margin:5px 0px 0px 25px"
                                               value="恢复@if($rsSkin['Skin_ID']==1) Diy个性首页 @else {{$key}}号模版 @endif"/>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <div class="clear"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script type=text/javascript>
        function SelectSkinID(Skin_ID, Trade_ID) {
            location.href = "/admin/web/skin_config?action=set&Skin_ID=" + Skin_ID + "&Trade_ID=" + Trade_ID;
        }

        function ReSkinID(Skin_ID, Trade_ID) {
            if (confirm("您确定要重置此风格吗？")) {
                location.href = "/admin/web/skin_config?action=setre&Skin_ID=" + Skin_ID + "&Trade_ID=" + Trade_ID;
            }
        }
    </script>
@endsection