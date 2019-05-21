<?php

namespace App\Notifications;

use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Cmgmyr\Messenger\Models\Thread;
use App\Transformers\UserTransformer;
use Illuminate\Notifications\Notification;

class NewMessage extends Notification
{
    use Queueable;

    private $conv;
    private $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Thread $conv, User $user)
    {
        $this->conv = $conv;
        $this->user = $user;
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
            'notification' => trans('notification.message.new', [
                'from' => $this->user->profile->display_name ?? $this->user->name,
                'username' => $this->user->username,
                'conv' => $this->conv->subject,
            ]),
            'from' => fractal($this->user, new UserTransformer())->toArray(),
            'conv' => $this->conv->subject,
            'created_at' => Carbon::now()->diffForHumans(),
        ];
    }
}
