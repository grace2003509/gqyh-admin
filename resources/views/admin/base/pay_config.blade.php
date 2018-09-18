@extends('admin.layouts.main')
@section('ancestors')
    <li>基础设置</li>
@endsection
@section('page', '支付设置')
@section('subcontent')
    <link href='/static/css/bootstrap.min.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/pay.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <link rel="stylesheet" href="/admin/js/kindeditor/themes/default/default.css" />
    <script type='text/javascript' src="/admin/js/kindeditor/kindeditor-min.js"></script>
    <script type='text/javascript' src="/admin/js/kindeditor/lang/zh_CN.js"></script>

    <div class="box">

        <div id="shopping" style="width: 50%;" >
            <table width="70%" align="center" border="0" cellpadding="5" cellspacing="0"  class="r_con_table" >
                <tr>
                    <td valign="top">
                        <form action="{{route('admin.base.pay_edit')}}" method="post" id="web_payment_form">
                            {{csrf_field()}}
                            <ul style="margin-right: 50px;">
                                <li>
                                    <h4>微信支付
                                        <span>
                                            <input type="checkbox" value="1" id="check_0" name="PaymentWxpayEnabled"
                                                   @if($rsConfig["PaymentWxpayEnabled"] == 1) checked @endif onClick="show_pay_ment(0);"/>
                                            启用
                                        </span>
                                    </h4>
                                    <dl id="pay_0" style="display:block">
                                        <dd>
                                            <input type="radio" name="PaymentWxpayType" value="0" @if($rsConfig["PaymentWxpayType"] == 0) checked @endif id="type_0" onClick="document.getElementById('paysignkey').style.display='block';" style="width:25px; height:10px"/>
                                            <label for="type_0">旧版本</label>&nbsp;&nbsp;
                                            <input type="radio" name="PaymentWxpayType" value="1" @if($rsConfig["PaymentWxpayType"] == 1) checked @endif id="type_1" onClick="document.getElementById('paysignkey').style.display='none';" style="width:25px; height:10px"/>
                                            <label for="type_1">新版本</label></dd>
                                        <dd>
                                            商户号PartnerId：
                                            <input type="text" name="PaymentWxpayPartnerId" value="{{$rsConfig["PaymentWxpayPartnerId"]}}" maxlength="10"/>
                                        </dd>
                                        <dd>&nbsp;
                                            密钥PartnerKey：
                                            <input type="text" name="PaymentWxpayPartnerKey" value="{{$rsConfig["PaymentWxpayPartnerKey"]}}" maxlength="32"/>
                                        </dd>
                                        <dd id="paysignkey" style="display:<?php echo $rsConfig["PaymentWxpayType"] == 0 ? "block" : "none"; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            PaySignKey：
                                            <input type="text" name="PaymentWxpayPaySignKey" value="{{$rsConfig["PaymentWxpayPaySignKey"]}}" maxlength="128"/>
                                        </dd>
                                        <dd style="position:relative">&nbsp;
                                            微信支付商户证书：
                                            <input type="text" class="input" id="CertPath" name="CertPath" value="@if($rsConfig["PaymentWxpayCert"]) {{$rsConfig["PaymentWxpayCert"]}} @endif" maxlength="500" placeholder="apiclient_cert.pem" />
                                            <div class="file" style="margin:10px;">
                                                <input name="PaymentWxpayCertUpload" id="PaymentWxpayCertUpload" type="button" style="width:120px" value="上传图片" />
                                            </div>
                                        </dd>
                                        <dd style="position:relative">&nbsp;
                                            微信支付证书密钥：
                                            <input type="text" class="input" id="KeyPath" name="KeyPath" value="@if($rsConfig["PaymentWxpayKey"]) {{$rsConfig["PaymentWxpayKey"]}} @endif" maxlength="500" placeholder="apiclient_key.pem"/>
                                            <div class="file" style="margin:10px;">
                                                <input name="PaymentWxpayKeyUpload" id="PaymentWxpayKeyUpload" type="button" style="width:120px" value="上传图片" />
                                            </div>
                                        </dd>
                                        <dd style="margin-top:3px; color:#999">
                                            微信支付商户证书、微信支付证书密钥主要适用于分销商试用
                                            <span style="color:#F00"> 微信红包提现 </span>和<span style="color:#F00"> 抢红包 </span>功能
                                        </dd>
                                        <dd>
                                            还需到“<a href="{{route('admin.base.wechat_set')}}">微信授权配置</a>”设置“AppId”和“AppSecret”
                                        </dd>
                                    </dl>
                                </li>
                                <?php  if(isset($appwitch20180321) && $appwitch20180321){ ?>
                                <li>
                                    <h4>APP微信支付
                                        <span>
                                            <input type="checkbox" value="1" id="check_6" name="PaymentAppWxpayEnabled" @if($rsConfig["PaymentAppWxpayEnabled"] == 1) checked @endif onClick="show_pay_ment(6);"/>
                                            启用
                                        </span>
                                    </h4>
                                    <dl id="pay_6" style="display:@if($rsConfig["PaymentAppWxpayEnabled"] != 1) none @endif">
                                        <dd>&nbsp;&nbsp;api key：<input type="text" name="PaymentAppWxpayPaySignKey" value="{{$rsConfig["PaymentAppWxpayPaySignKey"]}}"/></dd>
                                        <dd>APP微信商户号<input type="text" name="PaymentAppWxpayPartnerId" value="{{$rsConfig["PaymentAppWxpayPartnerId"]}}" maxlength="10"/></dd>
                                        <dd>APP微信App ID：<input type="text" name="PaymentAppWechatAppId" value="{{$rsConfig["PaymentAppWechatAppId"]}}" maxlength="30"/></dd>
                                        <dd style="position:relative">
                                            &nbsp;微信APP支付商户证书：<input type="text" class="input" id="CertAppPath" name="CertAppPath" value="@if($rsConfig["PaymentAppWxpayCert"]) {{$rsConfig["PaymentAppWxpayCert"]}} @endif" maxlength="500" placeholder="apiclient_cert.pem" />
                                            <div class="file" style="margin:10px;">
                                                <input name="PaymentAppWxpayCertUpload" id="PaymentAppWxpayCertUpload" type="button" style="width:120px" value="上传图片" />
                                            </div>
                                        </dd>
                                        <dd style="position:relative">
                                            &nbsp;微信APP支付证书密钥：
                                            <input type="text" class="input" id="KeyAppPath" name="KeyAppPath" value="@if($rsConfig["PaymentAppWxpayKey"]) {{$rsConfig["PaymentAppWxpayKey"]}} @endif" maxlength="500" placeholder="apiclient_key.pem" />
                                            <div class="file" style="margin:10px;">
                                                <input name="PaymentAppWxpayKeyUpload" id="PaymentAppWxpayKeyUpload" type="button" style="width:120px" value="上传图片" />
                                            </div>
                                        </dd>
                                    </dl>
                                </li>
                                <?php } ?>
                                <li>
                                    <h4>易宝支付<span>
                                    <input type="checkbox" value="1" id="check_1" name="PaymentYeepayEnabled" @if($rsConfig["PaymentYeepayEnabled"] == 1) checked @endif onClick="show_pay_ment(1);"/>
                                     启用</span></h4>
                                    <dl id="pay_1" style="display:@if($rsConfig["PaymentYeepayEnabled"] != 1) none @endif">
                                        <dd>&nbsp;&nbsp;商户编号：<input type="text" name="PaymentYeepayAccount" value="{{$rsConfig["PaymentYeepayAccount"]}}"/></dd>
                                        <dd>&nbsp;&nbsp;商户私钥：<input type="text" name="PaymentYeepayPrivateKey" value="{{$rsConfig["PaymentYeepayPrivateKey"]}}"/></dd>
                                        <dd>&nbsp;&nbsp;商户公钥：<input type="text" name="PaymentYeepayPublicKey" value="{{$rsConfig["PaymentYeepayPublicKey"]}}"/></dd>
                                        <dd>&nbsp;&nbsp;易宝公钥：<input type="text" name="PaymentYeepayYeepayPublicKey" value="{{$rsConfig["PaymentYeepayYeepayPublicKey"]}}"/></dd>
                                        <dd>商品类别码：<input type="text" name="PaymentYeepayProductCatalog" value="{{$rsConfig["PaymentYeepayProductCatalog"]}}"/></dd>
                                    </dl>
                                </li>
                                <li>
                                    <h4>支付宝<span>
                                    <input type="checkbox" value="1" id="check_2" name="AlipayEnabled" @if($rsConfig["Payment_AlipayEnabled"]) checked @endif onclick="show_pay_ment(2);"/>
                                    启用 <a href="https://b.alipay.com/order/productDetail.htm?productId=2013080604609688" target="_blank">申请</a></span></h4>
                                    <dl id="pay_2" style="display:@if($rsConfig["Payment_AlipayEnabled"] != 1) none @endif">
                                        <dd>合作身份ID：
                                            <input type="text" name="AlipayPartner" value="{{$rsConfig["Payment_AlipayPartner"]}}" maxlength="16"/>
                                        </dd>
                                        <dd>安全检验码：
                                            <input type="text" name="AlipayKey" value="{{$rsConfig["Payment_AlipayKey"]}}" maxlength="32"/>
                                        </dd>
                                        <dd>支付宝账号：
                                            <input type="text" name="AlipayAccount" value="{{$rsConfig["Payment_AlipayAccount"]}}" maxlength="30"/>
                                        </dd>
                                    </dl>
                                </li>
                                <li>
                                    <h4>银联支付<span>
                                    <input type="checkbox" value="1" id="check_3" name="UnionpayEnabled" @if($rsConfig["Payment_UnionpayEnabled"] == 1) checked @endif onclick="show_pay_ment(3);"/>
                                    启用</span></h4>
                                    <dl id="pay_3" style="display:@if($rsConfig["Payment_UnionpayEnabled"] != 1) none @endif">
                                        <dd>商户号：
                                            <input type="text" name="Unionum" value="@if($rsConfig["Payment_UnionpayAccount"]){{$rsConfig["Payment_UnionpayAccount"]}}@endif" maxlength="16"/>
                                        </dd>
                                        <dd style="position:relative">&nbsp; 商户私钥证书：<input type="text" class="input" id="PfxPath" name="PfxPath" value="@if($rsConfig["PaymentUnionpayPfx"]){{$rsConfig["PaymentUnionpayPfx"]}}@endif" maxlength="500" />
                                            <div class="file" style="margin:10px;">
                                                <input name="PfxUpload" id="PfxUpload" type="button" style="width:120px" value="上传图片" />
                                            </div>
                                        </dd>
                                        <dd>证书密码：
                                            <input type="text" name="Pfxpwd" value="@if($rsConfig["PaymentUnionpayPfxpwd"]){{$rsConfig["PaymentUnionpayPfxpwd"]}}@endif" maxlength="16"/>
                                        </dd>
                                        <dd style="position:relative">&nbsp; 银联公钥证书：<input type="text" class="input" id="CerPath" name="CerPath" value="@if($rsConfig["PaymentUnionpayCer"]) {{$rsConfig["PaymentUnionpayCer"]}} @endif" maxlength="500"/>
                                            <div class="file" style="margin:10px;">
                                                <input name="CerUpload" id="CerUpload" type="button" style="width:120px" value="上传图片" />
                                            </div>
                                        </dd>
                                    </dl>
                                </li>
                                <li>
                                    <h4>余额支付<span>
                                    <input type="checkbox" value="1" name="RemainderEnabled" @if($rsConfig["Payment_RmainderEnabled"] == 1) checked @endif />
                                    启用</span></h4>
                                </li>
                                <li>
                                    <h4>线下支付<span>
                                    <input type="checkbox" value="1" id="check_3" name="OfflineEnabled" @if($rsConfig["Payment_OfflineEnabled"] == 1) checked @endif onClick="show_pay_ment(3);"/>
                                    启用（填写收款账号信息）</span></h4>
                                    <dl id="pay_3" style="display:@if($rsConfig["Payment_OfflineEnabled"] != 1) none @endif">
                                        <dd>
                                            <textarea name="OfflineInfo">{{$rsConfig["Payment_OfflineInfo"]}}</textarea>
                                        </dd>
                                    </dl>
                                </li>
                            </ul>
                            <div>
                                <input type="submit" name="submit_button" value="提交保存"/>
                            </div>
                            <input type="hidden" name="action" value="payment">
                        </form>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>

    <script>
        KindEditor.ready(function(K) {
            var editor = K.editor({
                uploadJson : '{{route('admin.upload_json')}}',
                fileManagerJson : '{{route('admin.file_manager_json')}}',
                showRemote : true,
                allowFileManager : true,
            });

            K('#PaymentWxpayCertUpload').click(function(){
                editor.loadPlugin('insertfile', function(){
                    editor.plugin.fileDialog({
                        imageUrl : K('#CertPath').val(),
                        clickFn : function(url, title, width, height, border, align){
                            K('#CertPath').val(url);
                            editor.hideDialog();
                        }
                    });
                });
            });

            K('#PaymentWxpayKeyUpload').click(function(){
                editor.loadPlugin('insertfile', function(){
                    editor.plugin.fileDialog({
                        imageUrl : K('#KeyPath').val(),
                        clickFn : function(url, title, width, height, border, align){
                            K('#KeyPath').val(url);
                            editor.hideDialog();
                        }
                    });
                });
            });

            K('#PaymentAppWxpayCertUpload').click(function(){
                editor.loadPlugin('insertfile', function(){
                    editor.plugin.fileDialog({
                        imageUrl : K('#CertAppPath').val(),
                        clickFn : function(url, title, width, height, border, align){
                            K('#CertAppPath').val(url);
                            editor.hideDialog();
                        }
                    });
                });
            });

            K('#PaymentAppWxpayKeyUpload').click(function(){
                editor.loadPlugin('insertfile', function(){
                    editor.plugin.fileDialog({
                        imageUrl : K('#KeyAppPath').val(),
                        clickFn : function(url, title, width, height, border, align){
                            K('#KeyAppPath').val(url);
                            editor.hideDialog();
                        }
                    });
                });
            });

            K('#PfxUpload').click(function(){
                editor.loadPlugin('insertfile', function(){
                    editor.plugin.fileDialog({
                        imageUrl : K('#PfxPath').val(),
                        clickFn : function(url, title, width, height, border, align){
                            K('#PfxPath').val(url);
                            editor.hideDialog();
                        }
                    });
                });
            });

            K('#CerUpload').click(function(){
                editor.loadPlugin('insertfile', function(){
                    editor.plugin.fileDialog({
                        imageUrl : K('#CerPath').val(),
                        clickFn : function(url, title, width, height, border, align){
                            K('#CerPath').val(url);
                            editor.hideDialog();
                        }
                    });
                });
            });
        });

            function show_pay_ment(id) {
                if (document.getElementById('check_' + id).checked == false) {
                    document.getElementById('pay_' + id).style.display = 'none';
                } else {
                    document.getElementById('pay_' + id).style.display = 'block';
                }
            }

    </script>

@endsection