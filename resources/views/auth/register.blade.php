@extends('masterapp')
<?php
$entity = $registration;
switch ($registration) {
    case 'company':
        $entity = 'customer';
        break;

    case 'customer':
        $entity = 'member';
        break;
}
?>
@section('tab')
    <!-- BEGIN CONTENT -->

    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading orange-header" style="font-size:24px">New {{ $entity }}</div>
                <div class="panel-body">
                    @include('layouts.form_errors')
                    @if($registration === 'master')
                        <form class="form-horizontal" role="form" method="POST"
                              action="{{ url('/user/register/master') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">Email</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="email" value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Username</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="username"
                                           value="{{ old('username') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Confirm Password</label>

                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">First Name</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="first_name"
                                           value="{{ old('first_name') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Last Name</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="last_name"
                                           value="{{ old('last_name') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Role</label>

                                <div class="col-md-6">
                                    <select class="form-control" id="role" name="role">
                                        @foreach($roles as $role)
                                            <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- <div class="form-group">
									<label class="col-md-4 control-label">E-Mail Address</label>
									<div class="col-md-6">
										<input type="email" class="form-control" name="email" value="{{ old('email') }}">
									</div>
								</div> -->

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary form-btn">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif

                    @if($registration === 'company')
                        <form class="form-horizontal" role="form" method="POST"
                              action="{{ url('/user/register/company') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">Username</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="username"
                                           value="{{ old('username') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Confirm Password</label>

                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Company Code</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="code" value="{{ old('code') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Company Name</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="company_name"
                                           value="{{ old('company_name') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Website</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="website" value="{{ old('website') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Location Address</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Status</label>

                                <div class="col-md-6">
                                    <select class="form-control" id="company_status" name="company_status">
                                        @foreach($statuses as $status)
                                            <option value="{{ $status['id'] }}">{{ $status['status'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Memberships</label>

                                <div class="col-md-6">
                                    @foreach($memberships as $membership)
                                        <div class="checkbox">
                                            <label><input name="memberships[]" type="checkbox"
                                                          value="{{ $membership['id'] }}">{{ $membership['membership_name'] }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                <h3 class="col-md-4 control-label orange-header">Main Point of Contact</h3>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="poc_name"
                                           value="{{ old('poc_name') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Email</label>

                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="poc_email"
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


                            <!-- <div class="form-group">
									<label class="col-md-4 control-label">E-Mail Address</label>
									<div class="col-md-6">
										<input type="email" class="form-control" name="email" value="{{ old('email') }}">
									</div>
								</div> -->

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary form-btn">
                                        Add Company Account
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif

                    @if($registration === 'codes')
                        <form id="newPromotionalCodeForm" class="form-horizontal" role="form" method="POST"
                              action="{{ url('/user/register/codes') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name"
                                           value="{{ old('name') }}" required >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Code</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="code"
                                           value="{{ old('code') }}" required>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-4 control-label">Discount</label>

                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="discount"
                                           value="{{ old('discount') }}" required >
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-4 control-label">Start Date</label>

                                <div class="col-md-6">
                                    <input type="date" class="form-control" name="date_start"
                                           value="{{ old('date_start') }}" required>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-4 control-label">End Date</label>

                                <div class="col-md-6">
                                    <input type="date" class="form-control" name="date_end"
                                           value="{{ old('date_end') }}" required>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-4 control-label">Usage Limit</label>

                                <div class="col-md-6">
                                    <input type="number" required class="form-control" name="uses_total"
                                           value="{{ old('uses_total') }}">
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-4 control-label">Customers Limit</label>

                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="uses_customer"
                                           value="{{ old('uses_customer') }}">
                                </div>
                            </div>





                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary form-btn">
                                        Add code
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- END CONTENT -->

@endsection
@section('page-script')
    <script type="text/javascript">
        $('#newPromotionalCodeForm').validate();

         // this identifies your website in the createToken call below
        Stripe.setPublishableKey('pk_test_SmAnlteapf3AWlPA97uWiB5A');//Testing Publishable Key

        function stripeResponseHandler(status, response) {
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

        function vehicleInfoItem(label, value, name) {
            var html = '<div class="form-group vehicle-info"><label class="col-md-4 control-label">' + label + '</label><div class="col-md-6"><div class="form-control-static">' + value + '</div><input name="' + name + '" type="hidden" value="' + value + '"/></div></div>';
            return html
        }

        function setExpiryDate() {
            var duration = jQuery('#membership_type option:selected').attr('duration');
            var durationSplit = duration.split(' ');
            var months = durationSplit[0];
            // var monthsTimestamp = months * 30 * 24 * 60 * 60;

            var startDate = jQuery('#start-date').val();
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

            var months = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"];

            jQuery('.expiration-label').remove();
            var databaseDate = expirationDate.getFullYear() + '-' + (parseInt(expirationDate.getMonth()) + 1) + '-' + expirationDate.getDate();
            jQuery('#start-date').after('<div class="expiration-label"><input type="hidden" name="membership_expiration" value="' + databaseDate + '"><h4 class="orange-header"> This membership will expire on ' + expirationDate.getDate() + ' ' + months[parseInt(expirationDate.getMonth())] + ' ' + expirationDate.getFullYear() + '</h4></div>');
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
                var url = (reading !== '') ? 'http://portal.cartow.ie/public/user/vehicle/' + reg + '/' + reading + '/' + type : 'http://portal.cartow.ie/public/user/vehicle/' + reg;
                $.ajax({
                    // url:'https://www.vms.ie/api/valuationlookup/'+reg+'/'+reading+'/'+type+'?user=311solution&key=di-7jo21rt2589&output=json',
                    url: url,
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

            $("#customer-form").submit(function (event) {
                if ($(this).attr('logged-in') === 'master') {
                    // disable the submit button to prevent repeated clicks
                    $('.submit-button').attr("disabled", "disabled");

                    // createToken returns immediately - the supplied callback submits the form if there are no errors
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                    return false; // submit from callback
                }
            });

            var today = new Date();
            var year = today.getFullYear();
            var month = parseInt(today.getMonth()) + 1;
            month = (month < 10) ? '0' + month : month;
            var date = parseInt(today.getDate()) + 3;
            date = (date < 10) ? '0' + date : date;

            jQuery('#start-date').val(year + '-' + month + '-' + date);
            jQuery('#start-date').attr('min', year + '-' + month + '-' + date);

            if (jQuery('#start-date').val() !== '' && typeof jQuery('#start-date').val() !== 'undefined')
                setExpiryDate();

            jQuery('#start-date').on('change', function () {
                if (jQuery('#start-date').val() !== '' && typeof jQuery('#start-date').val() !== 'undefined')
                    setExpiryDate();
                else {
                    jQuery('.expiration-label').remove();
                }

            });

            jQuery('#membership_type').on('change', function () {
                if (jQuery('#start-date').val() !== '' && typeof jQuery('#start-date').val() !== 'undefined')
                    setExpiryDate();
                else {
                    jQuery('.expiration-label').remove();
                }

            });

            // jQuery('#start-date').datepicker({
            //     onSelect: function(dateText, inst) {
            //         var date = $(this).val();
            //         var time = $('#time').val();
            //         alert('on select triggered');
            //         $("#start").val(date + time.toString(' HH:mm').toString());
            //         alert(dateText);

            //     }
            // })
        });
    </script>
@stop