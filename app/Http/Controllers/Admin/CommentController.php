<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CommentsRequest;

class CommentController extends Controller
{
    /**
     * Show the application comments index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.comments.index', [
            'comments' => Comment::with('post', 'author')->latest()->paginate(50),
        ]);
    }

    /**
     * Display the specified resource edit form.
     */
    public function edit(Comment $comment)
    {
        return view('admin.comments.edit', [
            'comment' => $comment,
            'users' => User::pluck('name', 'id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentsRequest $request, Comment $comment)
    {
        $comment->update($request->validated());

        return redirect()->route('admin.comments.edit', $comment)->withSuccess(__('comments.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->route('admin.comments.index')->withSuccess(__('comments.deleted'));
    }
}
