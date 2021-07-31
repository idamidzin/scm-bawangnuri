<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="Bootstrap Admin App" />
        <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="icon" type="image/x-icon" href="/favicon.ico" />

        <title>Angle - Bootstrap Admin Template</title>

        <!-- =============== VENDOR STYLES ===============-->
        <link rel="stylesheet" href="{{ mix('/css/vendor.css') }}" />
        <!-- =============== BOOTSTRAP STYLES ===============-->
        <link rel="stylesheet" href="{{ mix('/css/bootstrap.css') }}" data-rtl="{{ mix('/css/bootstrap-rtl.css') }}" id="bscss" />
        <!-- =============== APP STYLES ===============-->
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}" data-rtl="{{ mix('/css/app-rtl.css') }}" id="maincss" />

        @yield('styles')
    </head>

    <body class="layout-h">
        <div class="wrapper">
            <!-- top navbar-->
            @include('layouts.includes.header-horizontal')
            <!-- offsidebar-->
            @include('layouts.includes.offsidebar')
            <!-- Main section-->
            <section class="section-container">
                <!-- Page content-->
                <div class="content-wrapper">
                    @yield('content')
                </div>
            </section>
            <!-- Page footer-->
            @include('layouts.includes.footer')
        </div>
        @yield('body-area')
        <!-- =============== VENDOR SCRIPTS ===============-->
        <script src="{{ mix('/js/manifest.js') }}"></script>
        <script src="{{ mix('/js/vendor.js') }}"></script>
        <!-- =============== APP SCRIPTS ===============-->
        <script src="{{ mix('/js/app.js') }}"></script>
        <!-- =============== CUSTOM PAGE SCRIPTS ===============-->
        @yield('scripts')
    </body>
</html>
