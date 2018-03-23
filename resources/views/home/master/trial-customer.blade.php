@extends('masterapp')

@section('page-style')
    <link href="{{ asset('css/customer-edit.css') }}" rel="stylesheet" type="text/css"/>

@endsection
@section('tab')
            @if(isset($grid))
            @if(!isset($message))
                    <!-- BEGIN PAGE HEAD -->
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1 class="orange-header">
                       Manage trial members
                    </h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>
            <!-- END PAGE HEAD -->

            {!! $grid !!}
            @else
                    <!-- BEGIN PAGE HEAD -->
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1 class="orange-header">
                        Trial members
                    </h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>
            <!-- END PAGE HEAD -->

            {!! $message !!}

            @endif
            @endif
            @if(isset($edit))
                    <!-- BEGIN PAGE HEAD -->
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1 class="orange-header">Edit Trial Member</h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>
            <!-- END PAGE HEAD -->
            <div id="editEntity"  class="saveBtnFix form-horizontal">
                {!! $edit !!}
            </div>
            @endif
                    <!-- END PAGE CONTENT INNER -->
@endsection
@section('fast-page-script')
    <script>
        grid_list.find('td:last-child').addClass('hidden');
    </script>
@endsection