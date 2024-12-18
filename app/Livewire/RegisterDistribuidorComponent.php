<?php

namespace App\Livewire;

use App\Mail\PreRegister;
use App\Models\Companies;
use App\Models\Countries;
use App\Models\DocumentsTables;
use App\Models\FamiliaProducto;
use App\Models\ReqRelationProfile;
use App\Models\ReqRelationProfileTable;
use App\Models\StateCountries;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Session;
use DB;

class RegisterDistribuidorComponent extends Component
{

    use WithPagination;
    use WithFileUploads;

    public $Pagination = 10;
    public $searchInput;
    public $bandera = 0;
    public $BusinnessName, $country, $city, $address, $phone, $facsimile, $website;
    public $firstName, $lastName, $email, $phoneContact, $userName, $typeCompany, $avatar;
    public $inputCountries, $inputStates, $inputCities, $whatsapp, $docRegister, $docId;
    public $docPoder, $docLicense, $familyProductsInput, $userNameCompany;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        if (!empty($this->country)) {
            $this->inputStates = StateCountries::where('country_id', $this->country)->get();
        }

    }

    public function updated()
    {
        if (!empty($this->country)) {
            $this->inputStates = StateCountries::where('country_id', $this->country)->get();
        }


    }


    public function render()
    {
        $familyProducts = FamiliaProducto::orderBy('id', 'desc')->get();
        $countries = Countries::orderBy('name', 'asc')->get();

        return view('livewire.register-distribuidor-component',
            ['familyProducts' => $familyProducts, 'countries' => $countries])
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
//            'phoneContact' => 'required',
            'lastName' => 'required',
            'userNameCompany' => 'required',
//            'userName' => 'required|min:2|unique:companies,user_name',
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
//            'phoneContact.required' => 'El telefono de contacto es obligatorio',
            'phone.required' => 'El telefono es obligatorio',
            'userNameCompany.required' => 'El usuario es obligatorio',
//            'userName.required' => 'El Objetivo es obligatorio',
//            'userName.min' => 'El usuario debe ser mayor a 2 caracteres',
//            'userName.unique' => 'el usuario ya existe',
        ];

        //Validamos los datos
        $this->validate($rules, $messages);


        try {

            if ($this->avatar) {
                //Guardamos la imagen en la carpeta publica
                $avatar_name = 'img_' . uniqid() . '.' . $this->avatar->extension();
                $avatarurl = $this->avatar->storeAs('public/companies/avatar', $avatar_name);
            } else {
                $avatar_name = 'default.png';
            }


            $countrieSelectedInsert = Countries::where('id', $this->country)->first();
            $stateSelectedInsert = StateCountries::where('id', $this->city)->first();


            //este metodo lo que hace es inicailizar las transacciones en la base de datos
            DB::beginTransaction();

            $company = Companies::create([
                'legal_name' => $this->BusinnessName,
                'country' => $countrieSelectedInsert->name,
                'city' => $stateSelectedInsert->name,
                'address' => $this->address,
                'phone' => $this->phone,
                'facsimile' => $this->facsimile,
                'phone_whatsapp' => $this->whatsapp,
                'website' => $this->website,
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'email' => $this->email,
                'user_name' => $this->userNameCompany,
//                'user_name' => $this->userName,
                'password' => '123456',
                'type_company' => $this->typeCompany == 'DISTRIBUIDOR' ? 'D' : 'F',
                'status' => 2,
                'country_id' => $this->country,
                'state_id' => $this->city,
                'family_id' => $this->familyProductsInput,
                'logo_companies' => $avatar_name
            ]);
            $company->syncRoles('Company');
            $company->save();

            
            if ($this->docRegister) {
                $doc_rec = 'doc_' . uniqid() . '.' . $this->docRegister->extension();
                $docRecUrl = $this->docRegister->storeAs('public/document/companies', $doc_rec);
//                $docSize = $this->docRegister->getSize(); // Get the file size
//                $docExtension = $this->docRegister->getClientOriginalExtension();

                DocumentsTables::create([
                    'document_id' => 2,
                    'table_name' => 'companies',
                    'table_id' => $company->id,
                    'document_name' => 'Documento de Registro',
                    'attachment' => $doc_rec,
//                    'size' => $docSize,
//                    'extension' => $docExtension,
                    'status' => 1
                ]);


            }
            if ($this->docId) {

                $doc_Id = 'doc_' . uniqid() . '.' . $this->docId->extension();
                $docIdUrl = $this->docId->storeAs('public/document/companies', $doc_Id);
//                $docSizedocId = $this->docId->getSize(); // Get the file size
//                $docExtensiondocId = $this->docId->getClientOriginalExtension();
                DocumentsTables::create([
                    'document_id' => 2,
                    'table_name' => 'companies',
                    'table_id' => $company->id,
                    'document_name' => 'Documento de Identidad',
                    'attachment' => $doc_Id,
//                    'size' => $docSizedocId,
//                    'extension' => $docExtensiondocId,
                    'status' => 1
                ]);


            }
            if ($this->docPoder) {
                $doc_Poder = 'doc_' . uniqid() . '.' . $this->docPoder->extension();
                $docPoderUrl = $this->docPoder->storeAs('public/document/companies', $doc_Poder);
//                $docSizedocPoder = $this->docPoder->getSize(); // Get the file size
//                $docExtensiondocPoder = $this->docPoder->getClientOriginalExtension();

                DocumentsTables::create([
                    'document_id' => 2,
                    'table_name' => 'companies',
                    'table_id' => $company->id,
                    'document_name' => 'Documento de Poder',
                    'attachment' => $doc_Id,
//                    'size' => $docSizedocPoder,
//                    'extension' => $docExtensiondocPoder,
                    'status' => 1
                ]);


            }

            if ($this->docLicense) {

                $doc_License = 'doc_' . uniqid() . '.' . $this->docLicense->extension();
                $docLicenceUrl = $this->docLicense->storeAs('public/logo/companies', $doc_License);
//                $docSizedocLicense = $this->docLicense->getSize(); // Get the file size
//                $docExtensiondocLicense = $this->docLicense->getClientOriginalExtension();

                DocumentsTables::create([
                    'document_id' => 2,
                    'table_name' => 'companies',
                    'table_id' => $company->id,
                    'document_name' => 'Documento de Licencia',
                    'attachment' => $doc_Id,
//                    'size' => $docSizedocLicense,
//                    'extension' => $docExtensiondocLicense,
                    'status' => 1
                ]);

            }

            Mail::to($this->email)->send(new PreRegister($this->BusinnessName));


            //Aqui se escribe el codigo que se desea hacer en la transaccion

            //este metodo lo que hace es guardar los cambios en la base de datos
            DB::commit();

//            $this->resetUI();
//            $this->dispatch('success_messages',
//                messages: 'La solicitud para registrarte en la base de datos de Negosacion Conjunta ha sido enviada correctamente, se te notificara cuando haya sido aprobada');

//                $this->dispatchBrowserEvent('message-success', ['message' => 'Distribuidor registrado correctamente']);

            return redirect('/messeger/success')->with('messagerSucess',
                'En estos momentos los datos fueron enviados correctamente, su aplicacion estara pendiente de aprobacion!!');

        } catch (\Throwable $e) {
            //este metodo lo que hace es deshacer los cambios en la base de datos
            DB::rollback();
            dd($e->getMessage());

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
