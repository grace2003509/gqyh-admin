define(['common','datepicker','daterangepicker'], function(){

    $(document).ready(function() {

        $("#callback_info").fadeOut(3000);

        $(".btn-delete").click(function () {
            if (!confirm('确认删除吗?')) {
                return false;
            }
            var url = $(this).attr('data-url');
            var trObj = $(this);
            $.ajax({
                url: url,
                data: '_token=' + common.token,
                type: 'DELETE',
                dataType: 'json',
                success: function (data) {
                    $(".alert").remove();
                    if (data.result) {
                        trObj.parent().parent().remove();
                    }
                    alert(data.message);
                },
                error: function () {

                }
            });
        });

        //时间范围选择
        $('input[name="daterange"]').focus(function() {
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