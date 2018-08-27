@extends('admin.layouts.base')

@section('css')
<link rel="stylesheet" href="/vendor/admin-lte/dist/css/skins/skin-green-light.min.css">
<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap-daterangepicker/2.1.24/daterangepicker.min.css">
<link rel="stylesheet" href="/vendor/bootstrap-treeview/dist/bootstrap-treeview.min.css">
<link rel="stylesheet" href="/css/admin.css">

<style type="text/css">
    header { font-family: "Microsoft Yahei"}
    .box-body { min-height: 120px; }
    th,td{ text-align: center; }
</style>
@endsection

@section('head')
<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('admin.home') }}" class="logo" style="text-align: left">
        <span class="logo-mini"><b>GQYH</b></span>
        <span class="logo-lg"><b>观前一号后台管理</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button" >
            <span class="sr-only">菜单</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="{{ route('profile.edit',Auth::user()->id) }}" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/images/avatar.png" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="/images/avatar.png" class="img-circle" alt="User Image">
                            <p>
                                {{ Auth::user()->name }} -
                                @foreach(Auth::user()->roles as $role)
                                    {{ $role->name }}
                                @endforeach
                                <small></small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ route('profile.edit',Auth::user()->id) }}" class="btn btn-default">编辑个人资料</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('admin.user.logout') }}" class="btn btn-default"><i class="fa fa-sign-out"></i> 退出</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('admin.user.logout') }}"><i class="fa fa-sign-out"></i> 退出</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
@include('admin.layouts.sidebar')
@endsection


@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>@yield('page')</h1>
        <ol class="breadcrumb">
            @yield('ancestors')
            <li class="active">@yield('page')</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('message.errors')
        @include('message.success')
        @yield('subcontent')
    </section>
</div>
@endsection

@section('foot')
<footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs"></div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2018 <a href="#">观前一号</a>.</strong> All rights reserved.
</footer>
@endsection

@section('script')
<script src="/static/js/plugins/vue/vue-2.1.3.min.js"></script>
<script src="/static/js/plugins/bootstrap/validator.min.js"></script>
<script src="/static/js/plugins/jQuery/jquery.serializejson.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap-daterangepicker/2.1.24/moment.min.js"></script>
<script src="//cdn.bootcss.com/moment.js/2.13.0/locale/zh-cn.js"></script>

<script type="text/javascript">
    // moment.locale('zh-cn');
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
    });
    $('.alert').fadeOut(3000);

</script>
<script src="//cdn.bootcss.com/bootstrap-daterangepicker/2.1.24/daterangepicker.min.js"></script>
<script src="/static/js/app.js?r=201701101"></script>

@endsection


