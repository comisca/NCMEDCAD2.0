<?php

namespace App\Livewire;

use App\Models\Application;
use App\Models\Companies;
use App\Models\ReqApplications;
use App\Models\ReqRelationProfile;
use App\Models\ReqRelationProfileTable;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class PreCalificacionAdministrativa extends Component
{

    use WithPagination;

    public $Pagination = 10;
    public $searchInput;
    public $idCompany;

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

        $datafill = [];

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

        if (!empty($fabricData)) {
            foreach ($fabricData as $itemsforeach) {
                $dataApplication =
                    ReqRelationProfileTable::join('requisitos',
                        'requisitos.id',
                        '=',
                        'req_relation_profile_tables.req_id')
//                ->join('medicamentos', 'medicamentos.id', '=', 'req_relation_produts.product_id')
                        ->join('grupos_requisitos', 'grupos_requisitos.id', '=', 'requisitos.grupo_requisito_id')
                        ->where('req_relation_profile_tables.company_id', $itemsforeach->id_company)
                        ->where('req_relation_profile_tables.status', 1)
                        ->select(
                            'grupos_requisitos.grupo as grupo_nombre',
                            'req_relation_profile_tables.id',
                            'requisitos.codigo',
                            'requisitos.descripcion'
                        )
                        ->orderBy('grupos_requisitos.grupo')
                        ->get()
                        ->groupBy('grupo_nombre') // Agrupa por 'grupo_nombre' en lugar de 'grupos_requisitos.grupo'
                        ->collect(); // Convierte a colección de soporte

                $datafill['Company'] = $itemsforeach->legal_name;
                $datafill['DataRequeriments'] = $dataApplication;


            }
        } else {
            $datafill['Company'] = '';
            $datafill['DataRequeriments'] = '';
        }


        return view('livewire.companies.pre-calificacion-administrativa',
            ['applicationsapp' => $dataApplication, 'company' => $company, 'fabricData' => $datafill])
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
