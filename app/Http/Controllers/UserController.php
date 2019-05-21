<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\Services\PostsGetter;
use App\Http\Requests\UsersRequest;
use App\Transformers\UserTransformer;
use App\Repositories\FavoriteRepository;

class UserController extends Controller
{
    protected $getter;
    protected $userRepo;

    protected $favoriteRepository;

    public function __construct(PostsGetter $getter, FavoriteRepository $favRepo)
    {
        $this->getter = $getter;
        $this->favoriteRepository = $favRepo;
    }

    public function show(string $username)
    {
        $user = User::where('username', $username)->get()->first();

        if (! $user) {
            abort(404);
        }

        $user = fractal($user, new UserTransformer())->toArray();

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = auth()->user();

        $this->authorize('update', $user);

        return view('users.edit', [
            'user' => $user,
            'roles' => Role::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UsersRequest $request)
    {
        $user = auth()->user();

        $this->authorize('update', $user);

        $user->update($request->validated());

        return redirect()->route('users.edit')->withSuccess(__('users.updated'));
    }
}
