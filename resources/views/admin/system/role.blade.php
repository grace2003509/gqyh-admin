@extends('admin.layouts.main')
@section('ancestors')
    <li>系统管理</li>
@endsection
@section('page', '角色管理')
@section('css')
    @parent
    <style>
        td{vertical-align: middle}
    </style>
@endsection
@section('subcontent')

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

    <div class="box">
        <div class="box-header with-border">
            <h5 class="box-title">角色列表</h5><br><br>
            <a href="{{ route('role.create') }}" class="btn btn-sm btn-success">新建角色</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-striped table-hover table-condensed table-responsive">
                <thead>
                <tr>
                    <th style="width: 60px">#</th>
                    <th>角色名称</th>
                    <th>备注</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>

                <tbody>
                    @if($roles->count())
                        @foreach($roles as $index => $role)
                            <tr>
                                <td style="vertical-align: middle">{{ $index+1 }}</td>
                                <td style="vertical-align: middle">{{ $role->name }}</td>
                                <td style="vertical-align: middle">{{ $role->description }}</td>
                                <td style="vertical-align: middle">{{ $role->created_at }}</td>
                                <td>
                                    <a href="{{ Route('role.edit',$role->id) }}">
                                        <button class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> 编辑</button>
                                    </a> &emsp;
                                    <input type="hidden" value="{{ $role->id }}">
                                    <button class="del btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> 删除</button>&emsp;
                                    <a href="{{ Route('assignpermission.edit',$role->id) }}">
                                        <button class="btn btn-sm btn-warning"><i class="fa fa-warning"></i> 分配权限</button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="10">暂无数据</td></tr>
                    @endif
                </tbody>

            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix col-lg-offset-5">

        </div>
    </div>


@endsection

@section('script')
    @parent

    <script>
        $('.del').click(function(){
            id = $(this).prev().val();
            $this = $(this);
            ensure('确认要删除吗？',
                    function(){
                        $.ajax({
                            type:'DELETE',
                            url:'role/'+id,
                            success:function(data){
                                console.log(data);
                                $this.closest('tr').remove();
                                $('.box').before("<div class='alert alert-success' id='callback_info'>" +
                                        "<strong><i class='fa fa-check-circle fa-lg fa-fw'></i></strong><br><br>删除成功!!!</div>");
                                $('.alert-success').fadeOut(3000);
                            },
                            error:function(){
                                $('.box').before("<div class='alert alert-danger' id='callback_info'>" +
                                        "<strong><i class='fa fa-times-circle fa-lg fa-fw'></i></strong><br><br>该角色无法删除!!!</div>");
                                $('.alert-danger').fadeOut(3000);
                            }
                        })
                    }
            )
        })
    </script>
@endsection