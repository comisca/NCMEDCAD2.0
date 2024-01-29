<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        @include('layouts.title-meta')
        @include('layouts.head')
        <style>

            *:focus{
            !important;
                border: 1px solid #1670BE;
                box-shadow: 0 0 3px #1670BE;
                outline-offset: 0px;
                outline: none;

            }



        </style>
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


    @include('components.shortcuts')

    </body>
</html>
