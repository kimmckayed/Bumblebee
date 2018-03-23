@extends('masterapp')
@section('tab')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading orange-header" style="font-size:24px">New Company/Partner</div>
                    <div class="panel-body">
                        @include('layouts.form_errors')
                        <form class="form-horizontal" role="form" method="POST"
                              action="{{ route('register_customer_post') }}" id="customerRegisterForm">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">





                            <div class="form-group">
                                <label class="col-md-4 control-label">Company Code<span class="orange-header">*</span></label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="code"
                                           value="{{ old('code') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Company Name<span class="orange-header">*</span></label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="company_name"
                                           value="{{ old('company_name') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Website</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="website"
                                           value="{{ old('website') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Location Address</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="address"
                                           value="{{ old('address') }}">
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-4 control-label">Memberships<span class="orange-header">*</span></label>

                                <div class="col-md-6">
                                    @foreach($memberships as $membership)
                                        <div class="checkbox">
                                            <label>
                                                <input name="memberships[]"
                                                       type="checkbox"
                                                       value="{{ $membership['id'] }}"
                                                @if(@in_array($membership['id'],old('memberships'))  ) checked @endif
                                                        />
                                                {{ $membership['membership_name'] }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="payment_method">
                                    Payment method:
                                </label>

                                <div class="col-md-6">
                                    <select class="form-control" id="payment_method" name="payment_method">
                                        <option value="1"  @if(old('payment_method') ==1 ) selected @endif>Pay As You Go
                                        </option>
                                        <option value="2"  @if(old('payment_method') ==2 ) selected @endif>Monthly Bill
                                        </option>
                                    </select>
                                </div>
                            </div>
                            {{--<div class="payment_method_check_container form-group hidden">
                                <label class="col-md-4 control-label"> </label>

                                <div class="col-md-6">

                                    <div class="checkbox">
                                        <label><input name="payment_method_check" type="checkbox"
                                                      value="1">Direct Debit mandate form has been returned
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Status</label>

                                <div class="col-md-6">
                                    <select class="form-control" id="company_status" name="company_status">
                                        @foreach($statuses as $status)
                                            <option value="{{ $status['id'] }}" @if(old('company_status') ==$status['id'] )
                                                    selected @endif>{{ $status['status'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>--}}
                            <div class="form-group">
                                <h3 class="col-md-4 control-label orange-header">Main Point of Contact</h3>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Username<span class="orange-header">*</span></label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="username"
                                           value="{{ old('username') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="poc_name"
                                           value="{{ old('poc_name') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Email<span class="orange-header">*</span></label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="poc_email"
                                           value="{{ old('poc_email') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Phone Number</label>

                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="poc_number"
                                           value="{{ old('poc_number') }}">
                                </div>
                            </div>
                            <div class="accountant-poc">
                                <div class="form-group">
                                    <h3 class="col-md-4 control-label orange-header">Accounts Point of Contact</h3>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Name</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="poc_name_2"
                                               value="{{ old('poc_name_2') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Email</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="poc_email_2"
                                               value="{{ old('poc_email_2') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Phone Number</label>

                                    <div class="col-md-6">
                                        <input type="number" class="form-control" name="poc_number_2"
                                               value="{{ old('poc_number_2') }}">
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary form-btn">
                                        Add Company Account
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
        $(document).ready(function () {
            var payment_method = $('#payment_method');
            payment_method.change(function () {
                var payment_method_check_container = $('.payment_method_check_container');
                var company_status = $('#company_status');
                payment_method_check_container.addClass('hidden');
                company_status.val(1);
                if ($(this).val() == 2) {
                    payment_method_check_container.removeClass('hidden');
                    company_status.val(2);
                }
            });

            payment_method.trigger('change');
        });
        jQuery.validator.addMethod("myEmail", function (value, element) {
               return this.optional(element) || ( /^[a-zA-Z0-9]+([-._][a-zA-Z0-9]+)*@([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*\.)+[a-z]{2,4}$/.test(value) && /^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/.test(value) );
           }, 'Please enter a valid email address.');
        $('#customerRegisterForm').validate({
            rules: {
                code: {
                    required: true
                },
                company_name: {
                    required: true
                },
                username: {
                    required: true
                },
                poc_email: {
                    required: true,
                    myEmail: true
                },
                poc_email_2: {
                    myEmail: true
                },
                'memberships[]': {
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