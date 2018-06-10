<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostsRequest;
use App\Http\Requests\Api\Post\FavoriteRequest;
use App\Http\Requests\Api\Post\RepostRequest;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transformers\PostTransformer;
use App\Favorite;
use App\RePost;
use App\Notifications\NewPost as NewPostNotification;

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

        // Send notification
        $usersToNotify = $authUser->followers()
            ->where('users.id', '!=', Auth::id())->get();

        foreach ($usersToNotify as $user) {
            $user->notify(new NewPostNotification($post));
        }

        return json_encode(['success' => ($post) ?  true : false]);
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

        if(!$post)
            abort(404);

        $build = fractal()
                ->collection($post->replies)
                ->transformWith(new PostTransformer());
        
        //User auth?
        if($authUser)
            $build = $build->includeMe();

        return $build->toArray();
        
    }

    public function repost(int $id, RepostRequest $request)
    {
        $authUser = Auth::guard('api')->user();
        $data = $request->only(['user_id']);

        if($authUser->id != $request->get('user_id'))
            return response()->json('Unauthorized.');

        $post = Post::find($id);

        if(!$post)
            abort(404);

        if($authUser->reposted($post->id))
        {
            // User has reposted the post already.
            $repost = RePost::where([
                'post_id' => $post->id, 
                'user_id' => $authUser->id
            ])->delete();

            if($repost)
                return response()->json(['success' => true, 'reposted' => false]);
            
            return response()->json(['success' => false, 'reposted' => true]);

        }

        // User not reposted the post.
        $repost = RePost::create([
            'post_id' => $post->id, 
            'user_id' => $authUser->id
        ]);

        if($repost)
            return response()->json(['success' => true, 'reposted' => true]);
            
        return response()->json(['success' => false, 'reposted' => false]);
       
    }

    public function favorite(int $id, FavoriteRequest $request)
    {
        $authUser = Auth::guard('api')->user();
        $data = $request->only(['user_id']);

        if($authUser->id != $request->get('user_id'))
            return response()->json('Unauthorized.');

        $post = Post::find($id);

        if(!$post)
            abort(404);

        if($authUser->favorited($post->id))
        {
            // User has favorited the post already.
            $favorite = Favorite::where([
                'post_id' => $post->id, 
                'user_id' => $authUser->id
            ])->delete();

            if($favorite)
                return response()->json(['success' => true, 'favorited' => false]);
            
            return response()->json(['success' => false, 'favorited' => false]);

        }

        // User not favorited the post.
        $favorite = Favorite::create([
            'post_id' => $post->id, 
            'user_id' => $authUser->id
        ]);

        if($favorite)
            return response()->json(['success' => true, 'favorited' => true]);
            
        return response()->json(['success' => false, 'favorited' => false]);
       
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
