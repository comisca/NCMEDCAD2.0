
@include('components.headermodal')

<div class="col-md-12">
    <div class="mb-3">
        <div class="position-relative">

        </div>
    </div>
</div>

<div class="col-md-12">

    <div class="card-body">


        <div class="form-group row">
            <label for="example-text-input" class="col-md-2 col-form-label">Nombre</label>
            <div class="col-md-10">
                <input wire:model="firts_name" class="form-control" type="text"  id="example-text-input">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-md-2 col-form-label">Apellidos</label>
            <div class="col-md-10">
                <input wire:model="lastName" class="form-control" type="text"  id="example-text-input">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-text-input" class="col-md-2 col-form-label">DUI</label>
            <div class="col-md-10">
                <input wire:model="dui" class="form-control" type="text"  id="example-text-input">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-search-input" class="col-md-2 col-form-label">Email</label>
            <div class="col-md-10">
                <input wire:model="email" class="form-control" type="email"  id="example-search-input">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-email-input" class="col-md-2 col-form-label">Password</label>
            <div class="col-md-10">
                <input wire:model="password"class="form-control" type="password"  id="example-email-input">
            </div>
        </div>


        <div class="form-group row">
            <label class="col-md-2 col-form-label">Roles</label>
            <div class="col-md-10">
                <select wire:model="role_id"  class="form-control">
                    <option value="0">Selecciona un rol</option>
                    @if(!empty($dataRoles))
                        @foreach($dataRoles as $rol)
                            <option value="{{$rol->name}}">{{$rol->name}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>


    </div>





</div>

@include('components.footermodal')




