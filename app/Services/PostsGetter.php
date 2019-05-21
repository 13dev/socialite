<?php

namespace App\Services;

use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use App\Repositories\RePostRepository;

class PostsGetter
{
    private $post;
    private $repost;
    private $user;

    public function __construct(
        UserRepository $user,
        PostRepository $post,
        RePostRepository $repost)
    {
        $this->user = $user;
        $this->post = $post;
        $this->repost = $repost;
    }

    public function getAll($userId)
    {
        $posts = $this->post->findByUser($userId);
        $reposts = $this->repost->findByUser($userId);
        $merge = $posts->merge($reposts);

        return $merge;
    }

    public function getAllOrdered($userId)
    {
        $all = $this->getAll($userId);

        return $this->sort($all);
    }

    public function followingPost($userId)
    {
        $following = $this->user->find($userId)->following;
        $posts = $this->post->findByUser($userId);
        foreach ($following as $user) {
            $followedPosts = $this->post->findByUser($user->id);
            $posts = $posts->merge($followedPosts);
        }

        return $this->sort($posts);
    }

    private function sort($posts)
    {
        $posts->sort(function ($a, $b) {
            $a = $a->created_at;
            $b = $b->created_at;
            if ($a === $b) {
                return 0;
            }

            return ($a < $b) ? 1 : -1;
        });

        return $posts;
    }
}
