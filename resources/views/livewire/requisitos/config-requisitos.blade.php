@section('title')
    @lang('NCMEDCAD | Tiitle')
@endsection

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <h5>Configuracion de requisitos</h5>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Familias de Productos</label>
                            <div class="col-md-10">
                                <select wire:model.live="familySelectedId" class="form-control">
                                    <option value="0">Selecciona Familia de productos</option>
                                    @if(!empty($familyProductsData))
                                        @foreach($familyProductsData as $itmesfamilyProductsData)
                                            <option
                                                value="{{$itmesfamilyProductsData->id}}">{{$itmesfamilyProductsData->familia_producto}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <h5>Requisitos</h5>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Grupo de Requisitos</label>
                            <div class="col-md-7">
                                <select wire:model.live="groupSelectedId"
                                        class="form-control @error('groupSelectedId') is-invalid @enderror">
                                    <option value="0">Selecciona un grupo</option>
                                    @if(!empty($groupDataSelected))
                                        @foreach($groupDataSelected as $itemsgroupDataSelected)
                                            <option
                                                value="{{$itemsgroupDataSelected->id}}">{{$itemsgroupDataSelected->grupo}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('groupSelectedId')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <button wire:click="addGroupRequeriment()" type="button" class="btn
                                btn-success">Agregar >>>
                                </button>
                            </div>
                        </div>

                        <div class="col-lg-12">

                            <table class="table align-middle mb-0 bg-white">
                                <thead class="bg-light">
                                <tr>
                                    <th>COD</th>
                                    <th>Requisito</th>
                                    <th>Accion</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(!empty($requisitodDataSelected))
                                    @foreach($requisitodDataSelected as $itemsrequisitodDataSelected)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">

                                                    {{$itemsrequisitodDataSelected->id}}

                                                </div>
                                            </td>
                                            <td>
                                                <p class="fw-normal mb-1">
                                                    {{$itemsrequisitodDataSelected->descripcion}}


                                                </p>
                                            </td>

                                            <td>
                                                <button
                                                    wire:click="addRequerimentOne({{$itemsrequisitodDataSelected->id}})"
                                                    type="button" class="btn
                                                btn-link btn-sm
                        btn-rounded">
                                                    Agregar
                                                </button>
                                            </td>

                                        </tr>

                                    @endforeach
                                @endif


                                </tbody>
                            </table>
                        </div>


                    </div>

                    <div class="col-lg-6">
                        <h5>Medicamentos</h5>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Productos a Seleccionar</label>
                            <div class="col-md-8">
                                <select wire:model.live="productSelectInput"
                                        class="form-control @error('productSelectInput') is-invalid @enderror">
                                    <option value="0">Selecciona un producto</option>
                                    @if(!empty($productsDataSelected))
                                        @foreach($productsDataSelected as $itemsproductsDataSelected)
                                            <option
                                                value="{{$itemsproductsDataSelected->id}}">{{$itemsproductsDataSelected->cod_medicamento}} {{$itemsproductsDataSelected->descripcion}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('productSelectInput')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="col-lg-12">
                            @if(!empty($productDataTable))
                                <div class="accordion" id="accordionExample">
                                    @foreach ($productDataTable as $grupo => $items)
                                        <div class="card">
                                            <div class="card-header" id="heading{{ $loop->index }}">
                                                <h2 class="mb-0">
                                                    <button
                                                        class="btn btn-link btn-block text-left {{ $loop->first ? '' : 'collapsed' }}"
                                                        type="button" data-toggle="collapse"
                                                        data-target="#collapse{{ $loop->index }}"
                                                        aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                                        aria-controls="collapse{{ $loop->index }}">
                                                        {{ $grupo }}
                                                    </button>
                                                </h2>
                                            </div>

                                            <div id="collapse{{ $loop->index }}"
                                                 class="collapse {{ $loop->first ? 'show' : '' }}"
                                                 aria-labelledby="heading{{ $loop->index }}"
                                                 data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <ul>
                                                        @foreach ($items as $item)
                                                            <li>{{ $item->codigo }} - {{ $item->descripcion }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{--                            <table class="table align-middle mb-0 bg-white">--}}
                            {{--                                <thead class="bg-light">--}}
                            {{--                                <tr>--}}
                            {{--                                    <th>COD</th>--}}
                            {{--                                    <th>Requisito</th>--}}
                            {{--                                    <th>Accion</th>--}}
                            {{--                                </tr>--}}
                            {{--                                </thead>--}}
                            {{--                                <tbody>--}}

                            {{--                                @if(!empty($productDataTable))--}}
                            {{--                                    @foreach($productDataTable as $itemsproductDataTable)--}}
                            {{--                                        <tr>--}}
                            {{--                                            <td>--}}
                            {{--                                                <div class="d-flex align-items-center">--}}

                            {{--                                                    {{$itemsproductDataTable->id}}--}}

                            {{--                                                </div>--}}
                            {{--                                            </td>--}}
                            {{--                                            <td>--}}
                            {{--                                                <p class="fw-normal mb-1">--}}
                            {{--                                                    {{$itemsproductDataTable->descripcion}}--}}


                            {{--                                                </p>--}}
                            {{--                                            </td>--}}

                            {{--                                            <td>--}}
                            {{--                                                <button--}}
                            {{--                                                    wire:click="addRequerimentOne({{$itemsproductDataTable->id}})"--}}
                            {{--                                                    type="button" class="btn--}}
                            {{--                                                btn-link btn-sm--}}
                            {{--                        btn-rounded">--}}
                            {{--                                                    Eliminar--}}
                            {{--                                                </button>--}}
                            {{--                                            </td>--}}

                            {{--                                        </tr>--}}

                            {{--                                    @endforeach--}}
                            {{--                                @endif--}}


                            {{--                                </tbody>--}}
                            {{--                            </table>--}}
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
    {{--         <livewire:search-universal></livewire:search-universal>--}}
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
