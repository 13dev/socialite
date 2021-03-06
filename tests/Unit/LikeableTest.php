<?php

namespace Tests\Unit;

use App\Like;
use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LikeableTest extends TestCase
{
    use RefreshDatabase;

    public function testLikes()
    {
        $post = factory(Post::class)->create();
        factory(Like::class)->create(['likeable_id' => $post->id]);

        $this->assertCount(1, $post->likes);
    }

    public function testLike()
    {
        $this->actingAsUser();
        $post = factory(Post::class)->create();

        $post->like();

        $this->assertCount(1, $post->likes);
    }

    public function testDislike()
    {
        $this->actingAsUser();
        $post = factory(Post::class)->create();

        $post->like();
        $post->dislike();

        $this->assertCount(0, $post->likes);
    }

    public function testIsLiked()
    {
        $this->actingAsUser();
        $post = factory(Post::class)->create();

        $post->like();

        $this->assertTrue($post->isLiked());
    }

    public function testIsNotLiked()
    {
        $this->actingAsUser();
        $post = factory(Post::class)->create();

        $this->assertFalse($post->isLiked());
    }
}
