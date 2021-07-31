@extends('layouts.user')
@section('content')
    <div class="abs-center wd-xl">
        <!-- START card-->
        <div class="d-flex justify-content-center">
            <div class="p-2"><img class="img-fluid img-thumbnail rounded-circle" src="img/user/02.jpg" alt="Avatar" width="60" height="60" /></div>
        </div>
        <div class="card b0">
            <div class="card-body">
                <p class="text-center">Please login to unlock your screen.</p>
                <form>
                    <div class="form-group">
                        <div class="input-group with-focus">
                            <input class="form-control border-right-0" id="exampleInputEmail1" type="email" placeholder="Enter email" autocomplete="off" required="required" />
                            <div class="input-group-append">
                                <span class="input-group-text text-muted bg-transparent border-left-0"><em class="fa fa-lock"></em></span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="mt-1">
                            <a class="text-muted" href="/recover"><small>Forgot your password?</small></a>
                        </div>
                        <div class="ml-auto"><a class="btn btn-sm btn-primary" href="/dashboard/dashboard">Unlock</a></div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END card-->
        @include("layouts.includes.footer-page")
    </div>
@endsection
