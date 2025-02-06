@section('title')
    @lang('NCMEDCAD | Tiitle')
@endsection

<div class="row">

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/companies/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ficha Técnica</li>
            </ol>
        </nav>
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">FICHA TÉCNICA</h1><br>
            <div class="clearfix">...</div>
        </div>

        <form>
            <fieldset class="form-group">

                <div class="form-row">

                    <!-- PROBANDO BUSCADORES -->

                    <!-- FIN DE LOS BUSCADORES -->


                    <div class="form-group col-6">
                        <label for="inputNameProductoOfertar">Seleccione Familia de productos a ofertar:</label>
                        <select id="inputState" wire:model.live="inputFamilyProduct"
                                class="form-control @error('inputFamilyProduct') is-invalid @enderror">
                            <option selected>SELECCIONA UNA FAMILIA DE PRODUCTO</option>
                            @foreach($familyProducts as $itemsFamilyProducts)
                                <option
                                    value="{{$itemsFamilyProducts->id}}">{{$itemsFamilyProducts->familia_producto}}</option>
                            @endforeach
                        </select>
                        @error('inputFamilyProduct')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="form-group col-6">
                        <label for="">Buscar producto:</label>
                        <input type="search" placeholder="Buscar"
                               class="form-control @error('country') is-invalid @enderror">
                        @error('country')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="ejemplo">lISTA DE PRODUCTOS</label>
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre de Medicamento</th>
                                <th scope="col">Acción</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($dataProducts))
                                @foreach($dataProducts as $itemsDataProdt)
                                    <tr>
                                        <th scope="row">{{$itemsDataProdt->id}}</th>
                                        <td>{{$itemsDataProdt->descripcion}} ({{$itemsDataProdt->cod_medicamento}})</td>
                                        <td>
                                            <button wire:click="showDetailFicha({{$itemsDataProdt->id}})" type="button"
                                                    class="btn btn-success">Agregar
                                            </button>
                                        </td>

                                    </tr>
                                @endforeach
                            @endif

                            </tbody>
                        </table>
                    </div>

                    <div class="col-12">
                        <label for="ejemplo">LISTA DE APLICACIONES</label>
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre Comercial</th>
                                <th scope="col">Producto</th>
                                <th scope="col">Acción</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($dataApplicationSelected))
                                @foreach($dataApplicationSelected as $itemsdataApplicationSelected)
                                    <tr>
                                        <th scope="row">{{$itemsdataApplicationSelected->id}}</th>
                                        <td>{{$itemsdataApplicationSelected->trade_name}}</td>
                                        <td>{{$itemsdataApplicationSelected->descripcion}}
                                            ({{$itemsdataApplicationSelected->cod_medicamento}})
                                        </td>
                                        <td>
                                            <button wire:click="showDetailFicha({{$itemsdataApplicationSelected->id}})"
                                                    type="button"
                                                    class="btn btn-success">ELIMINAR
                                            </button>
                                        </td>

                                    </tr>
                                @endforeach
                            @endif

                            </tbody>
                        </table>
                    </div>


                {{--                    <button type="button" wire:click="create()" class="btn btn-primary">Guardar</button>--}}

                {{--                    <button type="button" class="btn btn-danger">Cancelar</button>--}}
            </fieldset>
        </form>
    </div>

    {{--         <livewire:search-universal></livewire:search-universal>--}}

    @include('livewire.form-fichatec')
    @include('livewire.form-new-fabric')
</div>


@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/dashboard.init.js')}}"></script>
    <script>
        document.addEventListener('livewire:initialized', function () {

            // Configuración de los modales
            const $modalFichaTecnica = $('#modalFichaTecnica');
            const $modalCreateFabric = $('#modalCreateFabric');

            // Prevenir que el segundo modal cierre el primero
            $modalCreateFabric.on('show.bs.modal', function (e) {
                e.stopPropagation();
            });

            $modalCreateFabric.on('hidden.bs.modal', function (e) {
                e.stopPropagation();
                $('body').addClass('modal-open');
            });

            // Modificar el comportamiento del botón para crear fabricante
            $(document).on('click', '[data-target="#modalCreateFabric"]', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $modalCreateFabric.modal('show');
            });
            $modalFichaTecnica.modal({
                backdrop: 'static',
                keyboard: false,
                show: false
            });

            $modalCreateFabric.modal({
                backdrop: 'static',
                keyboard: false,
                show: false
            });


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
            })

            @this.on('messages-succes-fichatec', (event) => {
                $('#modalFichaTecnica').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Dato Guardado',
                    text: event.messages
                }).then((result) => {
                    // Opcional: recargar la página después de cerrar el alert
                    if (result.isConfirmed) {

                    }
                });
            })
            @this.on('success_new_fabric', (event) => {
                $('#modalCreateFabric').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Dato Guardado',
                    text: event.messages
                }).then((result) => {
                    // Opcional: recargar la página después de cerrar el alert
                    if (result.isConfirmed) {

                    }
                });
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

            @this.on('showDetailFichaEvent', (event) => {
                $modalFichaTecnica.modal('show');

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
