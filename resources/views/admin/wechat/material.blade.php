@extends('admin.layouts.main')
@section('ancestors')
    <li>我的微信</li>
@endsection
@section('page', '图文消息管理')
@section('subcontent')

    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/material.css' rel='stylesheet' type='text/css' />
    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script type='text/javascript' src='/admin/js/material.js'></script>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">

                <div id="material" class="r_con_wrap">
                    <div class="list">
                        <div class="item first_item">
                            <div>
                                <div><a href="{{route('admin.wechat.material_add')}}"></a></div>
                                <a href="{{route('admin.wechat.material_add')}}">+单图文消息</a> </div>
                            <div class="multi">
                                <div><a href="{{route('admin.wechat.material_madd')}}"></a></div>
                                <a href="{{route('admin.wechat.material_madd')}}">+多图文消息</a> </div>
                        </div>

                        @foreach($rsMaterials as $rsMaterial)
                            @if($rsMaterial['Material_Type'] == 1)
                                <div class="item multi">
                                    <div>{{$rsMaterial['Material_CreateTime']}}</div>
                                    @foreach($rsMaterial['json'] as $k=>$v)
                                        <div class="@if($k > 0) list @else first @endif">
                                            <div class="info">
                                                <div class="img"><img src="{{$v['ImgPath']}}" /></div>
                                                <div class="title">{{$v['Title']}}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="mod_del">
                                        <div class="mod">
                                            <a href="#">
                                                <img src="/admin/images/ico/mod.gif" />
                                            </a>
                                        </div>
                                        <div class="del">
                                            <a href="#" onClick="if(!confirm('删除后不可恢复，继续吗？')){return false};">
                                                <img src="/admin/images/ico/del.gif" />
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="item one">
                                    <div class="title">{{$rsMaterial['json']['Title']}}</div>
                                    <div>{{$rsMaterial['Material_CreateTime']}}</div>
                                    <div class="img"><img src="{{$rsMaterial['json']['ImgPath']}}" /></div>
                                    <div class="txt">{{$rsMaterial['json']['TextContents']}}</div>
                                    <div class="mod_del">
                                        <div class="mod">
                                            <a href="#">
                                                <img src="/admin/images/ico/mod.gif" />
                                            </a>
                                        </div>
                                        <div class="del">
                                            <a href="#" onClick="if(!confirm('删除后不可恢复，继续吗？')){return false};">
                                                <img src="/admin/images/ico/del.gif" />
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <div class="clear"></div>
                    </div>
                    <div class="blank12"></div>
                    {{ $rsMaterials->links() }}
                </div>
            </div>
        </div>

        <div style="height: 20px"></div>
    </div>

    <script language="javascript">$(window).load(material_obj.material_init);</script>

@endsection