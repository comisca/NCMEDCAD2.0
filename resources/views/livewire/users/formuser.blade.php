@include('components.headermodal')

<div class="col-md-12">
    <div class="mb-3">
    <label class="form-label">Nombres</label>
    <input wire:model.live="firstName" type="text" class="form-control" placeholder="Nombres">
        @error('permisos')
        <ul class="parsley-errors-list filled" id="parsley-id-9" aria-hidden="false">
            <li class="parsley-required">{{$message}} .</li>
        </ul>
        @enderror
</div>
</div>


<div class="col-md-12">
    <div class="mb-3">
    <label class="form-label">Apellidos</label>
    <input wire:model.live="firstName" type="text" class="form-control" placeholder="Nombres">
        @error('permisos')
        <ul class="parsley-errors-list filled" id="parsley-id-9" aria-hidden="false">
            <li class="parsley-required">{{$message}} .</li>
        </ul>
        @enderror
</div>
</div>
<div class="col-md-12">
    <div class="mb-3">
        <label class="form-label">DUI</label>
        <input wire:model.live="firstName" type="text" class="form-control" placeholder="Nombres">
        @error('permisos')
        <ul class="parsley-errors-list filled" id="parsley-id-9" aria-hidden="false">
            <li class="parsley-required">{{$message}} .</li>
        </ul>
        @enderror
    </div>
</div>
<div class="col-md-12">
    <div class="mb-3">
        <label class="form-label">Clave de acceso</label>
        <input wire:model.live="firstName" type="text" class="form-control" placeholder="Nombres">
        @error('permisos')
        <ul class="parsley-errors-list filled" id="parsley-id-9" aria-hidden="false">
            <li class="parsley-required">{{$message}} .</li>
        </ul>
        @enderror
    </div>
</div>

<div class="col-md-12">
    <div class="mb-3">
        <label class="form-label">Asignar Roles</label>
        <select class="custom-select">
            <option selected>Open this select menu</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
        </select>
        @error('permisos')
        <ul class="parsley-errors-list filled" id="parsley-id-9" aria-hidden="false">
            <li class="parsley-required">{{$message}} .</li>
        </ul>
        @enderror
    </div>
</div>




@include('components.footermodal')
