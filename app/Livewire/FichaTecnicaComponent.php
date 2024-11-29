<?php

namespace App\Livewire;

use App\Models\Companies;
use App\Models\FamiliaProducto;
use App\Models\Medicamentos;
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

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount() {}

    public function updated()
    {

        $this->dataProducts = Medicamentos::where('activo', 1)
            ->where('id_familia_producto', $this->inputFamilyProduct)
            ->orderBy('id', 'desc')
            ->get();
    }


    public function render()
    {
        $familyProducts = FamiliaProducto::where('status', 1)->get();
        $bussinessFabricante = Companies::where('status', 1)
            ->where('type_company', 'F')
            ->get();

        return view('livewire.ficha-tecnica-component', ['familyProducts' => $familyProducts, 'bussinessFabricante' => $bussinessFabricante])
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


    public function resetUI() {}
}
