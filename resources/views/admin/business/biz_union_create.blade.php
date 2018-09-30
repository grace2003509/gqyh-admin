@extends('admin.layouts.main')
@section('ancestors')
    <li>商家管理</li>
@endsection
@section('page', '添加联盟商家')
@section('subcontent')

<link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

<script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<script type='text/javascript' src='/admin/js/global.js'></script>
<link rel="stylesheet" href="/admin/js/kindeditor/themes/default/default.css" />
<script type='text/javascript' src="/admin/js/kindeditor/kindeditor-min.js"></script>
<script type='text/javascript' src="/admin/js/kindeditor/lang/zh_CN.js"></script>
<script type='text/javascript' src="/static/js/select2.js"></script>
<script type="text/javascript" src="/static/js/location.js"></script>
<script type="text/javascript" src="/admin/js/area.js"></script>
<script type="text/javascript" src="/admin/js/shopbiz.js"></script>
<link href="/static/css/select2.css" rel="stylesheet"/>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak={{$ak_baidu}}"></script>

<style>
    #loc_province, #loc_city, #loc_town{display:none;}
</style>

<div class="box">
    <div id="iframe_page">
        <div class="iframe_content">

            <div id="bizs" class="r_con_wrap">

                <form class="r_con_form" method="post" action="{{route('admin.business.biz_union_store')}}" id="group_edit">
                    {{csrf_field()}}
                    {{--<div class="rows">
                        <label>邀请码</label>
                        <span class="input">
                          <input type="text" name="Invitation_Code" value="" class="form_input" size="35" maxlength="50" />
                          <span class="fc_red"></span>
                        </span>
                        <div class="clear"></div>
                    </div>--}}
                    <div class="rows">

                        <label>登录账号</label>
                        <span class="input">
                          <input type="text" name="Account" value="{{old('Account')}}" class="form_input" size="35" maxlength="50" />
                          <span class="fc_red">*</span>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows">
                        <label>登录密码</label>
                        <span class="input">
                          <input type="password" name="PassWord" value="{{old('PassWord')}}" class="form_input" size="35" maxlength="50" />
                          <span class="fc_red">*</span>
                        </span>
                        <div class="clear"></div>
                    </div>

                    <div class="rows">
                        <label>确认登录密码</label>
                        <span class="input">
                          <input type="password" name="PassWord_confirmation" value="{{old('PassWord_confirmation')}}" class="form_input" size="35" maxlength="50" />
                          <span class="fc_red">*</span>
                        </span>
                        <div class="clear"></div>
                    </div>

                    <div class="rows">
                        <label>所属分组</label>
                        <span class="input">
                          <select name="GroupID">
                          @foreach($groups as $k=>$v)
                              <option value="{{$v["Group_ID"]}}" @if(old('GroupID') == $v['Group_ID']) selected @endif >{{$v["Group_Name"]}}</option>
                          @endforeach
                          </select>
                          <span class="fc_red">*</span>
                        </span>
                        <div class="clear"></div>
                    </div>

                    <div class="rows">
                        <label>到期时间</label>
                        <span class="input">
                          <input type="date" name="expiredate" value="{{old('expiredate')}}" class="form_input" size="35" maxlength="50" />
                          <span class="fc_red">*</span>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows">
                        <label>保证金</label>
                        <span class="input">
                          <input type="number" name="bond_free" value="{{old('bond_free')}}" class="form_input" size="35" maxlength="50" />
                          <span class="fc_red">*</span>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows">
                        <label>商家名称</label>
                        <span class="input">
                          <input type="text" name="Name" value="{{old('Name')}}" class="form_input" size="35" maxlength="50" />
                          <span class="fc_red">*</span>
                        </span>
                        <div class="clear"></div>
                    </div>

                    <div class="rows">
                        <label>隶属分类</label>
                        <span class="input">
                            <div class="sctrl">点击选择分类</div>
                            <ul class="role" style="display:none">
                                <div class="sbtnp" style="margin-left: -40px">
                                    <input id="btnCheckAll" type="button" class="button gray" value="全选" />
                                    <input id="btnChecknone" type="button" class="button gray" value="不选" />
                                    <input id="btnCheckflase" type="button" class="button gray" value="返选" />
                                </div>
                                @foreach($category_list as $key=>$value)
                                <div class="sitemone" id="{{$key}}" style="margin-left: -40px">
                                    <li>
                                        <input type="checkbox" name="rmenu[{{$key}}][]" id="checkitem" class="rotop" value="{{$value["Category_ID"]}}" checked />
                                        <strong>&nbsp;{{$value["Category_Name"]}}</strong>
                                    </li>
                                </div>
                                @if(!empty($value["child"]))
                                <div class="sitemtwo" id="b{{$key}}">
                                    @foreach($value["child"] as $k=>$v)
                                    <li class="oitem">
                                        <input type="checkbox" name="rmenu[{{$key}}][]" id="checkitem" value="{{$v["Category_ID"]}}" checked />&nbsp;
                                        {{$v["Category_Name"]}}
                                    </li>
                                    @endforeach
                                </div>
                                @endif
                                @endforeach
                         </ul>
                         </span>
                        <div class="clear"></div>
                    </div>

                    <div class="rows">
                        <label>所在地区</label>
                        <span class="input">
                            <select name="Province" id="loc_province" style="width:120px" required>
                            </select>
                            <select name="City" id="loc_city" style="width:120px" required>
                            </select>
                            <select name="Area" id="loc_town" style="width:120px;" >
                            </select> <span class="fc_red">*</span>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows">
                        <label>所在区域</label>
                        <span class="input">
                           <select name='RegionID_0' id="regionid_0" style="width:180px">
                              <option value='0'>请选择</option>
                           </select>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows">
                        <label>详细地址</label>
                        <span class="input">
                          <input name="Address" id="Address" value="黄河路经八路" type="text" class="form_input" size="40" maxlength="100" required>
                          <span class="primary" id="Primary">定位</span> <span class="fc_red">*</span><br />
                          <div class="tips">如果输入地址后点击定位按钮无法定位，请在地图上直接点击选择地点</div>
                          <div id="map"></div>
                        </span>
                        <div class="clear"></div>
                    </div>

                    <div class="rows">
                        <label>商家logo</label>
                        <span class="input"> <span class="upload_file">
                          <div>
                            <div class="up_input">
                              <input type="button" id="LogoUpload" value="添加图片" style="width:80px;" />
                            </div>
                            <div class="tips">图片建议尺寸：100*100px</div>
                            <div class="clear"></div>
                          </div>
                          <div class="img" id="LogoDetail" style="margin-top:8px"></div>
                        </span> </span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows">
                        <label>接受短信手机</label>
                        <span class="input">
                          <input type="tel" name="SmsPhone" value="{{old('SmsPhone')}}" class="form_input" size="30" />
                          <span class="tips">当用户下单时，系统会自动发短信到该手机</span>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows">
                        <label>联系人</label>
                        <span class="input">
                          <input type="text" name="Contact" value="{{old('Contact')}}" class="form_input" size="35" />
                          <span class="fc_red">*</span>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows">
                        <label>联系电话</label>
                        <span class="input">
                          <input type="text" name="Phone" value="{{old('Phone')}}" class="form_input" size="35" />
                          <span class="fc_red">*</span>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows">
                        <label>电子邮箱</label>
                        <span class="input">
                          <input type="email" name="Email" value="{{old('Email')}}" class="form_input" size="35"/>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows">
                        <label>公司主页</label>
                        <span class="input">
                          <input type="url" name="Homepage" value="{{old('Homepage')}}" class="form_input" size="35" />
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows">
                        <label>商家简介</label>
                        <span class="input">
                          <textarea class="ckeditor" name="Introduce" style="width:600px; height:300px;">{{old('Introduce')}}</textarea>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows">
                        <label>财务结算类型</label>
                        <span class="input">
                            <input type="radio" name="FinanceType" value="0" id="FinanceType_0" onClick="$('#FinanceRate').show();"
                                   @if(old('FinanceType') == 0 ) checked @endif />
                            <label for="FinanceType_0"> 按交易额比例</label>&nbsp;&nbsp;
                            <input type="radio" name="FinanceType" value="1" id="FinanceType_1" onClick="$('#FinanceRate').hide();"
                                    @if(old('FinanceType') == 1) checked @endif />
                            <label for="FinanceType_1"> 具体产品设置</label><br />
                            <span class="tips">注：若按交易额比例，则网站提成为：产品售价*比例%，网站提成包含网站应得和佣金发放两项</span>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows" id="FinanceRate">
                        <label>网站提成</label>
                        <span class="input">
                          <input type="number" name="FinanceRate" value="{{old('FinanceRate')}}" class="form_input" size="10" /> %
                          <span class="fc_red">*</span>
                        </span>
                        <div class="clear"></div>
                    </div>

                    <div class="rows">
                        <label>结算比例</label>
                        <span class="input">
                          <input type="number" name="PaymenteRate" value="{{old('PaymenteRate')}}" class="form_input" size="10" /> %
                           <span class="tips">注：商家财务结算时,按照结算比例款项一部分转向商家指定的卡号,剩下的转入商家绑定的前台会员的余额中。</span>
                           <span class="fc_red">*</span>
                        </span>
                        <div class="clear"></div>
                    </div>

                    <div class="rows">
                        <label>在首页显示</label>
                        <span class="input">
                          <input type="radio" name="IndexShow" value="0" id="IndexShow_0" @if(old('IndexShow') == 0)checked @endif />
                            <label for="IndexShow_0">不显示</label>&nbsp;&nbsp;
                          <input type="radio" name="IndexShow" value="1" id="IndexShow_1" @if(old('IndexShow') == 1)checked @endif  />
                            <label for="IndexShow_1">显示</label>&nbsp;&nbsp;
                        </span>
                        <div class="clear"></div>
                    </div>

                    <div class="rows">
                        <label>商家排序</label>
                        <span class="input">
                          <input type="number" name="Index" value="{{old('Index')}}" class="form_input" size="5" pattern="[0-9]*" />
                        </span>
                        <div class="clear"></div>
                    </div>

                    <div class="rows">
                        <label>状态</label>
                        <span class="input">
                            <input type="radio" name="Status" value="0" id="Status_0" @if(old('Status') == 0) checked @endif />
                            <label for="Status_0">正常</label>&nbsp;&nbsp;
                            <input type="radio" name="Status" value="1" id="Status_1" @if(old('Status') == 1) checked @endif />
                            <label for="Status_1">禁用</label>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="rows">
                        <label></label>
                        <span class="input">
                            <input type="submit" class="btn_green" name="submit_button" value="提交保存" />
                        </span>
                        <div class="clear"></div>
                    </div>
                    <input type="hidden" name="PrimaryLng" value="{{old('PrimaryLng')}}">
                    <input type="hidden" name="PrimaryLat" value="{{old('PrimaryLat')}}">
                    <input type="hidden" id="LogoPath" name="LogoPath" value="{{old('LogoPath')}}" />
                </form>
            </div>

        </div>
    </div>

</div>

<script>
    KindEditor.ready(function(K) {
        K.create('textarea[name="Introduce"]', {
            themeType : 'simple',
            filterMode : false,
            uploadJson : '/admin/upload_json?TableField=biz',
            fileManagerJson : '/admin/file_manager_json',
            allowFileManager : true,
            items : [
                'source', '|', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                'removeformat', 'undo', 'redo', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist', 'insertunorderedlist', '|', 'emoticons', 'image', 'link' , '|', 'preview']
        });
        var editor = K.editor({
            uploadJson : '/admin/upload_json?TableField=biz',
            fileManagerJson : '/admin/file_manager_json',
            showRemote : true,
            allowFileManager : true,
        });
        K('#LogoUpload').click(function(){
            editor.loadPlugin('image', function(){
                editor.plugin.imageDialog({
                    imageUrl : K('#LogoPath').val(),
                    clickFn : function(url, title, width, height, border, align){
                        K('#LogoPath').val(url);
                        K('#LogoDetail').html('<img src="'+url+'" />');
                        editor.hideDialog();
                    }
                });
            });
        });
    });

    $(document).ready(function(){
        showLocation(0,0,0);
        shopbiz_obj.biz_edit_init();
        global_obj.map_init();
    });

    $(function () {
        // 全选
        $("#btnCheckAll").on("click", function () {
            $("[id = checkitem]:checkbox").prop("checked", true);
        });

        // 全不选
        $("#btnChecknone").on("click", function () {
            $("[id = checkitem]:checkbox").prop("checked", false);
        });

        // 反选
        $("#btnCheckflase").on("click", function () {
            $("[id = checkitem]:checkbox").each(function () {
                $(this).prop("checked", !$(this).prop("checked"));
            });
        });
        // 分类选
        $(".rotop").on("click", function () {
            var catg = $(this).parent().parent().attr("id");
            if($(this).prop("checked")){
                $("#b"+catg+" input[type='checkbox']:checkbox").prop("checked", true);
            }else{
                $("#b"+catg+" input[type='checkbox']:checkbox").prop("checked", false);
            }
        });
        //行业类别列表
        $(".sctrl").click(function(){
            $(".role").animate({height: 'toggle', opacity: 'toggle'}, "slow");
        },function(){
            $(".role").animate({height: 'toggle', opacity: 'toggle'}, "slow");
        });
    });
</script>
@endsection