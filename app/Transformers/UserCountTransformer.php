<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserCountTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'posts' => $user->posts()->count(),
            'reposts' => $user->reposts()->count(),
            'favorites' => $user->favorites()->count(),
            'followers' => $user->followers()->count(),
            'following' => $user->following()->count(),
        ];
    }
}
