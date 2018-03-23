@extends('masterapp')

@section('tab')
    @if(isset($grid))
            <!-- BEGIN PAGE HEAD -->
    <div class="page-head">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1 class="orange-header">
               Company agents
            </h1>
        </div>
        <!-- END PAGE TITLE -->
    </div>
    <br/>
    <a href="{{ url('/user/register/agent') }}" class="btn btn-primary form-btn pull-left">
        Add agent
    </a>
    {!! $grid !!}
    @else
    @endif
@endsection