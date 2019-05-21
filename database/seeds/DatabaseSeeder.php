<?php

use App\Role;
use App\User;
use App\Token;
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

            $user->roles()->attach($role_admin->id);
        }

        $this->call([UsersTableSeeder::class]);

        // API tokens
        User::where('api_token', null)->get()->each->update([
            'api_token' => Token::generate(),
        ]);
    }
}
