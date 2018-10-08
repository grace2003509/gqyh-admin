@extends('admin.layouts.main')
@section('ancestors')
    <li>商家支付记录</li>
@endsection
@section('page', '保证金退款详情')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/audit.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">

                <div class="w">
                    <div class="main_xx">
                        <p>支付宝账号：@if(!empty($BizBackInfo['alipay_account'])) {{$BizBackInfo['alipay_account']}} @else 未填写 @endif</p>
                        <p>支付宝姓名：@if(!empty($BizBackInfo['alipay_username'])) {{$BizBackInfo['alipay_username']}} @else 未填写 @endif</p>
                        <p>申请理由：
                            <span>&nbsp;&nbsp;&nbsp;</span>
                            <span>
                                @if(!empty($BizBackInfo['info'])) {{$BizBackInfo['info']}} @else 未填写 @endif
                            </span>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection