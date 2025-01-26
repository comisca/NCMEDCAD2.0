<?php

namespace App\Livewire;

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
    public $maxAmount;

//    protected $rules = [
//        'bidAmount' => 'required|numeric|max:' . $this->maxAmount,
//    ];

    public function mount($auction, $idPosdor, $idAnonimo)
    {
        $this->auction = $auction;
        $this->idPosdor = $idPosdor;
        $this->idAnonimo = $idAnonimo;
        $this->calculateMaxAmount();
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


//    #[On('createBid')]
    public function placeBid()
    {

//        dd('placeBid');
        $this->validate([
            'bidAmount' => [
                'required',
                'numeric',
                'max:' . $this->maxAmount
            ]
        ]);

        // Crear la puja
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

            DB::commit();

            // Actualizar el tiempo de finalización de la subasta
//        $this->auction->update([
//            'end_time' => Carbon::now()->addMinutes(3),
//        ]);

            // Emitir evento para actualizar la pantalla
            event(new NewPuja($this->auction->id,
                $this->idPosdor,
                $this->bidAmount,
                $this->idPosdor,
                $this->idAnonimo));

            // Limpiar el input
            $this->bidAmount = null;

            // Actualizar el máximo local
            $this->calculateMaxAmount();


        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }


    public function render()
    {
        return view('livewire.events.minimum-bid-component');
    }


}
