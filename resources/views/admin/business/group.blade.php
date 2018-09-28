@extends('admin.layouts.main')
@section('ancestors')
    <li>商家分组</li>
@endsection
@section('page', '商家分组列表')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

    <div class="box">

        <div id="iframe_page">
            <div class="iframe_content">

                <div id="group" class="r_con_wrap">
                    <div class="control_btn">
                        <a href="{{route('admin.business.group_create')}}" class="btn_green btn_w_120">添加分组</a>
                    </div>

                    <table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                        <thead>
                        <tr>
                            <td width="10%" nowrap="nowrap">排序</td>
                            <td nowrap="nowrap">分组名称</td>
                            <td width="20%" nowrap="nowrap">开通店铺</td>
                            <td width="15%" nowrap="nowrap" class="last">操作</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lists as $k=>$rsGroup)
                        <tr>
                            <td nowrap="nowrap">{{$rsGroup["Group_Index"]}}</td>
                            <td>{{$rsGroup["Group_Name"]}}
                                @if($rsGroup['is_default']==1)
                                    (入驻商家默认 @if($rsGroup["Group_IsStore"]) 开通 @else 不开通 @endif 店铺)
                                @endif
                            </td>
                            <td>
                                @if($rsGroup["Group_IsStore"])
                                    <span style="color:blue">已开通</span>
                                @else
                                    <span style="color:red">不开通</span>
                                @endif
                            </td>
                            <td class="last" nowrap="nowrap">
                                <a href="{{route('admin.business.group_edit', ['id' => $rsGroup["Group_ID"]])}}">
                                    <img src="/admin/images/ico/mod.gif" align="absmiddle" alt="修改" />
                                </a>
                                @if($rsGroup['is_default'] == 0)
                                <a href="{{route('admin.business.group_del', ['id' => $rsGroup["Group_ID"]])}}" onClick="if(!confirm('删除后不可恢复，继续吗？')){return false};">
                                    <img src="/admin/images/ico/del.gif" align="absmiddle" alt="删除" />
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="blank20"></div>
                    {{$lists->links()}}
                </div>

            </div>
        </div>

    </div>

@endsection