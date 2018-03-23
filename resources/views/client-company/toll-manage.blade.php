@extends('masterapp')

@section('page-style')
    <link href="{{ asset('css/customer-edit.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        form[method="POST"], .form{
            width: 100% !important;
        }
    </style>
@endsection

@section('tab')

    @if(isset($message))
        {!! $message !!}
    @endif

    @if(isset($grid))
        <div class="page-head">
            <div class="page-title">
                <h1 class="orange-header">Tolls
                    <small>Manage Tolls</small>
                </h1>
            </div>
        </div>
        <a href="{{ url('toll/add') }}" class="btn btn-primary form-btn pull-left">
            Add Toll
        </a>

        {!! $grid !!}
    @endif
    @if(isset($edit))
        <!-- BEGIN PAGE HEAD -->
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1 class="orange-header">Edit Toll</h1>
            </div>
            <!-- END PAGE TITLE -->

        </div>

        <div id="editEntity" class="form-horizontal saveBtnFix">
            {!! $edit !!}
        </div>

    @endif
    <!-- END PAGE CONTENT INNER -->

@endsection


@section('page-script')
    <script>
        jQuery.validator.addMethod("myEmail", function (value, element) {
               return this.optional(element) || ( /^[a-zA-Z0-9]+([-._][a-zA-Z0-9]+)*@([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*\.)+[a-z]{2,4}$/.test(value) && /^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/.test(value) );
           }, 'Please enter a valid email address.');
    </script>
@endsection