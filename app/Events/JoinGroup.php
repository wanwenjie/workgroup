<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class JoinGroup implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $group_id;
    public $info;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($info)
    {
        $this->info = $info;
        $this->group_id = $info['group_id'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {   
        $name = 'group.'.$this->group_id;
        return new Channel($name);
    }
}
