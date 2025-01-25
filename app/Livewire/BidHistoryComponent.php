<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class BidHistoryComponent extends Component
{

    public $bids;

    protected $listeners = ['updateBidHistory' => 'updateBids'];

    public function mount($bids)
    {
        $this->bids = $bids;
    }

    public function updateBids($bids)
    {
        $this->bids = $bids;
    }

    public function render()
    {
        return view('livewire.bid-history-component');
    }


}
