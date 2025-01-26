<!-- JAVASCRIPT -->
<script src="{{ URL::asset('assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap/bootstrap.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/metismenu/metismenu.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/node-waves/node-waves.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/waypoints/waypoints.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/jquery-counterup/jquery-counterup.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>


@yield('script')

<!-- App js -->
<script src="{{ URL::asset('assets/js/app.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/toastr/toastr.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/pages/toastr.init.js')}}"></script>
<script src="{{ asset('assets/js/keypress.js') }}"></script>

{{--@livewireScripts--}}
@yield('script-bottom')
