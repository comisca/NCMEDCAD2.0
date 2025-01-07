<?php

namespace App\Livewire;

use App\Models\Application;
use App\Models\Companies;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class ListPrecAdminComponent extends Component
{

    use WithPagination;

    public $Pagination = 10;
    public $searchInput, $dataGlobal, $particioanteId;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {

    }

    public function updated()
    {
        $this->dataGlobal = Application::join('familia_producto', 'applications.family_id', '=', 'familia_producto.id')
            ->join('companies', 'applications.distribution_id', '=', 'companies.id')
            ->select(
                'familia_producto.id',
                'familia_producto.familia_producto',
                'companies.id as idcompany'
            )
            ->distinct()
            ->where('applications.distribution_id', $this->particioanteId) // Filtrar por empresa
            ->get();

    }


    public function render()
    {
        $companies = Companies::orderBy('id', 'desc')
            ->where('status', '=', 1)
            ->paginate($this->Pagination);
        return view('livewire.list-prec-admin-component', ['companies' => $companies])
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


    public function resetUI()
    {


    }

}
