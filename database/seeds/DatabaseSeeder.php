<?php

use App\Role;
use App\User;
use App\Token;
use App\Profile;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Roles
        Role::firstOrCreate(['name' => Role::ROLE_EDITOR]);
        $role_admin = Role::firstOrCreate(['name' => Role::ROLE_ADMIN]);

        // Users
        if (User::where('email', 'admin@admin.com')->doesntExist()) {
            $user = User::create([
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'username' => 'admin',
                'password' => 'secret',
            ]);

            // Create user profile
            factory(Profile::class)->create([
                'user_id' => $user->id,
            ]);

            $user->roles()->attach($role_admin->id);
        }
        if (User::where('email', 'user@user.com')->doesntExist()) {
            $user = User::create([
                'name' => 'user',
                'email' => 'user@user.com',
                'username' => 'user',
                'password' => 'secret',
            ]);
        }

        $this->call([UsersTableSeeder::class]);

        // API tokens
        User::where('api_token', null)->get()->each->update([
            'api_token' => Token::generate(),
        ]);
    }
}
