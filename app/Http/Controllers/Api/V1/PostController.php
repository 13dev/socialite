<?php

namespace App\Http\Controllers\Api\V1;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Transformers\PostTransformer;
use App\Http\Requests\Admin\PostsRequest;

class PostController extends Controller
{
    /**
     * Return the posts.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*
        return PostResource::collection(
            Post::search($request->input('q'))->withCount('comments')->latest()->paginate($request->input('limit', 20))
        ); */
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Admin\PostsRequest $request
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostsRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $post->update($request->only(['title', 'content', 'posted_at', 'author_id']));

        if ($request->hasFile('thumbnail')) {
            $post->storeAndSetThumbnail($request->file('thumbnail'));
        }

        //return new PostResource($post);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(PostsRequest $request)
    {
        $data = $request->only(['parent_id', 'post']);
        $authUser = Auth::guard('api')->user();
        $post = Post::create(
            array_merge(['user_id' => $authUser->id], $data)
        );

        return json_encode(['success' => ($post) ? true : false]);
    }

    /**
     * Return the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $authUser = Auth::guard('api')->user();
        $post = Post::find($id);

        if (! $post) {
            abort(404);
        }

        $build = fractal()
                ->collection($post->replies)
                ->transformWith(new PostTransformer());

        //User auth?
        if ($authUser) {
            $build = $build->includeMe();
        }

        return $build->toArray();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return response()->noContent();
    }
}
