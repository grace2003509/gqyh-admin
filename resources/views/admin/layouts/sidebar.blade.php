<!-- Left side column. sidebar -->
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">

            <li class="treeview">
                <a href="{{route('admin.home')}}">
                    <i class="fa fa-home"></i> <span>后台首页</span>
                </a>
            </li>

            @role(('administrator'))
                <li class="treeview  @if(Route::is('user.*') or Route::is('role.*') or Route::is('assignrole.*') or Route::is('assignpermission.*')) active @endif" >
                    <a href="#">
                        <i class="fa fa-user-circle-o"></i> <span>系统管理</span><i class="fa fa-angle-right pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li @if(Route::is('user.*') or Route::is('assignrole.*')) class="active" @endif>
                            <a href="{{ route('user.index') }}"><i class="fa fa-circle-o"></i>用户管理</a>
                        </li>
                        <li @if(Route::is('role.*') or Route::is('assignpermission.*')) class="active" @endif>
                            <a href="{{ route('role.index') }}"><i class="fa fa-circle-o"></i>角色管理</a>
                        </li>
                    </ul>
                </li>
            @endrole

            @foreach (json_decode(config('menus')) as $module)

                @if(perm_matches($module))
                    <li class="treeview @if(route_matches($module)) active @endif">
                        <a href="#">
                            <i class="fa fa-{{ $module->icon }}"></i> <span>{{ $module->name }}</span>
                            <i class="fa fa-angle-right pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            @foreach ($module->items as $menu)
                                @if(perm_match($menu))
                                    <li @if(route_matches($menu)) class="active" @endif>
                                        <a href="{{ route($menu->route) }}"><i class="fa fa-circle-o"></i>{{ $menu->name }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
