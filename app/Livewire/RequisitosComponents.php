<?php

namespace App\Livewire;

use App\Models\FamiliaProducto;
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

    public function updated()
    {

        $this->grupo_requisitos = GrupoRequisitos::orderBy('id', 'desc')
            ->where('id_familia_producto', $this->groupFamilyId)
            ->get();

    }


    public function render()
    {

        $this->grupo_familia = FamiliaProducto::orderBy('id', 'desc')->get();


        if (strlen($this->searchQuety) > 0) {
            $requisitos =
                Requisitos::join('grupos_requisitos', 'requisitos.grupo_requisito_id', '=', 'grupos_requisitos.id')
                    ->where('requisitos.descripcion', 'like', '%' . $this->searchQuety . '%')
                    ->select('requisitos.*', 'grupos_requisitos.descripcion as grupo_requisito')
                    ->paginate($this->pagination);
        } else {
            $requisitos =
                Requisitos::join('grupos_requisitos', 'requisitos.grupo_requisito_id', '=', 'grupos_requisitos.id')
                    ->select('requisitos.*', 'grupos_requisitos.descripcion as grupo_requisito')
                    ->orderBy('requisitos.id', 'desc')->paginate($this->pagination);

        }

        return view('livewire.requisitos.requisitos-components', ['data' => $requisitos])
            ->extends('layouts.master')
            ->section('content');
    }

    public function create()
    {

        $rules = [
            'codRequisitos' => 'required|min:2|unique:requisitos,codigo',
            'groupFamilyId' => 'required',
            'tiporequisito' => 'required',
            'tipopaeticipante' => 'required',
            'grupoRequisitoId' => 'required',
            'tipovalidacion' => 'required',
            'descripcion' => 'required',
            'messagesno' => 'required',
        ];
        $messages = [
            'codRequisitos.required' => 'El codigo del grupo de productos es requerido',
            'codRequisitos.min' => 'El codigo del grupo de productos debe tener al menos 2 caracteres',
            'codRequisitos.unique' => 'Este codigo ya se encuentra registrado',
            'groupFamilyId.required' => 'La familia de productos es requerida',
            'tiporequisito.required' => 'El tipo de requisito es requerido',
            'tipopaeticipante.required' => 'El tipo de participante es requerido',
            'tipovalidacion.required' => 'El tipo de validacion es requerido',
            'descripcion.required' => 'La descripcion del grupo de productos es requerida',
            'messagesno.required' => 'El mensaje es requerido',
            'grupoRequisitoId.required' => 'El Grupo de Requisito es requerido',

        ];

        $this->validate($rules, $messages);
        try {
            //este metodo lo que hace es inicailizar las transacciones en la base de datos
            DB::beginTransaction();

            Requisitos::create([
                'id_familia_producto' => $this->groupFamilyId,
                'grupo_requisito_id' => $this->grupoRequisitoId,
//                'cod_medicamento' => $this->cod_medicamento,
                'codigo' => $this->codRequisitos,
                'tipo_requisitos' => $this->tiporequisito,
                'tipo_participante' => $this->tipopaeticipante,
                'tipo_validacion' => $this->tipovalidacion,
                'descripcion' => $this->descripcion,
                'mensaje_nocumple' => $this->messagesno,
                'obligatorio' => $this->obligatorio,
                'ficha' => $this->fichaAplicacion,
                'vence' => $this->vencimiento,
                'entregable' => $this->entregable,
            ]);


            //Aqui se escribe el codigo que se desea hacer en la transaccion

            //este metodo lo que hace es guardar los cambios en la base de datos
            DB::commit();

            $this->resetUI();
            $this->dispatch('messages-succes', messages: 'El grupo de productos se ha creado correctamente');

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
        $this->codRequisitos = '';
        $this->groupFamilyId = '';
        $this->tiporequisito = '';
        $this->tipopaeticipante = '';
        $this->grupoRequisitoId = '';
        $this->tipovalidacion = '';
        $this->descripcion = '';
        $this->messagesno = '';
        $this->obligatorio = '';
        $this->fichaAplicacion = '';
        $this->vencimiento = '';
        $this->entregable = '';


    }

}
