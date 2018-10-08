@extends('admin.layouts.main')
@section('ancestors')
    <li>商家资质审核管理</li>
@endsection
@section('page', '商家入驻资质审核详情')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/audit.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <style type="text/css">
        #bizs .search *{font-size:12px;}
    </style>

    <div class="box">

        <div id="iframe_page">
            <div class="iframe_content">

                <div class="w">
                    <div class="main_xx">
                        <p>基本信息</p>

                        <div class="group ">
                            <span>认证类型：</span>
                            <span>
                                @if(!empty($BizInfo['authtype']))
                                    @if($BizInfo['authtype']==1)企业认证 @elseif($BizInfo['authtype']==2)个人认证 @endif
                                @endif
                            </span>
                        </div>
                        @if($BizInfo['authtype']==1)
                        <div class="group ">
                            <span>公司名称：</span>
                            <span>@if(!empty($baseinfo['company_name'])) {{$baseinfo['company_name']}} @endif</span>
                        </div>
                        <div class="group ">
                            <span>公司主体：</span>
                            <span>
                            @if(!empty($baseinfo['main_type']))
                                @if($baseinfo['main_type']==1)
                                    大陆企业
                                @elseif($baseinfo['main_type']==2)
                                    境外企业
                                @elseif($baseinfo['main_type']==3)
                                    保税区
                                @endif
                            @endif
                            </span>
                        </div>
                        <div class="group ">
                            <span>公司固话：</span>
                            <span>
                                @if(!empty($baseinfo['tel'][0])) {{$baseinfo['tel'][0]}} @endif
                                @if(!empty($baseinfo['tel'][1])) {{$baseinfo['tel'][1]}} @endif
                            </span>
                        </div>
                        <div class="group ">
                            <span>企业所在地：</span>
                            <span>
                                @if(!empty($baseinfo['city'][0]))
                                    {{$baseinfo['city'][0]}}
                                @endif
                                @if(!empty($baseinfo['city'][1]))
                                    {{$baseinfo['city'][1]}}
                                @endif
                                @if(!empty($baseinfo['city'][2]))
                                    {{$baseinfo['city'][2]}}
                                @endif
                                @if(!empty($baseinfo['address']))
                                    {{$baseinfo['address']}}
                                @endif
                            </span>
                        </div>
                        @endif
                        <div class="group ">
                            <span>主营商品：</span>
                            <span>@if(!empty($baseinfo['goods'])) {{$baseinfo['goods']}} @endif</span>
                        </div>
                        <div class="group ">
                            <span>联系人：</span>
                            <span>@if(!empty($baseinfo['contacts'])) {{$baseinfo['contacts']}} @endif</span>
                        </div>
                        <div class="group ">
                            <span>手机：</span>
                            <span>@if(!empty($baseinfo['mobile'])) {{$baseinfo['mobile']}} @endif</span>
                        </div>
                        <div class="group ">
                            <span>邮箱地址：</span>
                            <span>@if(!empty($baseinfo['email'])) {{$baseinfo['email']}} @endif</span>
                        </div>

                    </div>

                    <div class="main_xx">
                        <p>资质信息</p>
                        @if($BizInfo['authtype']==1)
                        <div class="group ">
                            <span>企业类型：</span>
                            <span>
                            @if(!empty($authinfo['company_type']))
                                @if($authinfo['company_type']==1)
                                    有限责任公司
                                @elseif($authinfo['company_type']==2)
                                    农民专业合作社
                                @elseif($authinfo['company_type']==3)
                                    中外合资企业
                                @elseif($authinfo['company_type']==4)
                                    外国或港澳台地区独资企业
                                @endif
                            @endif
                            </span>
                        </div>
                        <div class="group ">
                            <span>企业住所：</span>
                            <span>@if(!empty($authinfo['compay_add'])) {{$authinfo['compay_add']}} @endif</span>
                        </div>
                        <div class="group ">
                            <span>注册资金：</span>
                            <span>@if(!empty($authinfo['compay_reg_money'])) {{$authinfo['compay_reg_money']}} @endif</span>
                        </div>
                        <div class="group ">
                            <span>营业执照注册号或统一社会信用代码：</span>
                            <span>@if(!empty($authinfo['compay_license'])) {{$authinfo['compay_license']}} @endif</span>
                        </div>
                        <div class="group ">
                            <span>法人：</span>
                            <span>@if(!empty($authinfo['compay_user'])) {{$authinfo['compay_user']}} @endif </span>
                        </div>

                        <div class="group ">
                            <span class="l">法人身份证扫描件：</span>
                            <span>
                                @if(!empty($authinfo['compay_shenfenimg']))
                                    <a href='{{$authinfo['compay_shenfenimg']}}' target="_blank">
                                        <img src="{{$authinfo['compay_shenfenimg']}}">
                                    </a>
                                @endif
                            </span>
                        </div>
                        <div class="group ">
                            <span class="l">营业执照影印件：</span>
                            <span>
                                @if(!empty($authinfo['compay_licenseimg']))
                                    <a href='{{$authinfo['compay_licenseimg']}}' target="_blank">
                                        <img src="{{$authinfo['compay_licenseimg']}}">
                                    </a>
                                @endif
                            </span>
                        </div>
                        <div class="group ">
                            <span class="l">税务登记证扫描件：</span>
                            <span>
                                @if(!empty($authinfo['compay_shuiwuimg']))
                                    <a href='{{$authinfo['compay_shuiwuimg']}}' target="_blank">
                                        <img src="{{$authinfo['compay_shuiwuimg']}}">
                                    </a>
                                @endif
                            </span>
                        </div>
                        @else
                        <div class="group ">
                            <span>真实姓名：</span>
                            <span>@if(!empty($authinfo['per_realname'])) {{$authinfo['per_realname']}} @endif</span>
                        </div>
                        <div class="group ">
                            <span>身份证号码：</span>
                            <span>@if(!empty($authinfo['per_shenfenid'])) {{$authinfo['per_shenfenid']}} @endif</span>
                        </div>

                        <div class="group ">
                            <span class="l">身份证扫描件：</span>
                            <span>
                            @if(!empty($authinfo['per_shenfenimg']))
                                <a href='{{$authinfo['per_shenfenimg']}}' target="_blank">
                                    <img src="@if(!empty($authinfo['per_shenfenimg'])) {{$authinfo['per_shenfenimg']}} @endif">
                                </a>
                            @endif
                            </span>
                        </div>
                        @endif
                    </div>
                    <div class="main_xx">
                        <p>账户信息</p>
                        <div class="group ">
                            <span>提现方式：</span>
                            <span>
                            @if(!empty($accountinfo['withdraw_type']))
                                @if($accountinfo['withdraw_type']==1) 银行卡 @elseif($accountinfo['withdraw_type']==2) 支付宝 @endif
                            @endif
                            </span>
                        </div>
                        @if($accountinfo['withdraw_type']==1)
                        <div class="group ">
                            <span>开户城市：</span>
                            <span>@if(!empty($accountinfo['blan_city'])) {{$accountinfo['blan_city']}} @endif</span>
                        </div>
                        <div class="group ">
                            <span>开户银行：</span>
                            <span>@if(!empty($accountinfo['blan_name'])) {{$accountinfo['blan_name']}} @endif</span>
                        </div>
                        <div class="group ">
                            <span>开户姓名：</span>
                            <span>@if(!empty($accountinfo['blan_realname'])) {{$accountinfo['blan_realname']}} @endif</span>
                        </div>
                        <div class="group ">
                            <span>银行卡号：</span>
                            <span>@if(!empty($accountinfo['blan_card'])) {{$accountinfo['blan_card']}} @endif</span>
                        </div>
                        @else
                        <div class="group ">
                            <span>支付宝账号：</span>
                            <span>@if(!empty($accountinfo['alipay_account'])) {{$accountinfo['alipay_account']}} @endif</span>
                        </div>
                        <div class="group ">
                            <span>姓名：</span>
                            <span>@if(!empty($accountinfo['alipay_realname'])) {{$accountinfo['alipay_realname']}} @endif </span>
                        </div>
                        @endif
                    </div>
                    <div>
                        @if ($BizInfo['status'] !=2 )
                            <a style="cursor:hand;" href="{{route('admin.business.biz_apply_index', ['id' => $BizInfo['id'], 'action' => 'read'])}}">
                                <button id="btn" class="btn_xx">通过 </button>
                            </a>
                        @endif
                        @if ($BizInfo['status'] == 1 )
                            <a style="cursor:hand;" href="{{route('admin.business.biz_apply_index', ['id' => $BizInfo['id'], 'action' => 'back'])}}">
                                <button id="btn" class="btn_xx">驳回 </button>
                            </a>
                        @endif
                    </div>
                    <div style="height: 30px;"></div>
                </div>

            </div>
        </div>

    </div>

@endsection