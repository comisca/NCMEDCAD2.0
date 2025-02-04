<?php

namespace App\Livewire;

use App\Models\Auctions;
use App\Models\IntituteCountries;
use App\Models\PostorEvent;
use App\Models\ProductEvent;
use App\Models\Pujas;
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
    public $SelecthistoryAuction, $auctionsData;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {

    }

    public function updated()
    {

        $this->auctionsData = Auctions::join('events_auctions', 'auctions.event_id', '=', 'events_auctions.id')
            ->join('medicamentos', 'auctions.product_id', '=', 'medicamentos.id')
            ->select('auctions.*',
                'medicamentos.descripcion as product_name',
                'medicamentos.cod_medicamento as cod_medic',
                'auctions.id as auction_id')
            ->where('auctions.auction_state', '=', $this->SelecthistoryAuction)
            ->orderBy('auctions.id', 'desc')
            ->get();


    }


    public function render()
    {
        $this->auctionsData = Auctions::join('events_auctions', 'auctions.event_id', '=', 'events_auctions.id')
            ->join('medicamentos', 'auctions.product_id', '=', 'medicamentos.id')
            ->select('auctions.*',
                'medicamentos.descripcion as product_name',
                'medicamentos.cod_medicamento as cod_medic',
                'auctions.id as auction_id')
            ->where('auctions.auction_state', '=', 'Finalizada')
            ->orderBy('auctions.id', 'desc')
            ->get();
        return view('livewire.events.events-history')
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

        $actaData = Auctions::join('events_auctions', 'auctions.event_id', '=', 'events_auctions.id')
            ->join('familia_producto', 'auctions.product_id', '=', 'familia_producto.id')
            ->select('auctions.*',
                'events_auctions.event_name',
                'auctions.id as auction_id')
            ->where('auctions.id', '=', $id)
            ->orderBy('auctions.id', 'desc')
            ->first();
        $productData = ProductEvent::join('medicamentos', 'product_events.product_id', '=', 'medicamentos.id')
            ->where('product_events.event_id', $actaData->event_id)
            ->where('product_events.status', 1)
            ->select('product_events.*', 'medicamentos.*')
            ->first();

        $pujasDatas = Pujas::join('companies', 'pujas.postor_id', '=', 'companies.id')
            ->where('pujas.auction_id', $id)
            ->select('pujas.*')
            ->get();

        $suplierData = Pujas::join('companies', 'pujas.postor_id', '=', 'companies.id')
            ->where('pujas.auction_id', $id)
            ->select('companies.*', 'pujas.code_postor', DB::raw('COUNT(pujas.id) as total_pujas'))
            ->groupBy('companies.id', 'pujas.code_postor')
            ->get();

        $pujaWinner = Pujas::join('companies', 'pujas.postor_id', '=', 'companies.id')
            ->where('pujas.auction_id', $id)
            ->where('pujas.status', 1)
            ->orderBy('pujas.amount', 'desc')
            ->select('companies.*', 'pujas.*')
            ->first();
        $intitutionData =
            IntituteCountries::join('countries', 'intitute_countries.country_event_id', '=', 'countries.id')
                ->join('intitutions', 'intitute_countries.intitute_id', '=', 'intitutions.id')
                ->where('intitute_countries.events_id', $actaData->event_id)
                ->select('intitute_countries.*', 'countries.*', 'intitutions.*')
                ->get();


        $viewData = compact('actaData', 'productData', 'pujasDatas', 'suplierData', 'pujaWinner', 'intitutionData');


        $data = [];

        // Genera el PDF
        $pdf = Pdf::loadView('pdfs.acta-auctions', $viewData)
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
            'acta-' . $id . '- event.pdf'
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
