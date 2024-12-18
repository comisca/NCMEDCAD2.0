<?php

namespace App\Livewire;

use App\Models\FamiliaProducto;
use App\Models\GrupoRequisitos;
use App\Models\Medicamentos;
use App\Models\ReqRelationProduts;
use App\Models\ReqRelationProfile;
use App\Models\Requisitos;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class FichaAdminComponent extends Component
{

    use WithPagination;

    public $Pagination = 10;
    public $searchInput;
    public $familySelectedId, $groupSelectedId, $groupDataSelected, $productsDataSelected, $productSelectInput;
    public $requisitodDataSelected, $productDataTable;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {

    }


    public function render()
    {
        $familyProductsData = FamiliaProducto::where('status', 1)->get();
        return view('livewire.requisitos.ficha-admin-component', ['familyProductsData' => $familyProductsData])
            ->extends('layouts.master')
            ->section('content');
    }


    public function updated()
    {
        $this->groupDataSelected = GrupoRequisitos::where('id_familia_producto', $this->familySelectedId)
            ->where('status', 1)
            ->orderBy('orden', 'asc')
            ->get();

//        $this->productsDataSelected =
//            Medicamentos::where('activo', 1)->where('id_familia_producto', $this->familySelectedId)
//                ->orderBy('id', 'desc')
//                ->get();

        $this->requisitodDataSelected = Requisitos::where('grupo_requisito_id', $this->groupSelectedId)
            ->where('status', 1)
            ->where('tipo_requisitos', 'ADMINISTRATIVOS')
            ->orderBy('id', 'asc')
            ->get();
        $this->productDataTable =
            ReqRelationProfile::join('requisitos', 'requisitos.id', '=', 'req_relation_profiles.req_id')
//                ->join('medicamentos', 'medicamentos.id', '=', 'req_relation_produts.product_id')
                ->join('grupos_requisitos', 'grupos_requisitos.id', '=', 'requisitos.grupo_requisito_id')
                ->where('req_relation_profiles.type_profile', $this->productSelectInput)
                ->where('req_relation_profiles.status', 1)
                ->where('requisitos.tipo_requisitos', 'ADMINISTRATIVOS')
                ->select(
                    'grupos_requisitos.grupo as grupo_nombre',
                    'req_relation_profiles.id',
                    'requisitos.codigo',
                    'requisitos.descripcion'
                )
                ->orderBy('grupos_requisitos.grupo')
                ->get()
                ->groupBy('grupo_nombre') // Agrupa por 'grupo_nombre' en lugar de 'grupos_requisitos.grupo'
                ->collect(); // Convierte a colección de soporte


    }


    public function addGroupRequeriment()
    {

        $rules = [
            'productSelectInput' => 'required',
            'groupSelectedId' => 'required',
        ];
        $messages = [
            'productSelectInput.required' => 'Debe estar un perfil seleccionado',
            'groupSelectedId.required' => 'Debes seleccionar un grupo de requerimientos',
        ];

        $this->validate($rules, $messages);

        try {
            DB::beginTransaction();

            foreach ($this->requisitodDataSelected as $itemInsertRequeriment) {
                $validateRelations = ReqRelationProfile::where('type_profile', $this->productSelectInput)
                    ->where('req_id', $itemInsertRequeriment->id)
                    ->where('status', 1)
                    ->first();

                if (empty($validateRelations)) {

                    $newRelartion = ReqRelationProfile::create([
                        'type_profile' => $this->productSelectInput,
                        'req_id' => $itemInsertRequeriment->id,
                        'status' => 1
                    ]);

                }
            }

            DB::commit();
            $this->dispatch('messages-succes',
                messages: 'El requerimiento ha sido asignado correctamente al perfil');
        } catch (\Throwable $e) {
            DB::rollback();
            dd($e->getMessage());
        }


    }


    public function addRequerimentOne($idRequeriment)
    {
        $rules = [
            'productSelectInput' => 'required',
        ];
        $messages = [
            'productSelectInput.required' => 'Debe estar un perfil seleccionado',
        ];

        $this->validate($rules, $messages);

        try {

            DB::beginTransaction();
            $validateRelations = ReqRelationProfile::where('type_profile', $this->productSelectInput)
                ->where('req_id', $idRequeriment)
                ->where('status', 1)
                ->first();

            if (empty($validateRelations)) {

                $newRelartion = ReqRelationProfile::create([
                    'type_profile' => $this->productSelectInput,
                    'req_id' => $idRequeriment,
                    'status' => 1
                ]);

            }

            DB::commit();
            $this->dispatch('messages-succes',
                messages: 'El requerimiento ha sido asignado correctamente al perfil');

        } catch (\Throwable $e) {
            //este metodo lo que hace es deshacer los cambios en la base de datos
            DB::rollback();

            //este metodo lo que hace es mostrar el error en la consola
            dd($e->getMessage());
        }


    }


    public function create()
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
