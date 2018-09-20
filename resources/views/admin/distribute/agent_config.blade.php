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
                            @if($rsConfig['Agent_Level_Name'])
                                @foreach($Agent_Rate_list as $key => $Agent)
                                    <div  class="rows" id="Agent_Rate_Row" >
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
                                                    @for($i=0;$i<3;$i++)
                                                        <input type="text" name="Agent_Rate_Commi[pro][pro][]"
                                                               @if(isset($Agent_Rate_Commi_list['pro']['pro']))
                                                               value="{{$Agent_Rate_Commi_list['pro']['pro'][$i]}}"
                                                               @else
                                                               value="0"
                                                               @endif class="form_input" size="7" maxlength="10" required /><br>
                                                    @endfor
                                                </div>
                                                <div>省会级</div>
                                                <div>
                                                    @for($i=0;$i<3;$i++)
                                                        <input type="text" name="Agent_Rate_Commi[pro][procit][]"
                                                               @if(isset($Agent_Rate_Commi_list['pro']['procit']))
                                                               value="{{$Agent_Rate_Commi_list['pro']['procit'][$i]}}"
                                                               @else
                                                               value="0"
                                                               @endif class="form_input" size="7" maxlength="10" required /><br>
                                                    @endfor
                                                </div>
                                                <div>市级</div>
                                                <div>
                                                    @for($i=0;$i<3;$i++)
                                                        <input type="text" name="Agent_Rate_Commi[pro][cit][]"
                                                               @if(isset($Agent_Rate_Commi_list['pro']['cit']))
                                                               value="{{$Agent_Rate_Commi_list['pro']['cit'][$i]}}"
                                                               @else
                                                               value="0"
                                                               @endif class="form_input" size="7" maxlength="10" required /><br>
                                                    @endfor
                                                </div>
                                                <div>县(区)级</div>
                                                <div>
                                                    @for($i=0;$i<3;$i++)
                                                        <input type="text" name="Agent_Rate_Commi[pro][cou][]"
                                                               @if(isset($Agent_Rate_Commi_list['pro']['cou']))
                                                               value="{{$Agent_Rate_Commi_list['pro']['cou'][$i]}}"
                                                               @else
                                                               value="0"
                                                               @endif class="form_input" size="7" maxlength="10" required /><br>
                                                    @endfor
                                                </div>
                                                <div>@if(empty($hige_distribute_level['Level_Name'])) 总 @else {{$hige_distribute_level['Level_Name']}} @endif </div>
                                                <div>
                                                    @for($i=0;$i<3;$i++)
                                                        <input type="text" name="Agent_Rate_Commi[pro][zong][]"
                                                               @if(isset($Agent_Rate_Commi_list['pro']['zong']))
                                                               value="{{$Agent_Rate_Commi_list['pro']['zong'][$i]}}"
                                                               @else
                                                               value="0"
                                                               @endif class="form_input" size="7" maxlength="10" required /><br>
                                                    @endfor
                                                </div>
                                            </div>
                                        </span>
                                        <div class="clear"></div>
                                    </div>
                                @endforeach
                            @endif


                            <div  class="rows" id="Agent_Rate_Row" @if($rsConfig["Dis_Agent_Type"]>0) style="display:block" @else style="display:none" @endif >
                                <label>省级设置</label>
                                <span class="input" id="Agent_Rate_Input">
                                    销售额%<input type="text" name="Agent_Rate[pro][Province]"
                                               @if(isset($Agent_Rate_list['pro']['Province']))
                                                       value="{{$Agent_Rate_list['pro']['Province']}}"
                                               @else
                                                       value="0"
                                               @endif class="form_input" size="3" maxlength="10" required />&nbsp;&nbsp;&nbsp;
                                    代理价格<strong class="red">（元）</strong>
                                    <input type="text" name="Agent_Rate[pro][Provincepro]"
                                           @if(isset($Agent_Rate_list['pro']['Provincepro']))
                                                   value="{{$Agent_Rate_list['pro']['Provincepro']}}"
                                           @else
                                                   value="0"
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
                                                   value="0"
                                           @endif class="form_input" size="10" maxlength="10" required />&nbsp;&nbsp;&nbsp;
				                    团队销售额<strong class="red">（元）</strong>
                                    <input type="text" name="Agent_Rate[pro][Teampro]"
                                           @if(isset($Agent_Rate_list['pro']['Teampro']))
                                                   value="{{$Agent_Rate_list['pro']['Teampro']}}"
                                           @else
                                                   value="0"
                                           @endif class="form_input" size="10" maxlength="10" required />
                                    <br>
                                    <div class="level_for_level">
                                        <div>省级</div>
                                        <div>
                                            @for($i=0;$i<3;$i++)
                                                <input type="text" name="Agent_Rate_Commi[pro][pro][]"
                                                       @if(isset($Agent_Rate_Commi_list['pro']['pro']))
                                                               value="{{$Agent_Rate_Commi_list['pro']['pro'][$i]}}"
                                                       @else
                                                               value="0"
                                                       @endif class="form_input" size="7" maxlength="10" required /><br>
                                            @endfor
                                        </div>
                                        <div>省会级</div>
                                        <div>
                                            @for($i=0;$i<3;$i++)
                                                <input type="text" name="Agent_Rate_Commi[pro][procit][]"
                                                       @if(isset($Agent_Rate_Commi_list['pro']['procit']))
                                                       value="{{$Agent_Rate_Commi_list['pro']['procit'][$i]}}"
                                                       @else
                                                       value="0"
                                                       @endif class="form_input" size="7" maxlength="10" required /><br>
                                            @endfor
                                        </div>
                                        <div>市级</div>
                                        <div>
                                            @for($i=0;$i<3;$i++)
                                                <input type="text" name="Agent_Rate_Commi[pro][cit][]"
                                                       @if(isset($Agent_Rate_Commi_list['pro']['cit']))
                                                       value="{{$Agent_Rate_Commi_list['pro']['cit'][$i]}}"
                                                       @else
                                                       value="0"
                                                       @endif class="form_input" size="7" maxlength="10" required /><br>
                                            @endfor
                                        </div>
                                        <div>县(区)级</div>
                                        <div>
                                            @for($i=0;$i<3;$i++)
                                                <input type="text" name="Agent_Rate_Commi[pro][cou][]"
                                                       @if(isset($Agent_Rate_Commi_list['pro']['cou']))
                                                       value="{{$Agent_Rate_Commi_list['pro']['cou'][$i]}}"
                                                       @else
                                                       value="0"
                                                       @endif class="form_input" size="7" maxlength="10" required /><br>
                                            @endfor
                                        </div>
                                        <div>@if(empty($hige_distribute_level['Level_Name'])) 总 @else {{$hige_distribute_level['Level_Name']}} @endif </div>
                                        <div>
                                            @for($i=0;$i<3;$i++)
                                                <input type="text" name="Agent_Rate_Commi[pro][zong][]"
                                                       @if(isset($Agent_Rate_Commi_list['pro']['zong']))
                                                       value="{{$Agent_Rate_Commi_list['pro']['zong'][$i]}}"
                                                       @else
                                                       value="0"
                                                       @endif class="form_input" size="7" maxlength="10" required /><br>
                                            @endfor
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
                                           value="{{$Agent_Rate_list['procit']['Province']}}"
                                           @else
                                           value="0"
                                           @endif class="form_input" size="3" maxlength="10" required />&nbsp;&nbsp;&nbsp;
				                    代理价格<strong class="red">（元）</strong>
                                    <input type="text" name="Agent_Rate[procit][Provincepro]"
                                           @if(isset($Agent_Rate_list['procit']['Provincepro']))
                                           value="{{$Agent_Rate_list['procit']['Provincepro']}}"
                                           @else
                                           value="0"
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
                                                   value="{{$Agent_Rate_list['procit']['Selfpro']}}"
                                           @else
                                                   value="0"
                                           @endif class="form_input" size="10" maxlength="10" required />&nbsp;&nbsp;&nbsp;
				                    团队销售额<strong class="red">（元）</strong>
                                    <input type="text" name="Agent_Rate[procit][Teampro]"
                                           @if(isset($Agent_Rate_list['procit']['Teampro']))
                                           value="{{$Agent_Rate_list['procit']['Teampro']}}"
                                           @else
                                           value="0"
                                           @endif class="form_input" size="10" maxlength="10" required />
                                    <br>
                                    <div class="level_for_level">
                                        <div>省级</div>
                                        <div>
                                            @for($i=0;$i<3;$i++)
                                                <input type="text" name="Agent_Rate_Commi[procit][pro][]"
                                                       @if(isset($Agent_Rate_Commi_list['procit']['pro']))
                                                       value="{{$Agent_Rate_Commi_list['procit']['pro'][$i]}}"
                                                       @else
                                                       value="0"
                                                       @endif class="form_input" size="7" maxlength="10" required /><br>
                                            @endfor
                                        </div>
                                        <div>省会级</div>
                                        <div>
                                            @for($i=0;$i<3;$i++)
                                                <input type="text" name="Agent_Rate_Commi[procit][procit][]"
                                                       @if(isset($Agent_Rate_Commi_list['procit']['procit']))
                                                       value="{{$Agent_Rate_Commi_list['procit']['procit'][$i]}}"
                                                       @else
                                                       value="0"
                                                       @endif class="form_input" size="7" maxlength="10" required /><br>
                                            @endfor
                                        </div>
                                        <div>市级</div>
                                        <div>
                                            @for($i=0;$i<3;$i++)
                                                <input type="text" name="Agent_Rate_Commi[procit][cit][]"
                                                       @if(isset($Agent_Rate_Commi_list['procit']['cit']))
                                                       value="{{$Agent_Rate_Commi_list['procit']['cit'][$i]}}"
                                                       @else
                                                       value="0"
                                                       @endif class="form_input" size="7" maxlength="10" required /><br>
                                            @endfor
                                        </div>
                                        <div>县(区)级</div>
                                        <div>
                                            @for($i=0;$i<3;$i++)
                                                <input type="text" name="Agent_Rate_Commi[procit][cou][]"
                                                       @if(isset($Agent_Rate_Commi_list['procit']['cou']))
                                                       value="{{$Agent_Rate_Commi_list['procit']['cou'][$i]}}"
                                                       @else
                                                       value="0"
                                                       @endif class="form_input" size="7" maxlength="10" required /><br>
                                            @endfor
                                        </div>
                                        <div>@if(empty($hige_distribute_level['Level_Name'])) 总 @else {{$hige_distribute_level['Level_Name']}} @endif </div>
                                        <div>
                                            @for($i=0;$i<3;$i++)
                                                <input type="text" name="Agent_Rate_Commi[procit][zong][]"
                                                       @if(isset($Agent_Rate_Commi_list['procit']['zong']))
                                                       value="{{$Agent_Rate_Commi_list['procit']['zong'][$i]}}"
                                                       @else
                                                       value="0"
                                                       @endif class="form_input" size="7" maxlength="10" required /><br>
                                            @endfor
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
                                           value="{{$Agent_Rate_list['cit']['Province']}}"
                                           @else
                                           value="0"
                                           @endif class="form_input" size="3" maxlength="10" required />&nbsp;&nbsp;&nbsp;
				                    代理价格<strong class="red">（元）</strong>
                                    <input type="text" name="Agent_Rate[cit][Provincepro]"
                                           @if(isset($Agent_Rate_list['cit']['Provincepro']))
                                           value="{{$Agent_Rate_list['cit']['Provincepro']}}"
                                           @else
                                           value="0"
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
                                                   value="{{$Agent_Rate_list['cit']['Selfpro']}}"
                                           @else
                                                   value="0"
                                           @endif class="form_input" size="10" maxlength="10" required />&nbsp;&nbsp;&nbsp;
				                    团队销售额<strong class="red">（元）</strong>
                                    <input type="text" name="Agent_Rate[cit][Teampro]"
                                           @if(isset($Agent_Rate_list['cit']['Teampro']))
                                           value="{{$Agent_Rate_list['cit']['Teampro']}}"
                                           @else
                                           value="0"
                                           @endif class="form_input" size="10" maxlength="10" required />
                                    <br>
                                    <div class="level_for_level">
                                        <div>省级</div>
                                        <div>
                                            @for($i=0;$i<3;$i++)
                                                <input type="text" name="Agent_Rate_Commi[cit][pro][]"
                                                       @if(isset($Agent_Rate_Commi_list['cit']['pro']))
                                                       value="{{$Agent_Rate_Commi_list['cit']['pro'][$i]}}"
                                                       @else
                                                       value="0"
                                                       @endif class="form_input" size="7" maxlength="10" required /><br>
                                            @endfor
                                        </div>
                                        <div>省会级</div>
                                        <div>
                                            @for($i=0;$i<3;$i++)
                                                <input type="text" name="Agent_Rate_Commi[cit][procit][]"
                                                       @if(isset($Agent_Rate_Commi_list['cit']['procit']))
                                                       value="{{$Agent_Rate_Commi_list['cit']['procit'][$i]}}"
                                                       @else
                                                       value="0"
                                                       @endif class="form_input" size="7" maxlength="10" required /><br>
                                            @endfor
                                        </div>
                                        <div>市级</div>
                                        <div>
                                            @for($i=0;$i<3;$i++)
                                                <input type="text" name="Agent_Rate_Commi[cit][cit][]"
                                                       @if(isset($Agent_Rate_Commi_list['cit']['cit']))
                                                       value="{{$Agent_Rate_Commi_list['cit']['cit'][$i]}}"
                                                       @else
                                                       value="0"
                                                       @endif class="form_input" size="7" maxlength="10" required /><br>
                                            @endfor
                                        </div>
                                        <div>县(区)级</div>
                                        <div>
                                            @for($i=0;$i<3;$i++)
                                                <input type="text" name="Agent_Rate_Commi[cit][cou][]"
                                                       @if(isset($Agent_Rate_Commi_list['cit']['cou']))
                                                       value="{{$Agent_Rate_Commi_list['cit']['cou'][$i]}}"
                                                       @else
                                                       value="0"
                                                       @endif class="form_input" size="7" maxlength="10" required /><br>
                                            @endfor
                                        </div>
                                        <div>@if(empty($hige_distribute_level['Level_Name'])) 总 @else {{$hige_distribute_level['Level_Name']}} @endif </div>
                                        <div>
                                            @for($i=0;$i<3;$i++)
                                                <input type="text" name="Agent_Rate_Commi[cit][zong][]"
                                                       @if(isset($Agent_Rate_Commi_list['cit']['zong']))
                                                       value="{{$Agent_Rate_Commi_list['cit']['zong'][$i]}}"
                                                       @else
                                                       value="0"
                                                       @endif class="form_input" size="7" maxlength="10" required /><br>
                                            @endfor
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
                                                   value="{{$Agent_Rate_list['cou']['Province']}}"
                                           @else
                                                   value="0"
                                           @endif class="form_input" size="3" maxlength="10" required />&nbsp;&nbsp;&nbsp;
				                    代理价格<strong class="red">（元）</strong>
                                    <input type="text" name="Agent_Rate[cou][Provincepro]"
                                           @if(isset($Agent_Rate_list['cou']['Provincepro']))
                                           value="{{$Agent_Rate_list['cou']['Provincepro']}}"
                                           @else
                                           value="0"
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
                                                   value="{{$Agent_Rate_list['cou']['Selfpro']}}"
                                           @else
                                                   value="0"
                                           @endif class="form_input" size="10" maxlength="10" required />
				                    &nbsp;&nbsp;&nbsp;团队销售额<strong class="red">（元）</strong>
                                    <input type="text" name="Agent_Rate[cou][Teampro]"
                                           @if(isset($Agent_Rate_list['cou']['Teampro']))
                                           value="{{$Agent_Rate_list['cou']['Teampro']}}"
                                           @else
                                           value="0"
                                           @endif class="form_input" size="10" maxlength="10" required />
                                    <br>
                                    <div class="level_for_level">
                                        <div>省级</div>
                                        <div>
                                            @for($i=0;$i<3;$i++)
                                                <input type="text" name="Agent_Rate_Commi[cou][pro][]"
                                                       @if(isset($Agent_Rate_Commi_list['cou']['pro']))
                                                       value="{{$Agent_Rate_Commi_list['cou']['pro'][$i]}}"
                                                       @else
                                                       value="0"
                                                       @endif class="form_input" size="7" maxlength="10" required /><br>
                                            @endfor
                                        </div>
                                        <div>省会级</div>
                                        <div>
                                            @for($i=0;$i<3;$i++)
                                                <input type="text" name="Agent_Rate_Commi[cou][procit][]"
                                                       @if(isset($Agent_Rate_Commi_list['cou']['procit']))
                                                       value="{{$Agent_Rate_Commi_list['cou']['procit'][$i]}}"
                                                       @else
                                                       value="0"
                                                       @endif class="form_input" size="7" maxlength="10" required /><br>
                                            @endfor
                                        </div>
                                        <div>市级</div>
                                        <div>
                                            @for($i=0;$i<3;$i++)
                                                <input type="text" name="Agent_Rate_Commi[cou][cit][]"
                                                       @if(isset($Agent_Rate_Commi_list['cou']['cit']))
                                                       value="{{$Agent_Rate_Commi_list['cou']['cit'][$i]}}"
                                                       @else
                                                       value="0"
                                                       @endif class="form_input" size="7" maxlength="10" required /><br>
                                            @endfor
                                        </div>
                                        <div>县(区)级</div>
                                        <div>
                                            @for($i=0;$i<3;$i++)
                                                <input type="text" name="Agent_Rate_Commi[cou][cou][]"
                                                       @if(isset($Agent_Rate_Commi_list['cou']['cou']))
                                                       value="{{$Agent_Rate_Commi_list['cou']['cou'][$i]}}"
                                                       @else
                                                       value="0"
                                                       @endif class="form_input" size="7" maxlength="10" required /><br>
                                            @endfor
                                        </div>
                                        <div>@if(empty($hige_distribute_level['Level_Name'])) 总 @else {{$hige_distribute_level['Level_Name']}} @endif </div>
                                        <div>
                                            @for($i=0;$i<3;$i++)
                                                <input type="text" name="Agent_Rate_Commi[cou][zong][]"
                                                       @if(isset($Agent_Rate_Commi_list['cou']['zong']))
                                                       value="{{$Agent_Rate_Commi_list['cou']['zong'][$i]}}"
                                                       @else
                                                       value="0"
                                                       @endif class="form_input" size="7" maxlength="10" required /><br>
                                            @endfor
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

    <script>
        @if($rsConfig["Dis_Agent_Type"] <= 0)
            $("input[type='text']").attr('disabled', true);
        @endif
    </script>

@endsection