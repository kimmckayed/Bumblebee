@extends('demoapp')
@section('page-style')
    <link href="{{ asset('css/customer-edit.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .progress {
            background-color: #D5D5D5 !important;
            margin-bottom: 0 !important;
            min-width: 100px;
        }
        .progress-bar {
            background-color: #FF661B !important;
        }
        tr {
            text-align: center;
            vertical-align: center;
        }
        table.table {
            margin-bottom: 10px;
        }
        table.table thead tr th {
            text-align: center;
        }
        .cr-vr {
            font-weight: 600;
        }
        .loc {
            cursor: help;
        }
    </style>
@endsection
@section('tab')
    @if(isset($message))
        <!-- BEGIN PAGE HEAD -->
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1 class="orange-header">Services in progress</h1>
            </div>
            <!-- END PAGE TITLE -->
        </div>
        <!-- END PAGE HEAD -->
        {!! $message !!}
    @endif

    <!-- BEGIN PAGE HEAD -->
    <div class="page-head">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title pull-left">
            <h1 class="orange-header">Services in progress</h1>
        </div>
        <!-- END PAGE TITLE -->
        <p id="clock" style="font-weight: bold; font-size: 18px" class="pull-right orange-header"></p>
        <span style="clear: both"></span>
        <br/><br/>
    </div>

    @if(count($services)>0)
    <br/>
    <div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <!--<th>Bringg ID</th>-->
                <th>CarTow Rep</th>
                <th>Status</th>
                <th>Due by</th>
                <th>Live ETA</th>
                <th>Progress</th>
                <th>Notes</th>
                <th>Vehicle Reg</th>
                <th>Service Type</th>
                <!--<th>Title</th>-->
                <!--<th>Created at</th>-->
                <th>Driver</th>
                <th>Location</th>
                <th>Destination</th>
            </tr>
        </thead>
        <tbody>
        @foreach($services as $service)
            <tr
                @if($service['row_color'] != '')
                    style="color: {{$service['row_color']}}"
                @endif
                @if($service['id'] != null)
                    class='click-row' data-href='{{url('nonmember/edit/service')}}?show={{$service['id']}}'
                @endif
            >
                <!--<td>
                    <a href="{{url('nonmember/edit/service?show=')}}">{{$service['bringg_id']}}</a>
                </td>-->
                <td class="cr-vr">{{$service['cartow_rep']}}</td>
                <td>
                    @if($service['status'] != 'N/A')
                        <img src="{{$service['status']}}" style="max-width: 100%; display: block; margin: 0 auto;"/>
                    @else
                        N/A
                    @endif
                </td>
                <td>{{$service['due_by']}}</td>
                <td>{{$service['live_eta']}}</td>
                <td>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="{{$service['progress']}}"
                             aria-valuemin="0" aria-valuemax="100"
                             style="width:{{$service['progress']}}%;">
                            <span class="sr-only">{{$service['progress']}}%</span>
                        </div>
                    </div>
                </td>
                <td>
                    <img src="{{$service['note']}}" style="max-width: 100%; display: block; margin: 0 auto;"/>
                </td>
                <td class="cr-vr">{{$service['vehicle_reg']}}</td>
                <td>{{$service['service_type']}}</td>
                <!--<td>
                    <span title="{{$service['title']}}">{{str_limit($service['title'],25)}}</span>
                </td>-->
                <!--<td>{{$service['created_at']}}</td>-->
                <td>{{$service['driver']}}</td>
                <td>
                    <!--<span title="{{$service['location']}}">{{str_limit($service['location'],25)}}</span>-->
                    <span class="loc" title="{{$service['location']}}">{{$service['loc']}}</span>
                </td>
                <td>
                    <!--<span title="{{$service['destination']}}">{{str_limit($service['destination'],25)}}</span>-->
                    @if($service['destination'] != 'N/A')
                    <span class="loc" title="{{$service['destination']}}">{{$service['des']}}</span>
                    @else
                    N/A
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
    @else
        <h1>There are currently no open services</h1>
    @endif

    <div>
        <!--<h3 class="orange-header" style="margin-top: 0; font-weight: 400">Status legend</h3>-->
        <span>
            <img src="{{url(asset('images/task-icons/0.png'))}}" /> Created / Not assigned
        </span>
        &nbsp;&nbsp;
        <span>
            <img src="{{url(asset('images/task-icons/1.png'))}}" /> Assigned / Accepted
        </span>
        &nbsp;&nbsp;
        <span>
            <img src="{{url(asset('images/task-icons/2.png'))}}" /> On the way (Driving)
        </span>
        &nbsp;&nbsp;
        <span>
            <img src="{{url(asset('images/task-icons/3.png'))}}" /> Checked in
        </span>
        &nbsp;&nbsp;
        <span>
            <img src="{{url(asset('images/task-icons/4.png'))}}" /> Done
        </span>
        &nbsp;&nbsp;
        <span>
            <img src="{{url(asset('images/task-icons/7.png'))}}" /> Cancelled
        </span>
    </div>

    @if(count($open_services)>0)
        <div class="page-head">
            <div class="page-title">
                <h1 class="orange-header">Job Closures</h1>
            </div>
        </div>
        <!--<h3 style="margin-top: 0" class="orange-header">Job Closures</h3>-->
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <!--<th>Bringg ID</th>-->
                    <th>Cartow Rep</th>
                    <th>Status</th>
                    <th>Due by</th>
                    <th>Live ETA</th>
                    <th>Progress</th>
                    <th>Notes</th>
                    <th>Vehicle Reg</th>
                    <th>Service Type</th>
                    <!--<th>Title</th>-->
                    <!--<th>Created at</th>-->
                    <th>Driver</th>
                    <th>Location</th>
                    <th>Destination</th>
                </tr>
                </thead>
                <tbody>
                @foreach($open_services as $service)
                    <tr
                        @if($service['row_color'] != '')
                        style="color: {{$service['row_color']}}"
                        @endif
                        class='click-row' data-href='{{url('nonmember/edit/service')}}?show={{$service['id']}}'>
                    <!--<td>
                    <a href="{{url('nonmember/edit/service?show=')}}">{{$service['bringg_id']}}</a>
                    </td>-->
                        <td class="cr-vr">{{$service['cartow_rep']}}</td>
                        <td>
                            @if($service['status'] != 'N/A')
                                <img src="{{$service['status']}}" style="max-width: 100%; display: block; margin: 0 auto;"/>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{$service['due_by']}}</td>
                        <td>{{$service['live_eta']}}</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="{{$service['progress']}}"
                                     aria-valuemin="0" aria-valuemax="100"
                                     style="width:{{$service['progress']}}%;">
                                    <span class="sr-only">{{$service['progress']}}%</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <img src="{{$service['note']}}" style="max-width: 100%; display: block; margin: 0 auto;"/>
                        </td>
                        <td class="cr-vr">{{$service['vehicle_reg']}}</td>
                        <td>{{$service['service_type']}}</td>
                        <!--<td>
                            <span title="{{$service['title']}}">{{str_limit($service['title'],25)}}</span>
                        </td>-->
                        <!--<td>{{$service['created_at']}}</td>-->
                        <td>{{$service['driver']}}</td>
                        <td>
                        <!--<span title="{{$service['location']}}">{{str_limit($service['location'],25)}}</span>-->
                            <span class="loc" title="{{$service['location']}}">{{$service['loc']}}</span>
                        </td>
                        <td>
                        <!--<span title="{{$service['destination']}}">{{str_limit($service['destination'],25)}}</span>-->
                            @if($service['destination'] != 'N/A')
                                <span class="loc" title="{{$service['destination']}}">{{$service['des']}}</span>
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

@endsection
@section('fast-page-script')
    <script>
        $(document).ready(function(){
            //Clock display
            setInterval(function(){myClock();}, 1000);
            function myClock() {
                //var d = new Date();
                //document.getElementById("clock").innerHTML = d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
                document.getElementById("clock").innerHTML = moment().format('H:mm:ss');
            }
            //service rows link to single view
            /*$(".clickable-row").click(function() {
                window.open($(this).data("href"));
            });*/
            /*$(".click-row").click(function() {
                window.location.href = $(this).data("href");
            });*/

            //refresh page on interval
            setInterval(function(){window.location.reload()}, 60000);
        });
        //grid_list.find('td:last-child').addClass('hidden');
    </script>
@endsection