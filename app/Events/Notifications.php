<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Notifications implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $customer_id;
    public $message;
    public function __construct($customer_id, $message)
    {
        $this->customer_id = $customer_id;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return ['notifications-channel'];
    }
    public function broadcastAs()
    {
        return 'notifications-event';
    }
}
