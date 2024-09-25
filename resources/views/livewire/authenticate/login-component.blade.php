@section('title')
    @lang('NCMEDCAD | Iniciar Session')
@endsection





<div>


    <div class="home-btn d-none d-sm-block">
        <a href="#" class="text-dark"><i class="mdi mdi-home-variant h2"></i></a>
    </div>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <a href="#" class="mb-5 d-block auth-logo">
                            <img src="{{ asset('assets/images/bannersinergia.png')}}" alt="" height="68"
                                 class="logo logo-dark">
                            {{--                                <img src="{{ URL::asset('assets/images/logo-light.png')}}" alt="" height="22" class="logo logo-light">--}}
                        </a>
                    </div>
                </div>
            </div>
            <div class="row align-items-center justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">Bienvenidos</h5>
                                <p class="text-muted">Inicio de Session</p>
                            </div>
                            <div class="p-2 mt-4">


                                <div class="form-group">
                                    <label for="email">email</label>
                                    <input wire:model="email" id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email" autofocus
                                           placeholder="Enter Email address">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="float-right">
                                        @if (Route::has('password.request'))
                                            <a class="text-muted" href="{{ route('password.request') }}">
                                                {{ __('Forgot Password?') }}
                                            </a>
                                        @endif
                                    </div>
                                    <label for="password">Password</label>
                                    <input wire:model="password" id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="current-password" placeholder="Enter password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="auth-remember-check"
                                           name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="auth-remember-check">Recuerdame</label>
                                </div>
                                <div class="mt-3 text-right">
                                    <button wire:click="create()" class="btn btn-primary w-sm waves-effect waves-light"
                                            type="button">Iniciar
                                    </button>
                                </div>
                                {{--                                        <div class="mt-4 text-center">--}}
                                {{--                                            <div class="signin-other-title">--}}
                                {{--                                                <h5 class="font-size-14 mb-3 title">Sign in with</h5>--}}
                                {{--                                            </div>--}}


                                {{--                                            <ul class="list-inline">--}}
                                {{--                                                <li class="list-inline-item">--}}
                                {{--                                                    <a href="#" class="social-list-item bg-primary text-white border-primary">--}}
                                {{--                                                        <i class="mdi mdi-facebook"></i>--}}
                                {{--                                                    </a>--}}
                                {{--                                                </li>--}}
                                {{--                                                <li class="list-inline-item">--}}
                                {{--                                                    <a href="#" class="social-list-item bg-info text-white border-info">--}}
                                {{--                                                        <i class="mdi mdi-twitter"></i>--}}
                                {{--                                                    </a>--}}
                                {{--                                                </li>--}}
                                {{--                                                <li class="list-inline-item">--}}
                                {{--                                                    <a href="#" class="social-list-item bg-danger text-white border-danger">--}}
                                {{--                                                        <i class="mdi mdi-google"></i>--}}
                                {{--                                                    </a>--}}
                                {{--                                                </li>--}}
                                {{--                                            </ul>--}}
                                {{--                                        </div>--}}

                                {{--                                        <div class="mt-4 text-center">--}}
                                {{--                                            <p class="mb-0">Don't have an account ? <a href="{{url('register')}}" class="font-weight-medium text-primary"> Signup now </a> </p>--}}
                                {{--                                        </div>--}}

                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <script>document.write(new Date().getFullYear())</script>
                        © Sinerpgia 2.0.0.
                    </div>
                </div>
            </div>
        </div>
        <!-- end container -->
    </div>


</div>
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/dashboard.init.js')}}"></script>
    <script>
        document.addEventListener('livewire:initialized', function () {
            @this.
            on('messages-succes', (event) => {
                toastr.success(event.messages, 'Exito', {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-bottom-full-width",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": 300,
                    "hideDuration": 1000,
                    "timeOut": 5000,
                    "extendedTimeOut": 1000,
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                })
                // Swal.fire({
                //     position: 'top-end',
                //     icon: 'success',
                //     title: event.messages,
                //     text: "Exito!!",
                //     showConfirmButton: false,
                //     timer: 2500
                // })

            })
            @this.on('messages-error', (event) => {
                toastr.error(event.messages, 'Exito', {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-bottom-full-width",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": 300,
                    "hideDuration": 1000,
                    "timeOut": 5000,
                    "extendedTimeOut": 1000,
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                })
            })

            @this.on('roles-selected', (event) => {
                document.getElementById("roles").focus();

            })

        });

        function confirm(id) {
            Swal.fire({
                title: 'Eliminar Rol?',
                text: "Estas seguro de eliminar este rol?",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!',
                cancelButtonText: 'No, Cancelar'
            }).then((result) => {
                if (result.value) {
                    Livewire.dispatch('deleteroles', {postId: id})
                    swal.close();
                }
            });

        }
    </script>
@endsection
