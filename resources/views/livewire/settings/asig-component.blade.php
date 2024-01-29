@section('title') @lang('NCMEDCAD | Asignar Permisos') @endsection

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-9">
                        <div class="mb-3">
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Selecciona el rol</label>
                                <div class="col-md-10">
                                <select wire:model.live="roleSelect"  class="custom-select" >
                                    <option value="Elegir" selected >Selecciona un rol</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}"> {{$role->name}}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                                <button type="button" wire:click.prevent="synAll()" class="btn btn-success"> Sincronizar Todos</button>
                                <button type="button" onclick="confirm()"  class="btn btn-danger"> Revocar Todos</button>


                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="form-inline float-md-right mb-3">
                            <div class="search-box ml-2">
                                <div class="position-relative">
                                    <input type="text" wire:model.live="searchQuety" class="form-control rounded bg-light border-0" placeholder="{{__('actions.search')}} Permisos">
                                    <i class="mdi mdi-magnify search-icon"></i>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
                <!-- end row -->
                <div class="table-responsive mb-4">
                    <table class="table table-centered table-nowrap mb-0">
                        <thead>
                        <tr>
                            {{--                                <th scope="col" style="width: 50px;">--}}
                            {{--                                    <div class="custom-control custom-checkbox">--}}
                            {{--                                        <input type="checkbox" class="custom-control-input" id="contacusercheck">--}}
                            {{--                                        <label class="custom-control-label" for="contacusercheck"></label>--}}
                            {{--                                    </div>--}}
                            {{--                                </th>--}}
                            <th scope="col">ID</th>
                            <th scope="col">Permisos</th>
                            <th scope="col">{{__('actions.action')}}</th>
{{--                            <th scope="col" style="width: 200px;">{{__('actions.action')}}</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($permisos))

                            @foreach($permisos as $itempermisos)
                                <tr>
                                    {{--                                <th scope="row">--}}
                                    {{--                                    <div class="custom-control custom-checkbox">--}}
                                    {{--                                        <input type="checkbox" class="custom-control-input" id="contacusercheck1">--}}
                                    {{--                                        <label class="custom-control-label" for="contacusercheck1"></label>--}}
                                    {{--                                    </div>--}}
                                    {{--                                </th>--}}
                                    <td>
                                        {{--                                    <img src="{{ URL::asset('assets/images/users/avatar-2.jpg')}}" alt="" class="avatar-xs rounded-circle mr-2">--}}
                                        <a href="#" class="text-body">{{ $itempermisos->id }}</a>
                                    </td>
                                    <td>{{ $itempermisos->name }}</td>
{{--                                    <td>{{$itempermisos->description}}</td>--}}
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"  id="p{{$itempermisos->id}}" wire:change="asignarpermi($('#p' + {{$itempermisos->id}}).is(':checked'),'{{$itempermisos->name}}')" value="{{$itempermisos->id}}" {{$itempermisos->checked == 1 ? 'checked' : ''}}>
                                            <label class="form-check-label" for="flexCheckDefault">Estado</label>
                                        </div>
                                    </td>
                                </tr>

                            @endforeach
                        @endif

                        </tbody>
                    </table>
                    @if(!empty($permisos))
                        {{ $permisos->links() }}
                    @endif

                </div>

            </div>
        </div>

    </div>
<livewire:search-universal></livewire:search-universal>
</div>


@section('script')
    <!-- apexcharts -->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/icons.min.css')}}" id="icons-style" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ URL::asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/dashboard.init.js')}}"></script>
    <script>
        document.addEventListener('livewire:initialized', function () {

            @this.on('syncall', (event) => {
                toastr.success(event.messages, 'Exito',{
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
            @this.on('permi', (event) => {
                toastr.success(event.messages, 'Exito',{
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


            @this.
            on('messages-succes', (event) => {
                toastr.success(event.messages, 'Exito',{
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

            @this.on('removeall', (event) => {
                toastr.success(event.messages, 'Exito',{
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

            @this.on('sync-error', (event) => {
                toastr.error(event.messages, 'Error',{
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

{{--            @this.on('roles-selected', (event) => {--}}
{{--                document.getElementById("roles").focus();--}}

{{--            })--}}

        });

        function confirm() {
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
                    Livewire.dispatch('revokeall')
                    swal.close();
                }
            });

        }
    </script>
@endsection

