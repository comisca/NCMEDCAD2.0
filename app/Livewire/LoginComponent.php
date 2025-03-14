<?php

namespace App\Livewire;

use App\Models\Companies;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class LoginComponent extends Component
{

    use WithPagination;

    public $Pagination = 10;
    public $searchInput;
    public $email, $password, $remember;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {

    }


    public function render()
    {

        return view('livewire.authenticate.login-component')
            ->extends('layouts.master-without-nav')
            ->section('content');

    }

    public function create()
    {
        $rule = [
            'email' => 'required|min:3',
            'password' => 'required|min:3',
        ];
        $messages = [
            'email.required' => 'El email es requerido',
            'email.min' => 'El email debe se mayor o igual a 3 caracteres',
            'password.required' => 'El password  es requerido',
            'password.min' => 'El password  debe se mayor o igual a 3 caracteres',
        ];

        $this->validate($rule, $messages);

        try {


            //este metodo lo que hace es inicailizar las transacciones en la base de datos
            DB::beginTransaction();

            $users = User::where('email', '=', $this->email)->first();

            if (empty($users)) {
                $companyLoging = Companies::where('user_name', '=', $this->email)->first();
                if (empty($companyLoging)) {
//                    dd('no se encontro el usuario');
                    session()->flash('messages-error', 'Los datos para ingresar no coincide con la base de datos');
                } else {
                    if (Hash::check($this->password, $companyLoging->password)) {
                        if (Auth::guard('company')->loginUsingId($companyLoging->id)) {

                            Session::put('id_company', $companyLoging->id);
                            Session::put('email_user', $companyLoging->email);
                            Session::put('name_user', $companyLoging->legal_name);
                            Session::put('type_company', $companyLoging->type_company);

                            return redirect('/companies/dashboard');
                        }


                    } else {


                        session()->flash('messages-error', 'El password que escribiste no es el correcto');
                    }
                }
            } else {
                //contando cuantos centros de distribucion tienen anexado el usuario

                if (Hash::check($this->password, $users->password)) {
                    if (Auth::loginUsingId($users->id)) {

                        Session::put('id_user', $users->id);
                        Session::put('email_user', $users->email);
                        Session::put('name_user', $users->first_name . ' ' . $users->last_name);
                        return redirect('/listCompany');
                    }
                } else {

                    session()->flash('messages-error', 'El password que escribiste no es el correcto');
                }
            }


            //Aqui se escribe el codigo que se desea hacer en la transaccion

            //este metodo lo que hace es guardar los cambios en la base de datos
            DB::commit();
        } catch (\Throwable $e) {
            //este metodo lo que hace es deshacer los cambios en la base de datos
            DB::rollback();
            dd($e->getMessage());
            //este envia el error del sistema al email del soporte tecnico
            //  $this->notifyemail($e->getMessage(), Session::get('email_user'));

            $this->dispatch('roles-error', messages: 'ha ocurrido un problema contacta a soporte');
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

        } catch (\Throwable $e) {
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

        } catch (\Throwable $e) {
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
