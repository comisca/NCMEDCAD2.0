@section('title')
    @lang('NCMEDCAD | Tiitle')
@endsection
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="button-items">
                        <button type="button" id="modalusers" class="btn btn-primary waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#modalUniversal">
                            <i class="fa fa-user-o"></i> Adicionar
                        </button>


                    </div>
                    <div class="col-md-3">

                        {{-- <div class="mb-3">
                            @if($idSelecte > 0)
                                <a href="#" wire:click="update" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-plus mr-2"></i> {{__('actions.update')}}</a>
                            @else
                                <a href="#" wire:click="create" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus mr-2"></i> {{ __('actions.save') }}</a>
                            @endif

                        </div> --}}
                    </div>
                    <div class="col-md-3">
                        <div class="form-inline float-md-right mb-3">
                            <div class="search-box ml-2">
                                <div class="position-relative">
                                    <input type="text" wire:model.live="searchQuety"
                                           class="form-control rounded bg-light border-0"
                                           placeholder="{{__('actions.search')}} Roles">
                                    <i class="mdi mdi-magnify search-icon"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end row -->
                <div class="table-responsive">
                    <table id="instituciones" class="table table-bordered dt-responsive nowrap"
                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Cod. Producto</th>
                            <th scope="col">Nombre Producto</th>
                            <th scope="col">Fam. Producto</th>
                            <th scope="col">Grupo de Requisitos</th>
                            <th scope="col">Grupo de Pertenencia</th>
                            <th scope="col" style="width: 200px;">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($data))

                            @foreach($data as $items)
                                <tr>

                                    <td>
                                        <a href="#" class="text-body">{{ $items->id }}</a>
                                    </td>
                                    <td>{{ $items->cod_medicamento }}</td>
                                    <td>{{ $items->descripcion }}</td>
                                    <td>{{$items->familia_producto}}</td>
                                    <td>{{$items->grupo_requisito}}</td>
                                    <td>{{$items->grupo_familia}}</td>
                                    <td>
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="#" wire:click="edit({{$items->idMed}})"
                                                   class="px-2 text-primary" data-toggle="tooltip" data-placement="top"
                                                   title="{{__('Editar Institución')}}"><i
                                                        class="uil uil-pen font-size-18"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" onclick="confirm({{ $items->idMed }})"
                                                   class="px-2 text-danger" data-toggle="tooltip" data-placement="top"
                                                   title="Eliminar Institución"><i
                                                        class="uil uil-trash-alt font-size-18"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        </tbody>
                    </table>

                    @if(!empty($data))
                        {{ $data->links() }}
                    @endif
                </div>

            </div>
        </div>
    </div>


    @include('livewire.medicamentos.medicamentos-create')

    {{-- <livewire:search-universal></livewire:search-universal> --}}
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

            @this.on('medicamento-edit', (event) => {
                $('#modalUniversal').modal('show');
            })

            @this.on('roles-selected', (event) => {
                document.getElementById("roles").focus();

            })

        });

        function confirm(id) {
            Swal.fire({
                title: 'Eliminar Medicamento?',
                text: "Estas seguro de eliminar este Medicamento?",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!',
                cancelButtonText: 'No, Cancelar'
            }).then((result) => {
                if (result.value) {
                    Livewire.dispatch('deletedata', {medicamentoId: id})
                    swal.close();
                }
            });

        }
    </script>
@endsection
