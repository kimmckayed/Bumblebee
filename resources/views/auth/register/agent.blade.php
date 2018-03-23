@extends('masterapp')

@section('content')
<!-- BEGIN CONTENT -->

<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading orange-header" style="font-size:24px">New 
                    @if(((new App\Managers\AuthManager())->isAnyRole(['master','sales','finance'])))
                        Staff
                    @else
                        Agent
                    @endif
            </div>
            <div class="panel-body">
                @include('layouts.form_errors')

                <form class="form-horizontal" role="form" method="POST"
                      action="{{ url('/user/register/agent') }}" id="agentRegisterForm">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label class="col-md-4 control-label">Username<span class="orange-header">*</span></label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="username"
                                   value="{{ old('username') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">First Name</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="first_name"
                                   value="{{ old('first_name') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Last Name</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="last_name"
                                   value="{{ old('last_name') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Phone Number</label>

                        <div class="col-md-6">
                            <input type="number" class="form-control" name="agent_phone_number"
                                   value="{{ old('agent_phone_number') }}">
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-md-4 control-label">E-Mail Address<span class="orange-header">*</span></label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="email" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Role<span class="orange-header">*</span></label>

                        <div class="col-md-6">
                            <select class="form-control" id="role" name="role">
                                <option value=""></option>
                                @foreach($roles as $role)
                                    <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary form-btn">
                                    @if(((new App\Managers\AuthManager())->isAnyRole(['master','sales','finance'])))
                                        Add Staff account
                                    @else
                                        Add Agent account
                                    @endif
                                </button>
                            </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>

<!-- END CONTENT -->

@endsection
@section('page-script')
    <script type="text/javascript">
        jQuery.validator.addMethod("myEmail", function (value, element) {
               return this.optional(element) || ( /^[a-zA-Z0-9]+([-._][a-zA-Z0-9]+)*@([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*\.)+[a-z]{2,4}$/.test(value) && /^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/.test(value) );
           }, 'Please enter a valid email address.');
        $('#agentRegisterForm').validate({
            rules: {
                username: {
                    required: true
                },
                email: {
                    required: true,
                    myEmail: true
                },
                role: {
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
        });
    </script>
@stop