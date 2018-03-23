@extends('auth')
@section('content')
    <style>
        html,body {
            height:100%;
            width:100%;
            margin:0;
        }
        #parent-container {
            display: table-cell;
            text-align: center;
            vertical-align: middle;
        }
        #grand-parent-container {
            display: table;
            height: 100%;
            margin: 0 auto;
        }
        div.content {
            background-color: rgba(236,238,241,0.7) !important;
        }
        #authVideo {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -1;
        }
    </style>
    <!-- BEGIN LOGIN -->
    <div id="grand-parent-container">
        <div id="parent-container">
            <div class="content">
                <div style="text-align: center">
                    <a href="http://cartow.ie/">
                        <img src="{{ asset('images/spire-logo.png') }}" alt="Spire Logo"
                             style="display: block; margin: 0 auto"/>
                    </a>
                </div>
                @include('layouts.form_errors')

                <form class="form-horizontal login-form" role="form" method="POST" action="{{ url('/auth/login') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <h3 class="form-title">Sign In</h3>

                    <div class="form-group">
                        <label class="control-label visible-ie8 visible-ie9">Username</label>
                        <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off"
                               placeholder="Username" name="username" value="{{ old('username') }}">
                    </div>

                    <div class="form-group">
                        <label class="control-label visible-ie8 visible-ie9">Password</label>
                        <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off"
                               placeholder="Password" name="password">
                    </div>
                    <div>

                        <div class="form-actions pull-right" style="border-bottom: none">
                            <button type="submit" class="btn btn-success uppercase">Login</button>
                            <label class="rememberme check">
                                <input type="checkbox" name="remember" value="1"/>Remember </label>

                        </div>

                        <div class="form-group login-options pull-left">
                            <!-- <h4>Or login with</h4> -->
                            <ul class="social-icons">
                                <li>
                                    <a class="social-icon-color facebook" data-original-title="facebook"
                                       href="javascript:;"></a>
                                </li>
                                <li>
                                    <a class="social-icon-color twitter" data-original-title="Twitter" href="javascript:;"></a>
                                </li>
                                <li>
                                    <a class="social-icon-color googleplus" data-original-title="Goole Plus"
                                       href="javascript:;"></a>
                                </li>
                                <li>
                                    <a class="social-icon-color linkedin" data-original-title="Linkedin"
                                       href="javascript:;"></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group">
                        <a href="{{ url('/password/email') }}" id="forget-password" class="forget-password"
                           style="  float: none;">Forgot Password?</a>
                    </div>

                    <!-- <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> Remember Me
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                                Login
                            </button>

                            <a href="/password/email">Forgot Your Password?</a>
                        </div>
                    </div> -->
                </form>
            </div>
        </div>
    </div>
@endsection