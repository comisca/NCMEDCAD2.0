<?php

namespace App\Livewire;

use App\Models\FamiliaProducto;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class FamilyComponent extends Component
{

    use WithPagination;

    public $Pagination = 10;
    public $searchInput, $nameFamily, $idSelecte = 0;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {

    }


    public function render()
    {
        if (strlen($this->searchInput) > 0) {
            $data = FamiliaProducto::where('status', 1)
                ->where('familia_producto', 'like', '%' . $this->searchInput . '%')
                ->orderBy('id', 'desc')
                ->paginate($this->Pagination);

        } else {
            $data = FamiliaProducto::where('status', 1)
                ->orderBy('id', 'desc')
                ->paginate($this->Pagination);
        }


        return view('livewire.families.family-component', ['data' => $data])
            ->extends('layouts.master')
            ->section('content');
    }

    public function create()
    {


        $rules = [
            'nameFamily' => 'required|min:2|unique:familia_producto,familia_producto',
        ];
        $messages = [
            'nameFamily.required' => 'El nombre de la familia de productos es requerido',
            'nameFamily.min' => 'El nombre de la familia de productros debe se mayor a 2 caracteres',
            'nameFamily.unique' => 'Este nombre de familia de productos ya existe en la bade de datos',
        ];

        $this->validate($rules, $messages);


        try {
            //este metodo lo que hace es inicailizar las transacciones en la base de datos
            DB::beginTransaction();


            FamiliaProducto::create([
                'familia_producto' => $this->nameFamily,
                'status' => 1
            ]);


            //Aqui se escribe el codigo que se desea hacer en la transaccion

            //este metodo lo que hace es guardar los cambios en la base de datos
            DB::commit();

            $this->resetUI();
            $this->dispatch('messages-succes', messages: 'La familia de productos se ha creado correctamente');

        } catch (\Throwable $e) {
            //este metodo lo que hace es deshacer los cambios en la base de datos
            DB::rollback();

            //este metodo lo que hace es mostrar el error en la consola
            dd($e->getMessage());
        }
    }


    public function update()
    {

        $rules = [
            'nameFamily' => 'required|min:2|unique:familia_producto,familia_producto,' . $this->idSelecte,
        ];
        $messages = [
            'nameFamily.required' => 'El nombre de la familia de productos es requerido',
            'nameFamily.min' => 'El nombre de la familia de productros debe se mayor a 2 caracteres',
            'nameFamily.unique' => 'Este nombre de familia de productos ya existe en la bade de datos',

        ];

        $this->validate($rules, $messages);
        try {
            //este metodo lo que hace es inicailizar las transacciones en la base de datos
            DB::beginTransaction();

            $family = FamiliaProducto::find($this->idSelecte);
            $family->familia_producto = $this->nameFamily;
            $family->save();

            //Aqui se escribe el codigo que se desea hacer en la transaccion

            //este metodo lo que hace es guardar los cambios en la base de datos
            DB::commit();
            $this->idSelecte = 0;
            $this->resetUI();
            $this->dispatch('messages-succes',
                messages: 'El nombre de la familia de productos se ha actualizado correctamente');
        } catch (\Throwable $e) {
            //este metodo lo que hace es deshacer los cambios en la base de datos
            DB::rollback();

            //este metodo lo que hace es mostrar el error en la consola
            dd($e->getMessage());
        }
    }

    public function editFamily($idrole)
    {
        $this->idSelecte = $idrole;
        $namerles = FamiliaProducto::find($idrole);
        $this->nameFamily = $namerles->familia_producto;
        $this->dispatch('family-selected');

    }


    #[On('deleterfamily')]
    public function deletexid($postId)
    {
        try {
            //este metodo lo que hace es inicailizar las transacciones en la base de datos
            DB::beginTransaction();

            FamiliaProducto::where('id', $postId)->update(['status' => 0]);
            //Aqui se escribe el codigo que se desea hacer en la transaccion

            //este metodo lo que hace es guardar los cambios en la base de datos
            DB::commit();

            $this->dispatch('messages-succes',
                messages: 'La familia de productos se ha eliminado correctamente');
        } catch (\Throwable $e) {
            //este metodo lo que hace es deshacer los cambios en la base de datos
            DB::rollback();

            //este metodo lo que hace es mostrar el error en la consola
            dd($e->getMessage());
        }
    }


    public function resetUI()
    {

        $this->nameFamily = '';
        $this->idSelecte = 0;

    }

}
