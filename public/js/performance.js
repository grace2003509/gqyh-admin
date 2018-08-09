define(['common','datepicker','daterangepicker'], function(){

    $(document).ready(function() {
        alert('ddd');
        $("#callback_info").fadeOut(3000);

        //时间范围选择
        $('input[name="date_start"]').focus(function() {
            $(this).daterangepicker({
                locale: {
                    format: 'YYYY/MM/DD'
                }
            }).show();
        });

        //日期选择
        $(".form_datetime").datepicker({
            language: "cn",
            autoclose: true,//选中之后自动隐藏日期选择框
            clearBtn: true,//清除按钮
            format: "yyyy-mm-dd"//日期格式
        });


    })//end dom ready


})