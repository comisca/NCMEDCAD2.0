@section('title') @lang('NCMEDCAD | Tiitle') @endsection

    <div class="row">

                <!--INICIO de Formulario -->
                <div class="container mt-5">
                    <h2>Detalles de la Empresa</h2>
                    <form>
                      <!-- Detalles de la Empresa -->
                      <div class="mb-3">
                        <label for="companyName" class="form-label">Nombre de la Compañía</label>
                        <input type="text" class="form-control" id="companyName" placeholder="Introduce el nombre de la compañía" required>
                      </div>
                      <div class="mb-3">
                        <label for="country" class="form-label">País</label>
                        <input type="text" class="form-control" id="country" placeholder="Introduce el país" required>
                      </div>
                      <div class="mb-3">
                        <label for="municipality" class="form-label">Municipio</label>
                        <input type="text" class="form-control" id="municipality" placeholder="Introduce el municipio" required>
                      </div>
                      <div class="mb-3">
                        <label for="address" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="address" placeholder="Introduce la dirección" required>
                      </div>
                      <div class="mb-3">
                        <label for="phone" class="form-label">Número de Teléfono</label>
                        <input type="tel" class="form-control" id="phone" placeholder="Introduce el número de teléfono" required>
                      </div>
                
                      <!-- Lista dinámica de requisitos -->
                      <h4>Requisitos</h4>
                      <div id="requirements">
                        <div class="form-check mb-2">
                          <input class="form-check-input" type="checkbox" id="requirement1">
                          <label class="form-check-label" for="requirement1">
                            Requisito 1
                          </label>
                        </div>
                        <div class="form-check mb-2">
                          <input class="form-check-input" type="checkbox" id="requirement2">
                          <label class="form-check-label" for="requirement2">
                            Requisito 2
                          </label>
                        </div>
                      </div>
                
                      <!-- Botón para añadir más requisitos -->
                      <button type="button" class="btn btn-secondary mb-3" id="addRequirement">Añadir Requisito</button>
                
                      <!-- Subida de Archivos -->
                      <h4>Subir Documentos</h4>
                      <div class="mb-3">
                        <label for="formFile" class="form-label">Sube tus archivos aquí</label>
                        <input class="form-control" type="file" id="formFile" multiple>
                      </div>
                
                      <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
                    
                <!--FIN de Formulario -->




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
