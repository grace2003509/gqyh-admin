@extends('admin.layouts.main')

@section('css')
    @parent
    <style>
        .form-horizontal label.checkbox-inline {
            min-width: 120px;
        }

        .form-horizontal .date-range[readonly] {
            background: #fff;
        }
    </style>
@endsection

@section('ancestors')
    <li>系统管理</li>
    <li>用户管理</li>
@endsection
@section('page', '编辑用户')
@section('subcontent')

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

    <div class="box">
        <div class="box-header with-border">
            <h5 class="box-title">编辑</h5>
        </div>
        <!-- /.box-header -->
        @foreach( $user as $list )
            <form class="box form-horizontal" action="{{ route('user.update', $list->id) }}" method="post">
                {{csrf_field()}}
                {{ method_field('PUT') }}
                <div class="box-body">

                    <div class="form-group">
                        <label class="col-md-4 control-label">用户名<span class="asterisk">*</span></label>
                        <div class="col-md-4">
                            <input autofocus type="text" name="name" class="form-control" required
                                   data-error="请填写用户名" placeholder="登录用户名"
                                   value="{{ isset($list->name)?$list->name:'' }}"/>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">密码<span class="asterisk">*</span></label>
                        <div class="col-md-4">
                            <input id="password" type="password" name="password_confirm" class="form-control" required
                                   data-error="请填写密码" placeholder="确认密码" value="{{ $list->password }}"/>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">确认密码<span class="asterisk">*</span></label>
                        <div class="col-md-4">
                            <input id="password" type="password" name="password" class="form-control" required
                                   data-error="请再次输入密码" placeholder="密码" value="{{ $list->password }}"/>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">邮箱<span class="asterisk">*</span></label>
                        <div class="col-md-4">
                            <input type="text" name="email" class="form-control" placeholder="邮箱" required
                                   data-error="请输入邮箱" placeholder="邮箱" value="{{ $list->email }}"/>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix" align="center">
                    <a href="{{ route('user.index') }}" class="btn btn-default">取消</a>
                    <button class="btn btn-success">提交</button>
                </div>
            </form>
        @endforeach
    </div>

    <div class="hidden">

    </div>
@endsection
@section('script')
    @parent

    <script>
        $('.form-horizontal').validator(validatorOptions);
    </script>
@endsection