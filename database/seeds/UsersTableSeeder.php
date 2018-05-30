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
        		factory(Profile::class, 5)->create([
        			'user_id' => $user->id
        		]);
        });
    }
}
