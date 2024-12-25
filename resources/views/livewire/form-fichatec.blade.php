{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous"> --}}
<div class="modal fade bs-example-modal-xl" wire:ignore.self id="modalFichaTecnica" role="dialog"
     aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="exampleModalScrollableTitle">Creacion de aplicacion</h5>
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

                    <div class="mb-3">
                        <label for="legalName" class="form-label">Nombre Comercial</label>

                        <input wire:model="legalName" type="text"
                               class="form-control @error('legalName') is-invalid @enderror">


                        @error('legalName')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="numRegisterSalud" class="form-label">Numero de Registros de Salud</label>

                        <input wire:model="numRegisterSalud" type="text"
                               class="form-control @error('numRegisterSalud') is-invalid @enderror">


                        @error('numRegisterSalud')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="countryRegister" class="form-label">Seleccione el pais de registro</label>
                        <select id="inputState" wire:model="countryRegister"
                                class="form-control @error('countryRegister') is-invalid @enderror">
                            <option selected>Seleccione Pais</option>
                            <option value="1">EL SALVADOR</option>
                            <option value="2">GUATEMALA</option>
                            <option value="2">HONDURAS</option>
                            <option value="3">NICARAGUA</option>
                            <option value="4">COSTA RICA</option>
                            <option value="5">PANAMA</option>
                            <option value="6">BELICE</option>
                        </select>


                        @error('countryRegister')
                        <span class="text-danger">{{$message}}</span>
                        @enderror


                    </div>

                    <div class="mb-3">
                        <label for="registerNumber" class="form-label">Numero de registro</label>

                        <input wire:model="registerNumber" type="text"
                               class="form-control @error('registerNumber') is-invalid @enderror">


                        @error('registerNumber')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="companieF" class="form-label">Fabricante</label>
                        <select id="companieF" wire:model="companieF"
                                class="form-control @error('companieF') is-invalid @enderror">
                            <option selected>Selecciona un Fabricante</option>
                            @if(!@empty($bussinessFabricante))
                                @foreach ($bussinessFabricante as $itemsBussinessFabricante)

                                    <option
                                        value="{{ $itemsBussinessFabricante->id }}">{{ $itemsBussinessFabricante->legal_name }}</option>

                                @endforeach
                            @endif

                        </select>


                        @error('companieF')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </form>

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
                        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
                        crossorigin="anonymous"></script>


            </div>
            <div class="modal-footer">

                <button type="button" class="btn bg-primary" wire:click="create()">Guardar</button>


            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
