<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Support\Facades\Auth;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Thread new message
     * @var 
     */
    private $thread;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $authUser = Auth::guard('api')->user();

        foreach ($this->thread->users as $user) {

            // skip the current user
            if($authUser->id == $user->id)
                continue;

            $channels[] = new PrivateChannel('messages.' . $user->id);
        }

        return $channels;
    }

    /**
     * Event Alias
     * @return string channel name
     */
    public function broadcastAs()
    {
        return 'new.message';
    }

    public function broadcastWith()
    {
        return [
            'convid' => $this->thread->id
        ];
    }

}
