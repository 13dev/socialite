<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Http\Resources\Message as MessageResource;

class NewMessagePresence implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $thread;

    private $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($thread, $message)
    {
        $this->thread = $thread;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('thread.' . $this->thread->id);
    }

    public function broadcastAs()
    {
        return 'new.message.presence';
    }

    public function broadcastWith()
    {
        return (new MessageResource($this->message))
                ->toArray($this->message);
    }
}
