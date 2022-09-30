<?php

declare(strict_types=1);

namespace Domain\App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockPriceChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels, InteractsWithBroadcasting;

    public function __construct(
        public readonly int $price
    )
    {
    }

    public function broadcastAs(): string
    {
        return 'price.changed';
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('stocks');
    }
}
