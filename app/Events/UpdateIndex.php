<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateIndex implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
public $message;
    /**
     * Create a new event instance.
     */
    public function __construct($message)
    {
         $this->message = $message ;
    }

    public function broadcastOn()
    {
        return ['updateindex-channel'];
    }

    public function broadcastAs()
    {
        return 'updateindex-event';
    }
    // Specify the data to send with the broadcast event
    public function broadcastWith()
    {
        return ['message' => $this->message];
    }
}
