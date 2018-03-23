@extends('masterapp')

@section('tab')


        @if(isset($grid))
                <!-- BEGIN PAGE HEAD -->
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1 class="orange-header">Agents Activity
                    <small>in the last week</small>
                </h1>
            </div>
            <!-- END PAGE TITLE -->
        </div>


        <!-- END PAGE HEAD -->
                {!! $filter !!}
        {!! $grid !!}
        @endif
                <!-- END PAGE CONTENT INNER -->


@endsection
@section('page-style')
    <link href="{{ asset('css/customer-edit.css') }}" rel="stylesheet" type="text/css"/>
@endsection

