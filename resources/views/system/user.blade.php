@extends('layouts.main')
@section('ancestors')
    <li>系统管理</li>
@endsection
@section('page', '用户管理')
@section('subcontent')

    <div class="box">
        <div class="box-header with-border">
            <h5 class="box-title">用户列表</h5><br><br>
            <a href="{{ route('user.create') }}" class="btn btn-sm btn-success">新建用户</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-striped table-hover table-condensed table-responsive">
                <thead>
                <tr>
                    <th style="width: 60px">#</th>
                    <th>用户名</th>
                    <th>邮箱</th>
                    <th>角色</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>

                @if($users->count())
                    @foreach($users as $index => $user)
                        <tr>
                            <td style="vertical-align: middle">{{ $index+1 }}</td>
                            <td style="vertical-align: middle">{{ $user->name }}</td>
                            <td style="vertical-align: middle">{{ $user->email }}</td>
                            <td style="vertical-align: middle">{{ $user_role[$user->id] }}</td>
                            <td style="vertical-align: middle">{{ $user->created_at }}</td>
                            <td>
                                <a href="{{ Route('user.edit',$user->id) }}">
                                    <button class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> 编辑</button>
                                </a> &emsp;
                                <input type="hidden" value="{{ $user->id }}">
                                <button class="del btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> 删除</button>&emsp;
                                <a href="{{ Route('assignrole.edit',$user->id) }}">
                                    <button class="btn btn-sm btn-warning"><i class="fa fa-users"></i> 分配角色</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="10">暂无数据</td>
                    </tr>
                @endif

                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            @if($users->count())
                {{ $users->links() }}
            @endif
        </div>
    </div>


@endsection

@section('script')
    @parent

    <script>
        $('.del').click(function () {
            id = $(this).prev().val();
            $this = $(this);
            ensure('确认要删除吗？',
                    function () {
                        $.ajax({
                            type: 'DELETE',
                            url: 'user/' + id,
                            success: function (data) {
                                console.log(data);
                                $this.closest('tr').remove();
                                $('.box').before("<div class='alert alert-success' id='callback_info'>" +
                                        "<strong><i class='fa fa-check-circle fa-lg fa-fw'></i></strong><br><br>删除成功!!!</div>");
                                $('.alert').fadeOut(3000);
                            },
                            error: function () {
                                $('.box').before("<div class='alert alert-danger' id='callback_info'>" +
                                        "<strong><i class='fa fa-times-circle fa-lg fa-fw'></i></strong><br><br>删除失败,你不能删除自己或其他administrator用户!!!</div>");
                                $('.alert').fadeOut(3000);
                            }
                        })
                    }
            )
        })


    </script>
@endsection