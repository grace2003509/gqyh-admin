define(['common'], function(common){

    $('document').ready(function(){

        $('.del').click(function(){
            var url = $(this).attr('href');
            var dom = $(this);
            if(confirm('你确定删除此条数据?')){
                console.log('del')
                common.http.post(url,{_method:'delete'}).then(function(data){
                    alert(data.errorMsg);
                    if(data.errorCode == 1){
                        $(dom).closest('tr').remove();
                    }
                })
            }
            return false;
        })

    })

})