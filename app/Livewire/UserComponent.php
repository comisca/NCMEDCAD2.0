<?php

namespace App\Livewire;

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
        return view('livewire.users.user-component',['dataRoles' => $roles])
        ->extends('layouts.master')
        ->section('content');
    }

       public function create()
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
