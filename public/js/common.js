define(['app','exports','ZeroClipboard'], function(app,exports, ZeroClipboard){

    //init ZeroClipboard
    window.ZeroClipboard = ZeroClipboard;

    //exports xsrf token
    exports.token = $('meta[name=X-XSRF-TOKEN]').attr('content');

    $("#callback_info").fadeOut(3000);

    //ajax settings
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': exports.token
        }
    });

    var http = {
        /**
         * 封装ajax异步请求, 返回 Deferred promise 对象
         * @param url
         * @param args
         * @returns {*}
         */
        post : function(url, args){
            var defer = $.Deferred();
            $.ajax({
                type: 'post',
                url: url,
                cache:false,
                data: JSON.stringify(args),
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                timeout: 10000,
                success: function(data, status, xhr){
                    defer.resolve(data, status, xhr);
                },
                error: function(xhr, errorType, error){
                    defer.reject(xhr, errorType, error);
                }

            });
            return defer.promise();
        },


        /**
         * 封装getJSON请求, 返回 Deferred promise 对象
         * @param url
         * @returns {*}
         */
        get  : function(url){
            var defer = $.Deferred();
            $.getJSON(url,function(data, status, xhr){
                defer.resolve(data, status, xhr);
            });
            return defer.promise();
        }
    }

    exports.http = http;



})