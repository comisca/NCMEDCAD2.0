<?php

namespace App\Livewire;

use App\Models\Application;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class PreCalificacionTecnica extends Component
{

    use WithPagination;

    public $Pagination = 10;
    public $searchInput;
    public $typeid, $categoryRece;
    public $namePages;


    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount($typeid, $category)
    {
        $this->typeid = $typeid;
        if ($typeid == 'recepcion') {
            $this->namePages = 'Recepcion de documentos';
        } elseif ($typeid == 'tecnica') {
            $this->namePages = 'Pre-calificacion tecnica';
        } else {
            $this->namePages = 'Pre-calificacion Administrativa';
        }

        $this->categoryRece = $category;
    }


    public function render()
    {
        //        $applicationsapp = Application::join('familia_producto', 'applications.family_id', '=', 'familia_producto.id')
        //            ->join('medicamentos', 'applications.product_id', '=', 'medicamentos.id')
        //            ->join('companies', 'applications.fabric_id', '=', 'companies.id')
        //            ->select('applications.*',
        //                'medicamentos.descripcion',
        //                'medicamentos.cod_medicamento',
        //                'companies.legal_name')
        //            ->where('distribution_id', Session::get('id_company'))
        //            ->where('applications.status', '>=',1)
        //            ->get();

        $applicationsapp = Application::join('familia_producto', 'applications.family_id', '=', 'familia_producto.id')
            ->join('medicamentos', 'applications.product_id', '=', 'medicamentos.id')
            ->join('companies', 'applications.fabric_id', '=', 'companies.id')
            ->select(
                'applications.*',
                'medicamentos.descripcion',
                'medicamentos.cod_medicamento',
                'companies.legal_name',
                DB::raw('(SELECT COUNT(*) FROM req_applications WHERE req_applications.states_req_applications = 3 AND req_applications.application_id = applications.id) as req_applications_count')
            )
            ->where('distribution_id', Session::get('id_company'))
            ->where('applications.status', 1)
            ->get();
        return view('livewire.companies.pre-calificacion-tecnica', ['applicationsapp' => $applicationsapp])
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
