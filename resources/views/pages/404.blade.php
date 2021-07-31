@extends('layouts.user')
@section('content')
    <div class="abs-center wd-xl">
        <!-- START card-->
        <div class="text-center mb-4">
            <div class="text-lg mb-3">404</div>
            <p class="lead m-0">We couldn't find this page.</p>
            <p>The page you are looking for does not exists.</p>
        </div>
        <div class="input-group mb-4">
            <input class="form-control" type="text" placeholder="Try with a search" />
            <span class="input-group-btn">
                <button class="btn btn-secondary" type="button"><em class="fa fa-search"></em></button>
            </span>
        </div>
        <ul class="list-inline text-center text-sm mb-4">
            <li class="list-inline-item"><a class="text-muted" href="/dashboard">Go to App</a></li>
        </ul>
        @include("layouts.includes.footer-page")
    </div>
@endsection
