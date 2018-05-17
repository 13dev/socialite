<?php

namespace App\Transformers;

use App\RePost;
use Illuminate\Support\Facades\Auth;
use League\Fractal\TransformerAbstract;

class RePostTransformer extends TransformerAbstract
{

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(RePost $repost)
    {
        $user = Auth::guard('api')->user();

        $data = [];

        $data = [
            'is_repost' => true,
            'user_repost' => fractal($repost->user, new UserTransformer())->toArray(),

        ];

        //Include data of post
        //Is user auth?
        if($user){
            //get post data
            $postData = fractal($repost->post, new PostTransformer())
                ->includeMe()
                ->toArray();
        }else{
            $postData = fractal($repost->post, new PostTransformer())
                ->toArray();
        }


        return array_merge($data, $postData);
    }

}
