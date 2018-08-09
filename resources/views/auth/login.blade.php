@extends('layouts.base')
@section('css')
<style>
    body { background: url(/images/login_bg.png) no-repeat; background-size: 100% 35%; font-family: "Microsoft Yahei" }
    .login-box-body {background:#fff; border-radius:10px; padding:55px; color: #555;}
    .icheck>label {
        padding-left: 20px;
        color: #fff;
    }
    .login-box a {
        color: #fff;
    }
    .login-box {
        color:#fff;
        margin: 8% auto;
    }
    .links {line-height:3;}
    .shadow {
        -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.3);
        box-shadow: 0 5px 10px rgba(0,0,0,.3);
        filter: progid:DXImageTransform.Microsoft.Shadow(color='#888888', Direction=135, Strength=4);
    }
    h1 {font-family: "Microsoft Yahei";}
    .checkbox>label { color: #333}
    .links>a { color: #333}
    .links>a:hover { color: #737373}
    button[type=submit]:hover {background-color: rgb(86, 138, 7);color: #fff; }
    button[type=submit] {background-color: rgb(118,188,12); color: #fff!important;}

</style>
@endsection

@section('content')
<div class="login-box">
    <div class="login-logo">
        {{--<img src="images/logo.png">--}}
        <h1>观前一号后台管理</h1>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body shadow">
        <p class="login-box-msg hidden">登录</p>
        <form class="form-horizontal" role="form" method="POST">
            {{ csrf_field() }}
            <div class="form-group has-feedback">
                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="用户名">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div>
                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong style="color: red;">{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback">
                <input id="password" type="password" class="form-control" name="password" required placeholder="密码">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div>
                @if ($errors->has('password'))
                    <span class="help-block text-danger">
                        <strong style="color: red;">{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="row">
                <!-- /.col -->
                <div>
                    <div class="checkbox icheck pull-left">
                        <label>
                            <input type="checkbox"> 记住账号
                        </label>
                    </div>
                    <button type="submit" class="btn btn-block btn-flat btn-lg">登录</button>
                </div>
                <div class="col-xs-12">
                    <div class="pull-right links"><a href="{{ url('/password/email') }}">忘记密码?</a></div>
                </div>
            </div>
            <div>

            </div>
        </form>
    </div>
    <!-- /.login-box-body -->
</div>
@endsection
