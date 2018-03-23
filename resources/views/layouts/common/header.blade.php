
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="{{url('/')}}" style="max-height: 100%;">
                @if(((new App\Managers\AuthManager())->isRole('service_company')))
                    <img src="{{ asset('assets/admin/layout4/img/mapfre-logo.jpg') }}" alt="logo" style="width: 100%; height: 100%;" class="logo-default"/>
                @else
                    <!--<img src="{{ asset('assets/admin/layout4/img/cartow-logo.png') }}" alt="logo" class="logo-default"/>-->
                        <img src="{{ asset('images/spire-logo.png') }}" style="max-width: 175px" alt="Spire Logo" class="logo-default"/>
                @endif
            </a>
            <?php
            /**
             * TODO this sis a legacy code that make sure that every account have an agent and every agent assoiated to a company
             * else it should raise the red button
             * this is a migration related flag
             */
            use App\Models\Agent;$header_company_id = Agent::where('user_id','=',Auth::user()->id)->pluck('company_id');


            ?>
                {{--


                --@if($header_company_id)

                --<span><i class="fa fa-check-circle fa-4x text-success"></i></span>
                --@else
                --<span data-tooltip="sdfasdfsad"><i class="fa fa-minus-circle fa-4x text-danger"></i></span>
                --@endif
                --}}

            <div class="menu-toggler sidebar-toggler">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->

        <!-- BEGIN PAGE TOP -->
        <div class="page-top">
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <li class="separator hide">
                    </li>
                    <!-- BEGIN NOTIFICATION DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-extended dropdown-notification dropdown-dark" id="header_notification_bar">
                        <a  class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="icon-bell"></i>
                            @if($unread > 0)
                                <span class="notification badge badge-success">
						{{ $unread }} </span>
                            @endif

                        </a>
                        <ul class="dropdown-menu">
                            <li class="external">
                                    <h3><span class="bold">{{ $unread }} pending</span> notifications</h3>

                                <!-- <a href="extra_profile.html">view all</a> -->
                            </li>
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                    <li>
                                        @foreach($notifications as $notification)
                                            <a class="notification-item" data-id="{{$notification['id']}}" style="cursor: default;">
                                                <span class="time">{{ $notification['ago'] }}</span>
											<span class="details">
											<span class="label label-sm label-icon label-success">
											<i class="fa fa-plus"></i>
											</span>
                                                {{ $notification['text'] }} </span>
                                            </a>
                                        @endforeach
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                        <!-- END TODO DROPDOWN -->
                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-user dropdown-dark">
                            <a href="{{URL::route('profile_security')}}" class="dropdown-toggle" title="Account settings"> <!--Data toggle parameters for the anchor tag : data-toggle="dropdown" data-hover="dropdown" data-close-others="true"-->
                            <span class="username username-hide-on-mobile">
                             {{(new App\Managers\AuthManager())->getUser()->first_name}} </span>
                                <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
                                <span class="settings-cog"></span>
                                <!--<img alt="" class="img-circle" src="{{ asset('images/cog-cartow.png') }}"/>-->
                            </a>
                            <!--<ul class="dropdown-menu dropdown-menu-default">
                                <li>
                                    <a>
                                        <i class="icon-briefcase"></i>   {{\App\Models\Company::whereId($header_company_id)->pluck('name')}} </a>
                                </li>
                                <li>
                                    <a href="{{url('profile/security')}}">
                                        <i class="icon-user"></i> My Profile </a>
                                </li>
                                <li>
                                    <a>
                                        <i class="icon-calendar"></i> My Calendar </a>
                                </li>
                                <li>
                                    <a>
                                        <i class="icon-envelope-open"></i> My Inbox <span class="badge badge-danger">
                                    1 </span>
                                    </a>
                                </li>
                                <li class="divider">
                                </li>
                                <li>
                                    <a href="{{ asset('/auth/logout') }}">
                                        <i class="icon-key"></i> Log Out </a>
                                </li>
                            </ul>-->
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->


                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END PAGE TOP -->
    </div>
    <!-- END HEADER INNER -->
</div>
