@extends('admin.layouts.main')
@section('ancestors')
    <li>基础设置</li>
@endsection
@section('page', '系统URL查询')
@section('subcontent')

    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/material.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script type='text/javascript' src='/admin/js/material.js'></script>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">

                <div id="url" class="r_con_wrap" style="min-height:500px;">
                    <div class="type">
                        <a href="{{route('admin.base.sys_url', [ 'type'=>'shop_category'])}}">
                            产品分类
                        </a>
                        <a href="{{route('admin.base.sys_url', [ 'type'=>'shop_lists'])}}" >
                            产品列表
                        </a>
                        <a href="{{route('admin.base.sys_url', [ 'type'=>'biz'])}}" >
                            店铺列表
                        </a>
                    </div>
                    @include('admin.base.sysurl.'.$type)
                </div>

            </div>
        </div>
    </div>


@endsection