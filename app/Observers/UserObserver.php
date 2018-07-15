<?php

namespace App\Observers;

use App\Token;
use App\User;
use Avatar;
use App\Image;
use App\Profile;

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
        $avatar = md5(uniqid()) . '.png';
        if (!file_exists(public_path('images/avatar/'))) {
            mkdir(public_path('images/avatar/'), 666, true);
        }
        $avatar = 'images/avatar/' . $avatar;

        Avatar::create($user->name)->save(public_path($avatar));

        $image = Image::create([
            'user_id' => $user->id,
            'actual' => $avatar, 
            'large' => $avatar,
            'medium' => $avatar, 
            'small' => $avatar, 
            'tiny' => $avatar,
        ]);

        Profile::create([
            'user_id' => $user->id,
            'display_name' => ucfirst($user->name),
            'image_id' => $image->id,
        ]);

    }
}
