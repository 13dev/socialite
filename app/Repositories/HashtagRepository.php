<?php

namespace App\Repositories;

use App\Hashtag;

class HashtagRepository {

    protected $hashtag;

    public function __construct(Hashtag $hashtag)
    {
        $this->hashtag = $hashtag;
    }
    
    public function findByName($name)
    {
        return $this->hashtag->where('hashtag', $name)->first();
    }
}