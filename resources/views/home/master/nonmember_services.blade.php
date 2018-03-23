@extends('masterapp')

@section('page-style')
    <link href="{{ asset('css/customer-edit.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        #editEntity .col-sm-10 {
            height: inherit !important;
        }
        .form{
            width: 100% !important;
        }
        form.form .form-control{
            width: 100%;
        }
        #editEntity i[class^="icon-"],
        #editEntity i[class*="icon-"] {
            color: #FF661B;
        }
        .quote-table tr,
        .quote-table td {
            padding-right: 10px;
            padding-left: 10px;
        }
        .quote-table .main {
            font-size: 16px;
            color: #FF661B;
            font-weight: 400;
        }
        .quote-table .sub {
            font-size: 14px;
        }
        .quote-table .sub.lbl {
            color: #FF661B;
        }
        @media(min-width: 768px) {
            #editEntity div#fields .form-group {
                overflow: hidden;
            }

            #editEntity div#fields .form-group [class*="col-"] {
                margin-bottom: -999px;
                padding-bottom: 999px;
            }
            span#complete {
                padding: 6px 13px;
            }
        }
        @media only screen and (min-width : 768px) {
            .is-table-row {
                display: table;
            }
            .is-table-row [class*="col-"]:not(.no-table) {
                float: none;
                display: table-cell;
                vertical-align: top;
            }
        }
    </style>
@endsection

@section('tab')
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    @if(isset($grid))
        @if(!isset($message))
            <!-- BEGIN PAGE HEAD -->
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1 class="orange-header">
                       Non member services
                    </h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>
            <!-- END PAGE HEAD -->
            <div id="manageTasksFilter">
                {!! $filter !!}
            </div>
            <br/>
            <a href="{{ url('nonmember/service') }}" class="btn btn-primary form-btn pull-left">
                Add service
            </a>
            {!! $grid !!}
        @else
            <!-- BEGIN PAGE HEAD -->
            <div class="page-head">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1 class="orange-header">
                        Non member services
                    </h1>
                </div>
                <!-- END PAGE TITLE -->
            </div>
            <!-- END PAGE HEAD -->

            {!! $message !!}
        @endif
    @elseif(isset($non_member_service))
        <div class="page-title">
            <h1 class="orange-header">
                View service
            </h1>
        </div>

        <div id="editEntity" class="form-horizontal">
            <div class="form">
                <!-- Toolbar -->
                <div class="btn-toolbar" role="toolbar">
                    <div class="pull-right">
                        <a href="{{url('nonmember/attachments').'/'.$non_member_service->id}}"
                           class="btn btn-default" target="_blank">View attachments</a>
                        &nbsp;&nbsp;
                        @if($non_member_service->status == 'open')
                            <a href="{{url('nonmember/complete/')}}/{{$non_member_service->id}}" class="btn btn-default btn-complete">Complete Service</a>
                        @else
                            <span style="color:#0BCCBB; text-transform: uppercase">Completed</span>
                        @endif
                    </div>
                </div>
                <!-- Fields start -->
                <div id="fields">
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12 control-label">Vehicle Reg</label>
                    <div class="col-sm-10 col-xs-12">
                        {{$non_member_service->vehicle_reg}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12 control-label">Bringg order ID</label>
                    <div class="col-sm-10 col-xs-12">
                        {{($non_member_service->bringg_id)? $non_member_service->bringg_id : 'N/A'}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12 control-label">Added by</label>
                    <div class="col-sm-10 col-xs-12">
                        {{($non_member_service->added_by != null)? $non_member_service->added_by : 'N/A'}}
                    </div>
                </div>
                @if($non_member_service->status == 'complete')
                    <div class="form-group">
                        <label class="col-sm-2 col-xs-12 control-label">Completed by</label>
                        <div class="col-sm-10 col-xs-12">
                            {{($non_member_service->completed_by != null)? $non_member_service->completed_by : 'N/A'}}
                        </div>
                    </div>
                @endif
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12 control-label">Service Type</label>
                    <div class="col-sm-10 col-xs-12">
                        {{$non_member_service->service->type}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12 control-label">Recovery Driver</label>
                    <div class="col-sm-10 col-xs-12">
                        {{$non_member_service->recovery_driver}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12 control-label">Job created at time</label>
                    <div class="col-sm-10 col-xs-12">
                        {{$non_member_service->job_created_time}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12 control-label">Started at time</label>
                    <div class="col-sm-10 col-xs-12">
                        {{$non_member_service->started_at_time}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12 control-label">Arrival time</label>
                    <div class="col-sm-10 col-xs-12">
                        {{$non_member_service->arrival_time}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12 control-label">Due By</label>
                    <div class="col-sm-10 col-xs-12">
                        {{($non_member_service->due_time != null)? $non_member_service->due_time : 'N/A'}}
                        &nbsp;&nbsp;
                        <button type="button" id="eta-form-show" class="btn btn-default" style="margin-bottom: 5px">Add ETA</button>
                        <form id="eta-form" style="display: none; width: auto; border: none; margin-bottom: 5px" class="form-inline" method="post" action="{{url('nonmember/addeta')}}">
                            <input type="hidden" name="id" value="{{$non_member_service->id}}"/>
                            <select class="form-control" name="extra_eta" required>
                                <option value="">Extra ETA</option>
                                <option value="30">30 minutes</option>
                                <option value="45">45 minutes</option>
                                <option value="60">60 minutes</option>
                                <option value="90">90 minutes</option>
                            </select>
                            <button class="btn btn-default" type="submit">Add ETA</button>
                            <button class="btn" type="button" id="eta-form-hide">Cancel</button>
                        </form>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12 control-label">Location</label>
                    <div class="col-sm-10 col-xs-12">
                        {{$non_member_service->location}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12 control-label">Destination</label>
                    <div class="col-sm-10 col-xs-12">
                        {{$non_member_service->destination}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12 control-label">Driver's Notes</label>
                    <div class="col-sm-10 col-xs-12">
                        {{$non_member_service->driver_notes}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-12 control-label">To pay</label>
                    <div class="col-sm-10 col-xs-12">
                        {{$non_member_service->to_pay}}
                        @if($non_member_service->to_pay == 'Override')
                            ({{$non_member_service->override_reason}})
                        @endif
                    </div>
                </div>
                @if(!empty($non_member_service->notes))
                    <!-- Notes -->
                    <div class="form-group">
                        <label class="col-sm-2 col-xs-12 control-label">Service Comments</label>
                        <div class="col-sm-10 col-xs-12">
                        @foreach($non_member_service->notes as $key=>$note)
                            {{$key+1}}) '{{$note['note']}}' -{{$note['by']}} ({{$note['time']}})<br/>
                        @endforeach
                        </div>
                    </div>
                @endif
                @if(!empty($non_member_service->cc_comments))
                <!-- Call Centre comments -->
                    <div class="form-group">
                        <label class="col-sm-2 col-xs-12 control-label">Call centre Comments</label>
                        <div class="col-sm-10 col-xs-12">
                            @foreach($non_member_service->cc_comments as $key=>$comment)
                                {{$key+1}}) '{{$comment['comment']}}' - {{$comment['added_by']}} ({{date('j M,Y H:i A',strtotime($comment['created_at']))}})<br/>
                            @endforeach
                        </div>
                    </div>
                @endif
                </div>
                <!-- Fields end -->
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-xs-12" data-mh="height-group">
                <!-- Add Call centre comment form -->
                <div class="page-title">
                    <h3 class="orange-header">
                        Add a call centre comment
                    </h3>
                </div>
                <form class="form form-horizontal match-height" method="post"
                      action="{{url('nonmember/comment')}}">
                    <input type="hidden" name="service_id" value="{{$non_member_service->id}}"/>
                    <div class="form-group">
                        <label for="comment" class="col-sm-4 col-xs-12 control-label">Comment</label>
                        <div class="col-sm-8 col-xs-12">
                            <textarea id="comment" name="comment" class="form-control" required></textarea>
                            <br/>
                            <button class="btn btn-default" role="submit">Add comment</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-6 col-xs-12" data-mh="height-group">
                <div class="page-title">
                    <h3 class="orange-header">
                        Quote details
                    </h3>
                </div>
                <div class="form match-height">
                    @if($non_member_service->quote != null)
                    <table class="quote-table">
                        <tr>
                            <td><span class="main">Extra mileage:</span></td>
                        </tr>
                        <tr>
                            <td><span class="sub lbl">Total Distance</span></td>
                            <td><span class="sub">{{$non_member_service->quote->total_distance}}</span></td>
                        </tr>
                        <tr>
                            <td><span class="sub lbl">Cost</span></td>
                            <td><span class="sub">{{explode(' ',$non_member_service->quote->extra_distance)[1]}}</span></td>
                        </tr>
                        <tr>
                            <td><span class="sub lbl">Tax</span></td>
                            <td><span class="sub">{{$non_member_service->quote->extra_distance_tax}}</span></td>
                        </tr>
                        @if($non_member_service->quote->tolls != '' && $non_member_service->quote->tolls != null)
                            <tr>
                                <td><span class="main">Tolls:</span></td>
                            </tr>
                            @foreach(explode(',',$non_member_service->quote->tolls) as $toll)
                                <tr>
                                    <td><span class="sub lbl">{{explode(':',$toll)[0]}}</span></td>
                                    <td><span class="sub">{{explode(':',$toll)[1]}}</span></td>
                                </tr>
                            @endforeach
                        @endif
                        <tr>
                            <td><span class="main">Total Quote</span></td>
                            <td><span class="main">{{$non_member_service->quote->total}}</span></td>
                        </tr>
                    </table>
                    @else
                        <p>No quote found for this service</p>
                    @endif
                </div>
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
    <script src="{{ asset('js/jquery.matchHeight.js') }}" type="text/javascript"></script>
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
            $('.match-height').matchHeight({
                byRow: false
            });
            $('#eta-form-show').on('click',function(){
                $('#eta-form').css('display','inline-block');
                $('#eta-form-show').css('display','none');
            });
            $('#eta-form-hide').on('click',function(){
                $('#eta-form').css('display','none');
                $('#eta-form-show').css('display','inline-block');
            });
            /*$.ajax({
                url: url,
                async: true,
                dataType: "json",
                contentType: "application/json; charset=UTF-8"
            }).done(function (response) {
                console.log('vehicle ids retrieved');
                vehicleIDs = response;

                $('#manageTasksFilter #vehicle_reg').typeahead({
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
            $('#manageTasksFilter #vehicle_reg').attr('autocomplete','off')
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