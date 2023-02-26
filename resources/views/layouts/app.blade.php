<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title')
    </title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet" type="text/css">
    @yield('custom-css')

    <link href="{{ asset('font/font-family.css') }}" rel="stylesheet">

    <link href="{{ asset('font/google-font.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('font/font-awesome-6.2.1.css') }}"/>
    <style>
        #icon-loading{
            position: fixed;
            top: 0;
            z-index: 9999;
            width: 100%;
            height:100%;
            display: none;
            background: rgba(0,0,0,0.6);
        }
        .cv-spinner {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .spinner {
            width: 40px;
            height: 40px;
            border: 4px #ddd solid;
            border-top: 4px #2e93e6 solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }
        @keyframes sp-anime {
            100% {
                transform: rotate(360deg);
            }
        }
        .is-hide{
            display: block;
        }
    </style>
</head>

<body id="page-top">
<div id="wrapper">
    @include('layouts.sidebar')

    <div id="content-wrapper" class="d-flex flex-column">

        <div id="content">
            @include('layouts.navbar')

            <main class="py-4">
                @yield('content')
            </main>
        </div>

        @include('layouts.footer')
    </div>

</div>

<div id="icon-loading">
    <div class="cv-spinner">
        <span class="spinner"></span>
    </div>
</div>

<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('js/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

<!-- Page level plugins -->
<script src="{{ asset('js/Chart.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('js/chart-area-demo.js') }}"></script>
<script src="{{ asset('js/chart-pie-demo.js') }}"></script>

<script src="{{ asset('js/app.js') }}" defer></script>

<script>
    setTimeout(function () {
        $('.alert-dismissible').remove();
    }, 3000);
</script>

@yield('js')
</body>

</html>
