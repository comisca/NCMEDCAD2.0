@section('title')
    @lang('NCMEDCAD | Tiitle')
@endsection
<div>
    <div wire:loading wire:target="changeStateCompany" class="loading-overlay">
        <div class="spinner"></div>
        <div class="loading-text">Espera un momento, Ejecutando!!...</div>
    </div>


    <div class="row">

        <p>
        <h3>Listado de Aplicaciones</h3></p>
        <br>
        <p>Califica las aplicaciones de los participantes.</p>


        <div class="container">
            <form>
                <fieldset class="form-group">
                    <div class="form-group col-12">
                        <label for="inputNameCompany">Participante</label>
                        <select id="inputState" wire:model.live="particioanteId"
                                class="form-control @error('particioanteId') is-invalid @enderror">
                            <option selected>Selecciona un Participante</option>
                            @foreach($companies as $itemscompanies)
                                <option value="{{$itemscompanies->id}}">{{$itemscompanies->legal_name}}</option>
                            @endforeach
                        </select>
                        @error('particioanteId')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </fieldset>
            </form>
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
                @if(!empty($dataGlobal))
                    @foreach($dataGlobal as $itemsdataApplicationSelected)
                        <tr>
                            <th scope="row">{{$itemsdataApplicationSelected->id}}</th>
                            <td>{{$itemsdataApplicationSelected->trade_name}}</td>
                            <td>{{$itemsdataApplicationSelected->descripcion}}
                                ({{$itemsdataApplicationSelected->cod_medicamento}})
                            </td>
                            <td>{{$itemsdataApplicationSelected->legal_name}}</td>
                            <td>
                                @if($itemsdataApplicationSelected->calification_tec == 0)
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
        @include('livewire.form-detail-list-company')
        @include('livewire.form-detail-document')
        @include('livewire.form-messages')

        {{--    <livewire:search-universal></livewire:search-universal>--}}

    </div>
</div>

@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/dashboard.init.js')}}"></script>
    <script>
        document.addEventListener('livewire:initialized', function () {

            @this.
            on('success_messages_changes', (event) => {

                $('#modalMessagesCompanies').modal('hide');
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
            @this.on('success_messages', (event) => {
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
            @this.on('error_messages', (event) => {
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




            @this.on('changes-states-show', (event) => {
                $('#modalMessagesCompanies').modal('show');

            })

            @this.on('detail_company', (event) => {
                // console.log('hola estoy enn javascript');
                $('#modalDetailCompany').modal('show');

            })
            @this.on('view-visor-pdf', (event) => {
                // console.log('hola estoy enn javascript');
                $('#modalDetailDocuments').modal('show');

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
