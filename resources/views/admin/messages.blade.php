@extends('admin.layouts.main')

@section('subcontent')
    <style type="text/css">
        h3,h4,p { font-family: "Microsoft Yahei"}
        .small-box .inner a, .small-box .inner a:hover, .small-box .inner a:visited {
            color: white;
        }

        small.pull-right {
            line-height: 54px;
        }

        .list-group h4 {
            text-indent: 8px;
            padding-right: 40px;
        }
        .list-group-item:last-child {
            border-bottom: 0 !important;
        }
    </style>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">消息通知</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <ul class="list-unstyled list-group">
                @foreach ($messages as $msg)
                    <li class="list-group-item">
                        <h4>
                            <i class="fa fa-envelope-o"></i> 消息通知
                            <small class="pull-right">{{ $msg->created_at }}</small>
                        </h4>
                        <p class="text-muted">{{ $msg->content }}</p>
                    </li>
                @endforeach
            </ul>
        </div>


        <!-- /.box-body -->
        <div class="box-footer clearfix">
            @if(count($messages))
                {{ $messages->links() }}
            @endif
        </div>
    </div>
@endsection