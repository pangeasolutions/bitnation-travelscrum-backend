<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AskPermissionDocument implements ShouldBroadcast
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
error_log('asked-permission');
        // Set broadcast channel to approver's _id
        $this->channel = $permissionObject['approverId'];
        // Take out the approver details since the user already know his own data
        unset($permissionObject['approverId']);
        // Send out the message
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
        return 'permission-asked';
    }
}
