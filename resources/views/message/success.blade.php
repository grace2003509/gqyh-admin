@if (Session::has('success'))
    <div class="alert alert-success" id="callback_info">
        {{--<button type="button" class="close" data-dismiss="alert">×</button>--}}
        <strong>
            <i class="fa fa-check-circle fa-lg fa-fw"></i> 消息提示:
        </strong>
        <br><br>
        {{ Session::get('success') }}
    </div>
@endif

