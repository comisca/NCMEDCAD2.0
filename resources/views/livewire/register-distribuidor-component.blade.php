@section('title') @lang('NCMEDCAD | Tiitle') @endsection

    <div class="row">

        <div class="container">
            <form>
              <fieldset class="form-group">
                <legend>Solicitud de preregistro</legend>
                <!--<p>Si eres distribuidor o representante favor indicalo marcando el check; Si eres fabricante continua tu proceso con normalidad</p>-->
              <div class="form-row">
               <!--<div class="form-group form-check">
                  <input type="checkbox" value="DISTRIBUIDOR" wire:model="typeCompany" class="form-check-input" id="exampleCheck1">
                  <label class="form-check-label" for="exampleCheck1">SOY DISTRIBUIDOR/REPRESENTANTE </label>
                </div>-->
                <div class="form-group col-6">
                  <label for="inputNameCompany">Productos de interes</label>
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
                  <label for="inputNameCompany">Perfil a participar</label>
                  <select id="inputState" wire:model="country" class="form-control @error('country') is-invalid @enderror">
                    <option selected>Fabricantes</option>
                        <option value="ReactivosLaboratorio">Distribuidor</option>
                  </select>
                    @error('country')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group col-12">
                  <label for="inputNameCompany">Nombre de Fabricante o Distribuidor</label>
                  <input wire:model="BusinnessName" type="text" class="form-control @error('BusinnessName') is-invalid @enderror" id="inputAddress" placeholder="SICA SA de CV">
                    @error('BusinnessName')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                  <div class="form-group col-12">
                      <label for="inputNameCompany">Logo de la empresa</label>
                      <input wire:model="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror" id="inputAddress" placeholder="SICA SA de CV">
                      @error('avatar')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                  </div>
                <div class="form-group col-3">
                  <select id="inputState" wire:model="country" class="form-control @error('country') is-invalid @enderror">
                    <option selected>Seleccione Pais</option>
                    <option value="EL SALVADOR">EL SALVADOR</option>
                    <option value="GUATEMALA">GUATEMALA</option>
                    <option value="HONDURAS">HONDURAS</option>
                    <option value="NICARAGUA">NICARAGUA</option>
                    <option value="COSTA RICA">COSTA RICA</option>s
                    <option value="PANAMA">PANAMA</option>
                    <option value="BELICE">BELICE</option>
                  </select>
                    @error('country')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group col-3">
                  <select id="inputState" wire:model="city" class="form-control @error('city') is-invalid @enderror">
                    <option selected>Provincia o Municipio</option>
                    <option value="SAN MIGUEL">SAN MIGUEL</option>
                    <option value="SAN SALVADOR">SAN SALVADOR</option>
                    <option value="SANTA ANA">SANTA ANA</option>
                    <option value="SONSONATE">SONSONATE</option>
                    <option value="LA UNION">LA UNION</option>
                    <option value="LA LIBERTAD">LA LIBERTAD</option>
                    <option value="CUSCATLAN">CUSCATLAN</option>
                    <option value="CHALATENANGO">CHALATENANGO</option>
                    <option value="LA PAZ">LA PAZ</option>
                    <option value="CABAÑAS">CABAÑAS</option>
                    <option value="MORAZAN">MORAZAN</option>
                    <option value="USULUTAN">USULUTAN</option>
                    <option value="SAN VICENTE">SAN VICENTE</option>
                    <option value="AHUACHAPAN">AHUACHAPAN</option>
                  </select>
                    @error('city')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group col-6">
                <!--<label for="inputAddress">Dirección</label>-->
                <input type="text" wire:model="address" class="form-control @error('address') is-invalid @enderror" id="inputAddress" placeholder="Escribe tu Dirección" required>
                    @error('address')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group col-4">
                  <label for="inputEmail4">Teléfono</label>
                  <input type="tel" wire:model="phone" class="form-control @error('phone') is-invalid @enderror" id="inputEmail4">
                    @error('phone')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group col-4">
                  <label for="inputPassword4">Facsímile</label>
                  <input type="phone" wire:model="facsimile" class="form-control" id="inputPassword4">
                </div>
                <div class="form-group col-4">
                  <label for="inputPassword4">Número Whatssapp</label>
                  <input type="phone" wire:model="facsimile" class="form-control" id="inputPassword4">
                </div>
                <div class="form-group col-12">
                  <label for="inputNameCompany">Url o dirección WEB</label>
                  <input type="text" wire:model="website" class="form-control" id="inputAddress" placeholder="https://ejemplo.com">
                </div>
              </div>
            </fieldset>

            <!--Segunda parte del Formulario Persona de CONTACTO -->
            <fieldset class="form-group">
              <legend>Contacto de registro legal</legend>
            <div class="form-row">
              <div class="form-group col-12">
                <label for="inputNameCompany">Adjuntar documentanción de registro legal</label>
                <input wire:model="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror" id="inputAddress" placeholder="Documentos.pdf">
                @error('avatar')
                <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
              <div class="form-group col-6">
                <label for="inputNameCompany">Nombre</label>
                <input type="text" wire:model="firstName" class="form-control @error('firstName') is-invalid @enderror" id="inputAddress" placeholder="Ejemplo SA de CV">
                  @error('firstName ')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
              </div>
              <div class="form-group col-3">
                <label for="inputNameCompany">Número de contacto</label>
                <input type="text" wire:model="lastName" class="form-control @error('lastName') is-invalid @enderror" id="inputAddress" placeholder="SICA SA de CV">
                  @error('lastName ')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
              </div>
              <div class="form-group col-3">
                <label for="inputNameCompany">E-mail:</label>
                <input type="mail" wire:model="email" class="form-control @error('email') is-invalid @enderror" id="inputAddress" placeholder="SICA SA de CV">
                  @error('email ')
                  <span class="text-danger">{{$message}}</span>
                  @enderror
              </div>
            </fieldset>
            <fieldset class="form-group">
              <legend>Adjuntar documentación</legend>
            <div class="form-row">
              <div class="form-group col-4">
                <label for="inputNameCompany">Documento de Identidad</label>
                <input wire:model="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror" id="inputAddress" placeholder="Documentos.pdf">
                @error('avatar')
                <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
              <div class="form-group col-4">
                <label for="inputNameCompany">Poder de Representación</label>
                <input wire:model="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror" id="inputAddress" placeholder="Documentos.pdf">
                @error('avatar')
                <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
              <div class="form-group col-4">
                <label for="inputNameCompany">Licencia de Funcionamiento</label>
                <input wire:model="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror" id="inputAddress" placeholder="Documentos.pdf">
                @error('avatar')
                <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
            </fieldset>

            <button type="button" wire:click="create()" class="btn btn-primary">Guardar</button>
              
              <button type="button" class="btn btn-danger">Cancelar</button>

          <!--Tercera parte del Formulario Datos de Ingreso-->
          
            </form>
          </div>





         <livewire:search-universal></livewire:search-universal>
        </div>


@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/dashboard.init.js')}}"></script>\
    <script>
        document.addEventListener('livewire:initialized', function () {
            @this.
            on('success_messages', (event) => {
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
            @this.on('error_messages', (event) => {
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
