@extends('admin.layouts.main')
@section('ancestors')
    <li>分销管理</li>
@endsection
@section('page', '区域代理设置')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

    <style>
        .level_for_level > div { float: left; margin-top: 5px; margin-right: 10px; }
        .level_for_level > div:nth-child(even) { margin-right: 20px; }
        li {list-style-type: none}
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
                        <a href="{{route('admin.distribute.agent_config_index')}}" class="btn_green btn_w_120">区域代理设置</a>
                        <a href="{{route('admin.distribute.other_config_index')}}" class="btn_green btn_w_120">其他设置</a>
                    </div>

                        <form id="distribute_config_form" class="r_con_form" method="post"
                              action="{{route('admin.distribute.agent_config_update')}}">
                            {{csrf_field()}}

                            <h2 style="height:40px; line-height:40px; font-size:14px; font-weight:bold; background:#eee; text-indent:15px;">区域代理设置</h2>
                            <div class="rows" >
                                <label>分销商代理设置</label>
                                <span class="input">
                                    <input type="radio" id="f_0" name="Dis_Agent_Type" value="0" @if($rsConfig["Dis_Agent_Type"]==0) checked @endif />
                                    <label for="f_0">关闭</label>&nbsp;&nbsp;
                                    <input type="radio" id="f_1" name="Dis_Agent_Type" value="1" @if($rsConfig["Dis_Agent_Type"] == 1) checked @endif />
                                    <label for="f_1">地区代理</label>
                                </span>
                                <div class="clear"></div>
                            </div>

                            <!--edit in 20160409-->
                            <!-- 代理省级设置begin -->
                            <div  class="rows" id="Agent_Rate_Row" @if($rsConfig["Dis_Agent_Type"]>0) style="display:block" @else style="display:none" @endif >
                                <label>省级设置</label>
                                <span class="input" id="Agent_Rate_Input">
                                    销售额%<input type="text" name="Agent_Rate[pro][Province]"
                                               @if(isset($Agent_Rate_list['pro']['Province']))
                                                       value="{{$Agent_Rate_list['pro']['Province']}}"
                                               @else
                                                       value=""
                                               @endif class="form_input" size="3" maxlength="10" required />&nbsp;&nbsp;&nbsp;
                                    代理价格<strong class="red">（元）</strong>
                                    <input type="text" name="Agent_Rate[pro][Provincepro]"
                                           @if(isset($Agent_Rate_list['pro']['Provincepro']))
                                                   value="{{$Agent_Rate_list['pro']['Provincepro']}}"
                                           @else
                                                   value=""
                                           @endif class="form_input" size="10" maxlength="10" required />
                                    认证条件：等级
                                    <select name="Agent_Rate[pro][Level]">
				                        <option value="0" @if(isset($Agent_Rate_list['pro']['Level']) && $Agent_Rate_list['pro']['Level']== 0) selected @endif >---选择等级---</option>
                                        @if(!empty($distribute_level))
                                        @foreach($distribute_level as $key=>$level)
                                        <option value="{{$level['Level_ID']}}" @if(isset($Agent_Rate_list['pro']['Level']) && $level['Level_ID']==$Agent_Rate_list['pro']['Level']) selected @endif >{{$level['Level_Name']}}</option>
                                        @endforeach
                                        @endif
                                    </select>&nbsp;&nbsp;&nbsp;
                                    爵位
                                    <select name="Agent_Rate[pro][Protitle]">
			                            <option value="0" @if(isset($Agent_Rate_list['pro']['Protitle']) && $Agent_Rate_list['pro']['Protitle']== 0 ) selected @endif >---选择爵位---</option>
                                        @if(!empty($dis_title_level))
                                        @foreach($dis_title_level as $key=>$title)
                                        <option value="{{$key}}" @if(isset($Agent_Rate_list['pro']['Protitle']) && $key==$Agent_Rate_list['pro']['Protitle']) selected @endif >{{$title['Name']}}</option>
                                        @endforeach
                                        @endif
                                    </select>&nbsp;&nbsp;&nbsp;
                                    自费金额<strong class="red">（元）</strong>
                                    <input type="text" name="Agent_Rate[pro][Selfpro]"
                                           @if(isset($Agent_Rate_list['pro']['Selfpro']))
                                                   value="{{$Agent_Rate_list['pro']['Selfpro']}}"
                                           @else
                                                   value=""
                                           @endif class="form_input" size="10" maxlength="10" required />&nbsp;&nbsp;&nbsp;
				                    团队销售额<strong class="red">（元）</strong>
                                    <input type="text" name="Agent_Rate[pro][Teampro]"
                                           @if(isset($Agent_Rate_list['pro']['Teampro']))
                                                   value="{{$Agent_Rate_list['pro']['Teampro']}}"
                                           @else
                                                   value=""
                                           @endif class="form_input" size="10" maxlength="10" required />
                                    <br>
                                    <div class="level_for_level">
                                        <div>省级</div>
                                        <div>
                                            @if(isset($Agent_Rate_Commi_list['pro']['pro']))
                                                @foreach($Agent_Rate_Commi_list['pro']['pro'] as $ak => $av)
                                                    <input type="text" name="Agent_Rate_Commi[pro][pro][]" value="{{$av}}" class="form_input" size="7" maxlength="10" required /><br>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div>省会级</div>
                                        <div>
                                            @if(isset($Agent_Rate_Commi_list['pro']['procit']))
                                                @foreach($Agent_Rate_Commi_list['pro']['procit'] as $ak => $av)
                                                    <input type="text" name="Agent_Rate_Commi[pro][procit][]" value="{{$av}}" class="form_input" size="7" maxlength="10" required /><br>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div>市级</div>
                                        <div>
                                            @if(isset($Agent_Rate_Commi_list['pro']['cit']))
                                                @foreach($Agent_Rate_Commi_list['pro']['cit'] as $ak => $av)
                                                    <input type="text" name="Agent_Rate_Commi[pro][cit][]" value="{{$av}}" class="form_input" size="7" maxlength="10" required /><br>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div>县(区)级</div>
                                        <div>
                                            @if(isset($Agent_Rate_Commi_list['pro']['cou']))
                                                @foreach($Agent_Rate_Commi_list['pro']['cou'] as $ak => $av)
                                                    <input type="text" name="Agent_Rate_Commi[pro][cou][]" value="{{$av}}" class="form_input" size="7" maxlength="10" required /><br>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div>@if(empty($hige_distribute_level['Level_Name'])) 总 @else {{$hige_distribute_level['Level_Name']}} @endif </div>
                                        <div>
                                            @if(isset($Agent_Rate_Commi_list['pro']['zong']))
                                                @foreach($Agent_Rate_Commi_list['pro']['zong'] as $ak => $av)
                                                    <input type="text" name="Agent_Rate_Commi[pro][zong][]" value="{{$av}}" class="form_input" size="7" maxlength="10" required /><br>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
        	                    </span>
                                <div class="clear"></div>
                            </div>
                            <!-- 代理省级设置end -->

                            <!-- 代理省会级设置begin -->
                            <div class="rows" id="Agent_Ratpc_Row" @if($rsConfig["Dis_Agent_Type"]>0) style="display:block" @else style="display:none" @endif >
                                <label>省会级设置</label>
                                <span class="input" id="Agent_Ratpc_Input">
                                    销售额%
                                    <input type="text" name="Agent_Rate[procit][Province]"
                                           @if(isset($Agent_Rate_list['procit']['Province']))
                                           value="{{isset($Agent_Rate_list['procit']['Province'])}}"
                                           @else
                                           value=""
                                           @endif class="form_input" size="3" maxlength="10" required />&nbsp;&nbsp;&nbsp;
				                    代理价格<strong class="red">（元）</strong>
                                    <input type="text" name="Agent_Rate[procit][Provincepro]"
                                           @if(isset($Agent_Rate_list['procit']['Provincepro']))
                                           value="{{isset($Agent_Rate_list['procit']['Provincepro'])}}"
                                           @else
                                           value=""
                                           @endif class="form_input" size="10" maxlength="10" required />
                                    认证条件：
                                    等级
                                    <select name="Agent_Rate[procit][Level]">
					                    <option value="0" @if(isset($Agent_Rate_list['procit']['Level']) && $Agent_Rate_list['procit']['Level'] == 0) selected @endif >---选择等级---</option>
                                        @if(!empty($distribute_level))
                                        @foreach($distribute_level as $key=>$level)
                                        <option value="{{$level['Level_ID']}}" @if(isset($Agent_Rate_list['procit']['Level']) && $level['Level_ID']==$Agent_Rate_list['procit']['Level']) selected @endif >{{$level['Level_Name']}}</option>
                                        @endforeach
                                        @endif
				                    </select>&nbsp;&nbsp;&nbsp;
                                    爵位
                                    <select name="Agent_Rate[procit][Protitle]">
					                    <option value="0" @if(isset($Agent_Rate_list['procit']['Protitle']) && $Agent_Rate_list['procit']['Protitle']== 0) selected @endif >---选择爵位---</option>
                                        @if(!empty($dis_title_level))
                                        @foreach($dis_title_level as $key=>$title)
                                        <option value="{{$key}}" @if(isset($Agent_Rate_list['procit']['Protitle']) && $key==$Agent_Rate_list['procit']['Protitle']) selected @endif >{{$title['Name']}}</option>
                                        @endforeach
                                        @endif
				                    </select>&nbsp;&nbsp;&nbsp;
                                    自费金额<strong class="red">（元）</strong>
                                    <input type="text" name="Agent_Rate[procit][Selfpro]"
                                           @if(isset($Agent_Rate_list['procit']['Selfpro']))
                                                   value="{{isset($Agent_Rate_list['procit']['Selfpro'])}}"
                                           @else
                                                   value=""
                                           @endif class="form_input" size="10" maxlength="10" required />&nbsp;&nbsp;&nbsp;
				                    团队销售额<strong class="red">（元）</strong>
                                    <input type="text" name="Agent_Rate[procit][Teampro]"
                                           @if(isset($Agent_Rate_list['procit']['Teampro']))
                                           value="{{isset($Agent_Rate_list['procit']['Teampro'])}}"
                                           @else
                                           value=""
                                           @endif class="form_input" size="10" maxlength="10" required />
                                    <br>
                                    <div class="level_for_level">
                                        <div>省级</div>
                                        <div>
                                            @if(isset($Agent_Rate_Commi_list['procit']['pro']))
                                                @foreach($Agent_Rate_Commi_list['procit']['pro'] as $ak => $av)
                                                    <input type="text" name="Agent_Rate_Commi[procit][pro][]" value="{{$av}}" class="form_input" size="7" maxlength="10" required /><br>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div>省会级</div>
                                        <div>
                                            @if(isset($Agent_Rate_Commi_list['procit']['procit']))
                                                @foreach($Agent_Rate_Commi_list['procit']['procit'] as $ak => $av)
                                                    <input type="text" name="Agent_Rate_Commi[procit][procit][]" value="{{$av}}" class="form_input" size="7" maxlength="10" required /><br>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div>市级</div>
                                        <div>
                                            @if(isset($Agent_Rate_Commi_list['procit']['cit']))
                                                @foreach($Agent_Rate_Commi_list['procit']['cit'] as $ak => $av)
                                                    <input type="text" name="Agent_Rate_Commi[procit][cit][]" value="{{$av}}" class="form_input" size="7" maxlength="10" required /><br>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div>县(区)级</div>
                                        <div>
                                            @if(isset($Agent_Rate_Commi_list['procit']['cou']))
                                                @foreach($Agent_Rate_Commi_list['procit']['cou'] as $ak => $av)
                                                    <input type="text" name="Agent_Rate_Commi[procit][cou][]" value="{{$av}}" class="form_input" size="7" maxlength="10" required /><br>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div>@if(empty($hige_distribute_level['Level_Name'])) 总 @else {{$hige_distribute_level['Level_Name']}} @endif </div>
                                        <div>
                                            @if(isset($Agent_Rate_Commi_list['procit']['zong']))
                                                @foreach($Agent_Rate_Commi_list['procit']['zong'] as $ak => $av)
                                                    <input type="text" name="Agent_Rate_Commi[procit][zong][]" value="{{$av}}" class="form_input" size="7" maxlength="10" required /><br>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </span>
                                <div class="clear"></div>
                            </div>
                            <!-- 代理省会级设置end -->

                            <!-- 代理市级设置begin -->
                            <div class="rows" id="Agent_Rata_Row" @if($rsConfig["Dis_Agent_Type"]>0) style="display:block" @else style="display:none" @endif >
                                <label>市级设置</label>
                                <span class="input" id="Agent_Rata_Input">
                                    销售额%
                                    <input type="text" name="Agent_Rate[cit][Province]"
                                           @if(isset($Agent_Rate_list['cit']['Province']))
                                           value="{{isset($Agent_Rate_list['cit']['Province'])}}"
                                           @else
                                           value=""
                                           @endif class="form_input" size="3" maxlength="10" required />&nbsp;&nbsp;&nbsp;
				                    代理价格<strong class="red">（元）</strong>
                                    <input type="text" name="Agent_Rate[cit][Provincepro]"
                                           @if(isset($Agent_Rate_list['cit']['Provincepro']))
                                           value="{{isset($Agent_Rate_list['cit']['Provincepro'])}}"
                                           @else
                                           value=""
                                           @endif class="form_input" size="10" maxlength="10" required />
                                    认证条件：
                                    等级
                                    <select name="Agent_Rate[cit][Level]">
				                        <option value="0" @if(isset($Agent_Rate_list['cit']['Level']) && $Agent_Rate_list['cit']['Level'] == 0) selected @endif >---选择等级---</option>
                                        @if(!empty($distribute_level))
                                        @foreach($distribute_level as $key=>$level)
                                        <option value="{{$level['Level_ID']}}" @if(isset($Agent_Rate_list['cit']['Level']) && $level['Level_ID']==$Agent_Rate_list['cit']['Level']) selected @endif >{{$level['Level_Name']}}</option>
                                        @endforeach
                                        @endif
                                    </select>&nbsp;&nbsp;&nbsp;
                                    爵位
                                    <select name="Agent_Rate[cit][Protitle]">
			                            <option value="0" @if(isset($Agent_Rate_list['cit']['Protitle']) && $Agent_Rate_list['cit']['Protitle']== 0) selected @endif >---选择爵位---</option>
                                        @if(!empty($dis_title_level))
                                        @foreach($dis_title_level as $key=>$title)
                                        <option value="{{$key}}" @if(isset($Agent_Rate_list['cit']['Protitle']) && $key==$Agent_Rate_list['cit']['Protitle']) selected @endif >{{$title['Name']}}</option>
                                        @endforeach
                                        @endif
                                    </select>&nbsp;&nbsp;&nbsp;
                                    自费金额<strong class="red">（元）</strong>
                                    <input type="text" name="Agent_Rate[cit][Selfpro]"
                                           @if(isset($Agent_Rate_list['cit']['Selfpro']))
                                                   value="{{isset($Agent_Rate_list['cit']['Selfpro'])}}"
                                           @else
                                                   value=""
                                           @endif class="form_input" size="10" maxlength="10" required />&nbsp;&nbsp;&nbsp;
				                    团队销售额<strong class="red">（元）</strong>
                                    <input type="text" name="Agent_Rate[cit][Teampro]"
                                           @if(isset($Agent_Rate_list['cit']['Teampro']))
                                           value="{{isset($Agent_Rate_list['cit']['Teampro'])}}"
                                           @else
                                           value=""
                                           @endif class="form_input" size="10" maxlength="10" required />
                                    <br>
                                    <div class="level_for_level">
                                        <div>省级</div>
                                        <div>
                                            @if(isset($Agent_Rate_Commi_list['cit']['pro']))
                                                @foreach($Agent_Rate_Commi_list['cit']['pro'] as $ak => $av)
                                                    <input type="text" name="Agent_Rate_Commi[cit][pro][]" value="{{$av}}" class="form_input" size="7" maxlength="10" required /><br>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div>省会级</div>
                                        <div>
                                            @if(isset($Agent_Rate_Commi_list['cit']['procit']))
                                                @foreach($Agent_Rate_Commi_list['cit']['procit'] as $ak => $av)
                                                    <input type="text" name="Agent_Rate_Commi[cit][procit][]" value="{{$av}}" class="form_input" size="7" maxlength="10" required /><br>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div>市级</div>
                                        <div>
                                           @if(isset($Agent_Rate_Commi_list['cit']['cit']))
                                                @foreach($Agent_Rate_Commi_list['cit']['cit'] as $ak => $av)
                                                    <input type="text" name="Agent_Rate_Commi[cit][cit][]" value="{{$av}}" class="form_input" size="7" maxlength="10" required /><br>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div>县(区)级</div>
                                        <div>
                                            @if(isset($Agent_Rate_Commi_list['cit']['cou']))
                                                @foreach($Agent_Rate_Commi_list['cit']['cou'] as $ak => $av)
                                                    <input type="text" name="Agent_Rate_Commi[cit][cou][]" value="{{$av}}" class="form_input" size="7" maxlength="10" required /><br>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div>@if(empty($hige_distribute_level['Level_Name'])) 总 @else {{$hige_distribute_level['Level_Name']}} @endif </div>
                                        <div>
                                            @if(isset($Agent_Rate_Commi_list['cit']['zong']))
                                                @foreach($Agent_Rate_Commi_list['cit']['zong'] as $ak => $av)
                                                    <input type="text" name="Agent_Rate_Commi[cit][zong][]" value="{{$av}}" class="form_input" size="7" maxlength="10" required /><br>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </span>
                                <div class="clear"></div>
                            </div>
                            <!-- 代理市级设置end -->

                            <!-- 代理县级设置begin -->
                            <div class="rows" id="Agent_Ratc_Row" @if($rsConfig["Dis_Agent_Type"]>0) style="display:block" @else style="display:none" @endif >
                                <label>县（区）级设置</label>
                                <span class="input" id="Agent_Ratc_Input">
                                    销售额%
                                    <input type="text" name="Agent_Rate[cou][Province]"
                                           @if(isset($Agent_Rate_list['cou']['Province']))
                                                   value="{{isset($Agent_Rate_list['cou']['Province'])}}"
                                           @else
                                                   value=""
                                           @endif class="form_input" size="3" maxlength="10" required />&nbsp;&nbsp;&nbsp;
				                    代理价格<strong class="red">（元）</strong>
                                    <input type="text" name="Agent_Rate[cou][Provincepro]"
                                           @if(isset($Agent_Rate_list['cou']['Provincepro']))
                                           value="{{isset($Agent_Rate_list['cou']['Provincepro'])}}"
                                           @else
                                           value=""
                                           @endif class="form_input" size="10" maxlength="10" required />
                                    认证条件：
                                    @if(!empty($distribute_level))
                                    等级
                                    <select name="Agent_Rate[cou][Level]">
				                        <option value="0" @if(isset($Agent_Rate_list['cou']['Level']) && $Agent_Rate_list['cou']['Level']== 0) selected @endif >---选择等级---</option>
                                        @foreach($distribute_level as $key=>$level)
                                        <option value="{{$level['Level_ID']}}" @if(isset($Agent_Rate_list['cou']['Level']) && $level['Level_ID']==$Agent_Rate_list['cou']['Level']) selected @endif >{{$level['Level_Name']}}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                    &nbsp;&nbsp;&nbsp;爵位
                                    <select name="Agent_Rate[cou][Protitle]">
			                            <option value="0" @if(isset($Agent_Rate_list['cou']['Protitle']) && $Agent_Rate_list['cou']['Protitle']== 0) selected @endif >---选择爵位---</option>
                                        @if(!empty($dis_title_level))
                                        @foreach($dis_title_level as $key=>$title)
                                        <option value="{{$key}}" @if(isset($Agent_Rate_list['cou']['Protitle']) && $key==$Agent_Rate_list['cou']['Protitle']) selected @endif >{{$title['Name']}}</option>
                                        @endforeach
                                        @endif
                                    </select>
			                        &nbsp;&nbsp;&nbsp;自费金额<strong class="red">（元）</strong>
                                    <input type="text" name="Agent_Rate[cou][Selfpro]"
                                           @if(isset($Agent_Rate_list['cou']['Selfpro']))
                                                   value="{{isset($Agent_Rate_list['cou']['Selfpro'])}}"
                                           @else
                                                   value=""
                                           @endif class="form_input" size="10" maxlength="10" required />
				                    &nbsp;&nbsp;&nbsp;团队销售额<strong class="red">（元）</strong>
                                    <input type="text" name="Agent_Rate[cou][Teampro]"
                                           @if(isset($Agent_Rate_list['cou']['Teampro']))
                                           value="{{isset($Agent_Rate_list['cou']['Teampro'])}}"
                                           @else
                                           value=""
                                           @endif class="form_input" size="10" maxlength="10" required />
                                    <br>
                                    <div class="level_for_level">
                                        <div>省级</div>
                                        <div>
                                            @if(isset($Agent_Rate_Commi_list['cou']['pro']))
                                                @foreach($Agent_Rate_Commi_list['cou']['pro'] as $ak => $av)
                                                    <input type="text" name="Agent_Rate_Commi[cou][pro][]" value="{{$av}}" class="form_input" size="7" maxlength="10" required /><br>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div>省会级</div>
                                        <div>
                                            @if(isset($Agent_Rate_Commi_list['cou']['procit']))
                                                @foreach($Agent_Rate_Commi_list['cou']['procit'] as $ak => $av)
                                                    <input type="text" name="Agent_Rate_Commi[cou][procit][]" value="{{$av}}" class="form_input" size="7" maxlength="10" required /><br>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div>市级</div>
                                        <div>
                                            @if(isset($Agent_Rate_Commi_list['cou']['cit']))
                                                @foreach($Agent_Rate_Commi_list['cou']['cit'] as $ak => $av)
                                                    <input type="text" name="Agent_Rate_Commi[cou][cit][]" value="{{$av}}" class="form_input" size="7" maxlength="10" required /><br>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div>县(区)级</div>
                                        <div>
                                            @if(isset($Agent_Rate_Commi_list['cou']['cou']))
                                                @foreach($Agent_Rate_Commi_list['cou']['cou'] as $ak => $av)
                                                    <input type="text" name="Agent_Rate_Commi[cou][cou][]" value="{{$av}}" class="form_input" size="7" maxlength="10" required /><br>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div>@if(empty($hige_distribute_level['Level_Name'])) 总 @else {{$hige_distribute_level['Level_Name']}} @endif </div>
                                        <div>
                                            @if(isset($Agent_Rate_Commi_list['cou']['zong']))
                                                @foreach($Agent_Rate_Commi_list['cou']['zong'] as $ak => $av)
                                                    <input type="text" name="Agent_Rate_Commi[cou][zong][]" value="{{$av}}" class="form_input" size="7" maxlength="10" required /><br>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </span>
                                <div class="clear"></div>
                            </div>
                            <!-- 代理县级设置end -->

                            <!-- 代理申请是否显示begin -->
                            <div  class="rows" id="Agent_Ratb_Row" @if($rsConfig["Dis_Agent_Type"]>0) style="display:block" @else style="display:none" @endif >
                                <label>申请入口是否开启</label>
                                <span class="input" id="Agent_Ratb_Input">
			                        <input type="radio" id="s_0" name="Agent_Rate[Agentenable]"
                                        value="1" @if(isset($Agent_Rate_list['Agentenable']) && $Agent_Rate_list['Agentenable'] == 1) checked @endif />
                                    <label for="s_0">开启</label>&nbsp;&nbsp;
                                    <input type="radio" id="s_1" name="Agent_Rate[Agentenable]"
                                        value="0" @if(isset($Agent_Rate_list['Agentenable']) && $Agent_Rate_list['Agentenable'] == 0) checked @endif/>
                                    <label for="s_1">关闭</label>
        	                    </span>
                                <div class="clear"></div>
                            </div>
                            <!-- 代理申请是否显示end -->

                            <div class="rows">
                                <label></label>
                                <span class="input">
                                    <input type="submit" class="btn_green" name="submit_button" value="提交保存" />
                                </span>
                                <div class="clear"></div>
                            </div>

                        </form>
                    </div>

            </div>
        </div>
    </div>

@endsection