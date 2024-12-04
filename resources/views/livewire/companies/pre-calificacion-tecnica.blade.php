@section('title')
    @lang('NCMEDCAD | Tiitle')
@endsection

<div class="row">

    <div class="container">
        <form>
            <fieldset class="form-group">
                <legend>FICHA TÉCNICA</legend>
                <p>Por favor, complete todos los campos requeridos en la ficha técnica. Asegúrese de seguir cada uno de
                    los pasos indicados para garantizar el registro correcto y evitar cualquier error en el proceso.
                    Esto permitirá que la información sea procesada de manera eficiente y precisa.</p>
                <div class="form-row">

                    <!-- PROBANDO BUSCADORES -->

                    <!-- FIN DE LOS BUSCADORES -->


                    {{--                    <div class="form-group col-6">--}}
                    {{--                        <label for="inputNameProductoOfertar">Seleccione Familia de productos a ofertar:</label>--}}
                    {{--                        <select id="inputState" wire:model.live="inputFamilyProduct"--}}
                    {{--                                class="form-control @error('country') is-invalid @enderror">--}}
                    {{--                            <option selected>SELECCIONA UNA FAMILIA DE PRODUCTO</option>--}}
                    {{--                            @foreach($familyProducts as $itemsFamilyProducts)--}}
                    {{--                                <option--}}
                    {{--                                    value="{{$itemsFamilyProducts->id}}">{{$itemsFamilyProducts->familia_producto}}</option>--}}
                    {{--                            @endforeach--}}
                    {{--                        </select>--}}
                    {{--                        @error('country')--}}
                    {{--                        <span class="text-danger">{{$message}}</span>--}}
                    {{--                        @enderror--}}
                    {{--                    </div>--}}

                    <div class="form-group col-6">
                        <label for="">Buscar producto:</label>
                        <input type="search" placeholder="Buscar"
                               class="form-control @error('country') is-invalid @enderror">
                        @error('country')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="ejemplo">LISTA DE APLICACIONES</label>
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre Comercial</th>
                                <th scope="col">Producto</th>
                                <th scope="col">Fabricante</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acción</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($applicationsapp))
                                @foreach($applicationsapp as $itemsdataApplicationSelected)
                                    <tr>
                                        <th scope="row">{{$itemsdataApplicationSelected->id}}</th>
                                        <td>{{$itemsdataApplicationSelected->trade_name}}</td>
                                        <td>{{$itemsdataApplicationSelected->descripcion}}
                                            ({{$itemsdataApplicationSelected->cod_medicamento}})
                                        </td>
                                        <td>{{$itemsdataApplicationSelected->legal_name}}</td>
                                        <td>
                                            @if($itemsdataApplicationSelected->req_applications_count > 0)
                                                No Calificado
                                            @else
                                                Calificado
                                            @endif

                                        </td>
                                        <td>
                                            <a href="/documents/validation/{{$itemsdataApplicationSelected->id}}"

                                               type="button"
                                               class="btn btn-success">Ves detalle
                                            </a>
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
            })

            @this.on('messages-succes-fichatec', (event) => {
                $('#modalFichaTecnica').modal('hide');
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
                $('#modalFichaTecnica').modal('show');

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
