@extends('masterapp')

@section('tab')
    <!--
    @if(((new App\Managers\AuthManager())->hasAnyAccess(['reports.memberships'])))
        <a class="col-lg-3 col-md-3 col-sm-6 col-xs-12" href="{{ url('/home/new-memberships') }}">
            <div class="dashboard-stat2">
                <div class="display">
                    <div class="number">
                        <h3 class="font-green-sharp">{{ $number_of_new_memberships }}</h3>
                        <small>NEW MEMBERSHIPS</small>
                    </div>
                    <div class="icon">
                        <i class="icon-like"></i>
                    </div>
                </div>
            </div>
        </a>
    @endif
            -->
    @if(((new App\Managers\AuthManager())->hasAnyAccess(['reports.agents_activities'])))
        <a class="col-lg-3 col-md-3 col-sm-6 col-xs-12" href="{{ url('/reports/agents-activities') }}">
            <div class="dashboard-stat2">
                <div class="display">
                    <div class="number">
                        <h3 class="font-green-sharp">Audit manager</h3>
                        <small>User activity tracking</small>
                    </div>
                    <div class="icon">
                        <i class="icon-user-female"></i>
                    </div>
                </div>
            </div>
        </a>
        @endif
                <!-- END PAGE CONTENT INNER -->
@endsection