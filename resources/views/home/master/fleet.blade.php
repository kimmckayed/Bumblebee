@extends('masterapp')

@section('page-style')
    <link href="{{ asset('css/customer-edit.css') }}" rel="stylesheet" type="text/css"/>

@endsection
@section('tab')
            @if(isset($grid))
            @if(!isset($message))
            <div class="page-head">
                <div class="page-title">
                    <h1 class="orange-header">
                        Fleet wizard
                    </h1>
                </div>
            </div>
            <div class="row">
                <img src="{{asset('images/fleet_add.png')}}"
                     style="display:block; margin: 0 auto; max-width: 100%;"/>
            </div>

                    <!-- BEGIN PAGE HEAD -->
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1 class="orange-header">
                       Manage Fleets
                    </h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>
            <!-- END PAGE HEAD -->

            <a href="{{ url('fleet/add') }}" class="btn btn-primary form-btn pull-left">
                Add Fleet
            </a>
            {!! $grid !!}
            @else
                    <!-- BEGIN PAGE HEAD -->
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1 class="orange-header">Fleets
                        <small>add fleets</small>
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
                    <h1 class="orange-header">Edit Fleet Accounts</h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>
            <!-- END PAGE HEAD -->
            <div id="editEntity"  class="saveBtnFix">
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
@section('page-script')
    <script src="{{ asset('js/twitter-typeahead.js') }}" type="text/javascript"></script>
@endsection