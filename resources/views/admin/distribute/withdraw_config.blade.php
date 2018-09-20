@extends('admin.layouts.main')
@section('ancestors')
    <li>分销管理</li>
@endsection
@section('page', '提现设置')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script type='text/javascript' src='/admin/js/config.js'></script>

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
                    <form id="distribute_config_form" class="r_con_form" method="post" action="{{route('admin.distribute.withdraw_config_update')}}">
                        {{csrf_field()}}
                        <div class="rows">
                            <label>提现日期</label>
                            <span class="input">
                                <select name="Type_date">
                                    <option value="7" @if($rsConfig["Withdraw_Date"]==7) selected @endif >无限制</option>
                                    <option value="0" @if($rsConfig["Withdraw_Date"]==0) selected @endif >周日</option>
                                    <option value="1" @if($rsConfig["Withdraw_Date"]==1) selected @endif >周一</option>
                                    <option value="2" @if($rsConfig["Withdraw_Date"]==2) selected @endif >周二</option>
                                    <option value="3" @if($rsConfig["Withdraw_Date"]==3) selected @endif >周三</option>
                                    <option value="4" @if($rsConfig["Withdraw_Date"]==4) selected @endif >周四</option>
                                    <option value="5" @if($rsConfig["Withdraw_Date"]==5) selected @endif >周五</option>
                                    <option value="6" @if($rsConfig["Withdraw_Date"]==6) selected @endif >周六</option>
                                </select>
                              </span>
                            <div class="clear"></div>
                        </div>

                        <div class="rows">
                            <label>分销商提现门槛</label>
                            <span class="input">
                                <select name="Type">
                                    <option value="0" @if($rsConfig["Withdraw_Type"]==0 ) selected @endif >无限制</option>
                                    <option value="1" @if($rsConfig["Withdraw_Type"]==1 ) selected @endif >所得佣金限制</option>
                                    {{--<option value="2" @if($rsConfig["Withdraw_Type"]==2 ) selected @endif >购买商品</option>--}}
                                    <option value="3" @if($rsConfig["Withdraw_Type"]==3 ) selected @endif >等级限制</option>
                                </select>
                              </span>
                            <div class="clear"></div>
                        </div>

                        <div id="type_1" @if($rsConfig["Withdraw_Type"] != 1) style="display:none" @endif>
                            <div class="rows">
                                <label>最低佣金</label>
                                <span class="input">
                                  <input type="text" name="Limit[1]"
                                         @if($rsConfig["Withdraw_Type"]==1)
                                            value="{{$rsConfig["Withdraw_Limit"]}}"
                                         @else
                                            value=""
                                         @endif
                                         class="form_input" size="5" maxlength="10" /> <span class="tips">&nbsp;注:当分销商佣金达到此额度时才能有提现功能.</span>
                                </span>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div id="type_2" @if($rsConfig["Withdraw_Type"] != 2) style="display:none" @endif >
                            <div class="rows">
                                <label>连购开关</label>
                                <span class="input">
                                    <label><input type="radio" name="many_switch" id="many_switch_0" value="0"<?php echo empty($rsConfig["many_switch"]) ? ' checked' : ''?> />关闭</label>&nbsp;&nbsp;<label><input type="radio" name="many_switch" id="many_switch_1" value="1"<?php echo $rsConfig["many_switch"]==1 ? ' checked' : ''?> />开启</label>
                                   <span class="tips">&nbsp;注:开启的话，每次提现都要进行购买指定的商品.</span>
                                </span>
                                <div class="clear"></div>
                            </div>

                            <div class="rows">
                                <label>选择商品</label>
                                <span class="input">
                                    <label>
                                        <input type="radio" name="Fanwei" id="Fanwei_0" value="0"
                                               @if($rsConfig["Withdraw_Type"]<>2 || $withdraw_limit[0]==0) checked @endif />
                                        任意商品
                                    </label>&nbsp;&nbsp;
                                    <label>
                                        <input type="radio" name="Fanwei" id="Fanwei_1" value="1"
                                               @if($rsConfig["Withdraw_Type"]==2 && $withdraw_limit[0]==1) checked @endif />
                                        特定商品
                                    </label>
                                    <div class="products_option"
                                         @if($rsConfig["Withdraw_Type"]<>2 || $withdraw_limit[0]==0) style="display:none" @else style="display: block" @endif >
                                        <div class="search_div">
                                          <select>
                                          <option value=''>--请选择--</option>
                                              @foreach($category_list as $key=>$item)
                                                <option value="{{$key}}">{{$item['Category_Name']}}</option>
                                                @if(!empty($item['child']))
                                                  @foreach($item['child'] as $cate_id=>$child)
                                                    <option value="{{$child["Category_ID"]}}">&nbsp;&nbsp;&nbsp;&nbsp;{{$child["Category_Name"]}}</option>
                                                  @endforeach
                                                @endif
                                              @endforeach
                                         </select>
                                         <input type="text" placeholder="关键字" value="" class="form_input" size="35" maxlength="30" />
                                         <button type="button" class="button_search">搜索</button>
                                       </div>

                                       <div class="select_items">
                                             <select size='10' class="select_product0" style="width:300px; height:100px; display:block; float:left">
                                             </select>
                                             <button type="button" class="button_add">=></button>
                                             <select size='10' class="select_product1" multiple style="width:300px; height:100px; display:block; float:left">
                                                 @foreach($rsProduct as $key => $r)
                                                    <option value="{{$r["Products_ID"]}}">{{$r["Products_Name"]}}---{{$r['Products_PriceX']}}</option>
                                                 @endforeach
                                             </select>
                                             <input type="hidden" id="limit" name="Limit[2]"
                                                    @if($rsConfig["Withdraw_Type"]==2 && $withdraw_limit[0]==1 && !empty($withdraw_limit[1]))
                                                        value = "{{$withdraw_limit[1]}}"
                                                    @else
                                                        value = ''
                                                    @endif />
                                        </div>

                                       <div class="options_buttons">
                                            <button type="button" class="button_remove">移除</button>
                                            <button type="button" class="button_empty">清空</button>
                                       </div>
                                    </div>
                                </span>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div id="type_3" @if($rsConfig["Withdraw_Type"] != 3) style="display:none" @endif>
                            <div class="rows">
                                <label>最低等级</label>
                                <span class="input">
                                      <select name="Limit[3]">
                                         <option value="0">---选择等级---</option>
                                          @if(!empty($distribute_level))
                                              @foreach($distribute_level as $key=>$level)
                                              <option value="{{$level['Level_ID']}}" @if($rsConfig["Withdraw_Type"]==3 && $level['Level_ID']==$rsConfig["Withdraw_Limit"]) selected @endif>
                                                  {{$level['Level_Name']}}
                                              </option>
                                              @endforeach
                                          @else
                                          没有设置等级
                                          @endif
                                      </select>
                                </span>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="rows">
                            <label>每次提现最小金额</label>
                            <span class="input">
                              <input type="text" name="PerLimit" value="{{$rsConfig["Withdraw_PerLimit"]}}" class="form_input" size="5" maxlength="10" />
                                <span class="tips">&nbsp;注:分销商每次申请提现时，所填写金额不得小于该值</span>
                            </span>
                            <div class="clear"></div>
                        </div>

                        <div class="rows">
                            <label>提现余额分配比例</label>
                            <span class="input">
                              <input type="text" name="Balance_Ratio"
                                     @if(!empty($rsConfig["Balance_Ratio"]))
                                        value="{{$rsConfig["Balance_Ratio"]}}"
                                     @else
                                        value=""
                                     @endif class="form_input" size="5" maxlength="10" />%
                                <span class="tips">&nbsp;注:提现时，以此百分比计算的金额发放到余额，此金额无法提现</span>
                            </span>
                            <div class="clear"></div>
                        </div>

                        <div class="rows">
                            <label>提现手续费</label>
                            <span class="input">
                              <input type="text" name="Poundage_Ratio"
                                     @if(!empty($rsConfig["Poundage_Ratio"]))
                                        value="{{$rsConfig["Poundage_Ratio"]}}"
                                     @else
                                        value=""
                                     @endif
                                     class="form_input" size="5" maxlength="10" />%
                                <span class="tips">&nbsp;注:提现时，扣除用户以此百分比计算的手续费</span>
                            </span>
                            <div class="clear"></div>
                        </div>

                        <div class="rows">
                            <label>提现是否审核</label>
                            <span class="input">
                               <input type="radio" name="TxCustomize" id="c_0" value="0" @if($rsConfig["TxCustomize"]==0) checked @endif />
                                <label for="c_0"> 关闭</label>&nbsp;&nbsp;
                               <input type="radio" name="TxCustomize" id="c_1" value="1" @if($rsConfig["TxCustomize"]==1) checked @endif />
                                <label for="c_1"> 开启</label>
                                <span class="tips">&nbsp;&nbsp;注:仅对微信红包及转账有效</span>
                            </span>
                            <div class="clear"></div>
                        </div>

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

    <script type="text/javascript">
        $(document).ready(config_obj.withdraw_config);
    </script>

@endsection