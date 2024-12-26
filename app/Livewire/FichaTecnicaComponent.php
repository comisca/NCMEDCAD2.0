<?php

namespace App\Livewire;

use App\Models\Application;
use App\Models\Companies;
use App\Models\FamiliaProducto;
use App\Models\Medicamentos;
use App\Models\ReqApplications;
use App\Models\ReqRelationProduts;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class FichaTecnicaComponent extends Component
{

    use WithPagination;

    public $Pagination = 10;
    public $searchInput;
    public $dataProducts, $inputFamilyProduct;
    public $legalName, $numRegisterSalud, $countryRegister, $registerNumber, $companieF;
    public $idSelectedProducts, $dataApplicationSelected;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
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
                ->where('applications.status', 1)
                ->get();


    }


    public function render()
    {
        $familyProducts = FamiliaProducto::where('status', 1)->get();
        $bussinessFabricante = Companies::where('status', 1)
            ->where('type_company', 'F')
            ->get();


        return view('livewire.ficha-tecnica-component',
            ['familyProducts' => $familyProducts, 'bussinessFabricante' => $bussinessFabricante])
            ->extends('layouts.master')
            ->section('content');
    }


    public function showDetailFicha($id)
    {
//        dd('hola que tal');
        $this->idSelectedProducts = $id;
        $this->dispatch('showDetailFichaEvent', $id);

    }

    public function create()
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

            $dataRelation = ReqRelationProduts::where('product_id', $this->idSelectedProducts)
                ->where('status', 1)
                ->get();

            $applicationnew = Application::create([
                'family_id' => $this->inputFamilyProduct,
                'product_id' => $this->idSelectedProducts,
                'trade_name' => $this->legalName,
                'number_registration_salud' => $this->numRegisterSalud,
                'number_registration_fabric' => $this->registerNumber,
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
                    ->where('applications.status', 1)
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
