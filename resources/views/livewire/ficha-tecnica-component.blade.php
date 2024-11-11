@section('title') @lang('NCMEDCAD | Tiitle') @endsection

    <div class="row">

        <div class="container">
            <form>
              <fieldset class="form-group">
                <legend>FICHA TÉCNICA</legend>
                <p>Por favor, complete todos los campos requeridos en la ficha técnica. Asegúrese de seguir cada uno de los pasos indicados para garantizar el registro correcto y evitar cualquier error en el proceso. Esto permitirá que la información sea procesada de manera eficiente y precisa.</p>
              <div class="form-row">

                <!-- PROBANDO BUSCADORES -->
                
                <!-- FIN DE LOS BUSCADORES -->    
                
                
                <div class="form-group col-6">
                        <label for="inputNameProductoOfertar">Seleccione Familia de productos a ofertar:</label>
                        <select id="inputState" wire:model="country" class="form-control @error('country') is-invalid @enderror">
                        <option selected>Medicamentos </option>
                        <option value="ReactivosLaboratorio">Reactivos e Insumos de Laboratorio</option>
                        <option value="DistrideInsumos">Distribución Insumos de Medicamentos</option>
                        <option value="Obi">OBI</option>
                        <option value="Ejemplo">Ejemplo1</option>
                        <option value="Ejemplo">Ejemplo2</option>
                        </select>
                        @error('country')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                </div>

                <div class="form-group col-6">
                  <label for="">Buscar producto:</label>
                  <input type="search" placeholder="Buscar" class="form-control @error('country') is-invalid @enderror">
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
                          <tr>
                            <th scope="row">1</th>
                            <td>Paracetamol (Acetaminofén)</td>
                            <td><button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalFichaTecnica"">Agregar</button></td>
                       
                          </tr>
                          <tr>
                            <th scope="row">2</th>
                            <td>Naproxeno</td>
                            <td><button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalFichaTecnica"">Agregar</button></td>
                          </tr>
                          <tr>
                            <th scope="row">3</th>
                            <td>Naproxeno</td>
                            <td><button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalFichaTecnica"">Agregar</button></td>
                          </tr>
                          <tr>
                            <th scope="row">4</th>
                            <td>Naproxeno</td>
                            <td><button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalFichaTecnica"">Agregar</button></td>
                          </tr>
                          
                        </tbody>
                      </table>
                    </div>


            
              <button type="button" wire:click="create()" class="btn btn-primary">Guardar</button>
              
              <button type="button" class="btn btn-danger">Cancelar</button>
          </fieldset>
            </form>
          </div>

         <livewire:search-universal></livewire:search-universal>

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
