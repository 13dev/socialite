<?php

namespace App\Observers;

use Avatar;
use App\User;
use App\Image;
use App\Token;

class UserObserver
{
    /**
     * Listen to the User creating event.
     *
     * @param  User $user
     * @return void
     */
    public function creating(User $user)
    {
        $user->api_token = Token::generate();
    }

    public function created(User $user)
    {
        $avatar = md5(uniqid()).'.png';
        if (! file_exists(public_path('images/avatar/'))) {
            mkdir(public_path('images/avatar/'), 666, true);
        }
        $avatar = 'images/avatar/'.$avatar;

        Avatar::create($user->name)->save(public_path($avatar));

        Image::create([
            'user_id' => $user->id,
            'actual' => $avatar,
            'large' => $avatar,
            'medium' => $avatar,
            'small' => $avatar,
            'tiny' => $avatar,
        ]);
    }
}
