@extends('admin.layouts.main')
@section('ancestors')
    <li>商城设置</li>
@endsection
@section('page', '积分设置')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    {{--<script type='text/javascript' src='/admin/js/global.js'></script>--}}

    <style type="text/css">
        #config_form img{width:100px; height:100px; font-size: 14px}
    </style>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">

                <div class="r_con_wrap">
                    <div class="r_con_config">
                        <div class="shopping">
                            <form id="config_form" class="r_con_form" name="other_config_form" action="{{route('admin.shop.integrate_update')}}" method="post">
                                {{csrf_field()}}
                                <div class="rows">
                                    <label>积分使用规则</label>
                                    <span class="input">
                                        <a href="javascript:void(0);" id="add_integral_law" class="red">添加</a>
                                        <ul id="integral_panel" style="list-style:none;margin: 0; padding: 0">
                                        @if(count($integral_use_laws)>0)
                                            @foreach($integral_use_laws as $key=>$law)
                                            <li class="item" style="margin-bottom: 10px;"> 满：￥
                                                <input name="Integral_Man[]" value="{{$law['man']}}" class="form_input" size="3" maxlength="10" type="text"> 可用
                                                <input name="Integral_Use[]" value="{{$law['use']}}" class="form_input" size="3" maxlength="10" type="text"> 个
                                                <a onclick="del($(this))"><img src="/admin/images/ico/del.gif" style="width: 15px; height: 15px;"></a>
                                            </li>
                                            @endforeach
                                        @endif
                                            <li class="clear"></li>
                                        </ul>
                                        <p>(订单满足多大金额，可以使用多少个积分,例满100元可使用100个积分)<br/>设置排序由小到大</p>
                                    </span>
                                    <div class="clear"></div>
                                </div>

                                <div class="rows">
                                    <label>积分抵用设置</label>
                                    <span class="input">
                                      每 <input type="text" name="Integral_Buy" size="5" value="{{$rsConfig['Integral_Buy']}}"/> 积分抵用一元
                                    </span>
                                    <div class="clear"></div>
                                </div>
                                <div class="rows">
                                    <label></label>
                                    <span class="input">
                                      <input type="submit" class="btn_green" value="提交保存" name="submit_btn">
                                    </span>
                                    <div class="clear"></div>
                                </div>
                            </form>
                        <div>
                    </div>
                </div>

            </div>
        </div>
    </div>

        <script language="javascript">
            $(document).ready(function(){

                $("#add_integral_law").click(function(){
                    var li_item = '<li class="item" style="margin-bottom: 10px;">满：￥ ' +
                        '<input name="Integral_Man[]" value="" class="form_input" size="3" maxlength="10" type="text"> 可用 ' +
                        '<input name="Integral_Use[]" value="" class="form_input" size="3" maxlength="10" type="text"> 个 ' +
                        '<a onclick="del($(this))"><img src="/admin/images/ico/del.gif" style="width: 15px; height: 15px;"></a></li>';
                    $("ul#integral_panel").append(li_item);
                });

            });

            function del(obj)
            {
                if(!confirm('确认删除此设置吗？')) return false;
                obj.parent().remove();
            }
        </script>

@endsection