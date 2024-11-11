{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous"> --}}
<div class="modal fade bs-example-modal-xl" wire:ignore.self id="modalFichaTecnica" role="dialog"
     aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="exampleModalScrollableTitle">Detalles de medicamento</h5>
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
                        <label for="nameGroup" class="form-label">Nombre Comercial</label>

                        <input wire:model="nameGroup" type="text"
                               class="form-control @error('nameGroup') is-invalid @enderror">


                        @error('nameGroup')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nameGroup" class="form-label">Numero de Registros de Salud</label>

                        <input wire:model="nameGroup" type="text"
                               class="form-control @error('nameGroup') is-invalid @enderror">


                        @error('nameGroup')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nameGroup" class="form-label">Seleccione el pais de registro</label>
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


                        @error('nameGroup')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nameGroup" class="form-label">Numero de registro</label>

                        <input wire:model="nameGroup" type="text"
                               class="form-control @error('nameGroup') is-invalid @enderror">


                        @error('nameGroup')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nameGroup" class="form-label">Pais de registro</label>
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


                        @error('nameGroup')
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
