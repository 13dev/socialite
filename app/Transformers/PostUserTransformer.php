<?php

namespace App\Transformers;

use App\Post;
use App\User;
use League\Fractal\TransformerAbstract;

class PostUserTransformer extends TransformerAbstract
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Post $post)
    {
        return [
            'author' => $this->user->id == $post->user->id,
            'reposted' => $this->user->reposted($post->id),
            'favorited' => $this->user->favorited($post->id),

        ];
    }
}
