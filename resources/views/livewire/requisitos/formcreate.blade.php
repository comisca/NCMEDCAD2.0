{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous"> --}}

@include('components.headermodal')

@if(session('status'))
    <div class="alert alert-success">
        {{session('status')}}
    </div>
@endif
<form>
    <div class="row">
        <div class=" col-md-6">
            <label for="exampleInputEmail1" class="form-label">Familia de Productos</label>
            <select name="GrupoRequisitoId" id="GrupoRequisitoId"
                    class="form-control @error('groupFamilyId') is-invalid @enderror" wire:model.live="groupFamilyId">

                <option value="">Seleccione</option>

                @foreach ($grupo_familia as $item)
                    <option value="{{$item->id}}">{{$item->familia_producto}}</option>
                @endforeach
            </select>
            @error('groupFamilyId')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class=" col-md-6">
            <label for="exampleInputEmail1" class="form-label">Código</label>
            <input wire:model="codRequisitos" type="text"
                   class="form-control @error('codRequisitos') is-invalid @enderror">
            @error('codRequisitos')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="exampleInputEmail1" class="form-label">Tipo de requisitos</label>
            <select name="tiporequisito" id="tiporequisito"
                    class="form-control @error('tiporequisito') is-invalid @enderror" wire:model="tiporequisito">
                <option value="">Seleccione Tipo de requisito</option>
                <option value="ADMINISTRATIVOS">ADMINISTRATIVOS</option>
                <option value="TECNICOS">TECNICOS</option>

            </select>
            @error('tiporequisito')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="exampleInputEmail1" class="form-label">Tipo de participante</label>
            <select name="tipopaeticipante" id="tipopaeticipante"
                    class="form-control @error('tipopaeticipante') is-invalid @enderror" wire:model="tipopaeticipante">

                <option value="">Seleccione Tipo de Participantes</option>

                <option value="FABRICANTES">FABRICANTES</option>
                <option value="DISTRIBUIDOR/REPRESENTANTES">DISTRIBUIDOR/REPRESENTANTES</option>

            </select>
            @error('tipopaeticipante')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class=" col-md-6">
            <label for="exampleInputEmail1" class="form-label">Grupo de requisitos</label>
            <select name="grupoRequisitoId" id="grupoRequisitoId" class="form-control" wire:model="grupoRequisitoId">


                <option value="">Seleccione</option>
                @if(!empty($grupo_requisitos))
                    @foreach ($grupo_requisitos as $item)
                        <option value="{{$item->id}}">{{$item->grupo}}</option>
                    @endforeach
                @endif
            </select>
            @error('grupoRequisitoId')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="exampleInputEmail1" class="form-label">Tipo de validacion</label>
            <select name="tipovalidacion" id="tipovalidacion"
                    class="form-control @error('tipovalidacion') is-invalid @enderror" wire:model="tipovalidacion">

                <option value="">Seleccione el tipo de validacion</option>

                <option value="SIMPLE">SIMPLE</option>
                <option value="OPCION MULTIPLE">OPCION MULTIPLE</option>
                <option value="SELECCION MULTIPLE">SELECCION MULTIPLE</option>

            </select>
            @error('tipovalidacion')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="exampleInputEmail1" class="form-label">Descripción</label>
            <textarea wire:model="descripcion" class="form-control @error('descripcion') is-invalid @enderror"
                      rows="3"></textarea>
            @error('descripcion')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="col-md-6">
            <label for="exampleInputEmail1" class="form-label">Mensaje no cumple</label>
            <textarea wire:model="messagesno" class="form-control @error('mesagesno') is-invalid @enderror"
                      rows="3"></textarea>
            @error('messagesno')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <br>
        <hr>

        <div class=" col-md-3">
            <label for="exampleInputEmail1" class="form-label">Es Obligatorio?</label>
            <input wire:model="obligatorio" type="checkbox" class="@error('obligatorio') is-invalid @enderror">
            @error('obligatorio')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class=" col-md-3">
            <label for="exampleInputEmail1" class="form-label">Aplica a fichas y aplicaiones?</label>
            <input wire:model="fichaAplicacion" type="checkbox" class="@error('obligatorio') is-invalid @enderror">
            @error('fichaAplicacion')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class=" col-md-3">
            <label for="exampleInputEmail1" class="form-label">Vence?</label>
            <input wire:model="vencimiento" type="checkbox" class="@error('obligatorio') is-invalid @enderror">
            @error('vencimiento')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class=" col-md-3">
            <label for="exampleInputEmail1" class="form-label">Entregable?</label>
            <input wire:model="entregable" type="checkbox" class=" @error('obligatorio') is-invalid @enderror">
            @error('entregable')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>


    </div>
</form>
@include('components.footermodal')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
