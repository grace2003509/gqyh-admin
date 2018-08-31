@extends('admin.layouts.main')
@section('ancestors')
    <li>活动管理</li>
@endsection
@section('page', '编辑活动')
@section('subcontent')

    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />
    <link href='/static/css/daterangepicker.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script src="/static/js/moment.js"></script>
    <script type='text/javascript' src='/static/js/daterangepicker.js'></script>
    <style>
        label {padding-left:5px;}
    </style>
    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">

                <div id="products" class="r_con_wrap">
                    <form id="product_add_form" class="r_con_form skipForm" method="post"
                          action="{{route('admin.active.update',['id'=> $active['Active_ID']])}}">
                        {{csrf_field()}}
                        <div class="rows">
                            <label>活动名称</label>
                            <span class="input">
							    <input type="text" name="Active_Name" value="{{$active['Active_Name']}}"
                                       class="form_input" size="5" style="width: 200px; float: left;" maxlength="10" />
                                <span style="color: red">&nbsp;* </span>
						    </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>活动类型</label>
                            <span class="input">
                                <select name="ActiveType">
                                    <option value="" >--请选择--</option>
                                 @foreach ($typelist as $k => $v)
                                    <option value="{{$k}}" @if($active['Type_ID'] == $k) selected @endif >{{$v}}</option>
                                 @endforeach
                                </select><span style="color: red">&nbsp;* </span>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>商家数</label>
                            <span class="input">
                                <input type="number" name="MaxBizCount" class="form_input" size="5" maxlength="10"
                                       value="{{$active['MaxBizCount']}}" />
                                <span style="color: red">&nbsp;* </span>（允许多少个商家参加活动）
							 </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>活动最多产品数</label>
                            <span class="input">
                                <input type="number" name="MaxGoodsCount" class="form_input" size="5" maxlength="100"
                                    value="{{$active['MaxGoodsCount']}}" />
                                <span style="color: red">&nbsp;* </span>（活动总共可以参加的产品数量）
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>商家推荐产品数</label>
                            <span class="input">
                                <input type="number" name="BizGoodsCount"  class="form_input" size="5" maxlength="100"
                                    value="{{$active['BizGoodsCount']}}"/>
                                <span style="color: red">&nbsp;* </span>（每个商家最多可推荐的产品数量）
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>列表页显示产品数</label>
                            <span class="input">
                                <input type="number" name="ListShowGoodsCount" class="form_input" size="5" maxlength="100"
                                     value="{{$active['ListShowGoodsCount']}}"/>
                                <span style="color: red">&nbsp;* </span>（活动列表页可以显示的产品的数量）
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>商家店铺页显示产品数</label>
                            <span class="input">
                                <input type="number" name="BizShowGoodsCount" class="form_input" size="5" maxlength="100"
                                 value="{{$active['BizShowGoodsCount']}}"/>
                                <span style="color: red">&nbsp;* </span>（商家店铺页可以显示的产品的数量）
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>参与活动时间</label>
                            <span class="input time">
                                <span id="reportrange">
                                    <input type="text" id="reportrange-input" name="date-range-picker" placeholder="日期间隔"
                                        value="{{$active['date-range-picker']}}"/>
                                    <span style="color: red">&nbsp;* </span>
                                </span>
                            </span>
						    <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>活动状态</label>
                            <span class="input" style="font-size: 12px;">
							    <input type="radio" id="status_0" value="0" @if($active['Status'] == 0) checked @endif name="Status" />
                                <label for="status_0"> 关闭 </label>&nbsp;&nbsp;
                                <input type="radio" id="status_1" value="1" name="Status"  @if($active['Status'] == 1) checked @endif  />
                                <label for="status_1"> 开启 </label>
						    </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label></label>
                            <span class="input">
                                <input type="submit" class="btn_green" name="submit" value="提交保存" />
                                <a href="{{route('admin.active.index')}}" class="btn_gray" >返回</a>
                            </span>

							<div class="clear"></div>
                        </div>

                    </form>
                </div>

            </div>
        </div>

    </div>
    <!-- /.box-body -->
    <script language="javascript">
        var ranges  =  {
            '今日': [moment(), moment()],
            '昨日': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '本月': [moment().startOf('month'), moment().endOf('month')]
        };
        //初始化时间间隔插件
        $("#reportrange").daterangepicker({
            ranges: ranges,
            startDate: moment(),
            endDate: moment(),
            timePicker:true,
            // timePicker12Hour:false,
            // timePickerIncrement:1,
            // format:'YYYY-MM-DD hh:mm'
        }, function (startDate, endDate) {
            var range = startDate.format('YYYY/MM/DD') + "-" + endDate.format('YYYY/MM/DD');
            $("#reportrange #reportrange-inner").html(range);
            $("#reportrange #reportrange-input").attr('value', range);
        });
    </script>
@endsection