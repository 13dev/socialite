<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

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
