<?php

namespace App\Livewire;

use App\Mail\NotificationFabricAdmin;
use App\Mail\PreRegister;
use App\Models\Application;
use App\Models\Companies;
use App\Models\Countries;
use App\Models\DocumentsTables;
use App\Models\FamiliaProducto;
use App\Models\Medicamentos;
use App\Models\ReqApplications;
use App\Models\ReqRelationProduts;
use App\Models\StateCountries;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;
use Termwind\Components\Dd;

class FichaTecnicaComponent extends Component
{

    use WithPagination;

    public $Pagination = 10;
    public $searchInput;
    public $dataProducts, $inputFamilyProduct;
    public $legalName, $numRegisterSalud, $countryRegister, $registerNumber, $companieF;
    public $idSelectedProducts, $dataApplicationSelected;

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

        $this->dataProducts = Medicamentos::where('activo', 1)
            ->where('id_familia_producto', $this->inputFamilyProduct)
            ->orderBy('id', 'desc')
            ->get();

        $this->dataApplicationSelected =
            Application::join('familia_producto', 'applications.family_id', '=', 'familia_producto.id')
                ->join('medicamentos', 'applications.product_id', '=', 'medicamentos.id')
                ->select('applications.*', 'medicamentos.descripcion', 'medicamentos.cod_medicamento')
                ->where('applications.family_id', $this->inputFamilyProduct)
                ->where('applications.distribution_id', Session::get('id_company'))
                ->where('applications.status', '>', 0)
                ->get();

        if (!empty($this->country)) {
            $this->inputStates = StateCountries::where('country_id', $this->country)->get();
        }


    }


    public function render()
    {
        $familyProducts = FamiliaProducto::where('status', 1)->get();
        $countries = Countries::orderBy('name', 'asc')->get();
        $bussinessFabricante = Companies::where('status', 1)
            ->where('type_company', 'F')
            ->get();


        return view('livewire.ficha-tecnica-component',
            ['familyProducts' => $familyProducts,
                'bussinessFabricante' => $bussinessFabricante,
                'countries' => $countries])
            ->extends('layouts.master')
            ->section('content');
    }


    public function showDetailFicha($id)
    {
//        dd('hola que tal');
        $this->idSelectedProducts = $id;
        $this->dispatch('showDetailFichaEvent', $id);

    }

    public function createFabric()
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
                'type_company' => 'F',
                'status' => 1,
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
            $this->companieF = $company->id;
//            Mail::to($this->email)->send(new PreRegister($this->BusinnessName));


            //Aqui se escribe el codigo que se desea hacer en la transaccion

            //este metodo lo que hace es guardar los cambios en la base de datos
            DB::commit();

//            $this->resetUI();
            $this->dispatch('success_new_fabric',
                messages: 'El Fabricante se ha registrado correctamente, se ha enviado un correo de confirmacion');

//                $this->dispatchBrowserEvent('message-success', ['message' => 'Distribuidor registrado correctamente']);


        } catch (\Throwable $e) {
            //este metodo lo que hace es deshacer los cambios en la base de datos
            DB::rollback();
            dd($e->getMessage());

            //este metodo lo que hace es mostrar el error en la consola
//               dd($e->getMessage());

            $this->dispatch('error_messages', messages: 'la agenda no se ha creado correctamente');
        }

    }


    public function create()
    {

        //  dd($this->inputFamilyProduct);
        $rules = [
            'legalName' => 'required',
            'countryRegister' => 'required',
            'numRegisterSalud' => 'required',
            'companieF' => 'required',
        ];
        $messages = [
            'legalName.required' => 'El nombre comercial es requerido',
            'countryRegister.required' => 'El numero de registro de pais es requerido',
            'numRegisterSalud.required' => 'El numero de registro de salud es requerido',
            'companieF.required' => 'La seleccion de fabricante es requerida',
        ];

        $this->validate($rules, $messages);
        try {
            // dd('hola');
            //este metodo lo que hace es inicailizar las transacciones en la base de datos
            DB::beginTransaction();

            $dataRelation = ReqRelationProduts::where('product_id', $this->idSelectedProducts)
                ->where('status', 1)
                ->get();

            $applicationnew = Application::create([
                'family_id' => $this->inputFamilyProduct,
                'product_id' => $this->idSelectedProducts,
                'trade_name' => $this->legalName,
                'number_registration_salud' => $this->numRegisterSalud,
//                'number_registration_fabric' => $this->registerNumber,
                'country_id' => $this->countryRegister,
                'fabric_id' => $this->companieF,
                'distribution_id' => Session::get('id_company'),
                'states_applications' => 1,
                'status' => 1
            ]);

            if (!empty($dataRelation)) {
                foreach ($dataRelation as $item) {
                    $exitreqapplicationData = ReqApplications::where('application_id', $applicationnew->id)
                        ->where('requirement_id', $item->requirement_id)
                        ->where('product_id', $this->idSelectedProducts)
                        ->where('fabric_id', $this->companieF)
                        ->where('status', 1)
                        ->first();


                    if (empty($exitreqapplicationData)) {
                        $reqapplicationData = ReqApplications::create([
                            'application_id' => $applicationnew->id,
                            'requirement_id' => $item->requirement_id,
                            'distribution_id' => Session::get('id_company'),
                            'product_id' => $this->idSelectedProducts,
                            'fabric_id' => $this->companieF,
                            'states_req_applications' => 9,
                            'status' => 1,
                        ]);
                    }
                }
            }

            $verifyFabricToOtherAplication = Application::where('distribution_id', '!=', Session::get('id_company'))
                ->where('fabric_id', $this->companieF)
                ->where('status', 1)
                ->count();

            if ($verifyFabricToOtherAplication > 0) {
                // entonces aqui va la logica para enviar un correo al equipo de la UMOT notificando que el fabricante
                // esta asociado a otra distribuidora
                $nameD = Companies::where('id', Session::get('id_company'))->first()->legal_name;
                $nameF = Companies::where('id', $this->companieF)->first()->legal_name;

                Mail::to('henry.orellana@oceansbits.com')
                    ->send(new NotificationFabricAdmin($nameD, $nameF));

            }


            //Aqui se escribe el codigo que se desea hacer en la transaccion

            //este metodo lo que hace es guardar los cambios en la base de datos
            DB::commit();
            $this->resetUI();

            $this->dataApplicationSelected =
                Application::join('familia_producto', 'applications.family_id', '=', 'familia_producto.id')
                    ->join('medicamentos', 'applications.product_id', '=', 'medicamentos.id')
                    ->select('applications.*', 'medicamentos.descripcion', 'medicamentos.cod_medicamento')
                    ->where('applications.family_id', $this->inputFamilyProduct)
                    ->where('applications.distribution_id', Session::get('id_company'))
                    ->where('applications.status', '>', 0)
                    ->get();
            $this->dispatch('messages-succes-fichatec', messages: 'La ficha tecnica se ha creado correctamente');
        } catch (\Throwable $e) {
            //este metodo lo que hace es deshacer los cambios en la base de datos
            DB::rollback();

            //este metodo lo que hace es mostrar el error en la consola
            dd($e->getMessage());
        }
    }


    public function update()
    {

        $rules = [
            'legalName' => 'required',
            'numRegisterSalud' => 'required',
            'countryRegister' => 'required',
            'registerNumber' => 'required',
            'companieF' => 'required',
        ];
        $messages = [
            'legalName.required' => 'El nombre comercial es requerido',
            'countryRegister.required' => 'El numero de registro de pais es requerido',
            'registerNumber.required' => 'El numero de registro es requerido',
            'numRegisterSalud.required' => 'El numero de registro de salud es requerido',
            'companieF.required' => 'La seleccion de fabricante es requerida',
        ];

        $this->validate($rules, $messages);

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
        $this->legalName = '';
        $this->numRegisterSalud = '';
        $this->countryRegister = '';
        $this->registerNumber = '';
        $this->companieF = '';
    }
}
