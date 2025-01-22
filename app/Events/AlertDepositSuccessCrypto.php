<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AlertDepositSuccessCrypto implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return ['alertcrypto-channel'];
    }

    public function broadcastAs()
    {
        return 'alertcrypto-event';
    }
    // Specify the data to send with the broadcast event
    public function broadcastWith()
    {
        return ['user_id' => $this->message];
    }
}

