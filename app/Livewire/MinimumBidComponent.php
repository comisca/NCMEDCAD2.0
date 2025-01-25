<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class MinimumBidComponent extends Component
{

    public $auction;
    public $bidAmount;

    protected $rules = [
        'bidAmount' => 'required|numeric|min:0',
    ];

    public function mount(Auction $auction)
    {
        $this->auction = $auction;
    }

    public function placeBid()
    {
        $this->validate();

        // Crear la puja
        Bid::create([
            'auction_id' => $this->auction->id,
            'user_id' => auth()->id(),
            'amount' => $this->bidAmount,
        ]);

        // Actualizar el tiempo de finalización de la subasta
        $this->auction->update([
            'end_time' => Carbon::now()->addMinutes(3),
        ]);

        // Emitir evento para actualizar la pantalla
        $this->emit('bidPlaced');
    }


    public function render()
    {
        return view('livewire.events.minimum-bid-component');
    }


}
