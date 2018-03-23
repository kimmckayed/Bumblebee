@extends('masterapp')

@section('tab')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading orange-header" style="font-size:24px">Renew Membership</div>
                    <div class="panel-body">
                        @include('layouts.form_errors')
                        <form id="renew-form" logged-in="{{$logged_in}}" class="form-horizontal" role="form"
                              method="POST" action="{{ route('memberships_renew_post') }}">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <input type="hidden" name="customer_id" value="{{ $customer_id }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">Membership Type</label>

                                <div class="col-md-8">
                                    <select class="form-control" id="membership_id" name="membership_id">
                                        @foreach($memberships as $membership)
                                            <option value="{{ $membership['id'] }}"
                                                    duration="{{ $membership['duration'] }}"
                                                    @if($membership['id'] == $membership_id)
                                                        selected
                                                    @endif
                                                    >{{ $membership['membership_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group control-group">
                                <label class="col-sm-4 control-label">Start date for cover</label>

                                <div class="col-md-8">
                                    <input type="date" class="form-control" id="start-date" name="start_date"
                                           value="{{ old('start_date') }}" readonly>
                                    @if(( new \App\Managers\AuthManager())->isAnyRole(['master','sales','finance']))
                                        <span>
                                        <input type="checkbox"
                                               onclick="$('#start-date').prop('readonly',false);$(this).parent().parent().parent().hide()">
                                        </span>
                                        Allow changing the start date - cant be undone
                                    @endif
                                </div>
                            </div>

                            <div class="payment_section">
                                @if($payment_method === \App\Enums\PaymentMethod::online)
                                    @if(( new \App\Managers\AuthManager())->isAnyRole(['master','sales','finance']))
                                        <div class="form-group ">
                                            <label class="col-md-4 control-label">
                                                Bypass payment
                                            </label>

                                            <div class="col-md-8">
                                                <input type="checkbox" class="bypass_payment"
                                                       name="bypass_payment" value="1"> <span>can't be undone </span>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-12">

                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <h3 class="col-md-4 control-label orange-header">Credit Card

                                                </h3>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Card Number
                                        </label>

                                        <div class="col-md-4">
                                            <input style="width: 100%;" type="text" size="20" autocomplete="off"
                                                   class="card-number form-control"
                                                   data-stripe="number" name="card_number"
                                                   value="{{old('card_number')}}"
                                                   maxlength="16"/>

                                        </div>
                                        <div class="col-md-4">
                                            <img src=" {{asset('images/ssl_verified_logo.gif')}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">CVC</label>

                                        <div class="col-md-3">
                                            <input type="text" size="4" maxlength="4" autocomplete="off"
                                                   class="card-cvc form-control" data-stripe="cvc" name="cvc"
                                                   value="{{old('cvc')}}"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Expiration Date</label>

                                        <div class="col-md-6">
                                            <div class="form-inline">
                                                <input type="text" size="2" maxlength="2"
                                                       class="card-expiry-month date-month form-control"
                                                       data-stripe="exp-month" name="exp_month"
                                                       value="{{old('exp_month')}}">
                                                <span> / </span>
                                                <input type="text" size="4" maxlength="4"
                                                       class="card-expiry-year date-year form-control"
                                                       data-stripe="exp-year" name="exp_year"
                                                       value="{{old('exp_year')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"></label>

                                        <div class="col-md-6">
                                            <div class="form-inline">
                                                <img src="{{ asset('/images/lock-01.png')  }}" class="pull-left"
                                                     style="padding-top: 5px;">
                                                <a class="col-md-6" href="http://www.stripe.com"
                                                   style="color: #C3C3C3;padding-left: 5px;">Powered by
                                                    Stripe</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4"></label>
                                        <span class="col-md-6 payment-errors"></span>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary form-btn submit-button">
                                        Renew membership
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
    <script type="text/javascript">
        // this identifies your website in the createToken call below
        Stripe.setPublishableKey('{{env('stripe_key_publish', 'pk_live_lpyeyPESdKboLiDOcFYZOHFZ')}}');//Testing Publishable Key

        var payment = {
            process: function () {
                Stripe.createToken({
                    number: $('.card-number').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                }, this.stripeResponseHandler);
            },
            stripeResponseHandler: function (status, response) {
                if (response.error) {
                    // re-enable the submit button
                    $('.submit-button').removeAttr("disabled");
                    // show the errors on the form
                    $(".payment-errors").html(response.error.message);
                } else {
                    var form$ = $("#renew-form");
                    // token contains id, last4, and card type
                    var token = response['id'];
                    // insert the token into the form so it gets submitted to the server
                    form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                    // and submit
                    form$.get(0).submit();
                }
            }
        };
        @if($payment_method === \App\Enums\PaymentMethod::offline )

        payment.process = function () {
            $("#renew-form").get(0).submit();
        };
        @endif


        $('.bypass_payment').change(function () {
                    $('.payment_section').hide();
                    payment.process = function () {
                        $("#renew-form").get(0).submit();
                        // re-enable the submit button
                        $('.submit-button').removeAttr("disabled");
                    };
                });


    </script>
    <script type="text/javascript">
        function setExpiryDate() {
            var duration = $('#membership_id').find('option:selected').attr('duration');
            var durationSplit = duration.split(' ');
            var number_of_months = durationSplit[0];
            // var monthsTimestamp = months * 30 * 24 * 60 * 60;
            var start_date_selector = $('#start-date');

            var startDate = start_date_selector.val();
            var expirationDate = moment(startDate).add(number_of_months, 'months').format("YYYY-MM-DD");


            var months = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"];

            jQuery('.expiration-label').remove();

            start_date_selector.after('   <div class="expiration-label">' +
            '<input type="hidden" name="membership_expiration" value="' + expirationDate + '">' +
            '<h4 class="orange-header"> This membership will expire on ' + moment(expirationDate).format("DD MMMM YYYY") +
            '</h4>' +
            '</div>');
        }
        jQuery(document).ready(function () {

            jQuery(document).on('focus', '[name="expiration_date[from]"]', function () {
                // alert('focus');
                jQuery('[name="expiration_date[from]"]').datepicker();
            });

            jQuery(document).on('focus', '[name="expiration_date[to]"]', function () {
                // alert('focus');
                jQuery('[name="expiration_date[to]"]').datepicker();
            });
            
            $('#renew-form').validate({
                rules: {
                    membership_id: {
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
                ,
                submitHandler: function (form) {
                    $('.submit-button').attr("disabled", "disabled");
                    payment.process();
                    //form.submit();
                }
            });


            var start_date_selector = $('#start-date');
            start_date_selector.val(moment().add(3, 'days').format("YYYY-MM-DD"));
           // start_date_selector.attr('min', moment().format("YYYY-MM-DD"));

            if (start_date_selector.val() !== '' && typeof start_date_selector.val() !== 'undefined')
                setExpiryDate();

            start_date_selector.on('change', function () {
                if (start_date_selector.val() !== '' && typeof start_date_selector.val() !== 'undefined')
                    setExpiryDate();
                else {
                    jQuery('.expiration-label').remove();
                }

            });

            jQuery('#membership_id').on('change', function () {
                if (start_date_selector.val() !== '' && typeof start_date_selector.val() !== 'undefined')
                    setExpiryDate();
                else {
                    jQuery('.expiration-label').remove();
                }

            });
        });
    </script>
@stop