@extends('layouts.user')
@section('content')
    <div class="abs-center wd-xl">
        <!-- START card-->
        <div class="text-center mb-4">
            <div class="mb-3"><em class="fa fa-wrench fa-5x text-muted"></em></div>
            <div class="text-lg mb-3">500</div>
            <p class="lead m-0">Oh! Something went wrong :(</p>
            <p>Don't worry, we're now checking this.</p>
            <p>In the meantime, please try one of those links below or come back in a moment</p>
        </div>
        <ul class="list-inline text-center text-sm mb-4">
            <li class="list-inline-item"><a class="text-muted" href="/dashboard/dashboard">Go to App</a></li>
            <li class="text-muted list-inline-item">|</li>
            <li class="list-inline-item"><a class="text-muted" href="/login">Login</a></li>
            <li class="text-muted list-inline-item">|</li>
            <li class="list-inline-item"><a class="text-muted" href="/register">Register</a></li>
        </ul>
        @include("layouts.includes.footer-page")
    </div>
@endsection
