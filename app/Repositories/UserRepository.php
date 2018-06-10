<?php

namespace App\Repositories;

use App\Exceptions\UserNotFoundException;

use App\User;

class UserRepository {

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function find($id)
    {
        return $this->user->find($id);
    }
    
    public function findByName($name)
    {
        return $this->user->where('name', $name)->first();
    }

    public function findByUsername($username)
    {
        return $this->user->where('username', $username)->first();
    }
}