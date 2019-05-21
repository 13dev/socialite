<?php

namespace App\Policies;

use App\User;
use Cmgmyr\Messenger\Models\Message;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user is admin for all authorization.
     */
    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can store the message.
     *
     * @param  \App\User  $user
     * @param  \App\Comment  $message
     * @return bool
     */
    public function store(User $user, Message $message): bool
    {
        return $message->thread->hasParticipant($user->id);
    }
}
