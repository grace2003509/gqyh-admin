@extends('admin.layouts.main')

@section('subcontent')
    <!-- statistics start -->
    <link href='/static/css/bootstrap.min.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/admin_home.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/jquery-1.9.1.min.js"></script>
    <script src="/static/js/plugins/bootstrap/bootstrap.min.js"></script>
    <script type='text/javascript' src='/admin/js/global.js'></script>

    <div class="box" style="margin-top: -20px;">
        <div id="wrap" class="center">
            <div class="baobiao_x">
                <form method="get" action="?" id="form1">
                    <span style=" font-size:16px; line-height:50px; margin-left:15px;">时间范围：</span>
                    <select class="xx-select" id="type" name="type">
                        <option value="week">近七天</option>
                        <option value="month">近一个月</option>
                        <option value="quarter">近三个月</option>
                        <option value="half">近半年</option>
                        <option value="year">近一年</option>
                    </select>
                    <span style=" font-size:16px; line-height:50px; margin-left:15px;">时间粒度：</span>
                    <span>
                        <label class="labx_x"><input name="time" type="radio" value="day" class="time_xx" style=" margin:5px;">按日</label>
                        <label class="labx_x"><input name="time" type="radio" value="week" class="time_xx" style=" margin:5px;">按周</label>
                        <label class="labx_x"><input name="time" type="radio" value="month" class="time_xx" style=" margin:5px;">按月</label>
		            </span>
                    <span><a href="javascript:void(0);" class="scbg_x">生成报告</a></span>
                </form>
            </div>
        </div>

        <div class="report_table center">
            <table>
                <tr>
                    <th>日期</th>
                    <th>订单数量</th>
                    <th>金额</th>
                </tr>
                @foreach($data2 as $item)
                <tr>
                    <td>{{$item['date']}}</td>
                    <td>{{$item['OrderTotal']}}</td>
                    <td>{{$item['OrderTotalAmount']}}</td>
                </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td>共计<span>{{$totalOrder}}</span>个订单</td>
                    <td>共<span>{{$totalAmount}}</span>元</td>
                </tr>
            </table>
        </div>
        <div class="clearfix"></div>
        <!--// day report -->

        <!-- download -->
        @if(count($data2))
            <a href="{{route('admin.statistics.download', ['type'=> $default_data['type'],'time' => $default_data['time']])}}">
                <button id="down" class="report_down_button">点击下载</button>
            </a>
        @endif
        <!--// download -->

    </div>
    <!-- /.box-body -->
    <script type='text/javascript'>
        $(function(){
            $(".scbg_x").click(function(){
                $("#form1").submit();
            })

            $("#type").val('{{$default_data['type']}}');
            $("input:radio[value='{{$default_data['time']}}']").attr('checked','true');

        })
    </script>

@endsection