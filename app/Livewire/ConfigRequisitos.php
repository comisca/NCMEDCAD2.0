<?php

namespace App\Livewire;

use App\Models\FamiliaProducto;
use App\Models\GrupoRequisitos;
use App\Models\Medicamentos;
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
    public $requisitodDataSelected;

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
            ->orderBy('id', 'asc')
            ->get();

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
