<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RejectPermissionDocument implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $channel;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($permissionObject)
    {

        // Set broadcast channel to requester's _id
        $this->channel = $permissionObject['requesterId'];
        $this->message = $permissionObject;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel($this->channel);
    }
    public function broadcastAs()
    {
        return 'permission-response';
    }
}
