<?php

namespace App\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;
use Spatie\Permission\Models\Role;

class UserComponent extends Component
{

    use WithPagination;
    public $permisos, $descripcion, $searchQuety, $nameUser, $subTittle,$tittleModal,$detaiModal;
    public $idSelecte;
    public $namePage, $nameModal;
    public $pagination = 10;
    public $email,$password,$name,$lastName,$dui,$phone,$role_id,$firts_name;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->namePage = 'Usuarios';
        $this->nameUser = Session::get('name_user');
        $this->subTittle = 'Controla accesos y responsabilidades para una administración eficiente de permisos y funciones';
        $this->idSelecte = 0;
        $this->tittleModal = 'Crear Usuario';
        $this->detaiModal = 'Formulario para crear un nuevo usuario';

    }


    public function render()
    {
        $roles = Role::all();

        if (strlen($this->searchQuety) > 0) {
            $users = User::where('last_name', 'like', '%' . $this->searchQuety . '%')
                ->orWhere('first_name', 'like', '%' . $this->searchQuety . '%')
                ->orWhere('email', 'like', '%' . $this->searchQuety . '%')
                ->paginate($this->pagination);
        } else {
            $users = User::paginate($this->pagination);
        }
        return view('livewire.users.user-component',['dataRoles' => $roles, 'users' => $users])
        ->extends('layouts.master')
        ->section('content');
    }

    public function create()
    {

        $rules = [
            'lastName' => 'required|min:2',
            'email' => 'required|min:2|email|unique:users,email,' . $this->idSelecte,
        ];

        $messages = [
            'lastName.required' => 'Los apellidos son requeridos.',
            'email.required' => 'El email es requerido.',
            'lastName.min' => 'Los apellidos deben tener al menos 2 caracteres.',
            'email.min' => 'El email debe tener al menos 2 caracteres.',
            'email.email' => 'El email debe tener un formato válido.',
            'email.unique' => 'Este email ya está registrado.',
        ];


        $this->validate($rules, $messages);
        try {
            //este metodo lo que hace es inicailizar las transacciones en la base de datos
            DB::beginTransaction();

            $usario = User::create([
                'first_name' => $this->firts_name,
                'last_name' => $this->lastName,
                'dui' => $this->dui,
                'password' => Hash::make($this->password),
                'email' => $this->email,
                'id_role' => $this->role_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $usario->syncRoles($this->role_id);
            $usario->save();

            //Aqui se escribe el codigo que se desea hacer en la transaccion

            //este metodo lo que hace es guardar los cambios en la base de datos
            DB::commit();
            $this->dispatch('usuario-added', messages: 'Usuario agregado correctamente');
            $this->resetUI();
        } catch (\Throwable $e) {
            //este metodo lo que hace es deshacer los cambios en la base de datos
            DB::rollback();

            //este metodo lo que hace es mostrar el error en la consola
            dd($e->getMessage());
        }
    }


          public function update()
            {
                try {
                    //este metodo lo que hace es inicailizar las transacciones en la base de datos
                    DB::beginTransaction();

                    //Aqui se escribe el codigo que se desea hacer en la transaccion

                    //este metodo lo que hace es guardar los cambios en la base de datos
                    DB::commit();

                }catch (\Throwable $e) {
                    //este metodo lo que hace es deshacer los cambios en la base de datos
                    DB::rollback();

                    //este metodo lo que hace es mostrar el error en la consola
                    dd($e->getMessage());
                }
            }


            public function deletexid()
            {
                try {
                    //este metodo lo que hace es inicailizar las transacciones en la base de datos
                    DB::beginTransaction();

                    //Aqui se escribe el codigo que se desea hacer en la transaccion

                    //este metodo lo que hace es guardar los cambios en la base de datos
                    DB::commit();

                }catch (\Throwable $e) {
                    //este metodo lo que hace es deshacer los cambios en la base de datos
                    DB::rollback();

                    //este metodo lo que hace es mostrar el error en la consola
                    dd($e->getMessage());
                }
            }





     public function resetUI()
        {


        }

}
