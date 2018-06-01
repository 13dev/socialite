<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Profile;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 5)->create()
        	->each(function($user){
                $user->profile()->save(
                    factory(Profile::class)->make()
                );
        });
    }
}
