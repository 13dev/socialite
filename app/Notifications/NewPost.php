<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;
use App\Post;
use Cmgmyr\Messenger\Models\Thread;
use Auth;
use App\Transformers\UserTransformer;
use App\Transformers\PostTransformer;
use Carbon\Carbon;

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
                'from' => $notifiable->profile->display_name ?? $notifiable->username , 
                'username' => $notifiable->username,
            ]),
            'from' => fractal($notifiable, new UserTransformer())->toArray(),
            'post' => fractal($this->post, new PostTransformer())->toArray(),
            'created_at' => Carbon::now()->diffForHumans(),
        ];
    }
}
