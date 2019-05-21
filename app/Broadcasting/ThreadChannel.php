<?php

namespace App\Broadcasting;

use App\User;
use Cmgmyr\Messenger\Models\Thread;
use App\Http\Resources\User as UserResource;

class ThreadChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\User  $user
     * @return array|bool
     */
    public function join(User $user, Thread $thread)
    {
        if ($thread->hasParticipant($user->id)) {
            return new UserResource($user);
        }
    }
}
