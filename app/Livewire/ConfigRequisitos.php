<?php

namespace App\Livewire;

use App\Models\FamiliaProducto;
use App\Models\GrupoRequisitos;
use App\Models\Medicamentos;
use App\Models\ReqRelationProduts;
use App\Models\Requisitos;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class ConfigRequisitos extends Component
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

        return view('livewire.requisitos.config-requisitos', ['familyProductsData' => $familyProductsData])
            ->extends('layouts.master')
            ->section('content');
    }

    public function updated()
    {
        $this->groupDataSelected = GrupoRequisitos::where('id_familia_producto', $this->familySelectedId)
            ->where('status', 1)
            ->orderBy('orden', 'asc')
            ->get();

        $this->productsDataSelected =
            Medicamentos::where('activo', 1)->where('id_familia_producto', $this->familySelectedId)
                ->orderBy('id', 'desc')
                ->get();

        $this->requisitodDataSelected = Requisitos::where('grupo_requisito_id', $this->groupSelectedId)
            ->where('status', 1)
            ->where('tipo_requisitos', 'TECNICOS')
            ->orderBy('id', 'asc')
            ->get();
        $this->productDataTable =
            ReqRelationProduts::join('requisitos', 'requisitos.id', '=', 'req_relation_produts.requirement_id')
                ->join('medicamentos', 'medicamentos.id', '=', 'req_relation_produts.product_id')
                ->join('grupos_requisitos', 'grupos_requisitos.id', '=', 'requisitos.grupo_requisito_id')
                ->where('req_relation_produts.product_id', $this->productSelectInput)
                ->where('req_relation_produts.status', 1)
                ->select(
                    'grupos_requisitos.grupo as grupo_nombre',
                    'req_relation_produts.id',
                    'requisitos.codigo',
                    'requisitos.descripcion',
                    'req_relation_produts.id as id_req_products',
                )
                ->orderBy('grupos_requisitos.grupo')
                ->get()
                ->groupBy('grupo_nombre') // Agrupa por 'grupo_nombre' en lugar de 'grupos_requisitos.grupo'
                ->collect(); // Convierte a colección de soporte


    }

    #[On('deletereqproduct')]
    public function deletereqpro($id_req_products)
    {
        ReqRelationProduts::where('id', $id_req_products)->update(['status' => 0]);

    }

    public function addGroupRequeriment()
    {

        $rules = [
            'productSelectInput' => 'required',
            'groupSelectedId' => 'required',
        ];
        $messages = [
            'productSelectInput.required' => 'Debe estar un producto seleccionado',
            'groupSelectedId.required' => 'Debes seleccionar un grupo de requerimientos',
        ];

        $this->validate($rules, $messages);

        try {
            DB::beginTransaction();

            foreach ($this->requisitodDataSelected as $itemInsertRequeriment) {
                $validateRelations = ReqRelationProduts::where('product_id', $this->productSelectInput)
                    ->where('requirement_id', $itemInsertRequeriment->id)
                    ->where('status', 1)
                    ->first();

                if (empty($validateRelations)) {

                    $newRelartion = ReqRelationProduts::create([
                        'product_id' => $this->productSelectInput,
                        'requirement_id' => $itemInsertRequeriment->id,
                        'status' => 1
                    ]);

                }
            }

            DB::commit();
            $this->dispatch('messages-succes',
                messages: 'El requerimiento ha sido asignado correctamente al producto');
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
            'productSelectInput.required' => 'Debe estar un producto seleccionado',
        ];

        $this->validate($rules, $messages);

        try {

            DB::beginTransaction();
            $validateRelations = ReqRelationProduts::where('product_id', $this->productSelectInput)
                ->where('requirement_id', $idRequeriment)
                ->where('status', 1)
                ->first();

            if (empty($validateRelations)) {

                $newRelartion = ReqRelationProduts::create([
                    'product_id' => $this->productSelectInput,
                    'requirement_id' => $idRequeriment,
                    'status' => 1
                ]);

            }

            DB::commit();
            $this->dispatch('messages-succes',
                messages: 'El requerimiento ha sido asignado correctamente al producto');

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
