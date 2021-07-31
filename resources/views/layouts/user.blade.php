<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="Bootstrap Admin App" />
        <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="icon" type="image/x-icon" href="logo.png" />

        <title>Bawang Nuri</title>

        <!-- =============== VENDOR STYLES ===============-->
        <link rel="stylesheet" href="{{ mix('/css/vendor.css') }}" />
        <!-- =============== BOOTSTRAP STYLES ===============-->
        <link rel="stylesheet" href="{{ mix('/css/bootstrap.css') }}" data-rtl="{{ mix('/css/bootstrap-rtl.css') }}" id="bscss" />
        <!-- =============== APP STYLES ===============-->
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}" data-rtl="{{ mix('/css/app-rtl.css') }}" id="maincss" />

        @yield('styles')
    </head>

    <body>
        <div class="wrapper">
            @yield('content')
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
