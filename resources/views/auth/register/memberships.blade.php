@extends('masterapp')
@section('content')
<!-- BEGIN CONTENT -->

<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading orange-header" style="font-size:24px">New Membership</div>
            <div class="panel-body">
                @include('layouts.form_errors')

                <form class="form-horizontal" role="form" method="POST"
                      action="{{ url('/user/register/memberships') }}" id="membershipRegisterForm">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label class="col-md-4 control-label">Name<span class="orange-header">*</span></label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="membership_name"
                                   value="{{ old('membership_name') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Gross Price<span class="orange-header">*</span></label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="price"
                                   value="{{ old('price') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Duration<span class="orange-header">*</span></label>

                        <div class="col-md-6 form-inline">
                            <input type="number" class="form-control" name="duration"
                                   value="{{ old('duration') }}">
                            <label>months</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Code<span class="orange-header">*</span></label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="code" value="{{ old('code') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Number of Callouts</label>

                        <div class="col-md-6">
                            <input type="number" class="form-control" name="number_of_callouts"
                                   value="{{ old('number_of_callouts') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary form-btn">
                                Add Membership
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- END CONTENT -->

@endsection
@section('page-script')
    <script type="text/javascript">
        $('#membershipRegisterForm').validate({
            rules: {
                membership_name: {
                    required: true
                },
                price: {
                    required: true,
                    number: true
                },
                duration: {
                    required: true
                },
                code: {
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