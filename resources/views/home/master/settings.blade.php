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
                <h1 class="orange-header">Settings
                    <small>manage portal settings</small>
                </h1>
            </div>
            <!-- END PAGE TITLE -->
        </div>
        <!-- END PAGE HEAD -->
        {!! $grid !!}
        <!-- END PAGE CONTENT INNER -->
    @endif

    @if(isset($edit))
        <!-- BEGIN PAGE HEAD -->
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1 class="orange-header">Edit Setting</h1>
            </div>
            <!-- END PAGE TITLE -->
        </div>
        <!-- END PAGE HEAD -->
        <div id="editEntity" class="form-horizontal saveBtnFix">
            {!! $edit !!}
        </div>

        <!-- END PAGE CONTENT INNER -->
    @endif

@endsection

@section('page-script')
    <script type="text/javascript">
        jQuery(document).ready(function () {

         //   jQuery('th').css('display', 'none');

        });
    </script>
@endsection