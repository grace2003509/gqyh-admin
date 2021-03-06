var kf_obj={
    kf_init:function(){
        $('#kf_form').submit(function(){return false;});
        $('#kf_form input:submit').click(function(){

            $(this).attr('disabled', true);
            $.post('?', $('#kf_form').serialize(), function(data){
                $('#kf_form input:submit').attr('disabled', false);
                if(data.status==4){
                    alert('客服坐席已满，无法添加！');
                }else if(data.status==3){
                    alert('对不起，用户名和密码的长度都必须为6位以上！');
                }else if(data.status==2){
                    alert('对不起，此用户名已经被占用，请换一个用户名！');
                }else if(data.status==1){
                    window.location='account.php';
                }else{
                    alert('设置失败！');
                }
            }, 'json');
        });
    },

    web_init:function(){
        $('#kf_web .table img[field]').addClass('pointer').click(function(){
            var img_obj=$(this);
            $.get('?', 'action=item&field='+img_obj.attr('field')+'&Status='+img_obj.attr('Status'), function(data){
                if(data.status==1){
                    var img=img_obj.attr('Status')==0?'on':'off';
                    img_obj.attr('src', '/static/member/images/ico/'+img+'.gif');
                    img_obj.attr('Status', img_obj.attr('Status')==0?1:0);
                }else{
                    alert('设置失败，出现未知错误！');
                }
            }, 'json');
        });

        $('#kf_web .ico_list table img').click(function(){
            if(!confirm('您确定要选择此图标吗？')){return false};
            var img_obj=$(this);
            $.get('?', 'action=icon&ico='+img_obj.attr('ico'), function(data){
                if(data.status==1){
                    $('#kf_web .ico_list table img').removeClass('cur');
                    img_obj.addClass('cur');
                }else{
                    alert('设置失败，出现未知错误！');
                }
            }, 'json');
        });

        $('#kfconfig_form').submit(function(){
            $('#kfconfig_form input:submit').attr('disabled', true);
            return true;
        });
    }
}