<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\BuyerOrder;

class BuyerOrderWasPlaced extends Event
{
    use SerializesModels;

    public $buyer_order;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(BuyerOrder $buyer_order)
    {
        $this->buyer_order = $buyer_order;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
