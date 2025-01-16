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

                            <a href="#" data-toggle="modal" data-target="#modalCreateEvents"
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
                            <th scope="col">Familia de Productos</th>
                            <th scope="col">Nombre de evento</th>
                            <th scope="col" style="width: 200px;">{{__('actions.action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($eventsData))

                            @foreach($eventsData as $eventItems)
                                <tr>
                                    <th scope="row">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="contacusercheck1">
                                            <label class="custom-control-label" for="contacusercheck1"></label>
                                        </div>
                                    </th>
                                    <td>

                                        <a href="#" class="text-body">{{ $eventItems->id_events }}</a>
                                    </td>
                                    <td>{{ $eventItems->years }}</td>
                                    <td>{{ $eventItems->familia_producto }}</td>
                                    <td>{{ $eventItems->event_name }}</td>

                                    <td>
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="#"
                                                   wire:click="selectedEventProducts({{$eventItems->id_events}})"
                                                   class="px-2 text-primary" data-toggle="tooltip" data-placement="top"
                                                   title="Ver Detalles"><i
                                                        class="uil uil-eye font-size-18"></i></a>
                                            </li>

                                            <li class="list-inline-item">
                                                <a href="#"
                                                   wire:click="selectedProduct({{$eventItems->id_events}})"
                                                   class="px-2 text-primary" data-toggle="tooltip" data-placement="top"
                                                   title="Agregar Productos"><i
                                                        class="uil uil-plus font-size-18"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="#" wire:click="editRoles({{$eventItems->id_events}})"
                                                   class="px-2 text-primary" data-toggle="tooltip" data-placement="top"
                                                   title="Editar"><i
                                                        class="uil uil-pen font-size-18"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);"
                                                   onclick="confirm({{ $eventItems->id_events }})"
                                                   class="px-2 text-danger" data-toggle="tooltip" data-placement="top"
                                                   title="Eliminar"><i
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

    @include('livewire.events.form-detail-event')
    @include('livewire.events.form-create-event')
    @include('livewire.events.form-add-products')
    {{--    <livewire:search-universal></livewire:search-universal>--}}

</div>



@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/dashboard.init.js')}}"></script>
    <script>
        document.addEventListener('livewire:initialized', function () {


            @this.
            on('event-create', (event) => {
                $('#modalCreateEvents').modal('hide');
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

            @this.on('product-add_create', (event) => {
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

            @this.on('modal-add-products', (event) => {
                $('#modalAddProducts').modal('show');

            })

            @this.on('modal-detail-products', (event) => {
                $('#modalDetailProducts').modal('show');

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
