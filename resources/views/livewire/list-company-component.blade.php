@section('title') @lang('NCMEDCAD | Tiitle') @endsection

    <div class="row">

            <h3>Listado de fabricantes o representantes</h3>
            <p>Estamos aceptando solicitudes de fabricantes, distribuidores o representantes interesados en colaborar con nosotros. Para ser considerados en las futuras subastas:</p>

            <div class="container">
                <table class="table align-middle mb-0 bg-white">
                    <thead class="bg-light">
                      <tr>
                        <th>Nombre</th>
                        <th>Tipo de Solicitante</th>
                        <th>Status</th>
                        <th>Detalles</th>
                        <th>Acción</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <div class="d-flex align-items-center">
                            <img
                                src="https://mdbootstrap.com/img/new/avatars/8.jpg"
                                alt=""
                                style="width: 45px; height: 45px"
                                class="rounded-circle"
                                />
                            <div class="ms-3">
                              <p class="fw-bold mb-1">Ejemplo de Nombre</p>
                              <p class="text-muted mb-0">correo@gmail.com</p>
                              <p class="text-muted mb-0">+503 78567898</p>
                            </div>
                          </div>
                        </td>
                        <td>
                          <p class="fw-normal mb-1">FABRICANTE</p>
                        </td>
                        <td>
                          <span class="badge badge-success rounded-pill d-inline">Active</span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-link btn-sm btn-rounded">
                                Ver detalle
                              </button>
                        </td>
                        <td>
                          <button type="button" class="btn btn-link btn-sm btn-rounded">
                            Aceptar
                          </button>
                          <button type="button" class="btn btn-link btn-sm btn-rounded">
                            Rechazar
                          </button>
                        </td>
                      </tr>
                      <tr>
                    </tbody>
                  </table>
            </div>




         <livewire:search-universal></livewire:search-universal>
        </div>


@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/dashboard.init.js')}}"></script>
    <script>
        document.addEventListener('livewire:initialized', function () {
            @this.
            on('messages-succes', (event) => {
                toastr.success(event.messages, 'Exito',{
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
                toastr.error(event.messages, 'Exito',{
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
