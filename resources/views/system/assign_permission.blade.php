@extends('layouts.main')

@section('ancestors')
    <li>系统管理</li>
    <li>角色管理</li>
@endsection
@section('page', '权限分配')
@section('subcontent')
    <form action="{{ route('assignpermission.update',$id) }}" method="post">
        {{csrf_field()}}
        {{ method_field('PUT') }}
        <div class="panel panel-default">
            <div class="panel-heading">{{ $role_name }}</div>
            <div class="panel-body">
                <div id="tree" class="per-tree">
                    <ul class="list-group">
                        @foreach (json_decode(config('menus')) as $module)
                            <li class="list-group-item node-tree"><span><h4>{{ $module->name }}</h4></span></li>
                            @if($module->items !== null)
                                @foreach($module->items as $menu )
                                    <li class="list-group-item sub-tree" style="border-bottom-color: white">
                                        <label><input name="permission_names[]" type="checkbox" value="{{ $menu->route }}" @if($role_permission[$menu->route]) checked @endif>{{ $menu->name }}&emsp;
                                        </label>
                                    </li>
                                    @if($menu->items !== null)
                                        <li class="list-group-item" style="padding-left: 100px" style="border-top-color: white">
                                            @foreach($menu->items as $pages)
                                                <label><input name="permission_names[]" type="checkbox" value="{{ $pages->route }}" @if($role_permission[$pages->route]) checked @endif>{{ $pages->name }}&emsp;</label>
                                                @if($pages->items !== null)
                                                    @foreach($pages->items as $links)
                                                        <label><input name="permission_names[]" type="checkbox" value="{{ $links->route }}" @if($role_permission[$links->route]) checked @endif>{{ $links->name }}&emsp;</label>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="panel-footer" align="center">
                    <a href="{{ route('role.index') }}" class="btn btn-default">取消</a>&emsp;
                    <button class="btn btn-success">提交</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    @parent
    <script>
        $('.sub-tree').click(function(){
            $(this).next('li').find(':checkbox').prop('checked',$(this).find(':checkbox').prop('checked'));
        })
    </script>
@endsection
