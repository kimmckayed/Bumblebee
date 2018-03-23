@extends('masterapp')
@section('tab')
    <style>
        .form-horizontal label span {
            vertical-align: bottom;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading orange-header" style="font-size:24px">New Tax</div>
                    <div class="panel-body">
                        @include('layouts.form_errors')
                        <form class="form-horizontal" role="form" method="POST"
                              action="{{ url('tax/add') }}" id="taxRegisterForm">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Name<span class="orange-header">*</span></label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{ old('name') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="value" class="col-md-4 control-label">Value (%)<span class="orange-header">*</span></label>
                                <div class="col-md-6">
                                    <input id="value" type="text" class="form-control" name="value"
                                           value="{{ old('value') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary form-btn">
                                        Add Tax
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('page-script')
    <script>
        jQuery.validator.addMethod("myEmail", function (value, element) {
               return this.optional(element) || ( /^[a-zA-Z0-9]+([-._][a-zA-Z0-9]+)*@([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*\.)+[a-z]{2,4}$/.test(value) && /^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/.test(value) );
           }, 'Please enter a valid email address.');
        $('#taxRegisterForm').validate({
            rules: {
                name: {
                    required: true
                },
                value: {
                    required: true
                }
            },
            highlight: function (element) {
                $(element).closest('.form-group').removeClass('success').addClass('error');
            },
            success: function (element) {
                element.addClass('valid')
                        .closest('.form-group').removeClass('error').addClass('success');
            }
        });
    </script>
@stop