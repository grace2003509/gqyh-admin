define(['common','crel'], function(common,crel){

    $('document').ready(function(){

        //选择权限的模式
        var currentMode = 'current';

        //渲染权限列表
        var tree = $('<ul class="list-group"></ul>')
        $.each(menus, function(index, item){
            var isDisabled = item.role == 1 ? ' disabled' : '' ;
            var node = crel('li',{class:'list-group-item node-tree' + isDisabled},
                crel('span', {class:item.icon}),
                crel('span', item.text)
            )

            $(tree).append(node);
            if(undefined != item.nodes){
                $(node).append("<span class='badge'><label><input type='checkbox' value='"+ item.id +"' class='slt-all' "+ isDisabled +"> 全选</label></span>")
                $.each(item.nodes, function(i,n){
                    var attr = {type:'checkbox', class:'slt-current', value: n.id, disabled:'disabled', 'data-pid' : n.pid};
                    if(isDisabled == '') delete  attr.disabled;
                    var subMenu = crel('li',{class:'list-group-item sub-tree' + isDisabled},
                        crel('label', crel('input', attr), n.text)
                    )
                    $.each(n.tags, function(i, tags){
                        $(subMenu).append($('<span class="badge">'+ tags +'</span>'))
                    })
                    $(tree).append(subMenu);
                })
            }else{
                $.each(item.tags, function(i, tags){
                    $(node).append($('<span class="badge">'+ tags +'</span>'))
                })
            }

        })
        $('#tree').html(tree)

       //选择当前模块下面所有类别的所有权限
       $('.slt-all').change(function(){
           var hasCheck = $(this).prop('checked');
           $('input[data-pid='+ $(this).val() +']').prop('checked',hasCheck)
       })

       //选择当前类别下面的所有权限
       $('.slt-current').change(function(){
           var hasCheck = $(this).prop('checked');
           $('input[data-id='+ $(this).val() +']').prop('checked',hasCheck)
       })


       //模式选择
       $('input[name=slt]').change(function(){
            var action  = $(this).val();
            var role    = $(this).prop('data-role');
            currentMode = action;
            switch (action){
                case 'all' :
                    $('.list-group-item input').prop('checked',true)
                    break;
                case 'none' :
                    $('.list-group-item input').prop('checked',false).removeAttr('checked')
                    break;
            }
       })

        //自动切换模式
        $('.list-group-item input').change(function(){
            var hasCheck  = $(this).prop('checked');
            var className = $(this).attr('class');
            var parent    = $(this).closest('li');

            switch(currentMode){
                case 'all' :
                    if(hasCheck == false){
                        $('input[value=current]').prop('checked',true);
                    }
                    break;
                case 'none' :
                    if(hasCheck == true){
                        $('input[value=current]').prop('checked',true);
                    }
                    break;
            }

            if(undefined == className){
                checkCurrentLine($(parent).find('.per-checkbox>input'))
            }
        })


        //update ui
        function checkCurrentLine(data){
            var allCheck = true;
            var parent   = null;
            $.each(data, function(index, item){
                parent   = $(this).closest('li');
                if($(item).prop('checked') == false){
                    allCheck = false;
                }
                //console.log($(item).prop('checked'))
            })
            $(parent).find('.slt-current').prop('checked', allCheck)
        }


        $('.list-group-item').each(function(index,item){
            checkCurrentLine($(this).find('.per-checkbox>input'))
        })


        //获取权限数据
        function getData(role){
            var data = {};
            $('.per-checkbox input').each(function(i, node){
                var alias     = $(node).attr('data-alias');
                var value     = $(node).val();
                var menuPid   = $(node).attr('data-pid');
                var menuId    = $(node).attr('data-id');
                var hasCheck  = $(node).prop('checked');

                if(hasCheck == true){
                    var key       = "menu" + menuPid;

                    if(data[key] == undefined && menuPid > 0){
                        data[key] = {role_id:role, menu_id:menuPid,value:['view']};
                    }

                    if(data[alias] == undefined){
                        data[alias] = {role_id:role, menu_id:menuId,value:[value]};
                    }else{
                        data[alias].value.push(value);
                    }
                }
            })
            var rs = Object.values(data);
            return rs;
        }


        //提交
        $('#save').click(function(){
            var roleId  = $(this).attr('data-role');
            var data    = {role:parseInt(roleId), type : currentMode, data:getData(roleId), _method:'put'};
            var url     = $(this).attr('data-action');
            console.log(data)
            common.http.post(url, data).then(function(data){
                alert(data.errorMsg);
            })

        })








    })

})