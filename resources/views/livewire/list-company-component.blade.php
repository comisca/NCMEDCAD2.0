@section('title')
    @lang('NCMEDCAD | Tiitle')
@endsection
<div>
    <!-- Loading overlay -->
    <div wire:loading wire:target="changeStateCompany" class="loading-overlay">
        <div class="spinner"></div>
        <div class="loading-text">Espera un momento, Ejecutando!!...</div>
    </div>

    <div class="row">
        <div class="col-12"> <!-- Columna que ocupa todo el ancho -->
            <h3>Listado de fabricantes o representantes</h3>

            <p>Estamos aceptando solicitudes de fabricantes, distribuidores o representantes interesados en colaborar
                con
                nosotros. Para ser considerados en las futuras subastas:</p>

            <!-- Cambiamos de .container a .container-fluid -->
            <div class="container-fluid px-4"> <!-- padding-x para no pegar a los bordes -->
                <div class="table-container">
                    <livewire:companies-table-ra></livewire:companies-table-ra>
                </div>
            </div>
        </div>
    </div>

    @include('livewire.form-detail-list-company')
    @include('livewire.form-detail-document')
    @include('livewire.form-messages')
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
