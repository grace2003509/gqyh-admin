@extends('admin.layouts.main')
@section('ancestors')
    <li>微官网</li>
@endsection
@section('page', '内容列表')
@section('subcontent')
    <link href='/admin/css/global.css' rel='stylesheet' type='text/css'/>
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css'/>
    <link href='/admin/css/web.css' rel='stylesheet' type='text/css'/>

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

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

                <div id="column" class="r_con_wrap">
                    <div class="control_btn">
                        <a href="{{route('admin.web.article_create')}}" class="btn_green btn_w_120">添加内容</a>
                    </div>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="mytable">
                        <tr>
                            <td width="8%" align="center"><strong>排序</strong></td>
                            <td width="15%" align="center"><strong>隶属栏目</strong></td>
                            <td align="center"><strong>内容标题</strong></td>
                            <td width="10%" align="center"><strong>操作</strong></td>
                        </tr>
                        @foreach($articles as $key => $rsArticle)
                        <tr onMouseOver="this.bgColor='#D8EDF4';" onMouseOut="this.bgColor='';" >
                            <td align="center">{{$rsArticle["Article_Index"]}}</td>
                            <td align="center">{{$rsArticle['column']["Column_Name"]}}</td>
                            <td>{{$rsArticle["Article_Title"]}}</td>
                            <td align="center">
                                <a href="/admin/web/article_edit/{{$rsArticle["Article_ID"]}}" title="修改">
                                    <img src="/admin/images/ico/mod.gif" align="absmiddle" />
                                </a>
                                <a href="/admin/web/article_del/{{$rsArticle["Article_ID"]}}" title="删除" onClick="if(!confirm('删除后不可恢复，继续吗？')){return false};">
                                    <img src="/admin/images/ico/del.gif" align="absmiddle" />
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <div class="clear"></div>
                </div>

            </div>
        </div>
    </div>

@endsection