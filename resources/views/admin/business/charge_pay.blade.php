@extends('admin.layouts.main')
@section('ancestors')
    <li>商家支付记录</li>
@endsection
@section('page', '续费支付列表')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <style type="text/css">
        #bizs .search{padding:10px; background:#f7f7f7; border:1px solid #ddd; margin-bottom:8px; font-size:12px;}
        #bizs .search *{font-size:12px;}
        #bizs .search .search_btn{background:#1584D5; color:white; border:none; height:22px; line-height:22px; width:50px;}
    </style>

    <div class="box">

        <div id="iframe_page">
            <div class="iframe_content">

                <div id="bizs" class="r_con_wrap">

                    @include('admin.business.menu_top2')

                    <form class="search" method="get" action="{{route('admin.business.charge_pay')}}">
                        商家账号：
                        <input type="text" name="Biz_Account" value="" placeholder='请输入商家账号' class="form_input" size="15" />
                        状态：
                        <select name="status">
                            <option value="all">全部</option>
                            <option value="0">未付款</option>
                            <option value="1">已付款</option>
                        </select>
                        <input type="hidden" name="search" value="1" />
                        <input type="submit" class="search_btn" value="搜索" />
                    </form>
                    <table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                        <thead>
                        <tr>
                            <td width="5%" nowrap="nowrap">ID</td>
                            <td width="13%" nowrap="nowrap">商家账号</td>
                            <td width="8%" nowrap="nowrap">订单类型</td>
                            <td width="8%" nowrap="nowrap">保证金</td>
                            <td width="8%" nowrap="nowrap">开通年限</td>
                            <td width="8%" nowrap="nowrap">年费</td>
                            <td width="8%" nowrap="nowrap">总额</td>
                            <td width="8%" nowrap="nowrap">状态</td>
                            <td width="8%" nowrap="nowrap">支付方式</td>
                            <td width="10%" nowrap="nowrap">提交时间</td>
                            <td width="10%" nowrap="nowrap" class="last">支付时间</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lists as $k=>$rsBiz)
                        <tr>
                            <td nowrap="nowrap">{{$rsBiz["id"]}}</td>
                            <td>@if(!empty($rsBiz["biz"])) {{$rsBiz["biz"]['Biz_Account']}} @else 商家不存在或已删除 @endif</td>
                            <td>
                                @if($rsBiz['type']==1)入驻订单 @elseif($rsBiz['type']==2)年费订单 @elseif($rsBiz['type']==3)保证金订单 @endif
                            </td>
                            <td nowrap="nowrap">{{$rsBiz["bond_free"]}}</td>
                            <td nowrap="nowrap">{{$rsBiz["years"].'年'}}</td>
                            <td nowrap="nowrap">{{$rsBiz["year_free"]}}</td>
                            <td nowrap="nowrap">{{$rsBiz["total_money"]}}</td>
                            <td nowrap="nowrap">{{$_Status[$rsBiz["status"]]}}</td>
                            <td nowrap="nowrap">{{$rsBiz["order_paymentmethod"]}}</td>
                            <td nowrap="nowrap">{{date("Y-m-d H:i:s",$rsBiz["addtime"])}}</td>
                            <td class="last" nowrap="nowrap">
                                @if(!empty($rsBiz["paytime"])) {{date("Y-m-d H:i:s",$rsBiz["paytime"])}} @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="blank20"></div>
                    {{$lists->links()}}
                </div>

            </div>
        </div>

    </div>

@endsection