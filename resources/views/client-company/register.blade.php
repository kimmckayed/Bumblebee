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
                    <div class="panel-heading orange-header" style="font-size:24px">New Client Company</div>
                    <div class="panel-body">
                        @include('layouts.form_errors')
                        <form class="form-horizontal" role="form" method="POST"
                              action="{{ url('client-company/register') }}" id="clientCompanyRegisterForm">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Name<span class="orange-header">*</span></label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{ old('name') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="maximum_allowance" class="col-md-4 control-label">Maximum allowance (in distance unit)</label>
                                <div class="col-md-6">
                                    <input id="maximum_allowance" type="text" class="form-control" name="maximum_allowance"
                                           value="{{ old('maximum_allowance') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="additional_value" class="col-md-4 control-label">Additional value per extra distance unit</label>
                                <div class="col-md-6">
                                    <input id="additional_value" type="text" class="form-control" name="additional_value"
                                           value="{{ old('additional_value') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Covered?<span class="orange-header">*</span></label>
                                <div class="col-md-6">
                                    <label><input type="radio" name="covered" value="0"/> <span>No</span></label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" name="covered" value="1" /> <span>Yes</span></label>
                                    <label for="covered" class="error" style="display: none">This field is required</label>
                                </div>
                            </div>

                            <div class="form-group" id="call_out_value_container" style="display: none;">
                                <label for="call_out_value" class="col-md-4 control-label">Call out value</label>
                                <div class="col-md-6">
                                    <input id="call_out_value" type="number" class="form-control" name="call_out_value"
                                           value="{{ old('call_out_value') }}">
                                </div>
                            </div>

                            <div class="form-group" id="additional_tolls_container" style="display: none;">
                                <label for="additional_tolls" class="col-md-4 control-label">Additional tolls accepted</label>
                                <div class="col-md-6">
                                    <label><input type="radio" name="additional_tolls" value="0" /> <span>No</span></label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <label><input type="radio" name="additional_tolls" value="1" /> <span>Yes</span></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="bringg_id" class="col-md-4 control-label">Bringg tag ID</label>
                                <div class="col-md-6">
                                    <input id="bringg_id" type="text" class="form-control" name="bringg_id"
                                           value="{{ old('bringg_id') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="distance_unit" class="col-md-4 control-label">Unit of distance</label>
                                <div class="col-md-6">
                                    <select id="distance_unit" class="form-control" name="distance_unit">
                                        <option value="km">Kilometers</option>
                                        <option value="m">Miles</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary form-btn">
                                        Add Client Company
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
        $('#clientCompanyRegisterForm').validate({
            rules: {
                name: {
                    required: true
                },
                covered: {
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
        $(document).ready(function() {
            $('input[name="covered"]').on('click change', function (e) {
                if(this.value == 0){
                    $('#call_out_value_container').hide();
                    $('#additional_tolls_container').hide();
                } else if(this.value == 1){
                    $('#call_out_value_container').show();
                    $('#additional_tolls_container').show();
                }
            });
        });
    </script>
@stop