<?php

namespace App\Livewire;

use App\Models\Auctions;
use App\Models\PostorEvent;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class MonitorAuction extends Component
{

    use WithPagination;

    public $Pagination = 10;
    public $searchInput;
    public $IdSubasta, $IdPostor, $IdAnonimo;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount($id)
    {
        $this->IdSubasta = $id;
        $dataSubasta = Auctions::where('id', $this->IdSubasta)->first();

        $dateTimeStart = new \DateTime("{$dataSubasta->date_start} {$dataSubasta->hour_start}");
        $currentDateTime = new \DateTime();

        if ($dateTimeStart > $currentDateTime) {
            return redirect('/subastas')->with('error', 'La Subasta no ha iniciado aún');
        }

        if (Session::has('id_company')) {
            $postores = PostorEvent::join('companies', 'postor_events.postor_id', '=', 'companies.id')
                ->join('events_auctions', 'postor_events.event_id', '=', 'events_auctions.id')
                ->select('postor_events.*', 'companies.*', 'events_auctions.*')
                ->where('postor_events.event_id', $dataSubasta->event_id)
                ->where('postor_events.id_product_event', $dataSubasta->product_id)
                ->where('postor_events.postor_id', Session::get('id_company'))
                ->first();

            if ($postores) {
                $this->IdPostor = $postores->id;
                $this->IdAnonimo = $postores->name_anonimous;
            } else {
                return redirect('/subastas')->with('error', 'No tienes autorización para esta subasta');
            }
        }

    }

    public function updated()
    {
        $this->IdPostor = $this->IdPostor;
        $this->IdAnonimo = $this->IdAnonimo;

    }


    public function render()
    {
        return view('livewire.events.monitor-auction')
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
