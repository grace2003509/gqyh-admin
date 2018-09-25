@extends('admin.layouts.main')
@section('ancestors')
    <li>分销管理</li>
@endsection
@section('page', '下属分销商列表')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script type='text/javascript' src='/static/js/jquery.twbsPagination.min.js'></script>
    <style>
        .mytable {
            -moz-border-bottom-colors: none;
            -moz-border-left-colors: none;
            -moz-border-right-colors: none;
            -moz-border-top-colors: none;
            border-color: #CCCCCC;
            border-image: none;
            border-style: solid;
            border-width: 1px 0 0 1px;
        }
        .mytable td {
            -moz-border-bottom-colors: none;
            -moz-border-left-colors: none;
            -moz-border-right-colors: none;
            -moz-border-top-colors: none;
            border-color: #CCCCCC;
            border-image: none;
            border-style: solid;
            border-width: 0 1px 1px 0;
            padding: 5px;
        }
    </style>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">

                <div class="r_con_wrap">
                    <!-- level filter begin -->
                    <div class="btn-group" id="level_filter">
                        @for($i=1;$i<=$max_level;$i++)
                        <a  class="btn btn-default @if($level == $i) cur @endif " href="/admin/distribute/account_posterity/{{$userid}}?level={{$i}}">{{$i}}级分销商</a>
                        @endfor
                    </div>
                    <p>共{{$total_pages}}页,{{$total_num}}个,当前第{{$cur_page}}页</p>
                    <!-- level filter end -->

                    <div id="level_filter_panel">
                        <table class="mytable" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody><tr bgcolor="#f5f5f5">
                                <td width="50" align="center">序号</td>
                                <td width="50" align="center"><strong>账号</strong></td>
                                <td width="80" align="center"><strong>佣金余额</strong></td>
                                <td width="100" align="center"><strong>审核状态</strong></td>
                                <td width="100" align="center"><strong>总收入</strong></td>
                                <td width="100" align="center"><strong>加入时间</strong></td>

                            </tr>

                            @foreach($account_list as $key=>$item)
                            <tr onmouseover="this.bgColor='#D8EDF4';" onmouseout="this.bgColor='';" bgcolor="">
                                <td align="center" userid={{$item['User_ID']}}>{{$key+1}}</td>
                                <td align="center">
                                    @if(!empty($item['user']['User_ID']))
                                        {{$item['user']['User_Mobile']}}
                                    @else
                                        <span class="red">信息缺失</span>
                                    @endif
                                </td>
                                <td align="center">&yen;{{$item['balance']}}</td>
                                <td align="center">@if($item['Is_Audit']==1) 已通过 @else 未通过 @endif</td>
                                <td align="center">&yen;{{$item['Total_Income']}}</td>
                                <td align="center">{{ldate($item['Account_CreateTime'])}}</td>
                            </tr>
                            @endforeach

                            </tbody>
                        </table>

                    </div>

                    <div id="pagination_container">
                        <ul id="pagination" class="pagination-sm"></ul>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <script type='text/javascript'>
        $(document).ready(function(){
            @if($total_pages > 0)
            $('#pagination').twbsPagination({
                totalPages:'{{$total_pages}}',
                visiblePages: 7,
                href: '{{$href_template}}',
                onPageClick: function (event, page) {
                    $('#page-content').text('Page ' + page);
                }
            });
            @endif
        });
    </script>

@endsection