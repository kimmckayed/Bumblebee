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

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div>
                <div class="panel panel-default" style="margin-top: 20px;">
                    <div class="panel-body">
                        <h2 class="orange-header">Services search</h2>
                        <form class="form-horizontal" method="post" action="{{url('search/services')}}" style="border: 0;">
                        <label for="vehicle_reg">Vehicle registration</label>
                        <br/>
                        <input id="vehicle_reg" name="vehicle_reg" class="form-control">
                        <br/>
                        <button id="search" type="submit" class="btn btn-default">Search</button>
                        </form>
                        <br/>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @if(isset($grid) && $grid!=null)
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
            @endif
        </div>
        <div class="row">
            @if(isset($services))
                <div class="page-head">
                    <div class="page-title">
                        <h1 class="orange-header">
                            Member services
                        </h1>
                    </div>
                </div>
                @foreach($services as $service)
                    <div id="editEntity" class="form-horizontal">
                        <div class="form">
                            <!-- Fields start -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Vehicle Reg</label>
                                <div class="col-sm-10">
                                    {{$service->customer->vehicle_registration}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Bringg order ID</label>
                                <div class="col-sm-10">
                                    {{($service->bringg_id)? $service->bringg_id : 'N/A'}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Service Type</label>
                                <div class="col-sm-10">
                                    {{$service->services->type}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Recovery Driver</label>
                                <div class="col-sm-10">
                                    {{$service->recovery_driver}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Driver's Notes</label>
                                <div class="col-sm-10">
                                    {{$service->driver_notes}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Job created at time</label>
                                <div class="col-sm-10">
                                    {{$service->job_created_time}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Started at time</label>
                                <div class="col-sm-10">
                                    {{$service->started_at_time}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Arrival time</label>
                                <div class="col-sm-10">
                                    {{$service->arrival_time}}
                                </div>
                            </div>
                            @if(!empty($service->notes))
                                <!-- Notes -->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Comments</label>
                                    <div class="col-sm-10">
                                        @foreach($service->notes as $key=>$note)
                                            {{$key+1}}) '{{$note['note']}}' -{{$note['by']}} ({{$note['time']}})<br/>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <!-- Fields end -->
                            <!-- Attachments -->
                            @if(!empty($service->attachments))
                                <div class="page-title">
                                    <h3 class="orange-header">
                                        Attachments
                                    </h3>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        @foreach($service->attachments as $key=>$attachment)
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
                    <br/>
                @endforeach
            @endif
            @if(isset($nonmember_services))
                <div class="page-head">
                    <div class="page-title">
                        <h1 class="orange-header">
                            Non member services
                        </h1>
                    </div>
                </div>
                @foreach($nonmember_services as $service)
                    <div id="editEntity" class="form-horizontal">
                        <div class="form">
                            <!-- Fields start -->
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Vehicle Reg</label>
                                <div class="col-sm-10">
                                    {{$service->vehicle_reg}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Bringg order ID</label>
                                <div class="col-sm-10">
                                    {{($service->bringg_id)? $service->bringg_id : 'N/A'}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Service Type</label>
                                <div class="col-sm-10">
                                    {{$service->service->type}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Recovery Driver</label>
                                <div class="col-sm-10">
                                    {{$service->recovery_driver}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Driver's Notes</label>
                                <div class="col-sm-10">
                                    {{$service->driver_notes}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Job created at time</label>
                                <div class="col-sm-10">
                                    {{$service->job_created_time}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Started at time</label>
                                <div class="col-sm-10">
                                    {{$service->started_at_time}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Arrival time</label>
                                <div class="col-sm-10">
                                    {{$service->arrival_time}}
                                </div>
                            </div>
                            @if(!empty($service->notes))
                                <!-- Notes -->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Comments</label>
                                    <div class="col-sm-10">
                                        @foreach($service->notes as $key=>$note)
                                            {{$key+1}}) '{{$note['note']}}' -{{$note['by']}} ({{$note['time']}})<br/>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <!-- Fields end -->
                            <!-- Attachments -->
                            @if(!empty($service->attachments))
                                <div class="page-title">
                                    <h3 class="orange-header">
                                        Attachments
                                    </h3>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        @foreach($service->attachments as $key=>$attachment)
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
                    <br/>
                @endforeach
            @endif
        </div>
    </div>
@endsection
@section('page-script')
@endsection