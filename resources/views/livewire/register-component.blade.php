@section('title') @lang('NCMEDCAD | Tiitle') @endsection


   <div class="row">
    
        <!--Fomrulario-->
        <div class="container">
          <form>
            <fieldset class="form-group">
              <legend>Registro de Participante</legend>
            <div class="form-row">
              <div class="form-group col-12">
                <label for="inputNameCompany">Nombre de la Compañia</label>
                <input type="text" class="form-control" id="inputAddress" placeholder="SICA SA de CV">
              </div>
              <div class="form-group col-3">
                <select id="inputState" class="form-control">
                  <option selected>Seleccione Pais</option>
                  <option>...</option>
                </select>
              </div>
              <div class="form-group col-3">
                <select id="inputState" class="form-control">
                  <option selected>Provincia o Municipio</option>
                  <option>...</option>
                </select>
              </div>
              <div class="form-group col-6">
              <!--<label for="inputAddress">Dirección</label>-->
              <input type="text" class="form-control" id="inputAddress" placeholder="Escribe tu Dirección" required>
            </div>
              <div class="form-group col-6">
                <label for="inputEmail4">Teléfono</label>
                <input type="tel" class="form-control" id="inputEmail4">
              </div>
              <div class="form-group col-6">
                <label for="inputPassword4">Facsímile</label>
                <input type="number" class="form-control" id="inputPassword4">
              </div>
            </div>
          </fieldset>

          <!--Segunda parte del Formulario Persona de CONTACTO -->
          <fieldset class="form-group">
            <legend>Persona de Contacto</legend>
          <div class="form-row">
            <div class="form-group col-4">
              <label for="inputNameCompany">Nombre</label>
              <input type="text" class="form-control" id="inputAddress" placeholder="SICA SA de CV">
            </div>
            <div class="form-group col-4">
              <label for="inputNameCompany">Apellido</label>
              <input type="text" class="form-control" id="inputAddress" placeholder="SICA SA de CV">
            </div>
            <div class="form-group col-4">
              <label for="inputNameCompany">E-mail:</label>
              <input type="mail" class="form-control" id="inputAddress" placeholder="SICA SA de CV">
            </div>
          </fieldset>

        <!--Tercera parte del Formulario Datos de Ingreso-->
        <fieldset class="form-group ">
          <legend>Datos de ingreso</legend>
        
          <div class="form-group row">
            <label for="inputUser" class="col-sm-2">Usuario</label>
            <div class="col-sm-4">
              <input type="email" class="form-control" id="inputEmail3">
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="submit" class="btn btn-danger">Cancelar</button>
        </fieldset>
          </form>
        </div>
        
    
        <!--Fin del comentario-->


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
