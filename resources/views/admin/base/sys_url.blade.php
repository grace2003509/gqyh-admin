@extends('admin.layouts.main')
@section('ancestors')
    <li>基础设置</li>
@endsection
@section('page', '自定义URL')
@section('subcontent')

    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/material.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script type='text/javascript' src='/admin/js/global.js'></script>
    <script type='text/javascript' src='/admin/js/material.js'></script>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">

                <div id="url" class="r_con_wrap" style="min-height:500px;">
                    <div class="type">
                        @foreach($modules as $m)
                            @if($m["name"] != '云购')
                            <a href=" @if(empty($menus[$m["parentid"]]["type"])){{route('admin.base.sys_url', ['dialog'=>$dialog ,'input'=>$input, 'module'=>$m["module"]])}} @else # @endif ">
                                {{$m["name"]}}
                                @if(!empty($menus[$m["moduleid"]]["type"]))
                                    @foreach($menus[$m["moduleid"]]["type"] as $t)
                                    <span onClick="window.location.href='{{route('admin.base.sys_url', ['dialog'=>$dialog ,'input'=>$input, 'module'=>$m['module'], 'type'=>$t['module']])}}';">
                                        {{$t["name"]}}
                                    </span>
                                    @endforeach
                                @endif
                            </a>
                            @endif
                        @endforeach
                    </div>
                    @include('admin.base.sysurl.'.$module.($type ? '_'.$type : ''))
                </div>

            </div>
        </div>
    </div>

    @if($input)
        <script language="javascript">var parent_input = '{{$input}}'; $(document).ready(material_obj.url_select);</script>
    @endif


@endsection