@extends('admin.layouts.main')

@section('css')
    @parent
    <style>
        .form-horizontal label.checkbox-inline { min-width: 120px; }
        .form-horizontal .date-range[readonly] { background: #fff; }
    </style>
@endsection

@section('ancestors')
    <li>系统管理</li>
    <li>角色管理</li>
@endsection
@section('page', '新建角色')
@section('subcontent')

    <div class="box">
        <div class="box-header with-border">
            <h5 class="box-title">新建</h5>
        </div>
        <!-- /.box-header -->
        <form class="box form-horizontal"  action="{{ route('role.store') }}" method="post">
        <div class="box-body">
            {{csrf_field()}}

            <div class="form-group">
                <label class="col-md-4 control-label">角色名称<span class="asterisk">*</span></label>
                <div class="col-md-4">
                    <input type="text" name="name" class="form-control" required
                           data-error="请填写角色名称" placeholder="角色名称"/>
                    <div class="help-block with-errors"></div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">备注</label>
                <div class="col-md-4">
                    <input type="text" name="description" class="form-control"
                           data-error="请填写备注" placeholder="备注"/>
                </div>
            </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix" align="center">
            <a href="{{ route('role.index') }}" class="btn btn-default">取消</a>
            <button class="btn btn-success">提交</button>
        </div>
        </form>
    </div>

@endsection

@section('script')
    @parent
    <script>
        $('.form-horizontal').validator(validatorOptions);
    </script>
@endsection