{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous"> --}}
<div class="modal fade bs-example-modal-xl" wire:ignore.self id="modalCreateFabric" role="dialog"
     aria-labelledby="modalCreateFabricTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="modalCreateFabricTitle">Crear Nuevo Fabricante</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                @if(session('status'))
                    <div class="alert alert-success">
                        {{session('status')}}
                    </div>
                @endif
                <form>
                    <fieldset class="form-group">

                        <!--<p>Si eres distribuidor o representante favor indicalo marcando el check; Si eres fabricante continua tu proceso con normalidad</p>-->
                        <div class="form-row">
                            <!--<div class="form-group form-check">
                               <input type="checkbox" value="DISTRIBUIDOR" wire:model="typeCompany" class="form-check-input" id="exampleCheck1">
                               <label class="form-check-label" for="exampleCheck1">SOY DISTRIBUIDOR/REPRESENTANTE </label>
                             </div>-->
                            <div class="form-group col-6">
                                <label for="inputNameCompany">Familia de productos interes</label>
                                <select id="inputState" wire:model="familyProductsInput"
                                        class="form-control @error('familyProductsInput') is-invalid @enderror">
                                    <option selected>Selecciona una familia de productos</option>
                                    @foreach($familyProducts as $familyProduct)
                                        <option
                                            value="{{$familyProduct->id}}">{{$familyProduct->familia_producto}}</option>
                                    @endforeach
                                </select>
                                @error('familyProductsInput')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>


                            <div class="form-group col-6">
                                <label for="inputNameCompany">Perfil a participar</label>
                                <select id="inputState" wire:model="typeCompany"
                                        class="form-control @error('typeCompany') is-invalid @enderror">
                                    <option value="F" selected>Fabricantes</option>
                                    {{--                                    <option value="ReactivosLaboratorio">Distribuidor</option>--}}
                                </select>
                                @error('typeCompany')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group col-8">
                                <label for="inputNameCompany">Nombre de la compañia</label>
                                <input wire:model="BusinnessName" type="text"
                                       class="form-control @error('BusinnessName') is-invalid @enderror"
                                       id="inputAddress"
                                       placeholder="SICA SA de CV">
                                @error('BusinnessName')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            {{--                            <div class="form-group col-4">--}}
                            {{--                                <label for="inputNameCompany">Usuario de acceso</label>--}}
                            {{--                                <input wire:model="userNameCompany" type="text"--}}
                            {{--                                       class="form-control @error('userNameCompany') is-invalid @enderror"--}}
                            {{--                                       id="inputAddress"--}}
                            {{--                                       placeholder="empresasv">--}}
                            {{--                                @error('userNameCompany')--}}
                            {{--                                <span class="text-danger">{{$message}}</span>--}}
                            {{--                                @enderror--}}
                            {{--                            </div>--}}

                            {{--                            <div class="form-group col-12">--}}
                            {{--                                <label for="inputNameCompany">Logo de la empresa</label>--}}
                            {{--                                <input wire:model="avatar" type="file"--}}
                            {{--                                       class="form-control @error('avatar') is-invalid @enderror" id="inputAddress"--}}
                            {{--                                       placeholder="SICA SA de CV">--}}
                            {{--                                @error('avatar')--}}
                            {{--                                <span class="text-danger">{{$message}}</span>--}}
                            {{--                                @enderror--}}
                            {{--                            </div>--}}
                            <div class="form-group col-12">
                                <label class="fw-bold mb-2">Dirección de Lugar de Fabricación</label>
                                <div class="row">
                                    <div class="form-group col-3">
                                        <select id="inputState" wire:model.live="country"
                                                class="form-control @error('country') is-invalid @enderror">
                                            <option selected>Seleccione Pais</option>

                                            @if(!empty($countries))
                                                @foreach($countries as $itemsCountries)
                                                    <option
                                                        value="{{$itemsCountries->id}}">{{$itemsCountries->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('country')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-3">
                                        <select id="inputState" wire:model="city"
                                                class="form-control @error('city') is-invalid @enderror">
                                            <option selected>Selecciona el Estado o Ciudad</option>
                                            @if(!empty($inputStates))
                                                @foreach($inputStates as $inputState)
                                                    <option value="{{$inputState->id}}">{{$inputState->name}}</option>

                                                @endforeach
                                            @endif

                                        </select>
                                        @error('city')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <!--<label for="inputAddress">Dirección</label>-->
                                        <input type="text" wire:model="address"
                                               class="form-control @error('address') is-invalid @enderror"
                                               id="inputAddress"
                                               placeholder="Escribe tu Dirección" required>
                                        @error('address')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <label for="inputEmail4">Teléfono</label>
                                <input type="tel" wire:model="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       id="inputEmail4">
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
                                <input type="phone"
                                       class="form-control @error('whatsapp') is-invalid @enderror" id="whatsapp">
                                @error('whatsapp')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group col-12">
                                <label for="inputNameCompany">Web del Fabricante</label>
                                <input type="text" wire:model="website" class="form-control" id="inputAddress"
                                       placeholder="https://ejemplo.com">
                            </div>
                        </div>
                    </fieldset>

                    <!--Segunda parte del Formulario Persona de CONTACTO -->
                    <fieldset class="form-group">
                        <legend>Datos de Contacto del Fabricante</legend>
                        <div class="form-row">
                            {{--                            <div class="form-group col-12">--}}
                            {{--                                <label for="inputNameCompany">Adjuntar documentanción de registro legal</label>--}}
                            {{--                                <input wire:model="docRegister" type="file" accept=".pdf,application/pdf"--}}
                            {{--                                       class="form-control @error('docRegister') is-invalid @enderror" id="docRegister"--}}
                            {{--                                       placeholder="Documentos.pdf">--}}
                            {{--                                @error('docRegister')--}}
                            {{--                                <span class="text-danger">{{$message}}</span>--}}
                            {{--                                @enderror--}}
                            {{--                            </div>--}}
                            <div class="form-group col-6">
                                <label for="inputNameCompany">Nombre de Contacto</label>
                                <input type="text" wire:model="firstName"
                                       class="form-control @error('firstName') is-invalid @enderror" id="inputAddress"
                                       placeholder="Ejemplo SA de CV">
                                @error('firstName ')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group col-3">
                                <label for="inputNameCompany">Número de contacto</label>
                                <input type="text" wire:model="lastName"
                                       class="form-control @error('lastName') is-invalid @enderror" id="inputAddress"
                                       placeholder="SICA SA de CV">
                                @error('lastName ')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group col-3">
                                <label for="inputNameCompany">Correo electrónico de contacto:</label>
                                <input type="mail" wire:model="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="inputAddress" placeholder="SICA SA de CV">
                                @error('email ')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                    </fieldset>
                    <fieldset class="form-group">
                        <legend>Adjuntar documentación</legend>
                        <div class="form-row">
                            {{--                            <div class="form-group col-4">--}}
                            {{--                                <label for="inputNameCompany">Documento de Identidad</label>--}}
                            {{--                                <input wire:model="docId" type="file" accept=".pdf,application/pdf"--}}
                            {{--                                       class="form-control @error('docId') is-invalid @enderror" id="docId"--}}
                            {{--                                       placeholder="Documentos.pdf">--}}
                            {{--                                @error('docId')--}}
                            {{--                                <span class="text-danger">{{$message}}</span>--}}
                            {{--                                @enderror--}}
                            {{--                            </div>--}}
                            {{--                            <div class="form-group col-4">--}}
                            {{--                                <label for="inputNameCompany">Poder de Representación</label>--}}
                            {{--                                <input wire:model="docPoder" type="file" accept=".pdf,application/pdf"--}}
                            {{--                                       class="form-control @error('docPoder') is-invalid @enderror" id="docPoder"--}}
                            {{--                                       placeholder="Documentos.pdf">--}}
                            {{--                                @error('docPoder')--}}
                            {{--                                <span class="text-danger">{{$message}}</span>--}}
                            {{--                                @enderror--}}
                            {{--                            </div>--}}
                            {{--                            <div class="form-group col-4">--}}
                            {{--                                <label for="inputNameCompany">Licencia de Funcionamiento</label>--}}
                            {{--                                <input wire:model="docLicense" type="file" accept=".pdf,application/pdf"--}}
                            {{--                                       class="form-control @error('docLicense') is-invalid @enderror" id="docLicense"--}}
                            {{--                                       placeholder="Documentos.pdf">--}}
                            {{--                                @error('docLicense')--}}
                            {{--                                <span class="text-danger">{{$message}}</span>--}}
                            {{--                                @enderror--}}
                            {{--                            </div>--}}
                        </div>
                    </fieldset>

                    <button type="button" wire:click="createFabric()" class="btn btn-primary">Guardar</button>

                    <button type="button" class="btn btn-danger">Cancelar</button>

                    <!--Tercera parte del Formulario Datos de Ingreso-->

                </form>


            </div>
            <div class="modal-footer">

                {{--                <button type="button" class="btn bg-primary" wire:click="createFabric()">Guardar</button>--}}


            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
