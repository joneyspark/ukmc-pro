<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AgentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $user_id;
    public $message;
    public $url;

    public function __construct($user_id, $message, $url){
        $this->user_id = $user_id;
        $this->message = $message;
        $this->url = $url;
    }

    public function broadcastOn()
    {
        //return ['task.'.$this->user_id];
        return ['agent.'.$this->user_id];
    }

    public function broadcastAs()
    {
        return 'agentnotice';
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'url' => $this->url,
        ];
    }
}
