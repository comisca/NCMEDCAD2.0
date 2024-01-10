<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DB;

class RolesComponet extends Component
{

use WithPagination;
    public $roles, $descripcion, $searchQuety, $nameUser, $subTittle;
    public $idSelecte;
    public $namePage, $nameModal;
    public $pagination = 10;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }


    // este metodo se ejectuta antes de que cargue el html
    public function mount()
    {      $this->namePage = 'Roles';
        $this->nameUser = Session::get('name_user');
        $this->subTittle = 'Controla accesos y responsabilidades para una administración eficiente de roles y funciones';
        $this->idSelecte = 0;
    }


    public function render()
    {


        if (strlen($this->searchQuety) > 0) {
            $roles = Role::where('name', 'like', '%' . $this->searchQuety . '%')
                ->paginate($this->pagination);

        } else {
            $roles = Role::orderBy('id', 'desc')->paginate($this->pagination);
        }

        return view('livewire.settings.roles-componet', ['data' => $roles])
        ->extends('layouts.master')
        ->section('content');
    }

       public function create()
        {

            $rules = [
                'roles' => 'required|min:2|unique:roles,name',
                'descripcion' => 'required|min:2'
            ];
            $messages = [
                'roles.required' => 'El Rol es requerido',
                'roles.min' => 'El Rol debe se mayor a 2 caracteres',
                'roles.unique' => 'El el Rol ya existe en la bade de datos',
                'descripcion.required' => 'La descripción es requerida',
                'descripcion.min' => 'La descripción debe ser mayor a 2 caracteres'
            ];

            $this->validate($rules, $messages);


            try {
                DB::beginTransaction();

                Role::create([
                    'name' => $this->roles,
                    'descriptions' => $this->descripcion
                ]);
                $this->resetUI();
                $this->dispatch('roles-added', messages: 'Rol agregado correctamente');
                DB::commit();

            } catch (\Throwable $th) {
                DB::rollBack();
                $this->dispatch('roles-error', messages: 'Hubo un problema!! contacta a soporte!');
            }


        }


          public function update()
            {
                $rules = [
                    'roles' => 'required|min:2|unique:roles,name,' . $this->idSelecte,
                    'descripcion' => 'required|min:2'
                ];
                $messages = [
                    'roles.required' => 'El role es requerido',
                    'roles.min' => 'El role debe se mayor a 2 caracteres',
                    'roles.unique' => 'El role ya existe en la bade de datos',
                    'descripcion.required' => 'La descripción es requerida',
                    'descripcion.min' => 'La descripción debe ser mayor a 2 caracteres'
                ];

                $this->validate($rules, $messages);
                try {
                    DB::beginTransaction();
                    $roles = Role::find($this->idSelecte);
                    $roles->name = $this->roles;
                    $roles->descriptions = $this->descripcion;
                    $roles->save();
                    DB::commit();
                    $this->idSelecte=0;
                    $this->resetUI();
                    $this->dispatch('roles-added', messages: 'El Rol fue actualizado correctamente');
                } catch (\Throwable $th) {
                    DB::rollBack();
                    $this->dispatch('roles-error', messages: 'ha ocurrido un problema contacta a soporte');
                }
            }

    #[On('deleteroles')]
            public function deletexid($postId)
            {
                $permissionCount = Role::find($postId)->permissions->count();
                if ($permissionCount > 0) {
                    $this->dispatch('roles-error', messages: 'No se puede eliminar el Rol porque tiene permisos asociados');
                    return;
                }

                Role::find($postId)->delete();
                $this->dispatch('roles-added', messages: 'El Rol fue eliminado correctamente');
            }

    public function editRoles($idrole)
    {
        $this->idSelecte = $idrole;
        $namerles = Role::find($idrole);
        $this->roles = $namerles->name;
        $this->descripcion = $namerles->descriptions;
        $this->dispatch('roles-selected');

    }






    public function resetUI()
        {
            $this->roles = '';
            $this->descripcion = '';
            $this->idSelecte = 0;

        }

}
