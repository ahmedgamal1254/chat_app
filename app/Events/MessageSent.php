<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $user_id;
    public User $reciever;

    /**
     * Create a new event instance.
     */
    public function __construct($user_id,$message,User $reciever)
    {
        $this->user_id=$user_id;
        $this->message = $message;
        $this->reciever= $reciever;
    }

    public function broadcastOn()
    {
        return [
            new Channel('message'.$this->reciever->id)
        ];
    }

    public function broadcastAs()
    {
        return 'my-event';
    }
}
