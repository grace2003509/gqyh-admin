@extends('admin.layouts.main')
@section('ancestors')
    <li>分销管理</li>
@endsection
@section('page', '爵位设置')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

    <style>
        input {border: 1px #ddd solid; border-radius: 3px;}
    </style>
    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">

                <div class="r_con_wrap">
                    <div class="control_btn">
                        <a href="{{route('admin.distribute.base_config_index')}}" class="btn_green btn_w_120">基础设置</a>
                        <a href="{{route('admin.distribute.home_config_index')}}" class="btn_green btn_w_120">分销首页设置</a>
                        <a href="{{route('admin.distribute.withdraw_config_index')}}" class="btn_green btn_w_120">提现设置</a>
                        <a href="{{route('admin.distribute.protitle_config_index')}}" class="btn_green btn_w_120">爵位设置</a>
                        <a href="" class="btn_green btn_w_120">其他设置</a>
                    </div>

                        <!--新增，修改爵位奖设置晋级条件，奖励比例-->

                        <table class="r_con_config">
                            <form method="post" action="{{route('admin.distribute.protitle_config_update')}}" id="distribute_config_form">
                                {{csrf_field()}}
                                <div style="height: 55px; line-height: 75px">
                                    <span style="color:red;">(请先设置共有几级爵位，保存后设置爵位晋级条件，保存后再设置奖励比例)</span>
                                </div>
                                <div class="row" style="margin-left: 0px">
                                    <label style="margin-right: 20px"><span style="color: red">*</span>爵位级别设置: </label>
                                    共有 <input class="form_input" value="{{$dis_level_num}}" name="Dis_Pro_Rate[Level_Num]" type="text" required
                                             style="height: 28px; text-indent: 10px"
                                             onkeyup="(this.v=function(){this.value=this.value.replace(/[^\d]/,'');}).call(this)" onblur="this.v();"
                                    > 级
                                </div>

                                <div style="height: 55px; line-height: 75px">
                                    <span style="color:red;">爵位晋级条件设置</span>
                                </div>
                                <table  class="r_con_table" id="dis_pro_title_table" border="0" cellpadding="5" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <td width="10%">序号</td>
                                        <td width="15%">称号名称</td>
                                        <td width="15%">销售额<span style="color:red;">(元)</span></td>
                                        <td width="15%">发展下级个数<span style="color:red;"></span></td>
                                        <!--<td width="15%">等级图标</td>-->
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @for($i=1;$i<=$dis_level_num;$i++)
                                    <tr  fieldtype="text">
                                        <td>{{$i}}</td>
                                        <td>
                                            <input class="form_input" @if(empty($dis_title_Rate[$i]['Name'])) value="" @else value="{{$dis_title_Rate[$i]['Name']}}" @endif name="Dis_Pro_Rate[Name][]"
                                                   type="text"  style="height: 28px; text-indent: 10px">
                                        </td>
                                        <td>
                                            <input class="form_input Group_Num" @if(empty($dis_title_Rate[$i]['check_money'])) value="0" @else value="{{$dis_title_Rate[$i]['check_money']}}" @endif name="Dis_Pro_Rate[check_money][]"
                                                   type="text" style="height: 28px; text-indent: 10px"
                                                   onkeyup="(this.v=function(){this.value=this.value.replace(/[^\d]/,'');}).call(this)" onblur="this.v();"
                                            >
                                        </td>
                                        <td>
                                            <input class="form_input" @if(empty($dis_title_Rate[$i]['check_next']))) value="0" @else value="{{$dis_title_Rate[$i]['check_next']}}" @endif  name="Dis_Pro_Rate[check_next][]"
                                                   type="text" style="height: 28px; text-indent: 10px"
                                                   onkeyup="(this.v=function(){this.value=this.value.replace(/[^\d]/,'');}).call(this)" onblur="this.v();"
                                            >
                                        </td>
                                    </tr>
                                    @endfor

                                    </tbody>
                                </table>
                                <div style="height: 55px; line-height: 75px">
                                    <span style="color:red;">提取下级奖励比例设置</span>
                                </div>
                                <table class="r_con_table"  id="dis_pro_title_table" border="0" cellpadding="5" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <td width="10%">序号</td>
                                        <td width="15%">称号名称</td>
                                        @for($b=0;$b<=$dis_level_num-1;$b++)
                                        <td width="15%">@if(empty($dis_title_Rate[$b]['Name'])) 一级会员 @else {{$dis_title_Rate[$b]['Name']}} @endif </td>
                                        @endfor
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @for($a=1;$a<=$dis_level_num;$a++)
                                    @if(!empty($dis_title_Rate[$a]['Name']))
                                    <tr  fieldtype="text">
                                        <td>{{$a}}</td>
                                        <td>
                                            @if(!empty($dis_title_Rate[$a]['Name'])) {{$dis_title_Rate[$a]['Name']}} @endif
                                        </td>
                                        @for($j=0;$j<=$dis_level_num-1;$j++)
                                        <td>
                                            <input class="form_input" @if(empty($dis_title_Rate[$a]['check_rate'][$j])) value="" @else value="{{$dis_title_Rate[$a]['check_rate'][$j]}}" @endif  name="Dis_Pro_Rate[check_rate][{{$a}}][]"
                                                   type="text" @if($j >= $a) disabled @endif  style="height: 28px; text-indent: 10px">
                                            <span style="color: red">%</span>
                                        </td>
                                        @endfor
                                    </tr>
                                    @endif
                                    @endfor

                                    </tbody>
                                </table>

                                <div class="blank20"></div>
                                <div class="submit">
                                    <input style="background-color: #1584D5" name="submit_button" value="提交保存" type="submit">
                                </div>
                            </form>
                        </table>
            </div>
        </div>
    </div>

@endsection