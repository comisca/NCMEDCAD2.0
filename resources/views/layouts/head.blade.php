@yield('css')

<link rel="preload" href="{{ asset('assets/css/bootstrap.min.css') }}" as="style"
      onload="this.onload=null;this.rel='stylesheet'">
<link rel="preload" href="{{ asset('assets/css/icons.min.css') }}" as="style"
      onload="this.onload=null;this.rel='stylesheet'">
<link rel="preload" href="{{ asset('assets/css/app.min.css') }}" as="style"
      onload="this.onload=null;this.rel='stylesheet'">
<link rel="preload" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" as="style"
      onload="this.onload=null;this.rel='stylesheet'">
<link rel="preload" href="{{ asset('assets/libs/toastr/toastr.min.css') }}" as="style"
      onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/toastr/toastr.min.css') }}">
</noscript>
{{--<link href="{{ URL::asset('assets/libs/twitter-bootstrap-wizard/twitter-bootstrap-wizard.min.css')}}" rel="stylesheet" type="text/css" />--}}
