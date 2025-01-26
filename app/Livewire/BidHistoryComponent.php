<?php

namespace App\Livewire;

use App\Models\Pujas;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;
use Session;
use DB;

class BidHistoryComponent extends Component
{

    public $bids, $bidsAuction;

    protected $listeners = ['updateBidHistory' => 'updateBids'];

    public function mount($bidsAuction)
    {
        $this->bidsAuction = $bidsAuction;
        $this->bids = Pujas::where('auction_id', $this->bidsAuction->id)
            ->where('status', 1)
            ->orderBy('amount', 'desc')
            ->get();
    }

    #[On('newBid')]
    public function updateBids()
    {
        $this->bids = Pujas::where('auction_id', $this->bidsAuction->id)
            ->where('status', 1)
            ->orderBy('amount', 'desc')
            ->get();
    }


    public function render()
    {
        return view('livewire.events.bid-history-component');
    }


}
