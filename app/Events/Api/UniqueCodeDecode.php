<?php

namespace App\Events\Api;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UniqueCodeDecode implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $uniqueCode;

    public function __construct($uniqueCode)
    {
        $this->uniqueCode = $uniqueCode;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['uniqueCode.'.$this->uniqueCode['code']->channel_id];
    }

    public function broadcastAs()
    {
        return 'UniqueCodeDecode';
    }
}
