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
    public $idPosdor, $idAnonimo;
    public $bidAmount;

    protected $rules = [
        'bidAmount' => 'required|numeric|min:0',
    ];

    public function mount($auction, $idPosdor, $idAnonimo)
    {
        $this->auction = $auction;
        $this->idPosdor = $idPosdor;
        $this->idAnonimo = $idAnonimo;
    }

//    #[On('createBid')]
    public function placeBid()
    {

//        dd('placeBid');
        $this->validate();

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
