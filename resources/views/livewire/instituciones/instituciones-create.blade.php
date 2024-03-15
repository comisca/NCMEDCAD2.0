{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous"> --}}

@include('components.headermodal')

@if(session('status'))
    <div class="alert alert-success">
        {{session('status')}}
    </div>
@endif
<form>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">País</label>        
        <select wire:model="id_pais" id="pais"  name="pais" placeholder="Pais" class="form-control" required>
            <option value=0 >-- Seleccionar -- </option>
            @foreach($dataPaises as $obj_item)
                  <option value="{{$obj_item->id}}">{{$obj_item->pais}}</option>
            @endforeach
        </select>
        @error('id_pais')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Institución</label>
        <input wire:model="institucion" type="text" class="form-control @error('institucion') is-invalid @enderror" >
        @error('institucion')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Paga Cuota</label>    
        <select wire:model="paga_cuota" id="paga_cuota"  name="paga_cuota" placeholder="paga_cuota" class="form-control" required>
            @if($idSelecte == 0)
                <option value="#">Seleccione</option>
                <option value="1">Si</option>
                <option value="0">No</option>
            @else
                @if($paga_cuota == 1)
                    <option value="1" selected>Si</option>
                    <option value="0">No</option>
                @else
                    <option value="0" selected>No</option>
                    <option value="1">Si</option>
                @endif
            @endif        
        </select>
        @error('paga_cuota')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Cuota Pagada</label>    
        <select wire:model="cuota_pagada" id="paga_cuota"  name="cuota_pagada" placeholder="cuota_pagada" class="form-control" required>
            @if($idSelecte == 0)
                <option value="#">Seleccione</option>
                <option value="1">Si</option>
                <option value="0">No</option>
            @else
                @if($paga_cuota == 1)
                    <option value="1" selected>Si</option>
                    <option value="0">No</option>
                @else
                    <option value="0" selected>No</option>
                    <option value="1">Si</option>
                @endif
            @endif        
        </select>
        @error('cuota_pagada')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Ministerio de Salud?</label>    
        <select wire:model="es_minsa" id="paga_cuota"  name="es_minsa" placeholder="es_minsa" class="form-control" required>
            @if($idSelecte == 0)
                <option value="#">Seleccione</option>
                <option value="1">Si</option>
                <option value="0">No</option>
            @else
                @if($paga_cuota == 1)
                    <option value="1" selected>Si</option>
                    <option value="0">No</option>
                @else
                    <option value="0" selected>No</option>
                @endif
            @endif        
        </select>
        @error('es_minsa')
        <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Encabezado de Nota de Cobro</label>
        <textarea wire:model="encabezado_nota_cobro" class="form-control @error('encabezado_nota_cobro') is-invalid @enderror" rows="3"></textarea>
        @error('encabezado_nota_cobro')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
</form>
@include('components.footermodal')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>