@extends('admin.layouts.main')
@section('ancestors')
    <li>分销管理</li>
@endsection
@section('page', '分销账号管理')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/area_content.css?data=041607' rel='stylesheet' type='text/css' />
    <link href='/admin/css/distribute.css?data=041607' rel='stylesheet' type='text/css' />
    <link href='/static/js/plugins/lean-modal/style.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script type='text/javascript' src='/admin/js/account.js'></script>


    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">
                <div id="update_post_tips"></div>
                <div></div>
                <div id="user" class="r_con_wrap">

                    <form class="search" id="search_form" method="get" action="{{route('admin.distribute.account_index')}}">
                        <span> 推荐人：</span>
                        <input type="text" name="Keyword" value="" class="form_input" size="15" />
                        <span> 账号：</span>
                        <input type="text" name="Mobile" value="" class="form_input" size="15" />
                        <span>&nbsp;爵位级别&nbsp;</span>
                        <select name="level">
                            <option value="all">全部</option>
                            <option value="0">无级别</option>
                            @foreach($dis_title_level as $key=>$l)
                            <option value="{{$key}}">{{$l["Name"]}}</option>
                            @endforeach
                        </select>&nbsp;&nbsp;
                        <span>&nbsp;分销商级别&nbsp;</span>
                        <select name="dis_level">
                            <option value="0">全部</option>
                            @foreach($rsDis_Level as $key=>$l)
                            <option value="{{$l["Level_ID"]}}">{{$l["Level_Name"]}}</option>
                            @endforeach
                        </select>&nbsp;&nbsp;
                        <input type="hidden" name="search" value="1" />
                        <input type="submit" class="search_btn" value=" 搜索 " />
                    </form>

                    <table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" class="r_con_table">
                        <thead>
                        <tr>
                            <td width="5%" nowrap="nowrap">账号ID</td>
                            <td width="5%" nowrap="nowrap">推荐人</td>
                            <td width="8%" nowrap="nowrap">账号</td>
                            <td width="5%" nowrap="nowrap">可提佣金余额</td>
                            <td width="5%" nowrap="nowrap">审核状态</td>
                            <td width="6%" nowrap="nowrap">总收入</td>
                            <td width="6%" nowrap="nowrap">团队销售额</td>
                            <td width="5%" nowrap="nowrap">分销商等级</td>
                            <td width="5%" nowrap="nowrap">爵位</td>
                            <td width="5%" nowrap="nowrap">爵位奖金</td>
                            <td width="5%" nowrap="nowrap">加入时间</td>
                            <td width="5%" nowrap="nowrap">状态</td>
                            <td width="8%" nowrap="nowrap" class="last"><strong>操作</strong></td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($account_list as $key=>$account)
                        <tr UserID="{{$account['User_ID']}}" AccountID="{{$account['Account_ID']}}">
                            <td nowarp="nowrap">{{$account['Account_ID']}}</td>
                            <td nowrap="nowraqp">{{$account['inviter_name']}}</td>
                            <td nowarp="nowrap"> @if(!empty($account['user'])) {{$account['user']['User_Mobile']}} @else 信息缺失 @endif </td>
                            <td nowarp="nowrap">&yen;{{$account['balance']}}</td>
                            <td nowarp="nowrap">@if($account['Is_Audit']) 已通过 @else 未通过 @endif </td>
                            <td nowarp="nowrap">&yen;{{$account['Total_Income']}}</td>
                            <td nowrap="nowrap">&yen;{{$account['Sales_Group']}}元</td>
                            <td nowrap="nowrap" class="upd_selecjiejiet" field="5">{{$account['Level_Name']}}</td>
                            <td nowarp="nowrap">
                                @if(empty($dis_title_level[$account['Professional_Title']]['Name']))
                                    无
                                @else
                                    {{$dis_title_level[$account['Professional_Title']]['Name']}}
                                @endif
                            </td>
                            <td nowrap="nowrap">&yen;{{$account['nobi_Total']}}</td>
                            <td nowrap="nowrap">{{date("Y-m-d H:i:s",$account['Account_CreateTime'])}}</td>
                            <td nowrap="nowrap">
                                @if($account['status'] ==1&&$account['Is_Dongjie']==0&&$account['Is_Delete']==0 )
                                <img src="/admin/images/ico/yes.gif"/>
                                @else
                                <img src="/admin/images/ico/no.gif"/>
                                @endif
                            </td>
                            <td nowrap="nowrap" class="last">
                                <!-- 代理开关begin -->
                                @if($rsConfig['Dis_Agent_Type'] == 1)
                                <a class="agent_info" agent-id="{{$account['Account_ID']}}" href="javascript:void(0)">代理信息</a>|
                                @endif
                                <!-- 代理开关end -->
                                @if($account['Is_Audit'] == 0)
                                <a href="?action=pass&AccountID={{$account['Account_ID']}}">通过</a>
                                @endif
                                @if($account['status'] == 1)
                                    <a href="/admin/distribute/account_upate/{{$account['Account_ID']}}?action=disable"
                                       onClick="if(!confirm('禁用后此分销商不可分销,你确定要禁用么？')){return false};">禁用</a>|
                                @else
                                    <a href="/admin/distribute/account_upate/{{$account['Account_ID']}}?action=enable" title="开启" >开启</a>|
                                @endif
                                @if($account['Is_Dongjie'] == 0)
                                    <a href="/admin/distribute/account_upate/{{$account['Account_ID']}}?action=dongjie"
                                       onClick="if(!confirm('冻结后此分销商不可分销,你确定要冻结么？')){return false};">冻结</a>|
                                @else
                                    <a href="/admin/distribute/account_upate/{{$account['Account_ID']}}?action=jiedong" title="解冻" >解冻</a>|
                                @endif
                                @if($account['Is_Delete'] == 0)
                                    <a href="/admin/distribute/account_upate/{{$account['Account_ID']}}?action=delete"
                                       onClick="if(!confirm('删除后此分销商不可分销,你确定要删除么？')){return false};">删除</a>|
                                @else
                                    <a href="/admin/distribute/account_upate/{{$account['Account_ID']}}?action=undelete" title="恢复" >恢复</a>|
                                @endif
                                @if($account['status']==1&&$account['Is_Delete']==0&&$account['Is_Dongjie']==0)
                                <a href="/admin/distribute/account_posterity/{{$account['User_ID']}}" >下属</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <div class="page">{{$account_list->links()}}</div>
                </div>

            </div>
        </div>
    </div>


    <!-- 代理信息modal begin -->
    <div class="container">
        <div class="row">
            <div class="modal"  role="dialog" id="agent-info-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h5 class="modal-title" id="mySmallModalLabel">代理信息</h5>
                        </div>
                        <div class="modal-body">
                            <p>正在加载中...</p>
                            <div class="clearfix"></div>
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-default" id="confirm_dis_area_agent_btn">确定</a>
                            <a class="btn btn-danger" id="cancel_shipping_btn close" data-dismiss="modal">取消</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script language="javascript">
        var  base_url = '{{$base_url}}'
        var level_ary=Array();
        level_ary[0] = '无';
        <?php foreach($dis_title_level as $k=>$v){
            echo 'level_ary['.$k.']="'.$v['Name'].'";';
        }?>
        $(document).ready(function(){account_obj.account_init();});
    </script>
@endsection