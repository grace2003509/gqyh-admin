@extends('admin.layouts.main')

@section('subcontent')
    <!-- statistics start -->
    <link href='/static/css/bootstrap.min.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/admin_home.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/jquery-1.9.1.min.js"></script>
    <script src="/static/js/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script>
    <script src="http://cdn.hcharts.cn/highcharts/modules/exporting.js"></script>

    <div class="box" style="margin-top: -20px;">
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
            <form method="get" action="{{ route('admin.statistics.index') }}" id="form11">
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
        <div class="clear"></div>
        <!-- last 7days order total end -->

        <!-- 月销售统计begin -->
        <div class="col-md-12" id="sale-chart-panel"style=" padding:0px; border-top: #eee 1px solid ">
            <div class="panel panel-default" style="border:none;">
                <!-- Default panel contents -->
                <div class="panel-heading" style="background-color: #fff; padding-top: 30px">
                    <span class="fa fa-bar-chart sky-blue fz-20"></span>月销售统计
                    <div class="panel-body">
                        <div id="circleChart" style="float:right; width:20%"></div>
                        <div class="chart" id="chart" style="width:78%"></div>
                    </div>
                </div>

            </div>
        </div>
        <div class="box-footer clearfix"></div>
        <!-- 月销售统计end -->

        <!-- /.box-body -->
    </div>

    <script type="text/javascript">

        // 图表配置
        var order_options = {
            chart: {
                type: 'line',                         //指定图表的类型，默认是折线图（line）
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
                text: '近七天订单总计'  ,               // 标题
                x:0
            },
            xAxis: {
                categories: [
                    "{{$report['orderChartData_keys'][0]}}",
                    "{{$report['orderChartData_keys'][1]}}",
                    "{{$report['orderChartData_keys'][2]}}",
                    "{{$report['orderChartData_keys'][3]}}",
                    "{{$report['orderChartData_keys'][4]}}",
                    "{{$report['orderChartData_keys'][5]}}",
                    "{{$report['orderChartData_keys'][6]}}"
                ]   // x 轴分类
            },
            yAxis: {
                title: {
                    text: '单位（个）'
                }
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
                data: [{{$report['orderChartData_value']}}],
                color: '#1584D5'
            }]
        }
        // 图表初始化函数
        var chart = Highcharts.chart('weekOrderChart', order_options);

        var money_options = {
            chart: {
                type: 'line',                         //指定图表的类型，默认是折线图（line）
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
                text: '近七天订单金额总计'                 // 标题
            },
            xAxis: {
                categories: [
                    "{{$report['weekChartData_keys'][0]}}",
                    "{{$report['weekChartData_keys'][1]}}",
                    "{{$report['weekChartData_keys'][2]}}",
                    "{{$report['weekChartData_keys'][3]}}",
                    "{{$report['weekChartData_keys'][4]}}",
                    "{{$report['weekChartData_keys'][5]}}",
                    "{{$report['weekChartData_keys'][6]}}",
                ]  // x 轴分类
            },
            yAxis: {
                title: {
                    text: '单位（元）'
                }
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
                data: [{{$report['weekChartData_value']}}],
                color: '#1584D5'
            }]
        }
        var chart1 = Highcharts.chart('weekChart', money_options);


        var chart_data={

            "count": [ {
                "name": "本月销售曲线图",
                "data": [{{$saleline['month_sales_value']}}],
                "type": "column",
                'color': '#1584D5'
            },{
                "name": "本月支出曲线图",
                "data": [{{$saleline['month_summary_value']}}],
                "type": "column",
                'color': '#ff5646'
            }],
            "date": [{{$saleline['month_sales_keys']}}]
        };
        var saleline_options = {
            chart: {
                type: 'column',                         //指定图表的类型，默认是折线图（line）
                backgroundColor: '#f6fbfa'
            },
            title: {
                text: ''
            },
            tooltip: {
                valueSuffix: '元'
            },
            xAxis: {
                categories: chart_data.date
            },
            yAxis: [{
                title: {
                    text: '单位(元)'
                }
            }],
            series: chart_data.count,
            exporting: {
                enabled: false
            }
        };
        var chart2 = Highcharts.chart('chart', saleline_options);


        var sale_options = {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
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
                text: '进账与出账比'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                type: 'pie',
                name: '查看',
                data: [
                    {
                        name: '进账',
                        y: {{$sales['getPercent']}},
                        sliced: true,
                        selected: true
                    },
                    ['出账',     {{$sales['outPercent']}}]
                ]
            }]
        }
        var chart3 = Highcharts.chart('circleChart', sale_options);

    </script>

@endsection