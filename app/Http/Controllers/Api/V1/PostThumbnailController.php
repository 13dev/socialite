<?php

namespace App\Http\Controllers\Api\V1;

use App\Post;
use App\Http\Controllers\Controller;
use App\Http\Resources\Post as PostResource;

class PostThumbnailController extends Controller
{
    /**
     * Unset the post's thumbnail.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('update', $post);

        $post->update(['thumbnail_id' => null]);

        return new PostResource($post);
    }
}