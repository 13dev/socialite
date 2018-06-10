<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Post;

class TimelineTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['posts'];
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($timeline)
    {
        return [
            
        ];
    }

    public function includePosts($timeline)
    {   

    }
}
