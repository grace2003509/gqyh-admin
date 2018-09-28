@extends('admin.layouts.main')
@section('ancestors')
    <li>商家分组</li>
@endsection
@section('page', '添加商家分组')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

    <div class="box">

        <div id="iframe_page">
            <div class="iframe_content">

                <div id="bizs" class="r_con_wrap">
                    <form class="r_con_form" method="post" action="{{route('admin.business.group_store')}}" id="group_edit">
                        {{csrf_field()}}
                        <div class="rows">
                            <label>分组名称</label>
                            <span class="input">
                              <input type="text" name="Name" value="{{old('Name')}}" class="form_input" size="35" maxlength="50" />
                              <span class="fc_red">*</span>
                            </span>
                            <div class="clear"></div>
                        </div>

                        <div class="rows">
                            <label>分组排序</label>
                            <span class="input">
                                <input type="number" name="Index" value="{{old('Index')}}" class="form_input" size="10" />
                                <span class="fc_red">*</span>
                            </span>
                            <div class="clear"></div>
                        </div>

                        <div class="rows">
                            <label>是否开通店铺</label>
                            <span class="input">
                              <input type="radio" name="IsStore" value="1" id="IsStore_1" @if(old('IsStore') == 1) checked @endif />
                                <label for="IsStore_1">开通</label>&nbsp;&nbsp;
                              <input type="radio" name="IsStore" value="0" id="IsStore_0" @if(old('IsStore') == 0) checked @endif />
                                <label for="IsStore_0">不开通</label>
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
                    </form>
                </div>

            </div>
        </div>

    </div>

@endsection