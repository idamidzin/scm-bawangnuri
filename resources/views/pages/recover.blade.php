@extends('layouts.user')
@section('content')
    <div class="block-center mt-4 wd-xl">
        <!-- START card-->
        <div class="card card-flat">
            <div class="card-header text-center bg-dark">
                <a href="#"><img class="block-center rounded" src="img/logo.png" alt="Image" /></a>
            </div>
            <div class="card-body">
                <p class="text-center py-2">PASSWORD RESET</p>
                <form>
                    <p class="text-center">Fill with your mail to receive instructions on how to reset your password.</p>
                    <div class="form-group">
                        <label class="text-muted" for="resetInputEmail1">Email address</label>
                        <div class="input-group with-focus">
                            <input class="form-control border-right-0" id="resetInputEmail1" type="email" placeholder="Enter email" autocomplete="off" />
                            <div class="input-group-append">
                                <span class="input-group-text text-muted bg-transparent border-left-0"><em class="fa fa-envelope"></em></span>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-danger btn-block" type="submit">Reset</button>
                </form>
            </div>
        </div>
        <!-- END card-->
        @include("layouts.includes.footer-page")
    </div>
@endsection
