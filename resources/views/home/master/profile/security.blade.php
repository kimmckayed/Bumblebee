@extends('masterapp')

@section('tab')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading orange-header" style="font-size:24px">Profile - security - Change
                        Password
                    </div>
                    <div class="panel-body">
                        @include('layouts.form_errors')
                        <form class="form-horizontal" role="form"
                              method="POST" action="{{ route('profile_security') }}">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group control-group">
                                <label class="col-sm-4 control-label">Old Password <span
                                            class="orange-header">*</span></label>

                                <div class="col-sm-6">
                                    <input type="password" class="form-control" id="old_pass"
                                           name="old_password" >
                                </div>
                            </div>
                            <div class="form-group control-group">
                                <label class="col-sm-4 control-label">New Password <span
                                            class="orange-header">*</span></label>

                                <div class="col-sm-6">
                                    <input type="password" class="form-control" id="old_pass"
                                           name="password" >
                                </div>
                            </div>
                            <div class="form-group control-group">
                                <label class="col-sm-4 control-label">New Password again <span
                                            class="orange-header">*</span></label>

                                <div class="col-sm-6">
                                    <input type="password" class="form-control" id="old_pass"
                                           name="password_confirmation" >
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary form-btn submit-button">
                                        Change
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection