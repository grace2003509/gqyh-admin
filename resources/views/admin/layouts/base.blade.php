<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="X-XSRF-TOKEN" content="{{ csrf_token() }}" />
    <title>@yield('title', config('app.name'))</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <link rel="stylesheet" href="/static/css/font-awesome.min.css">
    <link rel="stylesheet" href="/static/css/AdminLTE.min.css">
    <link rel="stylesheet" href="/static/js/plugins/pace/pace.min.css">
    <style type="text/css">
        .asterisk { color: #00a65a; position: absolute; right: 6px; }
    </style>
    @yield('css')
</head>
<body class="hold-transition skin-green-light sidebar-mini">
<div class="wrapper">
    @yield('head')
    @yield('content')
    @yield('foot')
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">提示信息</h4>
            </div>
            <div class="modal-body">
                确认要删除吗？
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="cancel">取消</button>
                <button type="button" class="btn btn-primary" id="confirm">确定</button>
            </div>
        </div>
    </div>
</div>

<script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<script src="/static/js/plugins/bootstrap/bootstrap.min.js"></script>
<script src="/static/js/plugins/AdminLTE/app.min.js"></script>
<script src="/static/js/plugins/pace/pace.min.js"></script>
@yield('script')
</body>
</html>