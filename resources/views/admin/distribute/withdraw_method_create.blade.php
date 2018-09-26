@extends('admin.layouts.main')
@section('ancestors')
    <li>分销管理</li>
@endsection
@section('page', '添加提现方法')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/user.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">

                <div class="r_con_wrap">
                    <form id="method_form" class="r_con_form" method="post" action="{{route('admin.distribute.withdraw_method_store')}}">
                        {{csrf_field()}}
                        <div class="rows">
                            <label>提现方式</label>
                            <span class="input">
                                <select name="Type">
                                    @foreach($_METHOD as $key=>$value)
                                        <option value="{{$key}}" @if(old('Type') == $key) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div id="type_0">
                            <div class="rows">
                                <label>银行名称</label>
                                <span class="input">
                                    <input type="text" name="Name" value="{{old('Name')}}" class="form_input" size="20" />
                                </span>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="rows">
                            <label>是否启用</label>
                            <span class="input">
                                <input type="radio" id="status_1" value="1" name="Status" @if(old('Status') == 1) checked @endif >
                                    <label for="status_1">启用</label>
                                <input type="radio" id="status_0" value="0" name="Status" @if(old('Status') == 0) checked @endif >
                                    <label for="status_0">不启用</label>
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