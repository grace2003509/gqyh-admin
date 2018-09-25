@extends('admin.layouts.main')
@section('ancestors')
    <li>会员管理</li>
@endsection
@section('page', '会员列表')
@section('subcontent')

<link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/user.css' rel='stylesheet' type='text/css' />

<script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<script type='text/javascript' src='/admin/js/user.js'></script>
<link href='/static/js/plugins/lean-modal/style.css' rel='stylesheet' type='text/css' />
<script type='text/javascript' src='/static/js/plugins/lean-modal/lean-modal.min.js'></script>
<script type='text/javascript' src='/static/js/plugins/layer/layer.js'></script>
<style>
    .clearAll {
        background: #1584D5;
        color: white;
        border: none;
        height: 22px;
        line-height: 22px;
        width: 80px;
    }
    .inputPwd input{
        width: 90%;
        height: 30px;
        /* border: none; */
        border: 1px solid #bdb6b6;
        margin-left: 10px;
        margin-top: 10px;
    }

</style>
<div class="box">
    <div id="iframe_page">
        <div class="iframe_content">
            <div id="update_post_tips"></div>
            <div id="user" class="r_con_wrap">
                <form class="search" id="search_form" method="get" action="{{route('admin.member.user_list')}}">
                    <div class="l">
                        <select name="Fields">
                            <option value="all">--全部--</option>
                            <option value="Owner_Id" >推荐人</option>
                            <option value="User_Mobile" >会员手机</option>
                        </select>
                        <input type="text" name="Keyword" value="" class="form_input" size="15" />
                        会员等级：
                        <select name="MemberLevel">
                            <option value="all">--请选择--</option>
                            @foreach($UserLevel as $k=>$u)
                                <option value='{{$k}}'>{{$u}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="search" value="1" />
                        <input type="submit" class="search_btn" value=" 搜索 " />
                        <input type="button" class="output_btn" value="导出" />
                        <button type="button" class="clearAll"onclick="deleteUser(-1)">清空会员</button>
                    </div>
                    <div class="r"><strong>提示：</strong><span class="fc_red">双击表格可修改会员资料，按回车提交修改</span></div>
                </form>
                <table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                    <thead>
                    <tr>
                        <td width="5%" nowrap="nowrap">序号</td>
                        <td width="8%" nowrap="nowrap"><span class="red">推荐人手机号</span></td>
                        <td width="8%" nowrap="nowrap">会员号</td>
                        <td width="10%" nowrap="nowrap">手机号</td>
                        <td width="12%" nowrap="nowrap">总消费额</td>
                        <td width="8%" nowrap="nowrap">会员等级</td>
                        <td width="7%" nowrap="nowrap">积分</td>
                        <td width="7%" nowrap="nowrap">余额</td>
                        <td width="10%" nowrap="nowrap">注册时间</td>
                        <td width="8%" nowrap="nowrap" class="last"><strong>操作</strong></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lists as $key=>$rsUser)
                    <tr UserID="{{$rsUser['User_ID']}}">
                        <td nowrap="nowrap">{{$key+1}}</td>
                        <td nowrap="nowrap">{{$rsUser['upuser']['User_Mobile']}}</td>
                        <td nowrap="nowrap">{{$rsUser['User_No']}}</td>
                        <td nowrap="nowrap">{{$rsUser['User_Mobile']}}</td>
                        <td nowrap="nowrap">&yen;&nbsp;{{$rsUser['User_Cost']}}</td>
                        <td nowrap="nowrap" class="upd_select" field="5">
                            <span class="upd_txt">{{$UserLevel[$rsUser["Dis_Level"]]}}</span>
                        </td>
{{--                        <td nowrap="nowrap">{{$UserLevel[$rsUser["Dis_Level"]]}}</td>--}}
                        <td nowrap="nowrap" class="upd_points" field="3"><span class="upd_txt">{{$rsUser['User_Integral']}}</span></td>
                        <td nowrap="nowrap" class="upd_money" field="4"><span class="upd_txt">{{$rsUser['User_Money']}}</span></td>
                        <td nowrap="nowrap">{{$rsUser['User_CreateTime']}}</td>
                        <td nowrap="nowrap" class="last">
                            <a href="#doOrder" Mobile="{{$rsUser['User_Mobile']}}" style="text-decoration: none">
                                <img src="/admin/images/ico/add.gif" align="absmiddle" title="手动添加订单" />
                            </a>
                            <a href="#modpass" style="text-decoration: none">
                                <img src="/admin/images/ico/user.png" align="absmiddle" title="重置登陆密码" />
                            </a>
                            <a href="#modpay" style="text-decoration: none">
                                <img src="/admin/images/ico/paychange.png" align="absmiddle" title="重置支付密码" />
                            </a>
                            <a href="{{route('admin.member.user_capital', ['id' => $rsUser['User_ID']])}}" style="text-decoration: none">
                                <img src="/admin/images/ico/x3_06_03.jpg" align="absmiddle" title="会员详情与资金流水" />
                            </a>

                            @if($rsUser['downuser'] == 0)
                                <a href="{{route('admin.member.user_del', ['id' => $rsUser['User_ID']])}}" onclick="if(!confirm('确定删除此会员？')) return false;">
                                    <img src="/admin/images/del.gif" align="absmiddle" />
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="blank20"></div>
                {{ $lists->links() }}
            </div>
        </div>
        <div id="mod_user_pass" class="lean-modal lean-modal-forma">
            <div class="ha">登录密码重置为（<span class="red">123456</span>）<a class="modal_close" href="#"></a></div>
            <form class="form" method="post" action="{{route('admin.member.user_update')}}">
                {{csrf_field()}}
                <div class="rows">
                    <label></label>
                    <span class="submit">
                        <input type="submit" value="确定提交" name="submit_btn">
                    </span>
                    <div class="clear"></div>
                </div>
                <input type="hidden" name="UserID" value="">
                <input type="hidden" name="action" value="mod_password">
            </form>
            <div class="tips"></div>
        </div>

        <div id="mod_user_pay" class="lean-modal lean-modal-forma">
            <div class="ha">支付密码重置为（<span class="red">123456</span>）<a class="modal_close" href="#"></a></div>
            <form class="form" method="post" action="{{route('admin.member.user_update')}}">
                {{csrf_field()}}
                <div class="rows">
                    <label></label>
                    <span class="submit">
                        <input type="submit" value="确定重置" name="submit_btn">
                    </span>
                    <div class="clear"></div>
                </div>
                <input type="hidden" name="UserID" value="">
                <input type="hidden" name="action" value="mod_payword">
            </form>
            <div class="tips"></div>
        </div>


        <div id="do_order_hand" class="lean-modal lean-modal-forma" style="width: 40%">
            <div class="ha">线下交易手动下单<a class="modal_close" href="#"></a></div>
            <form class="form" method="post" action="{{route('admin.member.do_order')}}">
                {{csrf_field()}}
                <table width="100%" border="0" cellpadding="5" class="r_con_table" style="border-left: 1px #ddd solid">
                    <tr style="border-top: 1px #ddd solid">
                        <td>
                            <span class="fc_red">*</span><label>会员手机号：</label>
                        </td>
                        <td class="left">
                            <input type="text" name="User_Mobile" value="" maxlength="11" style="width: 160px; height: 30px; line-height: 30px;" disabled />
                            <input type="hidden" name="Mobile" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td><span class="fc_red">*</span><label>产品名称：</label></td>
                        <td class="left">
                            <select id="proChange" name="Products_ID" style="width: 160px; height: 30px; line-height: 30px;">
                                <option value="">请选择产品</option>
                                @foreach($productList as $k=>$v)
                                    <option value="{{$v['Products_ID']}}">{{$v['Products_Name']}}</option>
                                @endforeach
                            </select>
                            只显示订单流程为其他类型的产品
                        </td>
                    </tr>
                    <tr>
                        <td><span class="fc_red">*</span><label>订单价格：</label></td>
                        <td class="left">
                            <input type="number" name="price" value="" id="price" class="form_input" maxlength="10" style="width: 160px; height: 30px; line-height: 30px;" required />
                            可根据实际情况进行更改
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="left">
                            <input type="submit"class="btn_green btn_w_120" name="submit_button" value="生成订单" />
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="UserID" value="">
                <input type="hidden" name="action" value="do_order">
            </form>
            <div class="tips"></div>
        </div>

    </div>
</div>
</div>
<script language="javascript">
    var level_ary=Array();
    @foreach($UserLevel as $k=>$v)
        level_ary['{{$k}}']="{{$v}}";
    @endforeach
    $(document).ready(function(){user_obj.user_init();});

    //会员列表导出
    $("#search_form .output_btn").click(function(){
        window.location = '/admin/member/user_output?Fields={{$input['Fields']}}&Keyword={{$input['Keyword']}}&MemberLevel={{$input['MemberLevel']}}';
    });

    //手动下单，选择商品获得商品价格
    $("#proChange").change(function(){
        var pid = $(this).val();
        if(pid === 0) {
            $("#price").val('');
            return false;
        }
        $.get('/admin/member/product_change/'+pid,'',function(res){
            if(res.status === 1){
                var price = res.data;
                $("#price").val(price);
            } else {
                alert(res.info);
            }
        },'json')


    })

    //清空会员
    function deleteUser(user){
        if(user){
            if(user === -1){
                url= '/admin/member/all_user_del';
                layer.open({
                    type: 1,
                    title: "登陆密码",
                    closeBtn: 0,
                    shadeClose: true,
                    area:['300px','150px'],
                    btn:['确定'],
                    content: '<div class="inputPwd">' +
                    '<input type="password" name="password" value="" placeholder="请输入登录密码" /></div>',
                    yes: function(){
                        var password = $.trim($("input[name='password']").val());
                        if(password==="" || password===null){
                            layer.alert("请输入登录密码");
                            return false;
                        }
                        $.post("?",{ password:password,action:'deleteAllreal' }, function(data){
                            if(data.status === 1){
                                layer.confirm('本操作将清空与会员相关的一切数据（会员管理  订单管理  分销记录  分销账号管理  代理信息 创始人信息 结算信息等）请慎操！<br>确定清空全部会员？', {
                                    btn: ['确定','取消'], //按钮
                                    shade: false //不显示遮罩
                                }, function(){
                                    location.href = url;
                                });
                            }else{
                                layer.alert("登录密码错误！");
                            }
                        }, 'json');
                    }
                });
            }
            return false;
        }
    }

</script>
@endsection