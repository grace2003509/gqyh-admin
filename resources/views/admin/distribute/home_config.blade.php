@extends('admin.layouts.main')
@section('ancestors')
    <li>分销管理</li>
@endsection
@section('page', '分销首页设置')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">

                <div class="r_con_wrap">
                    <div class="control_btn">
                        <a href="{{route('admin.distribute.base_config_index')}}" class="btn_green btn_w_120">基础设置</a>
                        <a href="{{route('admin.distribute.home_config_index')}}" class="btn_green btn_w_120">分销首页设置</a>
                        <a href="" class="btn_green btn_w_120">提现设置</a>
                        <a href="" class="btn_green btn_w_120">爵位设置</a>
                        <a href="" class="btn_green btn_w_120">其他设置</a>
                    </div>
                    <form id="distribute_config_form" class="r_con_form" method="post" action="{{route('admin.distribute.home_config_update')}}">
                        {{csrf_field()}}
                        <input type="hidden" id="level_has" value="">
                        <input type="hidden" id="level" value="">

                        <div class="rows">
                            <label>管理称呼</label>
                            <span class="input">
                                 <input type="text" name="my_term" class="form_input" value="{{$Index_Professional_Json['myterm']}}">
                            </span>
                            <div class="clear"></div>
                        </div>

                        <div class="rows">
                            <label>分销商等级称呼</label>
                            <span class="input">
                                @if (!empty($rsAccount['Dis_Mobile_Level']) && $rsAccount['Dis_Mobile_Level'] > 0)
                                @for ($i = 1; $i <= $rsAccount['Dis_Mobile_Level']; $i++)
                                <input type="text" name="child_level_term[{{$i}}]" class="form_input"
                                       @if(empty($Index_Professional_Json['childlevelterm'][$i]))
                                            value="{{$level_name_list[$i]}}"
                                       @else
                                            value="{{$Index_Professional_Json['childlevelterm'][$i]}}"
                                       @endif >
                                @endfor
                                @endif
                            </span>
                            <div class="clear"></div>
                        </div>

                        <div class="rows">
                            <label>佣金称呼</label>
                            <span class="input">
                               <input type="text" name="catcommission" class="form_input" value="{{$Index_Professional_Json['catcommission']}}">
                            </span>
                            <div class="clear"></div>
                        </div>

                        <div class="rows">
                            <label>推荐人大类名称</label>
                            <span class="input">
                               <input type="text" name="cattuijian" class="form_input" value="{{$Index_Professional_Json['cattuijian']}}">
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

@endsection