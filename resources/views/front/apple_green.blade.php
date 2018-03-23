@extends('layouts.master.front')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2">
                <div class="panel panel-default" style="margin-top: 20px;">
                    <!-- <div class="panel-heading orange-header" style="font-size:20px">New Apple Green Customer</div> -->
                    <div class="panel-body">

                        <div class="row" style="margin-top: 15px; margin-bottom: 35px;">
                            <div class="col-xs-12 col-sm-4 col-sm-offset-2">
                                <img class="img-responsive center-block" src="{{ asset('/applegreen_images/cartow-login-logo.png') }}">
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <img class="img-responsive center-block" src="{{ asset('/applegreen_images/applegreen-logo-edited.png') }}">
                            </div>
                        </div>

                        @include('layouts.form_errors')
                        <form id="customer-form" class="form-horizontal center-block" role="form" method="POST"
                              action="{{ route('post_apple_green_memberships_registration') }}">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group control-group">
                                <label class="col-md-4 control-label">Apple Green Code<span class="orange-header">*</span></label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="applegreen_code" name="applegreen_code" value="{{ old('applegreen_code') }}">

                                </div>
                            </div>

                            <div class="form-group control-group">
                                <label class="col-sm-4 control-label">Vehicle Registration <span class="orange-header">*</span></label>

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
                                <label class="col-sm-4 control-label">First Name<span class="orange-header">*</span></label>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                           value="{{ old('first_name') }}">
                                </div>
                            </div>
                            <div class="form-group control-group">
                                <label class="col-sm-4 control-label">Last Name<span class="orange-header">*</span></label>

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
                                <label class="col-sm-4 control-label">Phone Number<span class="orange-header">*</span></label>

                                <div class="col-sm-6">
                                    <input type="tel" class="form-control" id="phone_number" name="phone_number"
                                           value="{{ old('phone_number') }}">
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
                                <label class="col-sm-4 control-label">Odometer Reading<span class="orange-header">*</span></label>

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

                            <div class="form-group control-group" style="display:none">
                                <label class="col-sm-4 control-label">Membership Type</label>

                                <div class="col-sm-6">
                                    <select class="form-control" id="membership_type" name="membership_type">
                                        <option value="{{ $memberships['id'] }}"
                                                duration="{{ $memberships['duration'] }}">{{ $memberships['membership_name'] }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group control-group">
                                <label class="col-sm-4 control-label">Start date for cover</label>

                                <div class="col-sm-6">
                                    <input type="date" class="form-control" id="start-date" name="start_date"
                                           value="{{ old('start_date') }}" readonly>
                                </div>
                            </div>





                            <div class="form-group">
                                <label class="col-md-4"></label>
                                <span class="col-md-6 payment-errors"></span>
                            </div>

                            <div class="form-group control-group">
                                <div class="col-sm-offset-4 col-sm-6">
                                    <div class="checkbox">
                                        <label>
                                            <input id="terms-conditions-checkbox" type="checkbox"
                                                   onChange="if($(this).is(':checked')) $('button').removeAttr('disabled'); else $('button').attr('disabled', 'disabled');"/>By
                                            ticking this box you confirm that you have read and understand the <a
                                                    href="{{ url('http://www.cartow.ie/terms-and-conditions.html') }}">Terms and
                                                Conditions</a> of Cartow.ie Membership.
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group control-group">
                                <div class="col-sm-6 col-sm-offset-4">
                                    <button type="submit" class="btn btn-primary btn-lg form-btn submit-button"
                                            disabled="disabled">
                                        Submit
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



        function vehicleInfoItem(label, value, name) {
            return '<div class="form-group vehicle-info" style="margin-bottom:0px"><label class="col-sm-4 control-label">' + label + '</label><div class="col-sm-6"><div class="form-control-static">' + value + '</div><input name="' + name + '" type="hidden" value="' + value + '"/></div></div>';
        }

        function setExpiryDate() {
            var duration = $('#membership_type option:selected').attr('duration');
            var durationSplit = duration.split(' ');
            var months = durationSplit[0];
            // var monthsTimestamp = months * 30 * 24 * 60 * 60;

            var startDate = $('#start-date').val();
            var startSplit = startDate.split('-');
            var date = new Date(parseInt(startSplit[0]), parseInt(startSplit[1]) - 1, parseInt(startSplit[2]));
            // var startTimestamp = date.getTime()/1000;

            // var expirationTimestamp = startTimestamp + monthsTimestamp;
            // var expirationDate = new Date(expirationTimestamp * 1000);

            // var expirationDate = addMonths(date,months);

            // var expirationDate = date;
            var expirationDate = date;
            var targetMonth = parseInt(date.getMonth()) + parseInt(months);
            expirationDate.setMonth(targetMonth);

            // alert(date);

             months = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"];

            $('.expiration-label').remove();
            var databaseDate = expirationDate.getFullYear() + '-' + (parseInt(expirationDate.getMonth()) + 1) + '-' + expirationDate.getDate();
            $('#start-date').after('<div class="expiration-label"><input type="hidden" name="membership_expiration" value="' + databaseDate + '"><h4 class="orange-header"> This membership will expire on ' + expirationDate.getDate() + ' ' + months[parseInt(expirationDate.getMonth())] + ' ' + expirationDate.getFullYear() + '</h4></div>');
        }

        $(document).ready(function () {
            function submitCustomerForm() {
                var $form = $('#customer-form');
                // Disable the submit button to prevent repeated clicks
                $form.find('button').prop('disabled', true);
                var reg = $('#vehicle_registration').val();
                var reading = $('#odometer_reading').val();
                var type = $('#odometer_type').val();
                if (typeof reg !== 'undefined' && reg!= '') {
                    var url = 'https://portal.cartow.ie/user/vehicle/' + reg + '/' + reading + '/' + type;
                    $.ajax({
                        // url:'https://www.vms.ie/api/valuationlookup/'+reg+'/'+reading+'/'+type+'?user=311solution&key=di-7jo21rt2589&output=json',
                        url: 'https://portal.cartow.ie/user/vehicle/' + reg ,
                        async: true,
                        dataType: "json"
                    }).done(function (response) {
                        var $form = $('#customer-form');
                        $form.get(0).submit();

                    }).fail(function (response) {

                    });
                }

                // Prevent the form from submitting with the default action
                return false;
            }

            if ($('#terms-conditions-checkbox').is(':checked')) {
                $('button').removeAttr('disabled');
            }
            else {
                $('button').attr('disabled', 'disabled');
            }
            
            jQuery.validator.addMethod("myEmail", function (value, element) {
                return this.optional(element) || ( /^[a-zA-Z0-9]+([-._][a-zA-Z0-9]+)*@([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*\.)+[a-z]{2,4}$/.test(value) && /^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/.test(value) );
            }, 'Please enter a valid email address.');
            $('#customer-form').validate({
                rules: {
                    applegreen_code: {
                        minlength: 13,
                        required: true
                    },
                    vehicle_registration: {
                        required: true
                    },
                    first_name: {
                        required: true
                    },
                    last_name: {
                        required: true
                    },
                    email: {
                        required: true,
                        myEmail: true
                    },
                    address_line_1: {
                        required: true
                    },
                    county: {
                        required: true
                    },
                    phone_number: {
                        required: true
                    },
                    odometer_reading: {
                        required: true
                    },
                    odometer_type: {
                        required: true
                    }
                },
                highlight: function (element) {
                    $(element).closest('.form-group.control-group').removeClass('success').addClass('error');
                },
                success: function (element) {
                    element.addClass('valid')
                            .closest('.form-group.control-group').removeClass('error').addClass('success');
                },
                submitHandler: function (form) {
                    submitCustomerForm();
                }
            });
            $('#applegreen_code').focusout(function() {
                var applegreen_code = $('#applegreen_code').val();

                if(typeof applegreen_code !== 'undefined' && applegreen_code !== '') {
                    var url = config.base_url+'/user/applegreencheck/'+applegreen_code;

                    $.ajax({
                        url: url,
                        async: true,
                        dataType: "json"

                    }).done(function (response) {

                        if(response.error === 0) {
                            $('#applegreen_code').closest('.form-group.control-group').removeClass('error').addClass('success');
                            $('.code-message').remove();
                        } else {
                            $('#applegreen_code').closest('.form-group.control-group').removeClass('success').addClass('error');
                            $('.code-message').remove();
                            $('#applegreen_code').after('<h5 class="code-message">'+response.message+'</h5>');

                        }

                    }).fail(function (response) {

                    });
                }
            });
            $('#vehicle_registration').focusout(function () {
                var reg = $('#vehicle_registration').val();
                if (typeof reg !== 'undefined' && reg !== '') {
                    var url = 'https://portal.cartow.ie/user/vehicle/' + reg;
                    $.ajax({
                        url: url,
                        async: true,
                        dataType: "json"
                    }).done(function (response) {

                        if (response !== null && response.error_code === '10') {
                            $('.vehicle-info').remove();
                            $('#vehicle-form').append('<div class="form-group vehicle-info"><div><label class="orange-header control-label col-sm-offset-4">No data available</label></div></div>');
                            $('#vehicle_registration').closest('.form-group.control-group').removeClass('success').addClass('error');
                        } else {
                            if (response === null || response.error_code === '100' || response.error_code === '101' || response.error_code === '102' || response.error_code === '103' || response.error_code === '104' || response.error_code === '105') {
                                $('.vehicle-info').remove();
                                $('#vehicle-form').append('<div class="form-group vehicle-info"><div><label class="orange-header control-label col-sm-offset-4">Could not retrieve vehicle info</label></div></div>');
                                $('#vehicle_registration').closest('.form-group.control-group').removeClass('success').addClass('error');
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

                                $('.vehicle-info').remove();

                                $('#vehicle-form').append('<div class="form-group vehicle-info"><h4 class="col-sm-4 control-label orange-header">Vehicle Details</h4></div>');

                                $('#vehicle-form').append(vehicleInfoItem('Make', make, 'make'));
                                $('#vehicle-form').append(vehicleInfoItem('Model', model, 'model'));
                                $('#vehicle-form').append(vehicleInfoItem('Version', version, 'version'));
                                $('#vehicle-form').append(vehicleInfoItem('Engine Size', engineSize, 'engine-size'));
                                $('#vehicle-form').append(vehicleInfoItem('Fuel', fuel, 'fuel'));
                                $('#vehicle-form').append(vehicleInfoItem('Transmission', transmission, 'transmission'));
                                $('#vehicle-form').append(vehicleInfoItem('Colour', colour, 'colour'));

                                $('#vehicle_registration').closest('.form-group .control-group').removeClass('error').addClass('success');
                            }
                        }

                    }).fail(function (response) {
                        $('.vehicle-info').remove();
                        $('#vehicle-form').append('<div class="form-group vehicle-info"><div><label class="orange-header control-label col-sm-offset-4">Could not retrieve vehicle info</label></div></div>');
                    });
                }
            });

            var today = new Date();

            today.setDate(parseInt(today.getDate()) + 2);

            var year = today.getFullYear();
            var month = parseInt(today.getMonth()) + 1;
            month = (month < 10) ? '0' + month : month;
            var date = parseInt(today.getDate());
            date = (date < 10) ? '0' + date : date;

            // alert(year+'-'+month+'-'+date);

            $('#start-date').val(year + '-' + month + '-' + date);
            $('#start-date').attr('min', year + '-' + month + '-' + date);

            if ($('#start-date').val() !== '' && typeof $('#start-date').val() !== 'undefined')
                setExpiryDate();

            $('#start-date').on('change', function () {
                if ($('#start-date').val() !== '' && typeof $('#start-date').val() !== 'undefined')
                    setExpiryDate();
                else {
                    $('.expiration-label').remove();
                }

            });

            $('#membership_type').on('change', function () {
                if ($('#start-date').val() !== '' && typeof $('#start-date').val() !== 'undefined')
                    setExpiryDate();
                else {
                    $('.expiration-label').remove();
                }

            });

            $('#vehicle_registration').trigger('focusout');
        });
    </script>
@endsection