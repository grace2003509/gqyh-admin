var payment={
    orders_init:function() {

        //初始化时间间隔插件
        $("#reportrange").daterangepicker({
            ranges: ranges,
            startDate: moment(),
            endDate: moment()
        }, function (startDate, endDate) {
            var range = startDate.format('YYYY/MM/DD') + "-" + endDate.format('YYYY/MM/DD');
            $("#reportrange #reportrange-inner").html(range);
            $("#reportrange #reportrange-input").attr('value', range);
        });


        /*var logic = function( currentDateTime ){
            if( currentDateTime.getDay()==6 ){
                this.setOptions({
                    minTime:'11:00'
                });
            }else
                this.setOptions({
                    minTime:'8:00'
                });
        };
        $('#search_form input[name=AccTime_S], #search_form input[name=AccTime_E]').datetimepicker({
            lang:'ch',
            onChangeDateTime:logic,
            onShow:logic
        });

        $("#search_form .output_btn").click(function(){
            window.location='./outputs.php?'+$('#search_form').serialize()+'&type=sales_record_list';
        });
    },
        payment_edit_init:function(){
        var date_str=new Date();
        $('#payment_form input[name=Time]').daterangepicker({
            timePicker:true,
            format:'YYYY/MM/DD HH:mm:00'}
        )
        $('#payment_form').submit(function(){
            if(global_obj.check_form($('*[notnull]'))){return false};
            $('#payment_form input:submit').attr('disabled', true);
            return true;
        });*/

    }
}