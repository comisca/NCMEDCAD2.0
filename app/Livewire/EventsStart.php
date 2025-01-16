<?php

namespace App\Livewire;

use App\Models\EventsAuction;
use App\Models\ProductEvent;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class EventsStart extends Component
{

    use WithPagination;

    public $Pagination = 10;
    public $searchInput;
    public $selectedYears, $selectedEvents, $eventsData, $productsEvents;
    public $selectedProductEvent;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {

    }

    public function updated()
    {
        $this->eventsData =
            EventsAuction::join('familia_producto', 'events_auctions.family_id', '=', 'familia_producto.id')
                ->where('events_auctions.status', 1)
                ->where('events_auctions.years', $this->selectedYears)
                ->select('events_auctions.id as id_events', 'familia_producto.*', 'events_auctions.*')
                ->get();


        $this->productsEvents = ProductEvent::join('medicamentos', 'product_events.product_id', '=', 'medicamentos.id')
            ->where('product_events.event_id', $this->selectedEvents)
            ->select('product_events.id as id_product_event',
                'medicamentos.*',
                'product_events.*')
            ->get();


    }


    public function render()
    {
        return view('livewire.events.events-start')
            ->extends('layouts.master')
            ->section('content');
    }


    public function selectedProductEvent($id)
    {
        $this->selectedProductEvent = $id;
        $this->dispatch('selectedProductEvent', $id);

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
