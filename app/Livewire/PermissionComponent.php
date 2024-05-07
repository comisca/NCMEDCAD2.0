<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;
use Spatie\Permission\Models\Permission;

class PermissionComponent extends Component
{

use WithPagination;
    public $permisos, $descripcion, $searchQuety, $nameUser, $subTittle;
    public $idSelecte;
    public $namePage, $nameModal;
    public $pagination = 10;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->namePage = 'Permisos';
        $this->nameUser = Session::get('name_user');
        $this->subTittle = 'Controla accesos y responsabilidades para una administración eficiente de permisos y funciones';
        $this->idSelecte = 0;

    }


    public function render()
    {
        if (strlen($this->searchQuety) > 0) {
            $roles = Permission::where('name', 'like', '%' . $this->searchQuety . '%')
                ->paginate($this->pagination);

        } else {
            $roles = Permission::orderBy('id', 'desc')->paginate($this->pagination);
        }

        return view('livewire.settings.permission-component', ['data' => $roles])
        ->extends('layouts.master')
        ->section('content');
    }

       public function create()
        {

            $rules = [
                'permisos' => 'required|min:2|unique:permissions,name',
                'descripcion' => 'required|min:2'
            ];
            $messages = [
                'permisos.required' => 'El permiso es requerido',
                'permisos.min' => 'El permiso debe se mayor a 2 caracteres',
                'permisos.unique' => 'El el el permiso ya existe en la bade de datos',
                'descripcion.required' => 'La descripción es requerida',
                'descripcion.min' => 'La descripción debe ser mayor a 2 caracteres'
            ];

            $this->validate($rules, $messages);


            try {
                DB::beginTransaction();

                Permission::create([
                    'name' => $this->permisos,
                    'descriptions' => $this->descripcion
                ]);
                $this->resetUI();
                $this->dispatch('roles-added', messages: 'el permiso fue agregado correctamente');
                DB::commit();

            } catch (\Throwable $th) {
                DB::rollBack();
                $this->dispatch('roles-error', messages: 'Hubo un problema!! contacta a soporte!');
            }

        }


          public function update()
            {
                $rules = [
                    'permisos' => 'required|min:2|unique:permissions,name,' . $this->idSelecte,
                    'descripcion' => 'required|min:2'
                ];
                $messages = [
                    'permisos.required' => 'El permiso es requerido',
                    'permisos.min' => 'El permiso debe se mayor a 2 caracteres',
                    'permisos.unique' => 'El permiso ya existe en la bade de datos',
                    'descripcion.required' => 'La descripción es requerida',
                    'descripcion.min' => 'La descripción debe ser mayor a 2 caracteres'
                ];

                $this->validate($rules, $messages);
                try {
                    DB::beginTransaction();
                    $roles = Permission::find($this->idSelecte);
                    $roles->name = $this->permisos;
                    $roles->descriptions = $this->descripcion;
                    $roles->save();
                    DB::commit();
                    $this->idSelecte=0;
                    $this->resetUI();
                    $this->dispatch('roles-added', messages: 'El permiso fue actualizado correctamente');
                } catch (\Throwable $th) {
                    DB::rollBack();
                    $this->dispatch('roles-error', messages: 'ha ocurrido un problema contacta a soporte');
                }
            }

    #[On('deleteroles')]
            public function deletexid($postId)
            {
                $permissionCount = Permission::find($postId)->getRoleNames()->count();
                if ($permissionCount > 0) {
                    $this->dispatch('roles-error', messages: 'No se puede eliminar el permiso porque tiene roles asociados');
                    return;
                }

                Permission::find($postId)->delete();
                $this->dispatch('roles-added', messages: 'El permiso fue eliminado correctamente');
            }

    public function editRoles($idrole)
    {
        $this->idSelecte = $idrole;
        $namerles = Permission::find($idrole);
        $this->permisos = $namerles->name;
        $this->descripcion = $namerles->descriptions;
        $this->dispatch('roles-selected');

    }





     public function resetUI()
        {
            $this->permisos = '';
            $this->descripcion = '';
            $this->idSelecte = 0;

        }

}
