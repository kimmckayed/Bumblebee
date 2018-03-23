<div class="page-sidebar navbar-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
        <li class="start">
            <a href="{{ url('dashboard') }}">
                <i class="icon-globe"></i>
                <span class="title">Dashboard</span>
            </a>
        </li>
        @if(((new App\Managers\AuthManager())->isAnyRole(['master','finance'])))
            {{--  <li>
                  <a href="{{ asset('/home/usermanagement') }}">
                      <i class="icon-users"></i>
                      <span class="title">User Management</span>
                  </a>
              </li>--}}
            {{--<li>
                <a href="{{ asset('/home/company') }}">
                    <i class="icon-home"></i>
                    <span class="title">Companies</span>
                </a>
            </li>--}}
            <li>
                <a>
                    <i class="icon-home"></i>
                    <span class="title">Companies</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ asset('/home/company') }}">
                            <i class="icon-home"></i>
                            <span class="title">Companies</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ asset('/client-company') }}">
                            <i class="icon-home"></i>
                            <span class="title">Client Companies</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ asset('/tax') }}">
                            <i class="icon-calculator"></i>
                            <span class="title">Taxes</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ asset('/toll') }}">
                            <i class="icon-calculator"></i>
                            <span class="title">Tolls</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
        @if(((new App\Managers\AuthManager())->isAnyRole(['master','finance','company_master'])))
            <li>
                <a href="{{ asset('/home/agent') }}">
                    <i class="icon-briefcase"></i>
                    <span class="title">
                        @if(((new App\Managers\AuthManager())->isAnyRole(['master','finance'])))
                        Cartow.ie staff
                        @else
                        Agents
                        @endif

                    </span>
                </a>
                
            </li>

        @endif
        @if(((new App\Managers\AuthManager())->hasAccess(['view.members.all'])))
            <li>
                @if(((new App\Managers\AuthManager())->hasAccess(['view.members.new'])))
                    <a>
                        <i class="icon-user"></i>
                        <span class="title">Members</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{ url('/home/customer') }}">
                                <i class="icon-list"></i>
                                <span class="title">List members</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('home/new-memberships') }}">
                                <i class="icon-user-follow"></i>
                                <span class="title">New members</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/home/trial-customer') }}">
                                <i class="icon-calendar"></i>
                                <span class="title">Trial members</span>
                            </a>
                        </li>
                        <!--
                        <li>
                            <a href="{{ url('/user/register/customer') }}">
                                <span class="orange-header">-</span> Add Members
                            </a>
                        </li>
                         -->
                        <li>
                            <a href="{{ url('/home/services') }}">
                                <i class="icon-wrench"></i>
                                <span class="title">Previous services</span>
                            </a>
                        </li>
                    </ul>
                @else
                    <!--<a  href="{{ url('/home/customer') }}">
                        <i class="icon-user"></i>
                        <span class="title">Members</span>

                    </a>-->
                @endif
            </li>
            <!-- fleet -->
            <li>
                @if(((new App\Managers\AuthManager())->hasAccess(['view.members.new'])))
                    <a>
                        <i class="icon-layers"></i>
                        <span class="title">Fleets</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{ url('/fleet/add') }}">
                                <i class="icon-plus"></i>
                                <span class="title">Add a Fleet</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/fleet/add') }}?update=1">
                                <i class="icon-refresh"></i>
                                <span class="title">Update a Fleet</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/fleet') }}">
                                <i class="icon-layers"></i>
                                <span class="title">Manage Fleets</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/fleet/members') }}">
                                <i class="icon-user"></i>
                                <span class="title">View Fleet Members</span>
                            </a>
                        </li>
                    </ul>
                @else
                    <!--<a href="{{ url('/fleet') }}">
                        <i class="icon-layers"></i>
                        <span class="title">Fleets</span>
                    </a>-->
                @endif
            </li>
        @endif
        @if(((new App\Managers\AuthManager())->isRole('master')))
            <li>
                <a>
                    <i class="icon-wrench"></i>
                    <span class="title">Non member services</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li>
                        <a href="{{ asset('/nonmember/service') }}">
                            <i class="icon-plus"></i>
                            <span class="title">Add service</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ asset('/nonmember') }}">
                            <i class="icon-list"></i>
                            <span class="title">Previous services</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ asset('/services/open') }}">
                    <i class="icon-control-play"></i>
                    <span class="title">Services in progress</span>
                </a>
            </li>
        @elseif(((new App\Managers\AuthManager())->isRole('customer_service')))
            <li>
                <a href="{{ asset('/search/member') }}">
                    <i class="icon-magnifier"></i><i class="icon-user"></i>
                    <span class="title">Member search</span>
                </a>
            </li>
            <li>
                <a href="{{ asset('/search/services') }}">
                    <i class="icon-magnifier"></i><i class="icon-wrench"></i>
                    <span class="title">Services search</span>
                </a>
            </li>
            <li>
                <a href="{{ asset('/nonmember/service') }}">
                    <i class="icon-wrench"></i>
                    <span class="title">Add non member service</span>
                </a>
            </li>
            <li>
                <a href="{{ asset('/services/open') }}">
                    <i class="icon-control-play"></i>
                    <span class="title">Services in progress</span>
                </a>
            </li>
        @elseif(((new App\Managers\AuthManager())->isRole('service_company')))
            <li>
                <a href="{{ asset('/nonmember/service') }}">
                    <i class="icon-wrench"></i>
                    <span class="title">Add service order</span>
                </a>
            </li>
        @endif
        @if(((new App\Managers\AuthManager())->hasAnyAccess(['billing'])))
            <li>
                <a href="{{ asset('/invoicing') }}">
                    <i class="fa fa-money icon-"></i>
                    <span class="title">&nbsp;Invoices</span>
                </a>
            </li>
        @endif
        @if(((new App\Managers\AuthManager())->hasAnyAccess(['reports.*'])))

            <li>
                <a href="{{ asset('/reports/agents-activities') }}">
                    <i class="icon-docs"></i>
                    <span class="title">System log</span>
                </a>
            </li>
        @endif
        @if(((new App\Managers\AuthManager())->isAnyRole(['master','finance'])))
            <li>
                <a href="{{ asset('/home/memberships') }}">
                    <i class="icon-list"></i>
                    <span class="title">Memberships</span>
                </a>
            </li>
            <li>
                <a href="{{ asset('/home/promotional-codes') }}">
                    <i class="icon-star"></i>
                    <span class="title">Promotional Codes</span>
                </a>
            </li>
        @endif
        @if(((new App\Managers\AuthManager())->isAnyRole(['master','finance'])))
            <li>
                <a href="{{ asset('/home/settings') }}">
                    <i class="icon-settings"></i>
                    <span class="title">Settings</span>
                </a>
            </li>
        @endif
        @if(Session::has('force_login_switch_me_back') )

            <li>
                <a href="{{ asset('/user/force-login-back') }}">
                    <i class="icon-logout"></i>
                    <span class="title">Switch Back</span>
                </a>
            </li>

        @endif
        <li>
            <a href="{{ asset('/auth/logout') }}">
                <i class="icon-logout"></i>
                <span class="title">Log out</span>
            </a>
        </li>
    </ul>
    <!-- END SIDEBAR MENU -->
</div>