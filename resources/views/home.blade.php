@extends('layouts.main')

@section('subcontent')
    <style type="text/css">
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
            <h3 class="box-title">待办事项</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

            <div class="row">

            </div>

        </div>


        <div class="box-header with-border">
            <h3 class="box-title">消息通知</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <ul class="list-unstyled list-group">

            </ul>
        </div>


        <!-- /.box-body -->
        <div class="box-footer clearfix">
        </div>
    </div>
@endsection