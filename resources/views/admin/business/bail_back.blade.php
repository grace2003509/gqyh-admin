@extends('admin.layouts.main')
@section('ancestors')
    <li>商家支付记录</li>
@endsection
@section('page', '保证金退款列表')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">

                <div id="bizs" class="r_con_wrap">

                    @include('admin.business.menu_top2')

                    <table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                        <thead>
                        <tr>
                            <td width="6%" nowrap="nowrap">ID</td>
                            <td width="8%" nowrap="nowrap">商家账号</td>
                            <td width="8%" nowrap="nowrap">商家名称</td>
                            <td width="8%" nowrap="nowrap">支付宝姓名</td>
                            <td width="8%" nowrap="nowrap">支付宝账号</td>
                            <td width="8%" nowrap="nowrap">退款金额</td>
                            <td width="14%" nowrap="nowrap">申请时间</td>
                            <td width="8%" nowrap="nowrap">状态</td>
                            <td width="10%" nowrap="nowrap" class="last">操作</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lists as $k=>$rsBiz)
                        <tr>
                            <td nowrap="nowrap">{{$rsBiz["id"]}}</td>
                            <td>@if(!empty($rsBiz["biz"]['Biz_Account'])) {{$rsBiz["biz"]['Biz_Account']}} @else 商家不存在 @endif</td>
                            <td>@if(!empty($rsBiz["biz"]['Biz_Name'])) {{$rsBiz["biz"]['Biz_Name']}} @endif</td>
                            <td>{{$rsBiz["alipay_username"]}}</td>
                            <td>{{$rsBiz["alipay_account"]}}</td>
                            <td>{{$rsBiz["back_money"]}}</td>
                            <td nowrap="nowrap">{{date("Y-m-d H:i:s",$rsBiz["addtime"])}}</td>
                            <td nowrap="nowrap">{{$_Status[$rsBiz["status"]]}}</td>
                            <td class="last" nowrap="nowrap">
                                <a class="see" href="{{route('admin.business.bail_show', ['id' => $rsBiz["id"]])}}">[查看]</a>
                                @if($rsBiz["status"] == 1)
                                <a href="{{route('admin.business.bail_back', ['id' => $rsBiz['id'], 'action' => 'read'])}}">[通过]</a>
                                <a href="{{route('admin.business.bail_back', ['id' => $rsBiz['id'], 'action' => 'back'])}}">[驳回]</a>
                                @endif
                                @if($rsBiz["status"] == 2)
                                <a href="{{route('admin.business.bail_back', ['id' => $rsBiz['id'], 'bizid' => $rsBiz['biz_id'], 'action' => 'begin_pay'])}}">[退款]</a>
                                @endif
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