@if (isset($errors) && count($errors) > 0)
        <!-- Form Error List -->
<div class="alert alert-danger" id="callback_info">
    {{--<button type="button" class="close" data-dismiss="alert">×</button>--}}
    <strong>错误消息:</strong>

    <br><br>
    <ul>
        @if(is_array(json_decode($errors, true)))
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        @else
            <li>{{ $errors }}</li>
        @endif
    </ul>
</div>
@endif
