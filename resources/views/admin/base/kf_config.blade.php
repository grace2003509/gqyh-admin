@extends('admin.layouts.main')
@section('ancestors')
    <li>基础设置</li>
@endsection
@section('page', '在线客服设置')
@section('subcontent')

    <link href='/admin/css/global.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/main.css' rel='stylesheet' type='text/css' />
    <link href='/admin/css/kf.css' rel='stylesheet' type='text/css'/>

    <script src="/static/js/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script type='text/javascript' src='/admin/js/kf.js'></script>

    <div class="box">
        <div id="kf_web">
            <form id="kfconfig_form" method="post" action="{{route('admin.base.kf_edit')}}">
                {{csrf_field()}}
                <div>
                    <table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" class="kftable_first">
                        <tr>
                            <td class="lefttd">客服类型</td>
                            <td class="righttd" style="text-indent: 15px">
                                <input type="radio" name="kftype" value="2" @if($rsConfig['kftype'] == 2) checked
                                       @endif class="kftype2" onclick="aftershow(this)">
                                <label>第三方客服</label>
                            </td>
                        </tr>
                    </table>
                </div>

                <div>
                    <table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" class="kftable_first"
                           id="kftype1" style="display: @if($rsConfig['kftype']!=1) none @endif">
                        <tr>
                            <td class="lefttd">QQ客服设置</td>
                            <td class="righttd">
                                <table class="kftable_first">

                                    <tr>
                                        <td class="sonlefttd">位置</td>
                                        <td class="sonrighttd">
                                            <input type="radio" name="qq_postion" value="left"
                                                   @if($rsConfig['qq_postion']=='left') checked @endif ><label>左边</label>&nbsp;
                                            <input type="radio" name="qq_postion" value="right"
                                                   @if($rsConfig['qq_postion']=='right') checked @endif><label>右边</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="sonlefttd">qq号</td>
                                        <td class="sonrighttd">
                                            <input type="text" name="qq"
                                                   value="@if(!empty($rsConfig['qq'])) {{$rsConfig['qq']}} @endif">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="sonlefttd">qq客服图标</td>
                                        <td class="sonrighttd">
                                            <input type="radio" name="qq_icon" value="1"
                                                   @if($rsConfig['qq_icon']=='1') checked @endif ><label><img
                                                        src="/admin/images/kf/1.gif"></label>&nbsp;
                                            <input type="radio" name="qq_icon" value="2"
                                                   @if($rsConfig['qq_icon']=='2') checked @endif ><label><img
                                                        src="/admin/images/kf/2.gif"></label>&nbsp;
                                            <input type="radio" name="qq_icon" value="3"
                                                   @if($rsConfig['qq_icon']=='3') checked @endif ><label><img
                                                        src="/admin/images/kf/3.gif"></label>&nbsp;
                                            <input type="radio" name="qq_icon" value="4"
                                                   @if($rsConfig['qq_icon']=='4') checked @endif ><label><img
                                                        src="/admin/images/kf/4.gif"></label>&nbsp;
                                            <input type="radio" name="qq_icon" value="5"
                                                   @if($rsConfig['qq_icon']=='5') checked @endif ><label><img
                                                        src="/admin/images/kf/5.gif"></label>&nbsp;
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="lefttd"></td>
                            <td class="righttd">
                                <input type="submit" value="提交保存" class="submit_btn">
                            </td>
                        </tr>
                    </table>
                </div>
                <div>
                    <table width="100%" align="center" border="0" cellpadding="5" cellspacing="0" class="kftable_first"
                           id="kftype2" style="display: @if($rsConfig['kftype'] != 2) none @endif">
                        <tr>
                            <td class="lefttd">第三方客服链接</td>
                            <td class="righttd">
                                <input type="text" name="CodeLink" value="{{$rsConfig['KF_Link']}}" >
                            </td>
                        </tr>
                        <tr>
                            <td class="lefttd">第三方客服代码</td>
                            <td class="righttd">
                                <textarea name="Code" >{{$rsConfig['KF_Code']}}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="lefttd"></td>
                            <td class="righttd">
                                <input type="submit" value="提交保存" name="submit_btn" class="submit_btn">
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
        </div>
    </div>
    <script>

        $(document).ready(kf_obj.web_init);

        function aftershow(the) {
            if (the.checked) {
                var type_val = $(the).val();
                if (type_val === 1) {
                    $("#kftype1").css('display', '');
                    $("#kftype2").css('display', 'none');
                } else {
                    $("#kftype2").css('display', '');
                    $("#kftype1").css('display', 'none');
                }
            } else {
                alert('请选择客服类型');
            }
        }
    </script>
@endsection