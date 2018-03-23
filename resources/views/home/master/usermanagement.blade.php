@extends('masterapp')
@section('page-style')
    <link href="{{ asset('css/customer-edit.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('tab')

    @if(isset($grid))
        <!-- BEGIN PAGE HEAD -->
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1 class="orange-header">User Management
                    <small>overview of all users</small>
                </h1>
            </div>
            <!-- END PAGE TITLE -->
        </div>
        <!-- END PAGE HEAD -->

        {!! $grid !!}
        {{-- <a href="{{ url('/user/register/master') }}" class="btn btn-primary form-btn pull-right">
             Add  Account
         </a>--}}
    @endif

    @if(isset($edit))
        <!-- BEGIN PAGE HEAD -->
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1 class="orange-header">Edit User Accounts</h1>
            </div>
            <!-- END PAGE TITLE -->
        </div>
        <!-- END PAGE HEAD -->

        {!! $edit !!}

        @endif

                <!-- END PAGE CONTENT INNER -->

@endsection
@section('fast-page-script')
    <script>
        grid_list.find('td:last-child').addClass('hidden');
    </script>
@endsection