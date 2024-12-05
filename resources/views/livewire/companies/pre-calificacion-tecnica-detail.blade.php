@section('title')
    @lang('NCMEDCAD | Tiitle')
@endsection
<div>
    <div wire:loading wire:target="chageStateRequeriment,createDocUp" class="loading-overlay">
        <div class="spinner"></div>
        <div class="loading-text">Espera un momento, Ejecutando!!...</div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            @if(!empty($dataApplication))
                <div class="accordion" id="accordionExample">
                    @foreach ($dataApplication as $grupo => $items)
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
                                            <li>

                                                <table class="table">
                                                    <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Requisito</th>
                                                        <th scope="col">Documentacion</th>
                                                        <th scope="col">Subir</th>
                                                        <th scope="col">Observaciones</th>
                                                        <th scope="col">Estado</th>
                                                        <th scope="col">Acción</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    <tr>
                                                        <th scope="row">{{$item->id}}</th>
                                                        <td> {{ $item->codigo }} - {{ $item->descripcion }}</td>
                                                        <td>
                                                            <a href="#" wire:click="showDoc({{$item->id}})"> Ver
                                                                Documentos</a><br>

                                                        </td>
                                                        <td>
                                                            <a href="#" wire:click="showUpDoc({{$item->id}})"> Subir
                                                                Documentacion</a>
                                                        </td>
                                                        <td>
                                                            <a href="#"
                                                               wire:click="showObservacionRequerimont({{$item->id}})">
                                                                Ver
                                                                Observaciones</a>
                                                        </td>
                                                        <td>
                                                            @if($item->states_req_applications == 1)
                                                                Calificado
                                                            @else
                                                                No Calificado
                                                            @endif


                                                        </td>
                                                        <td>
                                                            @if(Session::has('id_user'))
                                                                <a href="#"
                                                                   wire:click="showFormChangeState({{$item->id}})"
                                                                   type="button"
                                                                   class="btn btn-success">Cambiar Estado
                                                                </a>
                                                            @endif
                                                        </td>

                                                    </tr>


                                                    </tbody>
                                                </table>

                                            </li>
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

        @include('livewire.companies.form-doc')

        @include('livewire.companies.form-observacions')
        @include('livewire.companies.form-change-state')
        @include('livewire.companies.form-up-doc')
        @include('livewire.companies.form-view-doc')
        {{--         <livewire:search-universal></livewire:search-universal>--}}
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



            @this.on('chageStateRequerimentSuccess', (event) => {
                $('#modalChangeState').modal('hide');
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

            @this.on('upDocSuccess', (event) => {
                $('#modalUpDoct').modal('hide');
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

            @this.on('showUpDoc', (event) => {
                $('#modalUpDoct').modal('show');

            })

            @this.on('showObservacionRequerimont', (event) => {
                $('#modalShowObservacion').modal('show');

            })


            @this.on('showDoc', (event) => {
                $('#modalDocApplications').modal('show');

            })

            @this.on('viewDocAdmShow', (event) => {
                $('#modalViewDocModal').modal('show');

            })
            @this.on('showFormChangeState', (event) => {
                $('#modalChangeState').modal('show');

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
