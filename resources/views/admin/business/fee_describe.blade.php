@extends('admin.layouts.main')
@section('ancestors')
    <li>商家设置</li>
@endsection
@section('page', '年费设置')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <style>
        li { list-style-type: none}
    </style>
    <div class="box">

        <div id="iframe_page">
            <div class="iframe_content">

                <div id="products" class="r_con_wrap">

                    <div class="control_btn">
                        <a href="{{route('admin.business.home_describe')}}" class="btn_green btn_w_120">首页设置</a>
                        <a href="{{route('admin.business.enter_describe')}}" class="btn_green btn_w_120">入驻描述设置</a>
                        <a href="{{route('admin.business.register_describe')}}" class="btn_green btn_w_120">注册描述设置</a>
                        <a href="{{route('admin.business.fee_describe')}}" class="btn_green btn_w_120">年费设置</a>
                    </div>
                    <form class="r_con_form" id="group_edit" method="post" action="{{route('admin.business.describe_update')}}">
                        {{csrf_field()}}
                        <div class="rows">
                            <label>年费设置</label>
                            <span class="input">
                                <a href="javascript:void(0);" id="add_man" class="red">添加</a>
                                <ul id="man_panel">
                                @if(count($year_list['name'])>0)
                                    @foreach($year_list['name'] as $key=>$year)
                                    <li class="item"> 时间：
                                        <input name="year_fee[name][]" value="{{$year}}" class="form_input" size="20" maxlength="10" type="text">年&nbsp;&nbsp;
                                       费用
                                        <input name="year_fee[value][]" value="{{$year_list['value']["$key"]}}" class="form_input" size="15" maxlength="10" type="text">元
                                        <a><img src="/admin/images/ico/del.gif" hspace="5"></a>
                                    </li>
                                    @endforeach
                                @endif
                                    <li class="clear"></li>
                                </ul>
                            </span>
                            <div class="clear"></div>
                        </div>

                        <div class="rows">
                            <label></label>
                            <span class="input">
                                <input type="submit" class="btn_green" name="submit_button" value="提交保存" />
                                <input type="hidden" name="submit_fee" value="1" />
                            </span>
                            <div class="clear"></div>
                        </div>

                    </form>
                </div>

            </div>
        </div>

    </div>
    <script>
        $("#add_man").click(function(){
            var li_item = '<li class="item">时间： <input name="year_fee[name][]" value="" class="form_input" size="20" maxlength="10" type="text">年&nbsp;&nbsp;费用 ' +
                '<input name="year_fee[value][]" value="" class="form_input" size="15" maxlength="10" type="text"> 元<a>' +
                '<img src="/admin/images/ico/del.gif" hspace="5"></a></li>';
            $("ul#man_panel").append(li_item);
        });

        $("#man_panel li.item a").on('click',function(){
            $(this).parent().remove();
        });
    </script>
@endsection