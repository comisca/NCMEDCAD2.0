@section('title')
    @lang('SMYE | Usuarios')
@endsection



<div class="row">

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                <div class="row mb-2">


                    <div class="col-md-2">

                        <div class="form-inline float-md-right mb-3">
                            {{--                            <label for="inputNameCompany">Tipo de Productos</label>--}}
                            <select id="selectedType" wire:model.live="selectedYears"
                                    class="form-control @error('selectedYears') is-invalid @enderror">
                                <option selected>Seleccion el Año</option>
                                <option value="2015">2015</option>
                                <option value="2016">2016</option>
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                                <option value="2028">2028</option>


                            </select>
                            @error('selectedYears')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                        </div>
                    </div>

                    <div class="col-md-10">
                        <div class="form-inline float-md-right mb-3">
                            {{--                            <label for="inputNameCompany">Tipo de Productos</label>--}}
                            <select id="selectedType" wire:model.live="selectedEvents"
                                    class="form-control @error('selectedEvents') is-invalid @enderror">
                                <option selected>Selecciona el Evento</option>
                                @if(!empty($eventsData))
                                    @foreach($eventsData as $itemsEvents)
                                        <option
                                            value="{{$itemsEvents->id_events}}">{{$itemsEvents->event_name}}</option>
                                    @endforeach
                                @endif


                            </select>
                            @error('selectedEvents')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

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
                            <th scope="col">Codigo Producto</th>
                            <th scope="col">Producto</th>
                            <th scope="col" style="width: 200px;">{{__('actions.action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($productsEvents))

                            @foreach($productsEvents as $eventItems)
                                <tr>
                                    <th scope="row">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="contacusercheck1">
                                            <label class="custom-control-label" for="contacusercheck1"></label>
                                        </div>
                                    </th>
                                    <td>

                                        <a href="#" class="text-body">{{ $eventItems->id_product_event }}</a>
                                    </td>
                                    <td>{{ $eventItems->cod_medicamento }}</td>
                                    <td>{{ $eventItems->descripcion }}</td>

                                    <td>
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="#"
                                                   wire:click="viewPostorData({{$eventItems->id_product_event}})"
                                                   class="px-2 text-primary" data-toggle="tooltip" data-placement="top"
                                                   title="Ver Detalles"><i
                                                        class="uil uil-eye font-size-18"></i></a>
                                            </li>

                                            <li class="list-inline-item">
                                                <a href="#"
                                                   wire:click="selectedProductEventID({{$eventItems->id_product_event}})"
                                                   class="px-2 text-primary" data-toggle="tooltip" data-placement="top"
                                                   title="Agregar Postor"><i
                                                        class="uil uil-plus font-size-18"></i></a>
                                            </li>

                                            <li class="list-inline-item">
                                                <a href="#"
                                                   wire:click="createNeedes({{$eventItems->id_product_event}},{{$eventItems->id_medicamento}})"
                                                   class="px-2 text-primary" data-toggle="tooltip" data-placement="top"
                                                   title="Agregar Necesidades"><i
                                                        class="uil uil-plus font-size-18"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="#"
                                                   wire:click="createConfigSubasta({{$eventItems->id_product_event}})"
                                                   class="px-2 text-primary" data-toggle="tooltip" data-placement="top"
                                                   title="Configurar Subasta"><i
                                                        class="uil uil-setting font-size-18"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);"
                                                   onclick="confirm({{ $eventItems->id_product_event }})"
                                                   class="px-2 text-success" data-toggle="tooltip" data-placement="top"
                                                   title="Enviar Invitacion"><i
                                                        class="uil uil-envelope-add font-size-18"></i></a>
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
    @include('livewire.events.form-needs')
    @include('livewire.events.form-add-intitutions')

    @include('livewire.events.form-add-postor')
    @include('livewire.events.form-detail-postor')
    @include('livewire.events.form-subasta-config')
    {{--    <livewire:search-universal></livewire:search-universal>--}}

</div>



@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/dashboard.init.js')}}"></script>
    <script>
        document.addEventListener('livewire:initialized', function () {


            @this.
            on('auctions-create-susses', (event) => {

                $('#modalConfigSubasta').modal('hide');

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


            })


            @this.on('postor-add_create-susses', (event) => {

                $('#modalAddPostor').modal('hide');

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


            })


            @this.on('intitutions-create-susses', (event) => {

                $('#modalAddIntitutions').modal('hide');

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


            })

            @this.on('view-postor-data', (event) => {
                $('#modalViewPostor').modal('show');


            })

            @this.on('create-needs-create', (event) => {
                $('#modalNeedesInstitutions').modal('show');


            })
            @this.on('view-institutions-create', (event) => {
                $('#modalAddIntitutions').modal('show');


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

            @this.on('selectedProductEventDispach', (event) => {
                $('#modalAddPostor').modal('show');

            })

            @this.on('modal-config-subasta', (event) => {
                $('#modalConfigSubasta').modal('show');

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
