@section('title')
    @lang('NCMEDCAD | Tiitle')
@endsection

<div class="row">
    <div class="col-xl-12 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-xl-4 col-md-4 mb-4">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Nombre de la empresa:
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{$company->legal_name}}
                            </div>
                        </div>
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                ID de Empresa:
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{$company->id}}
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 mb-4">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Telefono:
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{$company->phone}}
                            </div>
                        </div>
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Correo Electronico:
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{$company->email}}
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-4 mb-4">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Representante Legal:
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{$company->first_name}} {{$company->last_name}}
                            </div>
                        </div>
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tipo de Empresa:
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if($company->type_company == 'F')
                                    Fabricante
                                @else
                                    Distribuidor

                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="ejemplo">LISTA DE FABRICANTES ENROLADOS</label>
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre Fabricante</th>
                                <th scope="col">Representante Legal</th>
                                <th scope="col">Email</th>
                                <th scope="col">Telefono</th>
                                {{--                                <th scope="col">Acción</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($fabricData))
                                @foreach($fabricData as $itemsfabricData)
                                    <tr>
                                        <th scope="row">{{$itemsfabricData->id_company}}</th>
                                        <td>{{$itemsfabricData->legal_name}}</td>
                                        <td>{{$itemsfabricData->first_name}}
                                            ({{$itemsfabricData->last_name}})
                                        </td>
                                        <td>{{$itemsfabricData->email}}</td>
                                        <td>{{$itemsfabricData->phone}}</td>

                                        {{--                                        <td>--}}
                                        {{--                                            <a href="/documents/validation/{{$itemsdataApplicationSelected->id}}"--}}

                                        {{--                                               type="button"--}}
                                        {{--                                               class="btn btn-success">Ves detalle--}}
                                        {{--                                            </a>--}}
                                        {{--                                        </td>--}}

                                    </tr>
                                @endforeach
                            @endif

                            </tbody>
                        </table>
                    </div>


                    {{--                        <div class="col-auto">--}}
                    {{--                            <i class="fas fa-calendar fa-2x text-gray-300"></i>--}}
                    {{--                        </div>--}}
                </div>
            </div>
        </div>
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
