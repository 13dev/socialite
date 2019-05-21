<?php

namespace App\Notifications;

use App\Post;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use App\Transformers\PostTransformer;
use App\Transformers\UserTransformer;
use Illuminate\Notifications\Notification;

class NewPost extends Notification
{
    use Queueable;

    private $post;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'notification' => trans('notification.post.new', [
                'from' => $this->post->user->name,
                'username' => $this->post->user->username,
            ]),
            'from' => fractal($this->post->user, new UserTransformer())->toArray(),
            'post' => fractal($this->post, new PostTransformer())->toArray(),
            'created_at' => Carbon::now()->diffForHumans(),
        ];
    }
}
