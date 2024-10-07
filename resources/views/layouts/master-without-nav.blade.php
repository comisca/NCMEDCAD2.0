<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <link rel="stylesheet" href="{{ asset('css/login.css')}}">
        @include('layouts.title-meta')
        @include('layouts.head')
        @livewireStyles
  </head>

    <body class="authentication-bg">
        @yield('content')
        @include('layouts.vendor-scripts')

        
       <script>
            function showDialog(){
                var dialog2 = document.getElementById('registroDialog');
                dialog2.show();
            }
            function closeDialog(){
                var dialog2 = document.getElementById('registroDialog');
                dialog2.close();
            }
        </script>
        @livewireScripts
    </body>
