<?php

namespace App\Livewire;

use App\Models\GrupoFamilia;
use App\Models\GrupoRequisitos;
use App\Models\Requisitos;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class RequisitosComponents extends Component
{

    use WithPagination;

    public $pagination = 10;
    public $searchQuety, $grupo_familia, $grupo_requisitos;
    public $namePage, $tittleModal, $detailModal, $idSelecte, $addInstitucion;
    public $GrupoRequisitoId, $cod_medicamento;
    public $groupFamilyId, $codRequisitos, $tiporequisito, $tipopaeticipante, $grupoRequisitoId, $tipovalidacion,
        $descripcion;
    public $messagesno, $obligatorio, $fichaAplicacion, $vencimiento, $entregable;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->namePage = 'Requisitos';
        $this->idSelecte = 0;
        $this->addInstitucion = 0;
        $this->tittleModal = 'Adicionar Requisitos';

    }


    public function render()
    {

        $this->grupo_familia = GrupoFamilia::orderBy('id', 'desc')->get();

        $this->grupo_requisitos = GrupoRequisitos::orderBy('id', 'desc')->get();


        if (strlen($this->searchQuety) > 0) {
            $requisitos =
                Requisitos::join('grupos_requisitos', 'requisitos.grupo_requisito_id', '=', 'grupos_requisitos.id')
                    ->where('requisitos.descripcion', 'like', '%' . $this->searchQuety . '%')
                    ->paginate($this->pagination);
        } else {
            $requisitos =
                Requisitos::join('grupos_requisitos', 'requisitos.grupo_requisito_id', '=', 'grupos_requisitos.id')
                    ->orderBy('requisitos.id', 'desc')->paginate($this->pagination);

        }

        return view('livewire.requisitos.requisitos-components', ['data' => $requisitos])
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
