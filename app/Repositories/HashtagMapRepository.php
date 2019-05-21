<?php

namespace App\Repositories;

use App\HashtagMap;

class HashtagMapRepository
{
    protected $map;

    public function __construct(HashtagMap $map)
    {
        $this->map = $map;
    }

    public function latest($count)
    {
        return $this->map->orderBy('created_at')->take($count)->get();
    }
}
