@extends('masterapp')

@section('page-style')
    <link href="{{ asset('css/customer-edit.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        #editEntity .col-sm-10{
            height: inherit !important;
        }
        form[method="POST"], .form{
            width: 100% !important;
        }
        #editEntity i[class^="icon-"],
        #editEntity i[class*="icon-"] {
            color: #FF661B;
        }
    </style>
@endsection

@section('tab')
    @if(isset($grid))
        @if(!isset($message))
            <!-- BEGIN PAGE HEAD -->
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1 class="orange-header">
                       Member services
                    </h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>
            <!-- END PAGE HEAD -->
            @if(isset($filter))
            <div id="manageTasksFilter">
                {!! $filter !!}
            </div>
            @endif
            <br/>
            <!--<a href="{{ url('user/services') }}" class="btn btn-primary form-btn pull-left">
                Add service
            </a>-->
            {!! $grid !!}
        @else
            <!-- BEGIN PAGE HEAD -->
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1 class="orange-header">
                        Member services
                    </h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>
            <!-- END PAGE HEAD -->

            {!! $message !!}
        @endif
    @elseif(isset($member_service))
        <div class="page-title">
            <h1 class="orange-header">
                View service
            </h1>
        </div>

        <div id="editEntity" class="form-horizontal">
            <div class="form">
                <!-- Fields start -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Vehicle Reg</label>
                    <div class="col-sm-10">
                        {{$member_service->customer->vehicle_registration}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Bringg order ID</label>
                    <div class="col-sm-10">
                        {{($member_service->bringg_id)? $member_service->bringg_id : 'N/A'}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Added by</label>
                    <div class="col-sm-10">
                        {{($member_service->added_by != null)? $member_service->added_by : 'N/A'}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Service Type</label>
                    <div class="col-sm-10">
                        {{$member_service->services->type}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Recovery Driver</label>
                    <div class="col-sm-10">
                        {{$member_service->recovery_driver}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Job created at time</label>
                    <div class="col-sm-10">
                        {{$member_service->job_created_time}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Started at time</label>
                    <div class="col-sm-10">
                        {{$member_service->started_at_time}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Arrival time</label>
                    <div class="col-sm-10">
                        {{$member_service->arrival_time}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Driver's Notes</label>
                    <div class="col-sm-10">
                        {{$member_service->driver_notes}}
                    </div>
                </div>
                @if(!empty($member_service->notes))
                    <!-- Notes -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Comments</label>
                        <div class="col-sm-10">
                            @foreach($member_service->notes as $key=>$note)
                                {{$key+1}}) '{{$note['note']}}' -{{$note['by']}} ({{$note['time']}})<br/>
                            @endforeach
                        </div>
                    </div>
                @endif
                <!-- Fields end -->
                @if(!empty($member_service->attachments))
                <!-- Attachments -->
                <div class="page-title">
                    <h3 class="orange-header">
                        Attachments
                    </h3>
                </div>
                <div class="form-group">
                    <div class="row">
                    @foreach($member_service->attachments as $key=>$attachment)
                        @if($key!=0 && $key%2 == 0)
                            </div>
                            <div class="row">
                        @endif
                        <div class="col-sm-6 col-xs-12"
                             style="margin-top:5px; margin-bottom: 5px;">
                            <div class="col-sm-12" style="background-color: #efefef; border-radius: 15px; ">
                                <h4><i class="
                                        @if($attachment['type']=='TaskPhoto')
                                        icon-camera
                                        @elseif($attachment['type']=='Signature')
                                        icon-pencil
                                        @endif
                                    "></i> by {{$attachment['by']}}</h4>
                                <a href="{{$attachment['url']}}" target="_blank">
                                    <img src="{{$attachment['url']}}"
                                         style="max-width: 100%; max-height: 250px; display: block; margin: 0 auto;" />
                                </a>
                                <br/>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    @endif
    @if(isset($edit))
        <!-- BEGIN PAGE HEAD -->
        <div class="page-head">
            @include('layouts.form_errors')
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1 class="orange-header">
                    View service
                </h1>
            </div>
            <!-- END PAGE TITLE -->
        </div>
        <!-- END PAGE HEAD -->
        <div id="editEntity"  class="saveBtnFix">
            {!! $edit !!}
        </div>
    @endif
    <!-- END PAGE CONTENT INNER -->
@endsection
@section('fast-page-script')
    <script>
        /*grid_list.find('td:last-child').addClass('hidden');*/
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
            /*$.ajax({
                url: url,
                async: true,
                dataType: "json",
                contentType: "application/json; charset=UTF-8"
            }).done(function (response) {
                console.log('vehicle ids retrieved');
                vehicleIDs = response;

                $('#manageTasksFilter #customer_vehicle_registration').typeahead({
                    hint: true,
                    highlight: true,
                    minLength: 2
                },
                {
                    name: 'vehicleIDs',
                    source: substringMatcher(vehicleIDs)
                });
            }).fail(function (xhr, textStatus, errorThrown) {
                console.log('fail');
            });*/
            $('#manageTasksFilter #customer_vehicle_registration').attr('autocomplete','off')
        });
        
        //jQuery.validator.addMethod("myEmail", function (value, element) {
        //    return this.optional(element) || ( /^[a-zA-Z0-9]+([-._][a-zA-Z0-9]+)*@([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*\.)+[a-z]{2,4}$/.test(value) && /^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/.test(value) );
        //}, 'Please enter a valid email address.');
        /*$('#memberEditForm').validate({
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
         });*/
    </script>
@endsection