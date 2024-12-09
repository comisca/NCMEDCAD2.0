<?php

namespace App\Livewire;

use App\Models\Application;
use App\Models\Companies;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class CompaniesDetailsComponents extends Component
{

    use WithPagination;

    public $Pagination = 10;
    public $searchInput, $idCompany;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount($id)
    {
        $this->idCompany = $id;

    }


    public function render()
    {

        $company = Companies::where('id', $this->idCompany)->first();

        $fabricData = Application::join('companies', 'applications.fabric_id', '=', 'companies.id')
            ->select(
                'companies.first_name',
                'companies.last_name',
                'companies.legal_name',
                'companies.email',
                'companies.phone',
                'companies.id as id_company')
            ->where('applications.distribution_id', $this->idCompany)
            ->where('applications.status', 1)
            ->distinct()
            ->get();
        return view('livewire.companies.companies-details-components',
            ['company' => $company, 'fabricData' => $fabricData])
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
