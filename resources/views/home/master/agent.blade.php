@extends('masterapp')
@section('page-style')
    <link href="{{ asset('css/customer-edit.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('tab')

    @if(isset($message))
        <!-- BEGIN PAGE HEAD -->
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1 class="orange-header">
                    @if(((new App\Managers\AuthManager())->isAnyRole(['master','sales','finance'])))
                        Staff
                    <small>manage staff accounts</small>
                    @else
                        Agents
                    <small>manage agent accounts</small>
                    @endif
                </h1>
            </div>
            <!-- END PAGE TITLE -->
        </div>
        <!-- END PAGE HEAD -->

        {!! $message !!}

    @endif
    @if(isset($grid))
        <div class="panel panel-default">
            <div class="panel-heading orange-header" style="font-size:24px">
                @if(((new App\Managers\AuthManager())->isAnyRole(['master','sales','finance'])))
                    Staff - Manage staff accounts
                @else
                    Agents - Manage agent accounts
                @endif</div>
            <div class="panel-body">
                <a href="{{ url('/user/register/agent') }}" class="btn btn-primary form-btn pull-left">
                    @if(((new App\Managers\AuthManager())->isAnyRole(['master','sales','finance'])))
                        Add Staff
                    @else
                        Add Agent
                    @endif
                </a>
                {!! $grid !!}
            </div>
        </div>



    @endif

    @if(isset($edit))
        <div class="panel panel-default">
            <div class="panel-heading orange-header" style="font-size:24px">
                @if(((new App\Managers\AuthManager())->isAnyRole(['master','sales','finance'])))
                    Edit Staff Account
                @else
                    Edit Agent Account
                @endif
            </div>
            <div class="panel-body">
                <div id="editEntity"  class="saveBtnFix">
                    {!! $edit !!}
                </div>
            </div>
        </div>
        @endif
                <!-- END PAGE CONTENT INNER -->
@endsection
@section('fast-page-script')
    <script>
        grid_list.find('td:last-child').addClass('hidden');
    </script>
@endsection
@section('page-script')
    @if(((new App\Managers\AuthManager())->isAnyRole(['master','sales','finance'])))
    <script type="text/javascript">
        $('#company_name').attr('readonly','true');
    </script>
    @endif
    <script type="text/javascript">
        jQuery.validator.addMethod("myEmail", function (value, element) {
               return this.optional(element) || ( /^[a-zA-Z0-9]+([-._][a-zA-Z0-9]+)*@([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*\.)+[a-z]{2,4}$/.test(value) && /^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/.test(value) );
           }, 'Please enter a valid email address.');
        $('#agentEditForm').validate({
            rules: {
                user_email: {
                    required: true,
                    myEmail: true
                }
            },
            highlight: function (element) {
                $(element).closest('.form-group').removeClass('success').addClass('error');
            },
            success: function (element) {
                element.addClass('valid')
                        .closest('.form-group').removeClass('error').addClass('success');
            }
        });
    </script>
@endsection