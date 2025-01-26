<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.title-meta')
    @include('layouts.head')
    <style>

        *:focus {
        !important;
            border: 1px solid #1670BE;
            box-shadow: 0 0 3px #1670BE;
            outline-offset: 0px;
            outline: none;

        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner {
            border: 16px solid #f3f3f3;
            border-top: 16px solid #3498db;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
            margin: auto;
        }

        .loading-text {
            margin-top: 20px;
            font-family: 'Open Sans', sans-serif, Verdana;
            font-size: 20px;
            color: #4b4b4c;
            text-align: center;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

    </style>
    <style>
        .progress-circle {
            position: relative;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: conic-gradient(#4caf50 0%, #4caf50 25%, #ddd 25%, #ddd 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .progress-circle .circle {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .time-display {
            font-size: 2rem;
            color: #fff; /* Letras blancas */
        }
    </style>
    @livewireStyles
    {{--    @vite(['resources/js/app.js'])  <!-- Incluye el archivo JavaScript compilado -->--}}
</head>

<body>
<!-- Begin page -->
<div id="layout-wrapper">

    @include('layouts.topbar')
    @include('layouts.sidebar')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @yield('content')

            </div>
            <!-- container-fluid -->

        </div>

        <!-- End Page-content -->
        @include('layouts.footer')

    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->

<!-- Right Sidebar -->
@include('layouts.right-sidebar')
<!-- /Right-bar -->

<!-- JAVASCRIPT -->

@include('layouts.vendor-scripts')

@livewireScripts
@include('components.shortcuts')

</body>
</html>
