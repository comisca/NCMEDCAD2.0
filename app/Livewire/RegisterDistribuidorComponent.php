<?php

namespace App\Livewire;

use App\Models\Companies;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class RegisterDistribuidorComponent extends Component
{

use WithPagination;
    public $Pagination = 10;
    public $searchInput;
    public $bandera = 0;
    public $BusinnessName,$country,$city,$address,$phone,$facsimile,$website;
    public $firstName,$lastName,$email,$phoneContact,$userName,$typeCompany;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {

    }


    public function render()
    {
        return view('livewire.register-distribuidor-component')
        ->extends('layouts.master')
        ->section('content');
    }

       public function create()
        {


            //Declaramos las reglas de validacion
            $rules = [
                'BusinnessName' => 'required|min:2|unique:companies,legal_name',
                'country' => 'required',
                'phone' => 'required',
                'city' => 'required',
                'address' => 'required',
                'firstName' => 'required',
                'email' => 'required',
                'phoneContact' => 'required',
                'lastName' => 'required',
                'userName' => 'required|min:2|unique:companies,user_name',
            ];

            //Declaramos los mensajes de validacion
            $messages = [
                'BusinnessName.required' => 'El nombre de la empresa es obligatorio',
                'BusinnessName.min' => 'El nombre de la la empresa debe ser mayor a 2 caracteres',
                'BusinnessName.unique' => 'el nombre de la empresa ya existe',
                'country.required' => 'El pais es obligatorio',
                'city.required' => 'La ciudad es obligatoria',
                'address.required' => 'La direccion es obligatoria',
                'firstName.required' => 'El nombre es obligatorio',
                'lastName.required' => 'El apellido es obligatorio',
                'email.required' => 'El correo es obligatorio',
                'phoneContact.required' => 'El telefono de contacto es obligatorio',
                'phone.required' => 'El telefono es obligatorio',
                'userName.required' => 'El Objetivo es obligatorio',
                'userName.min' => 'El usuario debe ser mayor a 2 caracteres',
                'userName.unique' => 'el usuario ya existe',
            ];

            //Validamos los datos
            $this->validate($rules, $messages);


            try {
                //este metodo lo que hace es inicailizar las transacciones en la base de datos
                DB::beginTransaction();

                $company = Companies::create([
                    'legal_name' => $this->BusinnessName,
                    'country' => $this->country,
                    'city' => $this->city,
                    'address' => $this->address,
                    'phone' => $this->phone,
                    'facsimile' => $this->facsimile,
                    'website' => $this->website,
                    'first_name' => $this->firstName,
                    'last_name' => $this->lastName,
                    'email' => $this->email,
                    'phone_contact' => $this->phoneContact,
                    'user_name' => $this->userName,
                    'password' => '123456',
                    'type_company' => $this->typeCompany == 'DISTRIBUIDOR' ? 'D' : 'F',
                    'status' => 2
                ]);


                //Aqui se escribe el codigo que se desea hacer en la transaccion

                //este metodo lo que hace es guardar los cambios en la base de datos
                DB::commit();

                $this->resetUI();
                $this->dispatch('success_messages', messages: 'La solicitud para registrarte en la base de datos de Negosacion Conjunta ha sido enviada correctamente, se te notificara cuando haya sido aprobada');

//                $this->dispatchBrowserEvent('message-success', ['message' => 'Distribuidor registrado correctamente']);

            }catch (\Throwable $e) {
                //este metodo lo que hace es deshacer los cambios en la base de datos
                DB::rollback();

                //este metodo lo que hace es mostrar el error en la consola
//               dd($e->getMessage());

                $this->dispatch('error_messages', messages: 'la agenda no se ha creado correctamente');
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

            $this->typeCompany = null;
            $this->BusinnessName = '';
            $this->country = '';
            $this->city = '';
            $this->address = '';
            $this->phone = '';
            $this->facsimile = '';
            $this->website = '';
            $this->firstName = '';
            $this->lastName = '';
            $this->email = '';
            $this->phoneContact = '';
            $this->userName = '';

        }

}
