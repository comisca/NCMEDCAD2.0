<?php

namespace App\Livewire;

use App\Models\Auctions;
use App\Models\PostorEvent;
use App\Models\Pujas;
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
    public $auction;
    public $timeLeft;
    public $bids;
    public $minPrice;

//    protected $listeners = ['bidPlaced' => 'updateAuction'];

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount($id)
    {
        if (Session::has('id_company') || Session::has('id_user')) {

            $this->IdSubasta = $id;
//            dd($this->IdSubasta);
            $this->auction = Auctions::join('events_auctions', 'auctions.event_id', '=', 'events_auctions.id')
                ->join('product_events', 'events_auctions.id', '=', 'product_events.event_id')
                ->select('auctions.*', 'product_events.id as product_id_pe', 'events_auctions.id as event_id')
                ->where('auctions.id', $this->IdSubasta)->first();
            // dd($this->auction);

            $this->bids = Pujas::where('auction_id', $this->IdSubasta)
                ->where('status', 1)
                ->get();

            if ($this->auction->auction_state == 'Finalizada') {
                return redirect('/subastas')->with('error', 'La Subasta ya finalizo!');
            }

            $dateTimeStart = new \DateTime("{$this->auction->date_start} {$this->auction->hour_start}");
            $currentDateTime = new \DateTime();

            if ($dateTimeStart > $currentDateTime) {
                return redirect('/subastas')->with('error', 'La Subasta no ha iniciado aún');
            }

            if (Session::has('id_company')) {
//                dd($this->auction->event_id . '-' . $this->auction->product_id);


                $postores = PostorEvent::join('companies', 'postor_events.postor_id', '=', 'companies.id')
                    ->join('events_auctions', 'postor_events.event_id', '=', 'events_auctions.id')
//                    ->join('product_events', 'postor_events.id_product_event', '=', 'product_events.id')
                    ->select('postor_events.*', 'companies.*', 'events_auctions.*')
                    ->where('postor_events.event_id', $this->auction->event_id)
                    ->where('postor_events.id_product_event', $this->auction->product_id_pe)
                    ->where('postor_events.postor_id', Session::get('id_company'))
                    ->first();

                if ($postores) {
//                        $this->IdPostor = 1;
//                        $this->IdAnonimo = 'wdwdwdwd';
                    $this->IdPostor = $postores->postor_id;
                    $this->IdAnonimo = $postores->name_anonimous;
                } else {
                    return redirect('/subastas')->with('error', 'No tienes autorización para esta subasta');
                }
            }

        } else {
            return redirect('/subastas')->with('error', 'Subasta Privada');
        }

//        $this->minPrice = $this->calculateMinPrice();
    }

    public function calculateTimeLeft()
    {
        $endTime = Carbon::parse($this->auction->end_time);
        $now = Carbon::now();

        if ($now->gt($endTime)) {
            return 0;
        }

        return $endTime->diffInSeconds($now);
    }

    public function calculateMinPrice()
    {
        // Lógica para calcular el precio mínimo basado en las pujas y el porcentaje de rebaja
        // Esto es un ejemplo, ajusta según tus necesidades
        $lastBid = Pujas::where('auction_id', $this->auction->id)->orderBy('created_at', 'desc')->first();
        $minPrice = $lastBid ? $lastBid->amount * 0.9 : $this->auction->price_reference * 0.9;

        return $minPrice;
    }


//    public function placeBid($amount)
//    {
//        // Validar que el monto sea mayor que el precio mínimo
//        if ($amount < $this->minPrice) {
//            return;
//        }
//
//        // Crear la puja
//        Bid::create([
//            'auction_id' => $this->auction->id,
//            'user_id' => auth()->id(),
//            'amount' => $amount,
//        ]);
//
//        // Actualizar el tiempo de finalización de la subasta
//        $this->auction->update([
//            'end_time' => Carbon::now()->addMinutes(3),
//        ]);
//
//        // Emitir evento para actualizar la pantalla
//        $this->emit('bidPlaced');
//    }


    public function updateAuction()
    {
        $this->timeLeft = $this->calculateTimeLeft();
        $this->bids = $this->auction->bids()->orderBy('created_at', 'desc')->get();
        $this->minPrice = $this->calculateMinPrice();
    }


    public function updated()
    {
        $this->IdPostor = $this->IdPostor;
        $this->IdAnonimo = $this->IdAnonimo;

    }


    public function render()
    {
        return view('livewire.events.monitor-auction', [
            'auction' => $this->auction,
            'timeLeft' => $this->timeLeft,
            'bids' => $this->bids,
            'minPrice' => $this->minPrice,
        ])
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
