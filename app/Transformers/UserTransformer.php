<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['roles', 'posts'];

    protected $defaultIncludes = ['count'];
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id'        => $user->id,
            'name'      => $user->name,
            'username'  => $user->username,
            'email'     => $user->email,
        ];
    }

    public function includePosts(User $user)
    {
        $posts = $user->posts;
        return $this->collection($posts, new PostTransformer);
    }

    public function includeCount(User $user)
    {
        return $this->item($user, new UserCountTransformer);
    }

}
