@extends('masterapp')

@section('tab')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading orange-header" style="font-size:24px">New Membership</div>
                    <div class="panel-body">
                        @include('layouts.form_errors')
                        <form id="customer-form" logged-in="{{$logged_in}}" class="form-horizontal" role="form"
                              method="POST" action="{{ url('/user/register/customer') }}">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group control-group">
                                <label class="col-sm-4 control-label">Vehicle Registration <span
                                            class="orange-header">*</span></label>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="vehicle_registration"
                                           name="vehicle_registration" value="{{ old('vehicle_registration') }}">
                                </div>
                            </div>

                            <div class="form-group control-group" id="vehicle-form" style="margin: 0px !important;">

                            </div>

                            <div class="form-group control-group">
                                <label class="col-sm-4 control-label">Title</label>

                                <div class="col-sm-6">
                                    <select class="form-control" id="title" name="title">
                                        <option value="Mr"  @if(old('title') ==='Mr' ) selected @endif >Mr</option>
                                        <option value="Mrs"  @if(old('title') ==='Mrs' ) selected @endif>Mrs</option>
                                        <option value="Ms"  @if(old('title') ==='Ms' ) selected @endif>Ms</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group control-group">
                                <label class="col-sm-4 control-label">First Name<span
                                            class="orange-header">*</span></label>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                           value="{{ old('first_name') }}">
                                </div>
                            </div>
                            <div class="form-group control-group">
                                <label class="col-sm-4 control-label">Last Name<span
                                            class="orange-header">*</span></label>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                           value="{{ old('last_name') }}">
                                </div>
                            </div>

                            <div class="form-group control-group">
                                <label class="col-sm-4 control-label">Email Address<span class="orange-header">*</span></label>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="email" name="email"
                                           value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="form-group control-group">
                                <label class="col-sm-4 control-label">Address Line 1<span class="orange-header">*</span></label>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="address_line_1"
                                           name="address_line_1"
                                           value="{{ old('address_line_1') }}">
                                </div>
                            </div>

                            <div class="form-group control-group">
                                <label class="col-sm-4 control-label">Address Line 2</label>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="address_line_2"
                                           name="address_line_2"
                                           value="{{ old('address_line_2') }}">
                                </div>
                            </div>

                            <div class="form-group control-group">
                                <label class="col-sm-4 control-label">Town</label>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="town" name="town"
                                           value="{{ old('town') }}">
                                </div>
                            </div>

                            <div class="form-group control-group">
                                <label class="col-sm-4 control-label">County<span class="orange-header">*</span></label>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="county" name="county"
                                           value="{{ old('county') }}">
                                </div>
                            </div>

                            <div class="form-group control-group">
                                <label class="col-sm-4 control-label">Postal Code</label>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="postal_code" name="postal_code"
                                           size="5"
                                           value="{{ old('postal_code') }}">
                                </div>
                            </div>

                            <div class="form-group control-group">
                                <label class="col-sm-4 control-label">Phone Number<span
                                            class="orange-header">*</span></label>

                                <div class="col-sm-6">
                                    <input type="tel" class="form-control" id="phone_number" name="phone_number"
                                           value="{{ old('phone_number') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Preferred next of kin Phone Number</label>

                                <div class="col-md-8">
                                    <input type="number" class="form-control" name="nok_phone_number"
                                           value="{{ old('nok_phone_number') }}">
                                </div>
                            </div>
                            <div class="form-group control-group">
                                <label class="col-sm-4 control-label">Do you have a valid NCT ?<span
                                            class="orange-header">*</span></label>

                                <div class="col-sm-6" >  
                                    <style>
                                        .radio{
                                           padding-top:3px !important; 
                                        }
                                           
                                    </style>
                                         <label class='radio-inline' style='padding-left:0px; padding-top:3px;'><input  type="radio" name="nct" value="1" checked="checked"> yes</label>
                                         <label class='radio-inline' style=''><input type="radio" name="nct" value="0"> no</label>

                                    
                                </div>
                            </div>
                            <div class="form-group control-group">
                                <label class="col-sm-4 control-label">Odometer Reading<span
                                            class="orange-header">*</span></label>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="odometer_reading"
                                           name="odometer_reading" value="{{ old('odometer_reading') }}">
                                </div>
                            </div>

                            <div class="form-group control-group">
                                <label class="col-sm-4 control-label">Odometer Type<span class="orange-header">*</span></label>

                                <div class="col-sm-6">
                                    <select class="form-control" id="odometer_type" name="odometer_type">
                                        <option value="k" @if(old('odometer_type') ==='k' ) selected @endif>Kilometers
                                        </option>
                                        <option value="m" @if(old('odometer_type') ==='m' ) selected @endif>Miles
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Membership Type</label>

                                <div class="col-md-8">
                                    <select class="form-control" id="membership_type" name="membership_type">
                                        @foreach($memberships as $membership)
                                            <option value="{{ $membership['id'] }}"
                                                    duration="{{ $membership['duration'] }}">{{ $membership['membership_name'] }}</option>
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
                                        Allow changing the start date - cant be undone
                                        <input type="checkbox"  class="form-control"
                                               onclick="$('#start-date').prop('readonly',false);$(this).parent().parent().parent().hide()">
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Username <span class="orange-header">*</span>
                                </label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="username"
                                           value="{{ old('username') }}">
                                </div>
                            </div>
                            @if(( new \App\Managers\AuthManager())->isAnyRole(['master','sales','finance']))
                                <div class="form-group ">
                                    <label class="col-md-4 control-label">
                                        Bypass automatic notification email
                                    </label>

                                    <div class="col-md-8">
                                        <input type="checkbox" class="form-control"
                                               name="bypass_notification" value="1">
                                    </div>
                                </div>
                            @endif
                            <div class="payment_section">
                                @if($payment_method === \App\Enums\PaymentMethod::online)
                                    @if(( new \App\Managers\AuthManager())->isAnyRole(['master','sales','finance']))
                                        <div class="form-group ">
                                            <label class="col-md-4 control-label">
                                                Bypass payment
                                            </label>

                                            <div class="col-md-8">
                                                <input type="checkbox" class="form-control bypass_payment"
                                                       name="bypass_payment" value="1"> <span>can't be un done </span>
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
                                        Add User Account
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
                    var form$ = $("#customer-form");
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
            $("#customer-form").get(0).submit();
        };
        @endif


        $('.bypass_payment').change(function () {
                    $('.payment_section').hide();
                    payment.process = function () {
                        $("#customer-form").get(0).submit();
                        // re-enable the submit button
                        $('.submit-button').removeAttr("disabled");
                    };
                });


    </script>
    <script type="text/javascript">


        function vehicleInfoItem(label, value, name) {
            var html = '<div class="form-group vehicle-info"><label class="col-md-4 control-label">' + label + '</label><div class="col-md-6"><div class="form-control-static">' + value + '</div><input name="' + name + '" type="hidden" value="' + value + '"/></div></div>';
            return html
        }
        /**
         * TODO
         *
         */
        function setExpiryDate() {
            var duration = $('#membership_type').find('option:selected').attr('duration');
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

            $('#vehicle_registration').focusout(function () {
                var reg = $('#vehicle_registration').val();
                var reading = ($('#odometer_reading').val() !== '') ? parseInt($('#odometer_reading').val()) : '';
                var type = $('#odometer_type').val();
                var url = (reading !== '') ? 'https://portal.cartow.ie/user/vehicle/' + reg + '/' + reading + '/' + type : 'https://portal.cartow.ie/user/vehicle/' + reg;
                if (reg == 'undefined' || reg == '') {
                    return false;
                }
                $.ajax({
                    // url:'https://www.vms.ie/api/valuationlookup/'+reg+'/'+reading+'/'+type+'?user=311solution&key=di-7jo21rt2589&output=json',
                    url: 'https://portal.cartow.ie/user/vehicle/' + reg,
                    async: true,
                    dataType: "json"
                }).done(function (response) {

                    if (response.error_code === '10') {
                        jQuery('.vehicle-info').remove();
                        jQuery('#vehicle-form').after('<div class="form-group vehicle-info"><div><label class="orange-header control-label">No data available</label></div></div>');
                    } else {
                        if (response.error_code === '100' || response.error_code === '101' || response.error_code === '102' || response.error_code === '103' || response.error_code === '104' || response.error_code === '105') {
                            jQuery('.vehicle-info').remove();
                            jQuery('#vehicle-form').after('<div class="form-group vehicle-info"><div><label class="orange-header control-label">Could not retrieve vehicle info</label></div></div>');
                        } else {

                            var vehicle = response.vehicle;
                            var make = vehicle.make;
                            var model = vehicle.model;
                            var version = vehicle.version;
                            var engineSize = vehicle.engineSize;
                            var fuel = vehicle.fuel;
                            var transmission = vehicle.transmission;
                            var colour = vehicle.colour;

                            if (make === '' || make == null)
                                make = '-';

                            if (model === '' || model == null)
                                model = '-';

                            if (version === '' || version == null)
                                version = '-';

                            if (engineSize === '' || engineSize == null)
                                engineSize = '-';

                            if (fuel === '' || fuel == null)
                                fuel = '-';

                            if (transmission === '' || transmission == null)
                                transmission = '-';

                            if (colour === '' || colour == null)
                                colour = '-';

                            jQuery('.vehicle-info').remove();
                            jQuery('#vehicle-form').after(vehicleInfoItem('Colour', colour, 'colour'));
                            jQuery('#vehicle-form').after(vehicleInfoItem('Transmission', transmission, 'transmission'));
                            jQuery('#vehicle-form').after(vehicleInfoItem('Fuel', fuel, 'fuel'));
                            jQuery('#vehicle-form').after(vehicleInfoItem('Engine Size', engineSize, 'engine-size'));
                            jQuery('#vehicle-form').after(vehicleInfoItem('Version', version, 'version'));
                            jQuery('#vehicle-form').after(vehicleInfoItem('Model', model, 'model'));
                            jQuery('#vehicle-form').after(vehicleInfoItem('Make', make, 'make'));

                            jQuery('#vehicle-form').after('<div class="form-group vehicle-info"><h3 class="col-md-4 control-label orange-header">Vehicle Details</h3></div>');
                        }
                    }

                }).fail(function (response) {
                    jQuery('.vehicle-info').remove();
                    jQuery('#vehicle-form').after('<div class="form-group vehicle-info"><div><label class="orange-header control-label">Could not retrieve vehicle info</label></div></div>');
                });
            });
            
            $('#customer-form').validate({
                rules: {
                    vehicle_registration: {
                        required: true
                    },
                    first_name: {
                        required: true
                    },
                    last_name: {
                        required: true
                    },
                    username: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    address_line_1: {
                        required: true
                    },
                    county: {
                        required: true
                    },
                    phone_number: {
                        required: true,
                        digits: true
                    },
                    odometer_reading: {
                        required: true
                    },
                    membership_type: {
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

            jQuery('#membership_type').on('change', function () {
                if (start_date_selector.val() !== '' && typeof start_date_selector.val() !== 'undefined')
                    setExpiryDate();
                else {
                    jQuery('.expiration-label').remove();
                }

            });
            $('#vehicle_registration').trigger('focusout');
        });
    </script>
@stop