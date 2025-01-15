@section('title')
    @lang('SMYE | Usuarios')
@endsection



<div class="row">

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                <div class="row mb-2">


                    <div class="col-md-6">

                        <div class="mb-3">

                            <a href="#" data-toggle="modal" data-target="#modalUniversal"
                               class="btn btn-primary waves-effect waves-light"><i
                                    class="mdi mdi-plus mr-2"></i> {{__('actions.create')}}</a>


                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-inline float-md-right mb-3">
                            <div class="search-box ml-2">
                                <div class="position-relative">
                                    <input type="text" wire:model.live="searchQuety"
                                           class="form-control rounded bg-light border-0"
                                           placeholder="{{__('actions.search')}} Usuarios">
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
                            <th scope="col" style="width: 50px;">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="contacusercheck">
                                    <label class="custom-control-label" for="contacusercheck"></label>
                                </div>
                            </th>
                            <th scope="col">ID</th>
                            <th scope="col">Año</th>
                            <th scope="col">Nombre de evento</th>
                            <th scope="col" style="width: 200px;">{{__('actions.action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($users))

                            @foreach($users as $permisoitems)
                                <tr>
                                    <th scope="row">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="contacusercheck1">
                                            <label class="custom-control-label" for="contacusercheck1"></label>
                                        </div>
                                    </th>
                                    <td>
                                        <img src="{{ URL::asset('assets/images/users/avatar-2.jpg')}}" alt=""
                                             class="avatar-xs rounded-circle mr-2">
                                        <a href="#" class="text-body">{{ $permisoitems->id }}</a>
                                    </td>
                                    <td>{{ $permisoitems->first_name }} {{ $permisoitems->last_name }}</td>
                                    <td>{{ $permisoitems->email }}</td>

                                    <td>
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="#" wire:click="editRoles({{$permisoitems->id}})"
                                                   class="px-2 text-primary" data-toggle="tooltip" data-placement="top"
                                                   title="{{__('actions.edit')}}"><i
                                                        class="uil uil-pen font-size-18"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" onclick="confirm({{ $permisoitems->id }})"
                                                   class="px-2 text-danger" data-toggle="tooltip" data-placement="top"
                                                   title="{{__('actions.delete')}}"><i
                                                        class="uil uil-trash-alt font-size-18"></i></a>
                                            </li>
                                            {{--                                                                                    <li class="list-inline-item dropdown">--}}
                                            {{--                                                                                        <a class="text-muted dropdown-toggle font-size-18 px-2" onclick="confirm({{ $permisoitems->id }})" href="#" role="button" data-toggle="dropdown" aria-haspopup="true">--}}
                                            {{--                                                                                            <i class="uil uil-ellipsis-v"></i>--}}
                                            {{--                                                                                        </a>--}}

                                            {{--                                                                                        <div class="dropdown-menu dropdown-menu-right">--}}
                                            {{--                                                                                            <a class="dropdown-item" href="#">Action</a>--}}
                                            {{--                                                                                            <a class="dropdown-item" href="#">Another action</a>--}}
                                            {{--                                                                                            <a class="dropdown-item" href="#">Something else here</a>--}}
                                            {{--                                                                                        </div>--}}
                                            {{--                                                                                    </li>--}}
                                        </ul>
                                    </td>
                                </tr>

                            @endforeach
                        @endif

                        </tbody>
                    </table>
                    @if(!empty($users))
                        {{ $users->links() }}
                    @endif
                </div>

            </div>
        </div>
    </div>

    @include('livewire.events.form-create-event')
    {{--    <livewire:search-universal></livewire:search-universal>--}}

</div>



@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/dashboard.init.js')}}"></script>
    <script>
        document.addEventListener('livewire:initialized', function () {
            @this.
            on('usuario-added', (event) => {
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
            @this.on('roles-error', (event) => {
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
                title: 'Eliminar Usuario?',
                text: "Estas seguro de eliminar este Usuario?",
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
