<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('v1')->namespace('Api\V1')->group(function () {
    
    //User
    Route::get('user/{id}/timeline', 'UserController@timeline');
    Route::get('user/{id}/feed', 'UserController@feed');
    Route::get('posts/{id}', 'PostController@show');
    Route::post('posts', 'PostController@store');
    Route::get('posts/{id}/replies', 'PostController@show');

    Route::middleware('auth:api')->group(function () {
        
        // User
        Route::get('user/unreadmessages', 'UserController@unreadMessages');

        // Messages 
        Route::apiResource('messages', 'MessageController')->only(['store', 'show']);

        // Threads
        Route::apiResource('threads', 'ThreadController');
        Route::apiResource('threads.messages', 'ThreadMessageController')->only('index');
      
        // Comments
        Route::apiResource('comments', 'CommentController')->only('destroy');
        Route::apiResource('posts.comments', 'PostCommentController')->only('store');

        // Users
        Route::apiResource('users', 'UserController')->only('update');
    });
    Route::post('/authenticate', 'Auth\AuthenticateController@authenticate')->name('authenticate');
    // Comments
    Route::apiResource('posts.comments', 'PostCommentController')->only('index');
    Route::apiResource('users.comments', 'UserCommentController')->only('index');
    Route::apiResource('comments', 'CommentController')->only(['index', 'show']);
    
    Route::apiResource('users.posts', 'UserPostController')->only('index');
    // Users
    Route::apiResource('users', 'UserController')->only(['index', 'show']);
});