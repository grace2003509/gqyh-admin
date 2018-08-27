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
@section('page', '编辑角色')
@section('subcontent')

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

    <div class="box">
        <div class="box-header with-border">
            <h5 class="box-title">编辑</h5>
        </div>
        <!-- /.box-header -->
        @foreach( $role as $list )
            <form class="box form-horizontal"  action="{{ route('role.update', $list->id) }}" method="post">
                {{csrf_field()}}
                {{ method_field('PUT') }}
                <div class="box-body">

                    <div class="form-group">
                        <label class="col-md-4 control-label">角色名称<span class="asterisk">*</span></label>
                        <div class="col-md-4">
                            <input autofocus type="text" name="name" class="form-control" required
                                   data-error="请填写角色名称" placeholder="角色名称" value="{{ isset($list->name)?$list->name:'' }}"/>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">备注</label>
                        <div class="col-md-4">
                            <input type="text" name="description" class="form-control" placeholder="备注" value="{{ $list->description }}" />
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix" align="center">
                    <a href="{{ route('role.index') }}" class="btn btn-default">取消</a>
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