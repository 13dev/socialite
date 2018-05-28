<?php

namespace App\Transformers;

use App\Post;
use App\User;
use Illuminate\Support\Facades\Auth;
use League\Fractal\Resource\Primitive;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['user'];

    protected $availableIncludes = ['me'];
    

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Post $post)
    {
        return [
            'id' => $post->id,
            'post' => $post->post,
            'created_at' => [
                'timestamp' => optional($post->created_at)->timestamp,
                'humans' => optional($post->created_at)->diffForHumans()
            ],
            'count' => [
                'favorites' => $post->favorites()->count(),
                'replies' => $post->replies()->count(),
                'reposts' => $post->reposts()->count(),
            ],
        ];
    }

    public function includeUser(Post $post)
    {
        return $this->item($post->user, new UserTransformer);
    }

    public function includeMe(Post $post)
    {
        $user = Auth::guard('api')->user();

        if(!$user)
            return $this->null();

        return $this->item($post, 
            new PostUserTransformer($user)
        );

    }

}
