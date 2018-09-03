@extends('admin.layouts.main')
@section('ancestors')
    <li>商城设置</li>
@endsection
@section('page', '首页设置')
@section('subcontent')


    <link href='/admin/css/skin_page.css' rel='stylesheet' type='text/css' />


                @include('admin.shop.skin')


@endsection