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
    Route::get('user/{id}/notifications', 'UserController@notifications');
    Route::post('user/{id}/follow', 'UserController@follow');
    Route::get('user/{id}/follow', 'UserController@userIsFollowing');

    Route::get('posts/{id}', 'PostController@show');
    Route::post('posts', 'PostController@store');
    Route::get('posts/{id}/replies', 'PostController@show');
    Route::post('posts/{id}/favorite', 'PostController@favorite');
    Route::post('posts/{id}/repost', 'PostController@repost');
    Route::middleware('auth:api')->group(function () {
        
        // User
        Route::get('user/unreadmessages', 'UserController@unreadMessages');

        // Messages 
        Route::apiResource('messages', 'MessageController')->only(['store', 'show']);

        // Threads
        Route::apiResource('threads', 'ThreadController');
        Route::apiResource('threads.messages', 'ThreadMessageController')->only('index');
      

        // Users
        Route::apiResource('users', 'UserController')->only('update');
    });
    Route::post('/authenticate', 'Auth\AuthenticateController@authenticate')->name('authenticate');
    
    // Users
    Route::apiResource('users', 'UserController')->only(['index', 'show']);
});