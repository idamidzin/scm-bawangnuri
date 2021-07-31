<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Bootstrap Admin App" />
    <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.png') }}" />

    <title>Bawang Goreng Nuri</title>

    <!-- =============== VENDOR STYLES ===============-->
    <link rel="stylesheet" href="{{ mix('/css/vendor.css') }}" />
    <!-- =============== BOOTSTRAP STYLES ===============-->
    <link rel="stylesheet" href="{{ mix('/css/bootstrap.css') }}" data-rtl="{{ mix('/css/bootstrap-rtl.css') }}" id="bscss" />
    <!-- =============== APP STYLES ===============-->
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}" data-rtl="{{ mix('/css/app-rtl.css') }}" id="maincss" /> 
    @yield('styles')
    <link rel="stylesheet" href="{{ mix('/css/theme-h.css') }}">
    <style type="text/css">
        #dropdown-user .dropdown-item .list-group a{text-decoration: none;}
        @media (max-width: 576px) {
            .topnavbar .navbar-header .brand-logo {font-size: 0.8rem;}
        }
        .bg-blue-grey {
            background-color: #607D8B !important;
            color: #fff;
        }
        .btn.bg-blue-grey:hover,
        .btn.bg-blue-grey:active,
        .btn.bg-blue-grey:focus{
            color: #fff;
            background-color: #4D646F !important;
        }
        ul.sidebar-nav span {white-space: normal;}
        .topnavbar-wrapper {
            background-color: #1e983b !important;
            color: #fff;
        }
    </style>
</head>

<body>
    <audio id="notif" src="{{ asset('sound/tone.mp3') }}"></audio>
    <div class="wrapper">
        <!-- top navbar-->
        @include('layouts.includes.header')
        <!-- sidebar-->
        @include('layouts.includes.sidebar')
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
    <script src="{{ mix('/js/notify.js') }}"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <!-- =============== CUSTOM PAGE SCRIPTS ===============-->
    @yield('scripts')
    <script type="text/javascript">
        var role = "{{ auth()->user()->role_id }}";

        $(document).ready(function(){
            if ($(".alert-remove").length > 0) {
                let delay = $(".alert-remove").data('delay');
                setTimeout(function(){
                    $(".alert-remove").slideUp(500);
                },typeof delay !== 'undefined' ? parseInt(delay) : 6000);
            }

            if (role == 1) {
                getPesananBaru("{{ route('admin.get-pesanan-baru') }}");
            }

            if (role == 2) {
                getPesananBaru("{{ route('supplier.get-pesanan-baru') }}");
            }
        });

        function getPesananBaru(url) {
            $.get(url,{data : null}, function(res){
                if (res.pesanan_produk_count > 0) {
                    $("#notif-pesanan-produk").addClass("badge badge-danger");
                    document.getElementById("notif-pesanan-produk").innerHTML = res.pesanan_produk_count;
                }
                if (res.pesanan_bahan_count > 0) {
                    $("#notif-pesanan").addClass("badge badge-danger");
                    document.getElementById("notif-pesanan").innerHTML = res.pesanan_bahan_count;
                }
            },'json');
        }

        function playNotification(){
            let notif = document.getElementById('notif');
            notif.volume = 1;
            notif.play();
        }

        Pusher.logToConsole = true;
        var pusher = new Pusher("{{ \config('app.pusher.key') }}", {
            cluster: "{{ \config('app.pusher.options.cluster') }}"
        });

        var channel = pusher.subscribe('channel-pesanan');
        channel.bind('event-pesanan', function(data) {
            console.log('user_id', data.user_id);
            if (data.user_id == '{{ auth()->user()->id }}') {

                if (role == 1) {
                    getPesananBaru("{{ route('admin.get-pesanan-baru') }}");
                }

                if (role == 2) {
                    getPesananBaru("{{ route('supplier.get-pesanan-baru') }}");
                }

                var html = data.pesan;
                $.notify(html, {"status":(data.status == "ok" ? "success":"danger"), "pos":"bottom-right","timeout":10000});
                playNotification();

                @if(\Request::is('supplier/pesanan') || \Request::is('admin/pesanan-produk'))
                    setTimeout(function(){
                        location.reload();
                    }, 5000);
                @endif
            }
        });

    </script>
</body>
</html>