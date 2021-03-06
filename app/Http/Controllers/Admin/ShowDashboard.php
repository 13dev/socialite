<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\User;
use App\Comment;
use App\Http\Controllers\Controller;

class ShowDashboard extends Controller
{
    /**
     * Show the application admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return view('admin.dashboard.index', [
            'comments' =>  Comment::lastWeek()->get(),
            'posts' => Post::lastWeek()->get(),
            'users' => User::lastWeek()->get(),
        ]);
    }
}
