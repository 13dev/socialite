<?php

namespace App\Http\Controllers\Api\V1;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Comment as CommentResource;

class UserCommentController extends Controller
{
    /**
     * Return the user's comments.
     *
     * @param  Request $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        return CommentResource::collection(
            $user->comments()->latest()->paginate($request->input('limit', 20))
        );
    }
}
