<?php

namespace App\Livewire;

use App\Models\EventsAuction;
use App\Models\FamiliaProducto;
use App\Models\Medicamentos;
use App\Models\ProductEvent;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class EventsConfig extends Component
{

    use WithPagination;

    public $Pagination = 20;
    public $searchInput;
    public $familySelecte, $yearsInput, $nameEvent, $observationEvent;
    public $selectedType, $productData, $idEventSelect;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {

    }

    public function updated()
    {
        if ($this->selectedType == 'Productos') {
            $this->productData = Medicamentos::all();
        } else {
            $this->productData = [];
        }


    }


    public function render()
    {
        $familyData = FamiliaProducto::where('status', 1)->get();
        $eventsData = EventsAuction::join('familia_producto', 'events_auctions.family_id', '=', 'familia_producto.id')
            ->where('events_auctions.status', 1)
            ->select('events_auctions.id as id_events', 'familia_producto.*', 'events_auctions.*')
            ->paginate($this->Pagination);

        return view('livewire.events.events-config', ['eventsData' => $eventsData, 'familyData' => $familyData])
            ->extends('layouts.master')
            ->section('content');
    }

    public function create()
    {
        $rules = [
            'familySelecte' => 'required',
            'yearsInput' => 'required',
            'nameEvent' => 'required',
            'observationEvent' => 'required',
        ];

        $messages = [
            'familySelecte.required' => 'La familia es requerida.',
            'yearsInput.required' => 'El año es requerido.',
            'nameEvent.required' => 'El nombre es requerido.',
            'observationEvent.required' => 'La Observacion es requerida.',

        ];


        $this->validate($rules, $messages);


        try {
            //este metodo lo que hace es inicailizar las transacciones en la base de datos
            DB::beginTransaction();

            $eventlast = EventsAuction::create([
                'family_id' => $this->familySelecte,
                'years' => $this->yearsInput,
                'event_name' => $this->nameEvent,
                'observation' => $this->observationEvent,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            //Aqui se escribe el codigo que se desea hacer en la transaccion

            //este metodo lo que hace es guardar los cambios en la base de datos
            DB::commit();

            $this->resetUI();
            $this->dispatch('event-create', messages: 'El evento fue agregado con exito');

        } catch (\Throwable $e) {
            //este metodo lo que hace es deshacer los cambios en la base de datos
            DB::rollback();

            //este metodo lo que hace es mostrar el error en la consola
            dd($e->getMessage());
        }
    }


    public function addProductsEvents($id)
    {

        try {
            DB::beginTransaction();

            $addData = ProductEvent::create([
                'event_id' => $this->idEventSelect,
                'product_id' => $id,
                'type_product' => $this->selectedType,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);


            DB::commit();

            $this->dispatch('product-add_create', messages: 'El producto fue agregado con exito');

        } catch (\Throwable $e) {
            DB::rollback();
        }


    }


    public function selectedProduct($id)
    {
        $this->idEventSelect = $id;
        $this->dispatch('modal-add-products', messages: 'El evento fue agregado con exito');
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

        $this->familySelecte = '';
        $this->yearsInput = '';
        $this->nameEvent = '';
        $this->observationEvent = '';

    }

}
