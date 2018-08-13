@extends('admin.layouts.main')

@section('subcontent')
    <!-- statistics start -->
    <link href='/admin/css/admin_home.css' rel='stylesheet' type='text/css' />
    <script src="/static/js/jQuery-1.9.1.min.js"></script>
    <script type='text/javascript' src='/admin/js/highcharts/highcharts_account.js'></script>
    <script type='text/javascript' src='/admin/js/highcharts/exporting.js'></script>
    <script type='text/javascript' src='/admin/js/account.js'></script>

    <div class="box" style="margin-top: -20px">
        <div class="remain_sms">
            <span style="font-size:14px;">[剩余短信<span style="color:#ff0000;"> {{$remain_count}}</span> 条]</span>
        </div>

        <dl id="statistics" class="list" style=" margin-left:5px;">

            <dd class="statis-item ">
                <p><span class="statis-num">{{$item['today_all_order_num']}}</span><br>
                    <span class="statis-name">今日所有订单</span>
                </p>
            </dd>
            <dd class="statis-item ">
                <p><span class="statis-num">{{$item['today_payed_order_num']}}</span><br>
                    <span class="statis-name">今日已付款订单</span>
                </p>
            </dd>
            <dd class="statis-item ">
                <p><span class="statis-num">{{$item['today_order_sales']}}</span><br>
                    <span class="statis-name">今日销售额</span>
                </p>
            </dd>
            <dd class="statis-item ">
                <p><span class="statis-num">{{$item['month_order_sales']}}</span><br>
                    <span class="statis-name">本月销售额</span>
                </p>
            </dd>
            <dd class="statis-item ">
                <p><span class="statis-num">{{$item['today_output_money']}}</span><br>
                    <span class="statis-name">今日支出佣金</span>
                </p>
            </dd>
            <dd class="statis-item ">
                <p><span class="statis-num">{{$item['month_output_money']}}</span><br>
                    <span class="statis-name">本月支出佣金</span>
                </p>
            </dd>
            <dd class="statis-item ">
                <p><span class="statis-num">{{$item['today_new__account_num']}}</span><br>
                    <span class="statis-name">今日加入分销商</span>
                </p>
            </dd>
            <dd class="statis-item">
                <p><span class="statis-num">{{$item['month_new_account_num']}}</span><br>
                    <span class="statis-name">本月加入分销商</span>
                </p>
            </dd>
        </dl>

        <div class="clearfix"></div>
        <!-- statistics end -->

        <!-- create record start -->
        <div class="baobiao_x">
            <form method="get" action="#" id="form11">
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
                    <label class="labx_x"><input name="time" type="radio" value="day" class="time_xx" checked="checked" style=" margin:5px;">按日</label>
                    <label class="labx_x"><input name="time" type="radio" value="week" class="time_xx" style=" margin:5px;">按周</label>
                    <label class="labx_x"><input name="time" type="radio" value="month" class="time_xx" style=" margin:5px;">按月</label>
		        </span>
                <span><a href="javascript:void(0);" class="scbg_x">生成报告</a></span>
            </form>
        </div>

        <script type="text/javascript">
            $(document).ready(function(){
                $(".scbg_x").click(function(){
                    $("#form11").submit();
                })
            })
        </script>
        <div class="clear"></div>
        <!-- create record end -->

        <!-- last 7days order total start -->
        <div class="ddzj_x">
            <div id="weekOrderChart"></div>
        </div>
        <div class="ddzj_x">
            <div id="weekChart"></div>
        </div>
        <!-- last 7days order total end -->

        <!-- /.box-body -->
        <div class="box-footer clearfix">
        </div>
    </div>
    <script type="text/javascript">

        $(function () {
            $('#weekOrderChart').highcharts({
                chart: {
                    backgroundColor: '#f6fbfa'
                },
                lang: {
                    printChart:"打印图表",
                    downloadJPEG: "下载JPEG 图片",
                    downloadPDF: "下载PDF文档",
                    downloadPNG: "下载PNG 图片",
                    downloadSVG: "下载SVG 矢量图",
                    exportButtonTitle: "导出图片"
                },
                title: {
                    text: '近七天订单总计',
                    x: 0 //center
                },
                subtitle: {
                    text: '',
                    x: 20
                },
                xAxis: {
                    categories: ["{{$report['orderChartData_keys']}}"]
                },
                yAxis: {
                    title: {
                        text: '单位（个）'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    valueSuffix: '个'
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [{
                    name: '订单',
                    data: [{{$report['orderChartData_value']}}]
                }]
            });

            $('#weekChart').highcharts({
                chart: {
                    backgroundColor: '#f6fbfa'
                },
                lang: {
                    printChart:"打印图表",
                    downloadJPEG: "下载JPEG 图片",
                    downloadPDF: "下载PDF文档",
                    downloadPNG: "下载PNG 图片",
                    downloadSVG: "下载SVG 矢量图",
                    exportButtonTitle: "导出图片"
                },
                title: {
                    text: '近七天订单金额总计',
                    x: 0 //center
                },
                subtitle: {
                    text: '',
                    x: 20
                },
                xAxis: {
                    categories: ["{{$report['weekChartData_keys']}}"]
                },
                yAxis: {
                    title: {
                        text: '单位（元）'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    valueSuffix: '元'
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [{
                    name: '收入',
                    data: [{{$report['weekChartData_value']}}]
                }]
            });
        });
    </script>
@endsection