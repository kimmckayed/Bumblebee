@extends('masterapp')

@section('page-style')
    <link href="{{ asset('css/customer-edit.css') }}" rel="stylesheet" type="text/css"/>

@endsection
@section('tab')
        <!-- BEGIN PAGE HEAD -->
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1 class="orange-header">Delete Fleet</h1>
            </div>
            <!-- END PAGE TITLE -->
        </div>
        <!-- END PAGE HEAD -->
        <div id="editEntity"  class="saveBtnFix">
            @if($fleet != null)
            <form id="deleteFleet" method="POST" action="{{url('fleet/delete')}}/{{$fleet->id}}">
                <h2>Warning</h2>
                <h3>This action will completely delete the fleet '{{$fleet->name}}'and all its customers</h3>
                <a href="{{url('fleet/members')}}?fleetMember_fleet_id={{$fleet->id}}" class="btn btn-info">View customers</a>
                <br/> <br/>
                <input type="submit" value="Delete" class="btn btn-danger">
                <a href="{{url('fleet')}}" class="btn btn-primary">Return to fleets</a>
            </form>
            @else
                <h3>No fleet was found with this ID</h3>
                <a href="{{url('fleet')}}" class="btn btn-primary">Return to fleets</a>
            @endif
        </div>
        <!-- END PAGE CONTENT INNER -->
@endsection