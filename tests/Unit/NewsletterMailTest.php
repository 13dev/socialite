<?php

namespace Tests\Unit;

use App\Post;
use Tests\TestCase;
use App\Mail\Newsletter;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewsletterMailTest extends TestCase
{
    use RefreshDatabase;

    public function testNewsletterMail()
    {
        $user = $this->user();
        $posts = factory(Post::class, 2)->create();

        Mail::fake();

        Mail::to($user->email)->send(new Newsletter($posts, $user->email));

        Mail::assertSent(Newsletter::class, function ($mailable) use ($user) {
            return $mailable->hasTo($user->email);
        });
    }
}
