<?php

namespace App\Http\Controllers\Api\V1;

use App\Post;
use App\User;
use App\RePost;
use App\UserRelations;
use Illuminate\Http\Request;
use App\Services\PostsGetter;
use App\Http\Requests\UsersRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Transformers\PostTransformer;
use App\Transformers\RePostTransformer;
use App\Http\Resources\User as UserResource;
use App\Transformers\NotificationTransformer;

class UserController extends Controller
{
    protected $getter;

    public function __construct(PostsGetter $getter)
    {
        $this->getter = $getter;
    }

    /**
     * Return the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return UserResource::collection(
            User::withCount(['comments', 'posts'])->with('roles')->latest()->paginate($request->input('limit', 20))
        );
    }

    /**
     * Return the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UsersRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $user->update(array_filter($request->only(['name', 'email', 'password'])));

        return new UserResource($user);
    }

    /**
     * Show all of new messages threads to the user.
     *
     * @return mixed
     */
    public function unreadMessages()
    {
        return [
            'count' => Auth::user()->newThreadsCount(),
        ];
    }

    public function timeline(int $id)
    {
        $user = User::find($id);

        if (! $user) {
            abort(404);
        }

        $timeline = $user->timeline;
        $response = [];
        $authUser = Auth::guard('api')->user();

        // For each post / repost
        foreach ($timeline as $post) {

            // choose correct transformer
            if ($post instanceof Post) {
                $build = fractal($post, new PostTransformer());

                //User auth?
                if ($authUser) {
                    $build = $build->includeMe();
                }

                $response[] = $build->toArray();
            } elseif ($post instanceof RePost) {
                $response[] = fractal($post, new RePostTransformer())->toArray();
            }
        }

        return $response;
    }

    public function notifications(int $id)
    {
        $user = User::find($id);
        $authUser = Auth::guard('api')->user();

        if (! $user || $user->id != $authUser->id) {
            abort(404);
        }

        return fractal($user->unreadNotifications, new NotificationTransformer())->toArray();
    }

    /**
     * check if current user (auth user) is following the {$id} user.
     * @param  int    $id user followed
     * @return bool
     */
    public function userIsFollowing(int $id)
    {
        // User to follow
        $user = User::find($id);
        $authUser = Auth::guard('api')->user();

        if (! $user) {
            abort(404);
        }

        //Is user already following ?
        if ($authUser->follows($user->id)) {
            return response()->json(['is_following' => true]);
        }

        return response()->json(['is_following' => false]);
    }

    /**
     * POST - follow/unfollow user.
     * @param  int    $id user to follow
     * @return bolean     return if user is followed or not.
     */
    public function follow(int $id)
    {
        $user = User::find($id);
        $authUser = Auth::guard('api')->user();

        if (! $user) {
            abort(404);
        }

        //Is user already following ?
        if ($authUser->follows($user->id)) {
            UserRelations::where([
                'follower_id' => $authUser->id,
                'followed_id' => $user->id,
            ])->delete();

            return response()->json(['is_following' => false]);
        }

        $follows = UserRelations::create([
            'follower_id' => $authUser->id,
            'followed_id' => $user->id,
        ]);

        if (! $follows) {
            return response()->json(['is_following' => false]);
        }

        return response()->json(['is_following' => true]);
    }

    /**
     * @param  int | user id
     * @return array
     */
    public function feed(int $id)
    {
        $user = User::find($id);
        $authUser = Auth::guard('api')->user();

        if (! $user || $user->id != $authUser->id) {
            abort(404);
        }

        $feed = [];
        $feed['posts'] = [];
        $feed['reposts'] = [];
        $response = [];

        foreach ($user->followers as $userFlrs) {
            // Merge reposts and posts to response array
            $response = array_merge(
                array_merge(
                    $userFlrs->posts
                        ->transformWith(new PostTransformer())
                        ->includeMe()
                        ->toArray(),
                    $userFlrs->reposts
                        ->transformWith(new RePostTransformer())
                        ->toArray()
                    ), $response);
        }

        foreach ($user->followers as $userFlg) {
            // Merge followers posts and reposts to response
            $response = array_merge(
                array_merge(
                    $userFlg->posts
                        ->transformWith(new PostTransformer())
                        ->includeMe()
                        ->toArray(),
                    $userFlg->reposts
                        ->transformWith(new RePostTransformer())
                        ->toArray()
                    ), $response);
        }

        // merge reposts and posts
        $response = array_merge(
            array_merge(
                $user->posts
                    ->transformWith(new PostTransformer())
                    ->includeMe()
                    ->toArray(),
                $user->reposts
                    ->transformWith(new RePostTransformer())
                    ->toArray()
                ), $response);

        // Sort array by date
        $response = array_values(array_sort($response, function ($value) {
            return $value['created_at'];
        }));

        // Remove duplicates
        $response = array_unique($response, SORT_REGULAR);

        return array_reverse($response);
    }
}
