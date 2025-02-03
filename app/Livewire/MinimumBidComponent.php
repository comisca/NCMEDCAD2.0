<?php

namespace App\Livewire;

use App\Events\AuctionEnded;
use App\Events\NewPuja;
use App\Models\Pujas;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class MinimumBidComponent extends Component
{

    public $auction;
    public $idPosdor, $idAnonimo, $lasBidData;
    public $bidAmount, $reductionAmount;
    public $maxAmount, $minAmount;
    public $remainingBids = 3; // Contador de pujas restantes para subasta directa


//    protected $rules = [
//        'bidAmount' => 'required|numeric|max:' . $this->maxAmount,
//    ];

    public function mount($auction, $idPosdor, $idAnonimo)
    {
        $this->auction = $auction;
        $this->idPosdor = $idPosdor;
        $this->idAnonimo = $idAnonimo;
        // Inicializar contador de pujas para subasta directa
        if ($this->auction->type_auction === 'Directa') {
            $bidCount = Pujas::where('auction_id', $this->auction->id)
                ->where('postor_id', $this->idPosdor)
                ->count();

            $this->remainingBids = 3 - $bidCount;
        }

        $this->calculateBidLimits();

//        $this->calculateMaxAmount();
    }

    public function calculateBidLimits()
    {
        if ($this->auction->type_auction === 'Inversa') {
            $this->calculateInverseBidLimits();
        } else {
            $this->calculateDirectBidLimits();
        }
    }

    private function calculateInverseBidLimits()
    {
        $this->lasBidData = Pujas::where('auction_id', $this->auction->id)
            ->where('status', 1)
            ->orderBy('amount', 'ASC')
            ->first();

        if ($this->lasBidData) {
            $this->reductionAmount = $this->lasBidData->amount * ($this->auction->porcentage_reductions / 100);
            $this->maxAmount = $this->lasBidData->amount * (1 - ($this->auction->porcentage_reductions / 100));
        } else {
            $this->maxAmount = $this->auction->price_reference;
            $this->reductionAmount = 0;
        }
    }

    private function calculateDirectBidLimits()
    {
        $tolerancePercentage = $this->auction->porcentage_tolerance ?? 0;
        $this->maxAmount = $this->auction->price_reference * (1 + ($tolerancePercentage / 100));
        $this->minAmount = 0; // O cualquier mínimo que necesites
    }


    public function calculateMaxAmount()
    {


        $this->lasBidData = Pujas::where('auction_id', $this->auction->id)
            ->where('status', 1)
            ->orderBy('amount', 'ASC')
            ->first();
        // dd($lasBidData);
        if ($this->lasBidData) {

            $this->reductionAmount = $this->lasBidData->amount * ($this->auction->porcentage_reductions / 100);

            // Calcular el nuevo máximo basado en el porcentaje de rebaja
            $this->maxAmount = $this->lasBidData->amount * (1 - ($this->auction->porcentage_reductions / 100));
        } else {
            // Si no hay pujas, usar el precio inicial
            $this->maxAmount = $this->auction->price_reference;
            $this->reductionAmount = 0;
        }
    }


    public function updateMaxAmount($data)
    {
        // Actualizar el máximo cuando se recibe una nueva puja
        $this->calculateMaxAmount();

        // Limpiar el input si el monto actual es mayor al nuevo máximo
        if ($this->bidAmount > $this->maxAmount) {
            $this->bidAmount = null;
        }
    }

    #[On('updateMinumusBid')]
    public function updateBidsDatas()
    {
        $this->calculateMaxAmount();
    }

    public function placeBid()
    {
        // Verificar si es subasta directa y ya usó sus 3 intentos
        if ($this->auction->type_auction === 'Directa') {
            $bidCount = Pujas::where('auction_id', $this->auction->id)
                ->where('postor_id', $this->idPosdor)
                ->count();

            if ($bidCount >= 3) {
                $this->addError('bidAmount', 'Ya has utilizado tus 3 pujas permitidas');
                return;
            }

            $this->remainingBids = 2 - $bidCount; // Actualizar contador antes de la nueva puja
        }

        $validationRules = [
            'bidAmount' => [
                'required',
                'numeric',
            ]
        ];

        if ($this->auction->type_auction === 'Inversa') {
            $validationRules['bidAmount'][] = 'max:' . $this->maxAmount;
        }

        $this->validate($validationRules);

        try {
            DB::beginTransaction();

            $pujaCreated = Pujas::create([
                'auction_id' => $this->auction->id,
                'postor_id' => $this->idPosdor,
                'amount' => $this->bidAmount,
                'puja_time' => now(),
                'code_postor' => $this->idAnonimo,
                'status' => 1,
            ]);

            // Si es subasta directa, actualizar contador y verificar finalización
            if ($this->auction->type_auction === 'Directa') {
                $this->remainingBids--;

                // Verificar si esta fue la tercera puja
                $totalBids = Pujas::where('auction_id', $this->auction->id)
                    ->where('postor_id', $this->idPosdor)
                    ->count();

                if ($totalBids >= 3) {
                    $this->evaluateAndFinalizeBids();
                }
            }


            DB::commit();

            event(new NewPuja(
                $this->auction->id,
                $this->idPosdor,
                $this->bidAmount,
                $this->idPosdor,
                $this->idAnonimo
            ));

            $this->bidAmount = null;
            $this->calculateBidLimits();

        } catch (\Throwable $e) {
            DB::rollBack();
            logger()->error('Error en puja: ' . $e->getMessage());
            $this->addError('bidAmount', 'Error al procesar la puja');
        }
    }


    private function evaluateAndFinalizeBids()
    {
        try {
            DB::beginTransaction();

            // Obtener todas las pujas ordenadas por monto
            $pujas = Pujas::where('auction_id', $this->auction->id)
                ->where('postor_id', $this->idPosdor)
                ->orderBy('amount', 'asc')
                ->get();

            // Calcular el monto máximo permitido según el porcentaje de tolerancia
            $maxAllowed = $this->auction->price_reference * (1 + ($this->auction->porcentage_tolerance / 100));

            // Verificar si hay alguna puja dentro del rango de tolerancia
            $validBids = $pujas->filter(function ($puja) use ($maxAllowed) {
                return $puja->amount <= $maxAllowed;
            });

            // Determinar si hay puja ganadora (la más baja dentro del rango)
            $bestBid = $validBids->first();

            // Limpiar winner_puja en todas las pujas de esta subasta
            Pujas::where('auction_id', $this->auction->id)
                ->update(['winner_puja' => 0]);

            if ($bestBid) {
                // Si hay puja ganadora, marcarla
                $bestBid->update(['winner_puja' => 1]);

                // Actualizar subasta como adjudicada
                $this->auction->update([
                    'auction_state' => 'Finalizada',
                    'auction_result' => 'Adjudicado',
                    'date_end' => now(),
                    'winner_id' => $bestBid->postor_id
                ]);

                $message = "Subasta finalizada. Puja ganadora: $" . number_format($bestBid->amount, 2);
                $icon = 'success';
                $title = 'Subasta Adjudicada';
            } else {
                // No hay pujas válidas
                $this->auction->update([
                    'auction_state' => 'Finalizada',
                    'auction_result' => 'No Adjudicado',
                    'date_end' => now()
                ]);

                $message = 'Subasta finalizada. Ninguna puja dentro del rango de tolerancia.';
                $icon = 'info';
                $title = 'Subasta No Adjudicada';
            }

            DB::commit();

            // Mostrar mensaje del resultado
            broadcast(new AuctionEnded($this->auction->id, $message, $icon, $title));
//            $this->dispatch('swal', [
//                'icon' => $icon,
//                'title' => 'Subasta Finalizada',
//                'text' => $message
//            ]);

            // Opcional: Refrescar la página o redirigir
            $this->dispatch('refreshComponent');

        } catch (\Exception $e) {
            DB::rollback();
            logger()->error('Error al finalizar subasta: ' . $e->getMessage());

            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Ocurrió un error al finalizar la subasta'
            ]);
        }

        // Asegurarse de que el contador de pujas se actualice
        $this->remainingBids = 0;
    }

    private function isWithinTolerance($amount)
    {
        $maxAllowed = $this->auction->price_reference * (1 + ($this->auction->porcentage_tolerance / 100));
        return $amount <= $maxAllowed;
    }


//    #[On('createBid')]
//    public function placeBid()
//    {
//
////        dd('placeBid');
//        $this->validate([
//            'bidAmount' => [
//                'required',
//                'numeric',
//                'max:' . $this->maxAmount
//            ]
//        ]);
//
//        // Crear la puja
//        try {
//            DB::beginTransaction();
//
//            $pujaCreated = Pujas::create([
//                'auction_id' => $this->auction->id,
//                'postor_id' => $this->idPosdor,
//                'amount' => $this->bidAmount,
//                'puja_time' => now(),
//                'code_postor' => $this->idAnonimo,
//                'status' => 1,
//            ]);
//
//            DB::commit();
//
//            // Actualizar el tiempo de finalización de la subasta
////        $this->auction->update([
////            'end_time' => Carbon::now()->addMinutes(3),
////        ]);
//
//            // Emitir evento para actualizar la pantalla
//            event(new NewPuja($this->auction->id,
//                $this->idPosdor,
//                $this->bidAmount,
//                $this->idPosdor,
//                $this->idAnonimo));
//
//            // Limpiar el input
//            $this->bidAmount = null;
//
//            // Actualizar el máximo local
//            $this->calculateMaxAmount();
//
//
//        } catch (\Throwable $e) {
//            DB::rollBack();
//            dd($e->getMessage());
//        }
//    }


    public function render()
    {
        return view('livewire.events.minimum-bid-component');
    }


}
