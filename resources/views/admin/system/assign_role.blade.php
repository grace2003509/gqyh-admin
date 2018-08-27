@extends('admin.layouts.main')

@section('ancestors')
    <li>系统管理</li>
    <li>用户管理</li>
@endsection
@section('page', '角色分配')
@section('subcontent')

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

    <form action="{{ route('assignrole.update',$id) }}" method="post">
    {{csrf_field()}}
    {{ method_field('PUT') }}
        <div class="panel panel-default">
            <div class="panel-heading">{{ $user_name }}</div>
            <div class="panel-body">
                <div id="tree" class="per-tree">
                    <ul class="list-group">
                        <li class="list-group-item sub-tree">
                            @foreach($roles as $role)
                                <label><input name="role[]" type="checkbox" value="{{ $role->id }}" @if($user_role[$role->name]) checked @endif>
                                    {{ $role->name }}&emsp;
                                </label>
                            @endforeach
                        </li>
                    </ul>
                </div>
                <div class="panel-footer" align="center">
                    <a href="{{ route('user.index') }}" class="btn btn-default">取消</a>&emsp;
                    <button class="btn btn-success">提交</button>
                </div>
            </div>
        </div>
    </form>
@endsection