<?php

namespace App\Livewire;

use App\Models\Auctions;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Session;
use DB;

class EventsHistory extends Component
{

    use WithPagination;

    public $Pagination = 10;
    public $searchInput;
    public $SelecthistoryAuction;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {

    }


    public function render()
    {
        $auctionsData = Auctions::join('events_auctions', 'auctions.event_id', '=', 'events_auctions.id')
            ->join('medicamentos', 'auctions.product_id', '=', 'medicamentos.id')
            ->select('auctions.*',
                'medicamentos.descripcion as product_name',
                'medicamentos.cod_medicamento as cod_medic',
                'auctions.id as auction_id')
            ->where('auctions.auction_state', '=', 'Pendiente')
            ->orderBy('auctions.id', 'desc')
            ->paginate($this->Pagination);
        return view('livewire.events.events-history', ['auctionsData' => $auctionsData])
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

    public function danloadActas($id)
    {
        $data = [];

        // Genera el PDF
        $pdf = Pdf::loadView('pdfs.acta-auctions', $data)
            ->setPaper('a4')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'helvetica',
            ]);

        // Retorna el PDF como descarga
        return response()->streamDownload(
            function () use ($pdf) {
                echo $pdf->output();
            },
            'acta.pdf'
        );
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
