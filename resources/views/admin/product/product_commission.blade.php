<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
</head>
<body>
<link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
<link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

<script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

<div id="orders" class="r_con_wrap">
    <table border="0" cellpadding="5" cellspacing="0" class="r_con_table" style="border-left:1px solid #ddd;">
        <thead>
        <tr>
            <td width="15%" nowrap="nowrap">序号</td>
            <td width="30%" nowrap="nowrap">级别名称</td>
            <td width="55%" nowrap="nowrap">佣金明细</td>
        </tr>
        </thead>
        <tbody>
        @foreach($dislevelarrs as $key=>$disinfo)
        <tr>
            <td nowrap="nowrap">{{$key+1}}</td>
            <td nowrap="nowrap">{{$disinfo['Level_Name']}}</td>
            <td nowrap="nowrap">

                @for($i=0;$i<$level;$i++)
                <li style="list-style-type:none">
                    @if($dis_config['Dis_Self_Bonus']==1 && $i==$dis_config['Dis_Level'])
                        <strong>自销佣金</strong>
                    @else
                        <strong>{{$arr[$i]}}级</strong>
                    @endif
                    @if(!empty($distribute_list[$disinfo['Level_ID']][$i]))
                        {{$distribute_list[$disinfo['Level_ID']][$i]}}
                    @else 0 @endif 元 &nbsp;(佣金)<em></em>
                </li>
                @endfor
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

</div>
</body>
</html>