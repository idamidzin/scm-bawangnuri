@extends('layouts.user')
@section('content')
    <div class="block-center mt-4 wd-xl">
        <!-- START card-->
        <div class="card card-flat">
            <div class="card-header text-center bg-dark">
                <a href="#"><img class="block-center rounded" src="img/logo.png" alt="Image" /></a>
            </div>
            <div class="card-body">
                <p class="text-center py-2">SIGN IN TO CONTINUE.</p>
                <form class="mb-3" id="loginForm" novalidate="novalidate">
                    <div class="form-group">
                        <div class="input-group with-focus">
                            <input class="form-control border-right-0" id="exampleInputEmail1" type="email" placeholder="Enter email" autocomplete="off" required="required" />
                            <div class="input-group-append">
                                <span class="input-group-text text-muted bg-transparent border-left-0"><em class="fa fa-envelope"></em></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group with-focus">
                            <input class="form-control border-right-0" id="exampleInputPassword1" type="password" placeholder="Password" required="required" />
                            <div class="input-group-append">
                                <span class="input-group-text text-muted bg-transparent border-left-0"><em class="fa fa-lock"></em></span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix">
                        <div class="checkbox c-checkbox float-left mt-0">
                            <label>
                                <input type="checkbox" value="" name="remember" />
                                <span class="fa fa-check"></span>
                                Remember Me
                            </label>
                        </div>
                        <div class="float-right"><a class="text-muted" href="/recover">Forgot your password?</a></div>
                    </div>
                    <button class="btn btn-block btn-primary mt-3" type="submit">Login</button>
                </form>
                <p class="pt-3 text-center">Need to Signup?</p>
                <a class="btn btn-block btn-secondary" href="/register">Register Now</a>
            </div>
        </div>
        <!-- END card-->
        @include("layouts.includes.footer-page")
    </div>
@endsection
@section('scripts')
    <script src="{{ mix('/js/pages.js') }}"></script>
@endsection
