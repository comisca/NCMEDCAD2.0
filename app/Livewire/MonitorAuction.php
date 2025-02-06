<?php

namespace App\Livewire;

use App\Events\AuctionEnded;
use App\Events\TimerUpdate;
use App\Jobs\SendBulkActaEmails;
use App\Mail\NotificationActas;
use App\Models\Auctions;
use App\Models\IntituteCountries;
use App\Models\PostorEvent;
use App\Models\ProductEvent;
use App\Models\Pujas;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
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
    public $IdSubasta, $IdPostor, $IdAnonimo, $namePostor;
    public $auction;
    public $timeLeft;
    public $bids;
    public $minPrice, $productEventData;
    public $remainingTime, $varNewMyBid;
    public $isRecoveryPeriod = false;

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
                ->select('auctions.*',
                    'product_events.id as product_id_pe',
                    'events_auctions.id as event_id',
                    'events_auctions.event_name',
                    'auctions.total',
                    'auctions.price_reference')
                ->where('auctions.id', $this->IdSubasta)->first();
            // dd($this->auction);

            $this->productEventData =
                ProductEvent::join('medicamentos', 'product_events.product_id', '=', 'medicamentos.id')
                    ->select('product_events.*', 'medicamentos.*')
                    ->where('product_events.event_id', $this->auction->event_id)
                    ->first();

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
                    $this->namePostor = $postores->legal_name;
                } else {
                    return redirect('/subastas')->with('error', 'No tienes autorización para esta subasta');
                }


            }

        } else {
            return redirect('/subastas')->with('error', 'Subasta Privada');
        }
        // Verificar si la subasta ya debería estar finalizada
        $now = Carbon::now();
        $startTime = Carbon::parse($this->auction->date_start . ' ' . $this->auction->hour_start);
        $endTime = $startTime->copy()->addMinutes($this->auction->duration_time);

        if ($now->gt($endTime)) {
            $this->calculateRemainingTime();
            $this->finalizarSubasta();
//            return redirect('/subastas')->with('error', 'La Subasta ya finalizo!');
        }

        $this->calculateRemainingTime();
//        $this->minPrice = $this->calculateMinPrice();
    }

    public function calculateRemainingTime()
    {
        $now = Carbon::now();
        $startTime = Carbon::parse($this->auction->date_start . ' ' . $this->auction->hour_start);
        $endTime = $startTime->copy()->addMinutes($this->auction->duration_time);

        // Si ya pasó el tiempo de finalización
        if ($now->gt($endTime)) {
            if ($this->auction->auction_state !== 'Finalizada') {
                $this->finalizarSubasta();
            }
            $this->remainingTime = 0;
            return;
        }

        $this->remainingTime = max(0, $endTime->diffInSeconds($now));
        $this->isRecoveryPeriod = $this->remainingTime <= ($this->auction->recovery_time * 60);

        broadcast(new TimerUpdate(
            $this->auction->id,
            $this->remainingTime,
            $this->isRecoveryPeriod
        ));
    }

    private function finalizarSubasta()
    {
        try {
            DB::beginTransaction();

            $auction = Auctions::find($this->auction->id);

            $lastPujaData = Pujas::where('auction_id', $this->auction->id)
                ->where('status', 1)
                ->orderBy('id', 'desc')
                ->first();

            if (!empty($lastPujaData)) {


                if ($auction && $auction->auction_state !== 'Finalizada') {
                    $auction->update([
                        'date_end' => Carbon::now(),
                        'auction_state' => 'Finalizada',
                        'winner_id' => $lastPujaData->postor_id,
                        'auction_result' => 'Adjudicado'
                    ]);

                    Pujas::where('auction_id', $this->auction->id)
                        ->where('status', 1)
                        ->where('id', '=', $lastPujaData->id)
                        ->update([
                            'winner_puja' => 1
                        ]);


//                    broadcast(new AuctionEnded($auction->id))->toOthers();


                    $icon = 'success';
                    $title = '¡Subasta Adjudicada!';
                    $text = 'Subasta finalizada. Puja ganadora: $' . number_format($lastPujaData->amount, 2);

                }
            } else {
                $auction->update([
                    'date_end' => Carbon::now(),
                    'auction_state' => 'Finalizada',
                    'auction_result' => 'No Adjudicado'
                ]);
                $icon = 'success';
                $title = '¡Subasta No Adjudicada!';
                $text = 'La negociacion ha terminado sin adjudicar';


            }

            DB::commit();

            $this->danloadActasMonitor($this->auction->id);

            broadcast(new AuctionEnded($auction->id, $text, $icon, $title));
        } catch (\Exception $e) {
            DB::rollback();
            logger()->error('Error finalizando subasta: ' . $e->getMessage());
        }
    }

    public function danloadActasMonitor($id)
    {

        try {

            $actaData = Auctions::join('events_auctions', 'auctions.event_id', '=', 'events_auctions.id')
                ->join('medicamentos', 'auctions.product_id', '=', 'medicamentos.id')
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

            $soloemails = Pujas::join('companies', 'pujas.postor_id', '=', 'companies.id')
                ->where('pujas.auction_id', $id)
                ->groupBy('companies.id', 'companies.email') // Asegúrate de incluir email en el groupBy
                ->pluck('companies.email')
                ->toArray();

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

//            dd($soloemails);

            $viewData = compact('actaData', 'productData', 'pujasDatas', 'suplierData', 'pujaWinner', 'intitutionData');

            // Genera el PDF
            $pdf = Pdf::loadView('pdfs.acta-auctions', $viewData)
                ->setPaper('a4')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'defaultFont' => 'helvetica',
                ]);

            // Nombre del archivo PDF
            $filename = 'acta-' . $id . '-event.pdf';

            // Guarda el PDF temporalmente
            $pdfContent = $pdf->output();
            Storage::disk('local')->put('temp/' . $filename, $pdfContent);

            // Envía el correo con el PDF adjunto
            SendBulkActaEmails::dispatch($viewData, $filename, $soloemails);


//            // Retorna el PDF como descarga
            return response()->streamDownload(
                function () use ($pdf) {
                    echo $pdf->output();
                },
                $filename
            );
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }
    }
//    #[On('updateTimerCount')]
//    public function calculateRemainingTime()
//    {
//        $now = Carbon::now();
//        $startTime = Carbon::parse($this->auction->date_start . ' ' . $this->auction->hour_start);
//        $endTime = $startTime->copy()->addMinutes($this->auction->duration_time);
//
//        if ($now->lt($startTime)) {
//            $this->remainingTime = null;
//            return;
//        }
//
//        $this->remainingTime = $endTime->diffInSeconds($now);
//        $this->isRecoveryPeriod = $this->remainingTime <= ($this->auction->recovery_time * 60);
//
//        // Si el tiempo restante es 0 o negativo
//        if ($this->remainingTime <= 0) {
//            try {
//                DB::beginTransaction();
//
//                $auction = Auctions::find($this->auction->id);
//                if ($auction && $auction->auction_state !== 'Finalizada') {
//                    $auction->update([
//                        //     'date_end' => Carbon::now(),
//                        'auction_state' => 'Finalizada'
//                    ]);
//
//                    DB::commit();
//
//                    // Emitir evento para notificar a otros usuarios
//                    broadcast(new AuctionEnded($auction->id))->toOthers();
//
//                    // Mostrar mensaje de finalización
//                    $this->dispatch('swal', [
//                        'icon' => 'success',
//                        'title' => '¡Subasta Finalizada!',
//                        'text' => 'La subasta ha terminado exitosamente'
//                    ]);
//                }
//            } catch (\Exception $e) {
//                DB::rollback();
//                \Log::error('Error al finalizar la subasta: ' . $e->getMessage());
//            }
//
//            $this->remainingTime = 0;
//            return;
//        }
//
//        // Emitir evento de actualización del timer
//        broadcast(new TimerUpdate($this->auction->id, $this->remainingTime, $this->isRecoveryPeriod))->toOthers();
//    }
//    public function calculateRemainingTime()
//    {
//        $now = Carbon::now();
//        $startTime = Carbon::parse($this->auction->date_start . ' ' . $this->auction->hour_start);
//        $endTime = $startTime->copy()->addMinutes($this->auction->duration_time);
//
//        if ($now->lt($startTime)) {
//            $this->remainingTime = null;
//            return;
//        }
//
//        $this->remainingTime = $endTime->diffInSeconds($now);
//        $this->isRecoveryPeriod = $this->remainingTime <= ($this->auction->recovery_time * 60);
//
//        // Emitir evento de actualización del timer
//        broadcast(new TimerUpdate($this->auction->id, $this->remainingTime, $this->isRecoveryPeriod))->toOthers();
//    }

    #[On('updateWacth')]
    public function handleNewBid()
    {
        if ($this->isRecoveryPeriod) {
            $this->remainingTime = $this->auction->recovery_time * 60;
            broadcast(new TimerUpdate(
                $this->auction->id,
                $this->remainingTime,
                true
            ));
        }
    }


    #[On('endAuction')]
    public function handleEndAuction()
    {

        //   dd('endAuction');
        try {
            DB::beginTransaction();

            $auction = Auctions::find($this->auction->id);
            if ($auction) {
                $auction->update([
                    'date_end' => Carbon::now(),
                    'auction_state' => 'Finalizada'
                ]);

                DB::commit();

                $this->dispatch('swal', [
                    'icon' => 'success',
                    'title' => '¡Subasta Finalizada!',
                    'text' => 'La subasta ha terminado exitosamente'
                ]);
            }

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error al finalizar la subasta: ' . $e->getMessage());

            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Hubo un problema al finalizar la subasta'
            ]);
        }
    }



//    #[On('auctionFinished')]
//    public function handleAuctionEnd()
//    {
//        try {
//            DB::beginTransaction();
//
//            $auction = Auctions::find($this->auction->id);
//            if ($auction) {
//                $auction->update([
//                    'date_end' => Carbon::now(),
//                    'auction_state' => 'Finalizada'
//                ]);
//
//                DB::commit();
//
//                // Emitir evento para otros usuarios
//                broadcast(new AuctionEnded($auction->id))->toOthers();
//
//                $this->redirect('/subastas');
//            }
//        } catch (\Exception $e) {
//            DB::rollback();
//            \Log::error('Error al finalizar la subasta: ' . $e->getMessage());
//        }
//    }

//    public function handleNewBid()
//    {
//        $now = Carbon::now();
//        $startTime = Carbon::parse($this->auction->date_start . ' ' . $this->auction->hour_start);
//        $endTime = $startTime->copy()->addMinutes($this->auction->duration_time);
//
//        $this->remainingTime = $endTime->diffInSeconds($now);
//        $this->isRecoveryPeriod = $this->remainingTime <= ($this->auction->recovery_time * 60);
//
//        if ($this->isRecoveryPeriod) {
//            $this->remainingTime = $this->auction->recovery_time * 60;
//
//            broadcast(new TimerUpdate(
//                $this->auction->id,
//                $this->remainingTime,
//                true
//            ))->toOthers();
//        }
//    }


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
        $this->namePostor = $this->namePostor;

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
