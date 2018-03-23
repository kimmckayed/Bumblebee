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
                    <h1 class="orange-header">Memberships Sold
                        <small>manage Invoicing</small>
                    </h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>
            <!-- END PAGE HEAD -->
            {!! $filter !!}

            {!! $grid !!}
            <a href="{{ url('/invoicing/create/'.Input::get('company_id')) }}" class="btn btn-primary form-btn pull-right">
                Generate Invoice
            </a>
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
        {!! $edit !!}

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
        var url = config.base_url + '/user/vehicleids';
        jQuery(document).ready(function () {
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


    </script>
@endsection