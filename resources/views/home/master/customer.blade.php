@extends('masterapp')



@section('page-style')
    <link href="{{ asset('css/customer-edit.css') }}" rel="stylesheet" type="text/css"/>

@endsection
@section('tab')
            @if(isset($grid))
            @if(!isset($message))
                    <!-- BEGIN PAGE HEAD -->
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1 class="orange-header">
                       Manage members
                    </h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>
            <!-- END PAGE HEAD -->
            <div id="manageMembersFiler">
            {!! $filter !!}
            </div>
                    <!-- {!! $filter->open !!}
                    <div class="input-group custom-search-form">

                         {!! $filter->field('membership_id') !!}
            {!! $filter->field('vehicle_registration') !!}
            {!! $filter->field('expiration_date_from') !!}
            {!! $filter->field('expiration_date_to') !!}
                    </div>
                {!! $filter->close !!} -->
            <br/>
            <a href="{{ url('/user/register/customer') }}" class="btn btn-primary form-btn pull-left">
                Add Member
            </a>
            {!! $grid !!}
            @else
                    <!-- BEGIN PAGE HEAD -->
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1 class="orange-header">Members
                        <small>add memberships</small>
                    </h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>
            <!-- END PAGE HEAD -->

            {!! $message !!}

            @endif
            @endif
            @if(isset($edit))
                    <!-- BEGIN PAGE HEAD -->
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1 class="orange-header">Edit Member Accounts</h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>
            <!-- END PAGE HEAD -->
            <div id="editEntity"  class="saveBtnFix form-horizontal">
                {!! $edit !!}
            </div>
            @endif
                    <!-- END PAGE CONTENT INNER -->
@endsection
@section('fast-page-script')
    <script>
        grid_list.find('td:last-child').addClass('hidden');
    </script>
@endsection
@section('page-script')

    <script src="{{ asset('assets/datepicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/twitter-typeahead.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        var substringMatcher = function (strs) {
            return function findMatches(q, cb) {
                var matches, substringRegex;

                // an array that will be populated with substring matches
                matches = [];

                // regex used to determine if a string contains the substring `q`
                substrRegex = new RegExp(q, 'i');

                // iterate through the pool of strings and for any string that
                // contains the substring `q`, add it to the `matches` array
                $.each(strs, function (i, str) {
                    if (substrRegex.test(str)) {
                        matches.push(str);
                    }
                });

                cb(matches);
            };
        };

        var vehicleIDs = [];
        var url = config.base_url+'/user/vehicleids';
        jQuery(document).ready(function () {
            $('#start_date').prop('type', 'date');
            $.ajax({
                url: url,
                async: true,
                dataType: "json",
                contentType: "application/json; charset=UTF-8"
            }).done(function (response) {
                console.log('success');
                vehicleIDs = response;
                jQuery('.input-daterange').datepicker();
                $('#vehicle_registration').addClass('typeahead');

                $('#vehicle_registration.typeahead').typeahead({
                            hint: true,
                            highlight: true,
                            minLength: 4
                        },
                        {
                            name: 'vehicleIDs',
                            source: substringMatcher(vehicleIDs)
                        });
            }).fail(function (xhr, textStatus, errorThrown) {
                console.log('fail');
            });


        });
        
        jQuery.validator.addMethod("myEmail", function (value, element) {
            return this.optional(element) || ( /^[a-zA-Z0-9]+([-._][a-zA-Z0-9]+)*@([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*\.)+[a-z]{2,4}$/.test(value) && /^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/.test(value) );
        }, 'Please enter a valid email address.');
        $('#memberEditForm').validate({
             rules: {
                first_name: {
                    required: true
                },
                last_name: {
                    required: true
                },
                user_email: {
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
                    required: true,
                    digits: true
                },
                vehicle_registration: {
                    required: true
                },
                vehicle_make: {
                    required: true
                },
                vehicle_model: {
                    required: true
                },
                vehicle_fuel_type: {
                    required: true
                },
                vehicle_colour: {
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
@endsection