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
        <h3>Listado de fabricantes o representantes</h3></p>
        <br>
        <p>Estamos aceptando solicitudes de fabricantes, distribuidores o representantes interesados en colaborar con
            nosotros. Para ser considerados en las futuras subastas:</p>

        <div class="container">
            {{--            <form>--}}
            {{--                <fieldset class="form-group">--}}
            {{--                    <div class="form-group col-12">--}}
            {{--                        <label for="inputNameCompany">Buscador</label>--}}
            {{--                        <input wire:model.live="searchInput" type="text" class="form-control" id="inputAddress"--}}
            {{--                               placeholder="BUSCA LA EMPRESA...">--}}

            {{--                    </div>--}}
            {{--                </fieldset>--}}
            {{--            </form>--}}
            <div class="table-container">
                <h3 class="mb-4">Companies List</h3>
                <livewire:companies-table-ra></livewire:companies-table-ra>
            </div>
            {{--            <table class="table align-middle mb-0 bg-white">--}}
            {{--                <thead class="bg-light">--}}
            {{--                <tr>--}}
            {{--                    <th>Nombre</th>--}}
            {{--                    <th>Tipo de Solicitante</th>--}}
            {{--                    <th>Status</th>--}}
            {{--                    <th>Doc Pre Registro</th>--}}
            {{--                    <th>Mas Informacion</th>--}}
            {{--                    <th>Acción</th>--}}
            {{--                </tr>--}}
            {{--                </thead>--}}
            {{--                <tbody>--}}

            {{--                @foreach($companies as $items)--}}

            {{--                    <tr>--}}
            {{--                        <td>--}}
            {{--                            <div class="d-flex align-items-center">--}}

            {{--                                <img--}}
            {{--                                    src="/storage/logo/companies/{{$items->logo_companies}}"--}}
            {{--                                    alt=""--}}
            {{--                                    style="width: 45px; height: 45px"--}}
            {{--                                    class="rounded-circle"--}}
            {{--                                />--}}
            {{--                                <div class="ms-3">--}}
            {{--                                    <p class="fw-bold mb-1">{{ $items->legal_name }}</p>--}}
            {{--                                    <p class="text-muted mb-0">{{$items->email}}</p>--}}
            {{--                                    <p class="text-muted mb-0">+{{ $items->phone }}</p>--}}
            {{--                                </div>--}}
            {{--                            </div>--}}
            {{--                        </td>--}}
            {{--                        <td>--}}
            {{--                            <p class="fw-normal mb-1">--}}
            {{--                                @if($items->type_company == 'D')--}}
            {{--                                    DISTRIBUIDOR--}}
            {{--                                @else--}}
            {{--                                    FABRICANTE--}}
            {{--                                @endif--}}

            {{--                            </p>--}}
            {{--                        </td>--}}
            {{--                        <td>--}}
            {{--                            @if($items->status == 1)--}}

            {{--                                <span class="badge badge-success rounded-pill d-inline">Active</span>--}}

            {{--                            @elseif($items->status == 2)--}}
            {{--                                <span class="badge badge-warning rounded-pill d-inline">Pendiente</span>--}}

            {{--                            @elseif($items->status == 0)--}}
            {{--                                <span class="badge badge-danger rounded-pill d-inline">Rechazado</span>--}}

            {{--                            @endif--}}

            {{--                        </td>--}}
            {{--                        <td>--}}
            {{--                            <button wire:click="detailCompany({{$items->id}})" type="button" class="btn btn-link btn-sm--}}
            {{--                        btn-rounded">--}}
            {{--                                Ver detalle--}}
            {{--                            </button>--}}
            {{--                        </td>--}}

            {{--                        <td>--}}
            {{--                            <a href="/companie/info/{{$items->id}}" type="button" class="btn btn-link btn-sm--}}
            {{--                        btn-rounded">--}}
            {{--                                Ver Informacion--}}
            {{--                            </a>--}}
            {{--                        </td>--}}
            {{--                        <td>--}}
            {{--                            <button type="button" wire:click="changesStates({{$items->id}},1)"--}}
            {{--                                    class="btn btn-link btn-sm btn-rounded">--}}
            {{--                                Aceptar--}}
            {{--                            </button>--}}
            {{--                            <button type="button" wire:click="changesStates({{$items->id}},0)"--}}
            {{--                                    class="btn btn-link btn-sm btn-rounded">--}}
            {{--                                Rechazar--}}
            {{--                            </button>--}}
            {{--                        </td>--}}
            {{--                    </tr>--}}
            {{--                    <tr>--}}

            {{--                @endforeach--}}
            {{--                </tbody>--}}
            {{--            </table>--}}
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

    <script>
        let pdfWindowCounter = 0;  // Contador para generar IDs únicos

        window.viewPdf = function (url) {
            pdfWindowCounter++;  // Incrementar el contador
            const windowName = 'PDF_Viewer_' + pdfWindowCounter;  // Crear nombre único para la ventana

            const pdfWindow = window.open('', windowName,
                'width=800,height=600,left=200,top=100,resizable=yes,menubar=no,location=no,status=yes');

            pdfWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Visor de PDF ${pdfWindowCounter}</title>
                <style>
                    body {
                        margin: 0;
                        padding: 0;
                        overflow: hidden;
                        background-color: #525659;
                    }
                    iframe {
                        width: 100%;
                        height: 100vh;
                        border: none;
                    }
                </style>
            </head>
            <body>
                <iframe src="${url}" width="100%" height="100%"></iframe>
            </body>
            </html>
        `);

            pdfWindow.document.close();
        }
    </script>
@endsection
