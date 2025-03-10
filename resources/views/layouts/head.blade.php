@yield('css')

<link rel="preload" href="{{ asset('assets/css/bootstrap.min.css') }}" as="style"
      onload="this.onload=null;this.rel='stylesheet'">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

{{--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">--}}
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
