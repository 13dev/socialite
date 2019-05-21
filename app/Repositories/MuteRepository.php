<?php

namespace App\Repositories;

use App\Mute;

class MuteRepository
{
    protected $mute;

    public function __construct(Mute $mute)
    {
        $this->mute = $mute;
    }

    public function find($id)
    {
        return $this->mute->find($id)->first();
    }

    public function remove($userId, $muteId)
    {
        return $this->mute->where(['user_id' => $userId, 'muted_id' => $muteId])->delete();
    }
}
