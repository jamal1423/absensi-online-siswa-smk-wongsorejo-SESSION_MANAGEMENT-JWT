<!DOCTYPE html>
<html lang="en" dir="">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>#Dasboard | SMKN1 Wongsorejo</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="{{ asset('siswa/assets/css/themes/lite-purple.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('siswa/assets/css/plugins/perfect-scrollbar.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('siswa/assets/css/plugins/toastr.css') }}" />
    @stack('styles')
</head>

<body class="text-left">
    <div class="app-admin-wrap layout-sidebar-large">
        @include('partials.header')
        
        <!-- =============== Left side End ================-->
        <div class="main-content-wrap sidenav-open d-flex flex-column">
            <!-- ============ Body content start ============= -->
            @yield('content')
        </div>
    </div>
    <script src="{{ asset('siswa/assets/js/plugins/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('siswa/assets/js/plugins/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('siswa/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('siswa/assets/js/scripts/script.min.js') }}"></script>
    <script src="{{ asset('siswa/assets/js/scripts/sidebar.large.script.min.js') }}"></script>
    <script src="{{ asset('siswa/assets/js/plugins/echarts.min.js') }}"></script>
    <script src="{{ asset('siswa/assets/js/scripts/echart.options.min.js') }}"></script>
    <script src="{{ asset('siswa/assets/js/scripts/dashboard.v1.script.min.js') }}"></script>
    <script src="{{ asset('siswa/assets/js/plugins/toastr.min.js') }}"></script>
    @stack('scripts')
</body>
</html>