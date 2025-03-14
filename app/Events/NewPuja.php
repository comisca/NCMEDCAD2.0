<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewPuja implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $auctioID;
    public $userdID;
    public $monto, $postor_id, $code_postor;

    /**
     * Create a new event instance.
     */
    public function __construct($auctioID, $userdID, $monto, $postor_id, $code_postor)
    {
        $this->auctioID = $auctioID;
        $this->userdID = $userdID;
        $this->monto = $monto;
        $this->postor_id = $postor_id;
        $this->code_postor = $code_postor;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('auction.' . $this->auctioID),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'auction_id' => $this->auctioID,
            'user_id' => $this->userdID,
            'amount' => $this->monto,
            'postor_id' => $this->postor_id,
            'code_postor' => $this->code_postor,
        ];
    }
}
