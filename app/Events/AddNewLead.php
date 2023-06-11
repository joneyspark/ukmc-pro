<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AddNewLead implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $url;

    public function __construct($message,$url)
    {
        $this->message = $message;
        $this->url = $url;
    }

    public function broadcastOn()
    {
        return ['CreateLead'];
    }

    public function broadcastAs()
    {
        return 'notice';
    }
}
