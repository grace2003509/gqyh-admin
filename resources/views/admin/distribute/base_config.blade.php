@extends('admin.layouts.main')
@section('ancestors')
    <li>分销管理</li>
@endsection
@section('page', '基础设置')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/shop.css' rel='stylesheet' type='text/css' />

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script type='text/javascript' src='/static/js/plugins/layer/layer.js'></script>
    <script type='text/javascript' src='/admin/js/config.js'></script>
    <link rel="stylesheet" href="/admin/js/kindeditor/themes/default/default.css" />
    <script charset="utf-8" src="/admin/js/kindeditor/kindeditor-min.js"></script>
    <script charset="utf-8" src="/admin/js/kindeditor/lang/zh_CN.js"></script>

    <style type="text/css">
        #level_intro table{margin:8px 0px; border:1px #dfdfdf solid}
        #level_intro table th{height:30px; line-height:30px; background:#f5f5f5; border-right:1px #dfdfdf solid}
        #level_intro table td{padding:8px 0px; line-height:20px; border-right:1px #dfdfdf solid; text-align:center; border-top:1px #dfdfdf solid; background:#FFF}
        #level_intro .last{border-right:none}
    </style>

    <div class="box">
        <div id="iframe_page">
            <div class="iframe_content">

                <div class="r_con_wrap">
                    <form id="distribute_config_form" class="r_con_form" method="post" action="{{route('admin.distribute.base_config_update')}}">
                        {{csrf_field()}}
                        <input type="hidden" id="level_has" value="{{count($list_level)}}">
                        <input type="hidden" id="level" value="{{$rsConfig["Dis_Level"]}}">
                        <div class="rows">
                            <label>分销级别</label>
                            <span class="input">
                                <select name="Dis_Level">
                                    @for($i=1;$i<=$max_level;$i++)
                                        <option value="{{$i}}" @if($rsConfig["Dis_Level"]==$i) selected @endif >{{$i}}级</option>
                                    @endfor
                                </select>
                            </span>
                            <div class="clear"></div>
                        </div>

                        <div class="rows">
                            <label>分销商自买得佣金</label>
                            <span class="input">
           		                <input type="checkbox" name="Dis_Self_Bonus"  id="Dis_Self_Bonus" value="1" @if($rsConfig["Dis_Self_Bonus"] == 1) checked @endif />
           	                    <label>开启后分销商自己购买也可得到佣金</label>
                            </span>
                            <div class="clear"></div>
                        </div>

                        <div class="rows">
                            <label>手机分销中心显示级别</label>
                            <span class="input">
                              <select name="Dis_Mobile_Level">
                                @for($i=1;$i<=$rsConfig['Dis_Level'];$i++)
                                  <option value="{{$i}}" @if($rsConfig['Dis_Mobile_Level'] == $i) selected @endif >{{$i}}级</option>
                                @endfor
                              </select>
                            </span>
                            <div class="clear"></div>
                        </div>

                        <div class="rows">
                            <label>分销商升级方式</label>
                            <span class="input">
                                <input type="radio" id="zhuji" name="Distribute_UpgradeWay" @if($rsConfig['Distribute_UpgradeWay']==0) checked @endif value="0">
                                <label for="zhuji">逐级升级</label>
                                <input type="radio" id="tiaoji" name="Distribute_UpgradeWay" @if($rsConfig['Distribute_UpgradeWay']==1) checked @endif value="1">
                                <label for="tiaoji">跳级升级</label>
                            </span>
                            <div class="clear"></div>
                        </div>

                        <div class="rows">
                            <label>成为分销商门槛</label>
                            <span class="input">
                              <select name="Distribute_Type">
                                   {{--<option value="0" @if($rsConfig['Distribute_Type']==0) selected @endif >直接购买</option>
                                   <option value="1" @if($rsConfig['Distribute_Type']==1) selected @endif >消费额</option>--}}
                                   <option value="2" @if($rsConfig['Distribute_Type']==2) selected @endif >购买商品</option>
                              </select>
                            </span>
                            <div class="clear"></div>
                        </div>
                        <div class="rows">
                            <label>分销商级别</label>
                            <span class="input">
                              <a href="javascript:void(0);" class="setting_level_btn">[设置级别]</a>
                              <div id="level_intro"></div>
                            </span>
                            <div class="clear"></div>
                        </div>

                        <div class="rows">
                            <label>购买协议</label>
                            <span class="input">
                              <input name="AgreementOpen" value="0" type="radio" id="agree_0" @if($rsConfig['Distribute_AgreementOpen']==0) checked @endif />
                                <label for="agree_0">关闭</label>&nbsp;&nbsp;
                              <input name="AgreementOpen" value="1" type="radio" id="agree_1" @if($rsConfig['Distribute_AgreementOpen']==1) checked @endif />
                                <label for="agree_1">开启</label>
                            </span>
                            <div class="clear"></div>
                        </div>

                        <div class="rows">
                            <label>购买协议标题</label>
                            <span class="input">
                              <input name="AgreementTitle" value="{{$rsConfig["Distribute_AgreementTitle"]}}" type="text" class="form_input" size="30" />
                            </span>
                            <div class="clear"></div>
                        </div>

                        <div class="rows">
                            <label>购买协议内容</label>
                            <span class="input">
                              <textarea name="Agreement" style="width:100%;height:400px;visibility:hidden;">{{$rsConfig["Distribute_Agreement"]}}</textarea>
                              <div class="tips">此协议仅在购买成为分销商页面显示</div>
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
    <script>
        // $(document).ready(config_obj.base_config);
        KindEditor.ready(function(K) {
            K.create('textarea[name="Agreement"]', {
                themeType : 'simple',
                filterMode : false,
                uploadJson : '{{route('admin.upload_json')}}',
                fileManagerJson : '{{route('admin.file_manager_json')}}',
                allowFileManager : true
            });
        });

        var type = $("select[name='Distribute_Type']").find('option:selected').attr('value');
        $.get('/admin/distribute/dis_level','action=get_dis_level&type='+type,function(data){
            if (data.type === 1) {
                $('#uplevel').hide();
            } else {
                $('#uplevel').show();
            }
            $('#level_intro').html(data.html);
        },'json');


        $("a.setting_level_btn").click(function(){
            //分销商级别设置弹框
            var level = $("select[name='Dis_Level']").find('option:selected').attr('value');
            var type = $("select[name='Distribute_Type']").find('option:selected').attr('value');
            create_layer('分销商级别设置', '/admin/distribute/level?level='+level+'&type='+type,1000,500,1,1);
        });

        function create_layer(title, url, width, height){
            var callback = arguments[6] ? arguments[6] : function(){};
            layer.open({
                type: 2,
                title: title,
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: [width+'px', height+'px'],
                content: url,
                end:function(){
                    if(callback != undefined){
                        callback();
                    }
                }
            });
        }
    </script>
@endsection