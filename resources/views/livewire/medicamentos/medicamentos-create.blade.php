{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous"> --}}

@include('components.headermodal')

@if(session('status'))
    <div class="alert alert-success">
        {{session('status')}}
    </div>
@endif
<form>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Código</label>
        <input wire:model="cod_medicamento" type="text" class="form-control @error('cod_medicamento') is-invalid @enderror" >
        @error('cod_medicamento')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Descripción</label>
        <textarea wire:model="descripcion" class="form-control @error('descripcion') is-invalid @enderror" rows="3"></textarea>
        @error('descripcion')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Familia producto</label>  
        <select name="id_familia_producto" id="id_familia_producto" class="form-control" wire:model.live="FamProductoId">
            <option value="#">Seleccione</option>
            @foreach ($familias_producto as $item)
                <option value="{{$item->id}}">{{$item->familia_producto}}</option>
            @endforeach
        </select>
        @error('id_familia_producto')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Grupo Familia</label>  
        <select name="id_grupo_familia" id="id_grupo_familia" class="form-control" wire:model="GrupoFamiliaId">
            @if ($grupo_familia->count() == 0)
                <option value="#">Seleccione</option>
            @endif
            @foreach ($grupo_familia as $item)
                <option value="{{$item->id}}">{{$item->grupo}}</option>
            @endforeach
        </select>
        @error('id_grupo_familia')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Grupo de Requisitos</label>  
        <select name="id_grupo_requerimiento" id="id_grupo_requerimiento" class="form-control" wire:model="GrupoRequisitoId">
            @if ($grupo_requisitos->count() == 0)
                <option value="#">Seleccione</option>
            @endif
            @foreach ($grupo_requisitos as $item)
                <option value="{{$item->id}}">{{$item->grupo}}</option>
            @endforeach
        </select>
        @error('id_grupo_requerimiento')
            <span class="text-danger">{{$message}}</span>
        @enderror
    </div>
    
    
    
</form>
@include('components.footermodal')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>