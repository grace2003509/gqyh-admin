<!DOCTYPE html>
<html lang="zh-CN">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge, Chrome=1" />
        <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>500 服务器错误</title>
        <style>

            html, body {
                width:100%;
                height: 100%;
                font-family: ff-tisa-web-pro-1,ff-tisa-web-pro-2,"Lucida Grande","Helvetica Neue",Helvetica,Arial,"Hiragino Sans GB","Hiragino Sans GB W3","WenQuanYi Micro Hei","microsoft yahei",sans-serif;
            }

            h4.split {
                width: 100%;
                margin: 10px auto;
                height: 24px;
                overflow: hidden;
                text-align: center;
                background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6ODkzODlCRDk1RkNEMTFFNEIzMzA5NzRCRUM3QjI5MDgiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6ODkzODlCREE1RkNEMTFFNEIzMzA5NzRCRUM3QjI5MDgiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo4OTM4OUJENzVGQ0QxMUU0QjMzMDk3NEJFQzdCMjkwOCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo4OTM4OUJEODVGQ0QxMUU0QjMzMDk3NEJFQzdCMjkwOCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PremU6kAAAAPSURBVHjaYrh79y5AgAEABTICmE6dxYwAAAAASUVORK5CYII=) repeat-x 0 center;
            }

            h4.split span {
                padding:0 15px;
                font-size: 1.2rem;
                color: #999;
                display: inline-block;
                height: 24px;
                line-height: 24px;
                background-color: #edeae7;
            }

            h1, .h1, h2, .h2, h3, .h3, h4, .h4, .lead, h5, .h5, h6, .h6 {
                font-family: ff-tisa-web-pro-1, ff-tisa-web-pro-2, "Lucida Grande", "Helvetica Neue", Helvetica, Arial, "Hiragino Sans GB", "Hiragino Sans GB W3", "Microsoft YaHei UI", "WenQuanYi Micro Hei", "microsoft yahei", sans-serif;
                margin: 0;
                padding: 0;
            }


            h4.split {
                width: 100%;
                margin: 10px auto;
                height: 24px;
                overflow: hidden;
                text-align: center;
                background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6ODkzODlCRDk1RkNEMTFFNEIzMzA5NzRCRUM3QjI5MDgiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6ODkzODlCREE1RkNEMTFFNEIzMzA5NzRCRUM3QjI5MDgiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo4OTM4OUJENzVGQ0QxMUU0QjMzMDk3NEJFQzdCMjkwOCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDo4OTM4OUJEODVGQ0QxMUU0QjMzMDk3NEJFQzdCMjkwOCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PremU6kAAAAPSURBVHjaYrh79y5AgAEABTICmE6dxYwAAAAASUVORK5CYII=) repeat-x 0 center;
            }

            h4.split span {
                padding:0 15px;
                font-size: .8rem;
                color: #999;
                display: inline-block;
                height: 24px;
                line-height: 24px;
                background-color: #eee;
            }

            ul, ol, dl, dt, dd{
                margin: 0;
                padding: 0;
                list-style-type: none;
            }

            p {text-indent: 2em;}

            hr {
                margin-top: 15px;
                margin-bottom: 15px;
                border: 0;
                clear: both;
                border-top: 1px solid #ebebeb;
            }
            img {
                vertical-align: middle;
            }
            a {
                color: #888;
                text-decoration: none;
            }
            a:hover, a:focus {
                color: #f7526a;
                text-decoration: none;
            }
            a:focus {
                outline: thin dotted;
                outline: 5px auto -webkit-focus-ring-color;
                outline-offset: -2px;
            }

            input[type="text"], input[type="search"] {
                text-indent: 5px;
            }
            .placeholder {
                color: #999!important;
            }

            html {
                background-color: #eee;
                background-image: url("/images/keyborad.png");
                background-position: 110% -10%;
                background-repeat: no-repeat;

            }
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                font-weight: 100;
                background-image: url("/images/paper.png");
                background-position: -10% -35%;
                background-repeat: no-repeat;
            }

            .container {
                width: 100%;
                height: 100%;
                text-align: center;
                vertical-align: middle;
                background-image: url("/images/coffice.png");
                background-position: 85% 140%;
                background-repeat: no-repeat;

            }


            .boxes {
                width: 100%;
                height: 100%;
                background-image: url("/images/pen.png");
                background-position: 10% bottom;
                background-repeat: no-repeat;

            }

            .content {
                position: relative;
                top:40%;
                width: 45%;
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 1.4em;
            }

            .blur {
                -webkit-filter: blur(3px);
                -moz-filter: blur(3px);
                -o-filter: blur(3px);
                -ms-filter: blur(3px);
                filter: blur(3px);
            }

            ::selection {
                background: #f7526a;
                text-shadow: none;
                color: #fff;
            }

            @media (max-width: 1000px){
                h4.split span { background-color: transparent; }
            }

            @media (max-width: 640px){
                .content {top:25%; width: 60%; }
                .title {color:#6E8693;}
                html { background-image: none; }
                body {background-position: 0 -75%;}
                .container {background-position: 85% 200%;}
            }
        </style>
    </head>
    <body>
        <div class="boxes">
            <div class="container">
                <div class="content">
                    <div>
                        <div class="title"> (눈_눈)  抱歉，您访问的页面不小心睡着了  (；′⌒`) </div>
                        <h4 class="split"><span>●</span></h4>
                        <div>
                            <a href="/">返回首页</a> / <a href="javascript:history.go(-1)">返回上页</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>
