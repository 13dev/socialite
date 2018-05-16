<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
//use App\Role;

class User extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            //'roles' => Role::collection($this->roles),
        ];
    }
}
