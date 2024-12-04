<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Termwind\Components\Dd;
use Throwable;

class AsisComponent extends Component
{

    use WithPagination;

    public $searchQuety, $nameUser, $subTittle, $roleSelect;
    public $idSelecte;
    public $namePage, $nameModal;
    public $pagination = 10;
    public $permissionSelecte = [], $permissionOld = [];

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->namePage = 'Permisos';
        $this->nameUser = Session::get('name_user');
        $this->subTittle =
            'Controla accesos y responsabilidades para una administración eficiente de permisos y funciones';
        $this->idSelecte = 0;
        $this->roleSelect = 'Elegir';

    }


    public function render()
    {
//        $permisos = Permission::select('name', 'descriptions', 'id', DB::raw('0 as checked'))
//            ->where('name', 'like', '%' . $this->searchQuety . '%')
//            ->orderBy('name', 'asc')->paginate($this->pagination);

        if ($this->roleSelect != 'Elegir') {
            $role = Role::find($this->roleSelect);

            if ($role) {
                $guardName = $role->guard_name;
//                dd($guardName);

                // Filtrar los permisos por la guardia del rol
                $permisos = Permission::select('name', 'descriptions', 'id', DB::raw('0 as checked'))
                    ->where('guard_name', $guardName) // Agregar filtro por guardia
                    ->where('name', 'like', '%' . $this->searchQuety . '%')
                    ->orderBy('name', 'asc')
                    ->paginate($this->pagination);

                // ... (resto del código para asignar los permisos al rol) ...
            }
        } else {
            $permisos = Permission::select('name', 'descriptions', 'id', DB::raw('0 as checked'))
                ->where('name', 'like', '%' . $this->searchQuety . '%')
                ->orderBy('name', 'asc')->paginate($this->pagination);
        }


        if ($this->roleSelect != 'Elegir') {
            $role = Role::find($this->roleSelect);

            if ($role) {
                $guardName = $role->guard_name;
                $this->permissionOld = $role->permissions()->where('guard_name', $guardName)->pluck('id')->toArray();
            }
        }

//        if ($this->roleSelect != 'Elegir') {
//            $list = Permission::join('role_has_permissions as rp', 'rp.permission_id', 'permissions.id')
//                ->where('role_id', $this->roleSelect)->pluck('permissions.id')->toArray();
//            $this->permissionOld = $list;
//        }

        if ($this->roleSelect != 'Elegir') {
            $role = Role::find($this->roleSelect);

            if ($role) {
                // Obtener la guardia del rol
                $guardName = $role->guard_name;
                // dd($guardName);
                foreach ($permisos as $permiso) {
                    try {
                        // Verificar el permiso con la guardia correcta
                        $tienePermiso = $role->hasPermissionTo($permiso->name, $guardName);

                        if ($tienePermiso) {
                            $permiso->checked = 1;
                        }
                    } catch (Throwable $e) {
                        dd($e);
                    }
                }
            }
        }

//        if ($this->roleSelect != 'Elegir') {
//            foreach ($permisos as $permiso) {
//                $role = Role::find($this->roleSelect);
//                $tienePermiso = $role->hasPermissionTo($permiso->name);
//                if ($tienePermiso) {
//                    $permiso->checked = 1;
//                }
//
//            }
//        }

        $rolseall = Role::orderBy('name', 'asc')->get();
        return view('livewire.settings.asig-component', ['permisos' => $permisos, 'roles' => $rolseall])
            ->extends('layouts.master')
            ->section('content');
    }

    #[On('revokeall')]
    public function RemoveAll()
    {
        if ($this->roleSelect == 'Elegir') {
            $this->dispatch('sync-error', messages: 'Selecciona un role validado');
            return;
        }
        $role = Role::find($this->roleSelect);
        $role->syncPermissions([0]);
        $this->dispatch('removeall', messages: 'Los Roles fueron removidos');
    }

    public function synAll()
    {
        if ($this->roleSelect == 'Elegir') {
            $this->dispatch('sync-error', messages: 'Selecciona un role validado');
            return;
        }

        $role = Role::find($this->roleSelect);
        $permisos = Permission::pluck('id')->toArray();
        $role->syncPermissions($permisos);
        $this->dispatch('syncall', messages: 'Se sincronizaron todos los permisos');
    }

    public function asignarpermi($state, $permisoName)
    {
        if ($this->roleSelect != 'Elegir') {
            $rolname = Role::find($this->roleSelect);
            if ($state) {
                $rolname->givePermissionTo($permisoName);
                $this->dispatch('permi', messages: 'Permiso Asignado correctamente');
            } else {
                $rolname->revokePermissionTo($permisoName);
                $this->dispatch('permi', messages: 'Permiso Revocado');
            }
        } else {
            $this->dispatch('sync-error', messages: 'Selecciona un role validado');
        }
    }
}
