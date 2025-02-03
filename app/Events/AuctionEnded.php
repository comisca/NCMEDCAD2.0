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

class AuctionEnded implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $auctionId;
    public $title;
    public $text;
    public $icon;

    /**
     * Create a new event instance.
     */
    public function __construct($auctionId, $text, $icon, $title)
    {
        $this->auctionId = $auctionId;
        $this->text = $text;
        $this->icon = $icon;
        $this->title = $title;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('auctionEndTimer.' . $this->auctionId),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'auction_id' => $this->auctionId,
            'text' => $this->text,
            'icon' => $this->icon,
            'title' => $this->title,
        ];

    }
}
