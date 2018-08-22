@extends('admin.layouts.main')
@section('ancestors')
    <li>基础设置</li>
@endsection
@section('page', '快递公司管理')
@section('subcontent')

    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">
                <div id="update_post_tips"></div>
                <div id="user" class="r_con_wrap">
                    <div class="control_btn">
                        <a data-target="#create_shipping_btn" data-toggle= 'modal' class="btn_green btn_w_120">添加</a>
                        {{--<a data-target="#mod_delete_shipping" data-toggle= 'modal' class="btn_green btn_w_120">恢复默认设置</a>--}}
                    </div>

                    <table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                        <thead>
                        <tr>
                            <td width="5%" nowrap="nowrap">序号</td>
                            <td width="8%" nowrap="nowrap">快递公司</td>
                            <td width="5%" nowrap="nowrap">状态</td>
                            <td width="10%" nowrap="nowrap">添加时间</td>
                            <td width="8%" nowrap="nowrap" class="last"><strong>操作</strong></td>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($shipping_list as $key=>$shipping)
                        <tr>
                            <td>{{$shipping['Shipping_ID']}}</td>
                            <td>{{$shipping['Shipping_Name']}}</td>
                            <td>
                                @if($shipping['Shipping_Status'] ==1)
                                    <img src="/admin/images/ico/yes.gif"/>
                                    @else
                                    <img src="/admin/images/ico/no.gif"/>
                                    @endif
                            </td>
                            <td nowrap="nowrap">{{$shipping['Shipping_CreateTime']}}</td>

                            <td nowrap="nowrap" class="last">
                                <a onclick="Values({{$shipping}})" data-target="#mod_edit_shipping" data-toggle= 'modal'  class="shipping_edit_btn">
                                    <img src="/admin/images/ico/mod.gif" alt="修改" align="absmiddle">
                                </a>
                                <a href="{{route('admin.base.shipping_del', ['id' => $shipping['Shipping_ID']])}}" onClick="if(!confirm('删除后不可恢复，且其下属分销模板会被一并删除,继续吗？')){return false};">
                                    <img src="/admin/images/ico/del.gif" align="absmiddle" />
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="blank20"></div>
                    {{ $shipping_list->links() }}
                </div>

            </div>
        </div>

    </div>


    <div class="modal fade" id="create_shipping_btn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        添加快递公司
                    </h4>
                </div>
                <form class="form" action="{{route('admin.base.shipping_store')}}" method="post">
                <div class="modal-body">
                    {{csrf_field()}}
                    <p class="rows">
                        <label for="Shipping_Name">名称</label>
                        <input type="text" value=""  name="Shipping_Name" />
                    </p>

                    <p class="rows">
                        <label>状态</label>
                        <input name="Shipping_Status" value="1"  type="radio" checked>&nbsp;&nbsp;可用
                        <input name="Shipping_Status" value="0"  type="radio">&nbsp;&nbsp; 不可用
                    </p>
                </div>
                <div class="modal-footer">
                    <input type="submit" style="border: none;padding: 10px" value="确定提交" name="submit_btn" class="btn btn-primary">
                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>



    <div class="modal fade" id="mod_delete_shipping" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        恢复默认设置
                    </h4>
                </div>
                <form class="form" action="{{route('admin.base.shipping_recovered')}}" method="post">
                    <div class="modal-body">
                        {{csrf_field()}}
                        <p class="rows">
                            <span> 快递公司数据将删除</span>
                        </p>

                    </div>
                    <div class="modal-footer">
                        <p class="rows">
                            <input type="submit" value="确定删除" name="submit_btn" style="border: none;padding: 10px">
                        </p>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>


    <div class="modal fade" id="mod_edit_shipping" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        修改快递公司信息
                    </h4>
                </div>

                <form class="form" action="" method="post" id="form_edit_shipping">
                    <div class="modal-body">
                        {{csrf_field()}}
                        <p class="rows">
                            <label for="Shipping_Name">名称</label>
                            <input type="text" value=""  name="Shipping_Name" id="Shipping_Name" />
                        </p>

                        <p class="rows">
                            <label>状态</label>
                            <input name="Shipping_Status" id="Shipping_Status" value="1"  type="radio" checked>&nbsp;&nbsp;可用
                            <input name="Shipping_Status" id="Shipping_Status" value="0"  type="radio">&nbsp;&nbsp; 不可用
                        </p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" value="" id="shipping_id">
                        <input type="submit" style="border: none;padding: 10px" value="提交修改" name="submit_btn" class="btn btn-primary">
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>

    <script>

        function Values(compay) {
            var url = '/admin/base/shipping_update/'+compay['Shipping_ID'];
            $('#Shipping_Name').val(compay['Shipping_Name']);
            $('#Shipping_Status').val(compay['Shipping_Status']);
            $('#shipping_id').val(compay['Shipping_ID']);
            $("#form_edit_shipping").attr('action',url);
        }
    </script>


@endsection