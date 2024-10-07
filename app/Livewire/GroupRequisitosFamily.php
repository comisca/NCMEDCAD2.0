<?php

namespace App\Livewire;

use App\Models\FamiliaProducto;
use App\Models\GrupoFamilia;
use App\Models\GrupoRequisitos;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class GroupRequisitosFamily extends Component
{

    use WithPagination;

    public $Pagination = 10;
    public $searchQuety, $descriptionGroup, $idSelecte = 0, $nameGroup, $dataGroup, $idSelectedGroup;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {

    }


    public function render()
    {

        if (strlen($this->searchQuety) > 0) {
            $data = FamiliaProducto::where('status', 1)
                ->where('familia_producto', 'like', '%' . $this->searchQuety . '%')
                ->orderBy('id', 'desc')
                ->paginate($this->Pagination);

        } else {
            $data = FamiliaProducto::where('status', 1)
                ->orderBy('id', 'desc')
                ->paginate($this->Pagination);
        }

        return view('livewire.requisitos.group-requisitos-family', ['data' => $data])
            ->extends('layouts.master')
            ->section('content');
    }

    public function addGroups($id)
    {
        $this->idSelecte = $id;
        $this->dispatch('addGroupsAnwers', $id);

    }

    public function create()
    {

        $rules = [
            'nameGroup' => 'required|min:2|unique:grupos_productos,grupo',
            'descriptionGroup' => 'required',
        ];
        $messages = [
            'nameGroup.required' => 'El nombre del grupo de productos es requerido',
            'nameGroup.min' => 'El nombre del grupo de productos debe se mayor a 2 caracteres',
            'nameGroup.unique' => 'Este nombre de grupo de productos ya existe en la bade de datos',
            'descriptionGroup.required' => 'La descripcion del grupo de productos es requerida',

        ];

        $this->validate($rules, $messages);


        try {
            //este metodo lo que hace es inicailizar las transacciones en la base de datos
            DB::beginTransaction();

            GrupoRequisitos::create([
                'id_familia_producto' => $this->idSelecte,
                'grupo' => $this->nameGroup,
                'descripcion' => $this->descriptionGroup,
                'status' => 1
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

    #[On('seeViewDetailRequisitos')]
    public function seeDetail($idFamily)
    {
        //dd($idFamily);
        $this->idSelectedGroup = $idFamily;
        $this->dataGroup = GrupoRequisitos::where('id_familia_producto', $idFamily)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get();

        $this->dispatch('addGroupsDetail', $idFamily);
    }

    #[On('deleteGroupRequisitos')]
    public function deletexid($postId)
    {
        try {
            //este metodo lo que hace es inicailizar las transacciones en la base de datos
            DB::beginTransaction();

            GrupoRequisitos::where('id', $postId)->update(['status' => 0]);


            $this->dataGroup = GrupoRequisitos::where('id_familia_producto', $this->idSelectedGroup)
                ->where('status', 1)
                ->orderBy('id', 'desc')
                ->get();
            //Aqui se escribe el codigo que se desea hacer en la transaccion

            //este metodo lo que hace es guardar los cambios en la base de datos
            DB::commit();
            $this->dispatch('messages-succes', messages: 'El grupo de productos se ha eliminado correctamente');

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


    public function resetUI()
    {


    }

}
