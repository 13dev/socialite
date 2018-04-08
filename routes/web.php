<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'PostController@index')->name('home');
Route::resource('media', 'MediaController')->only('show');
Route::get('/posts/feed', 'PostFeedController@index')->name('posts.feed');
Route::resource('posts', 'PostController')->only('show');
Route::resource('users', 'UserController')->only('show');

Route::get('newsletter-subscriptions/unsubscribe', 'NewsletterSubscriptionController@unsubscribe')->name('newsletter-subscriptions.unsubscribe');

Route::group(['prefix' => 'messages', 'middleware' => 'auth'], function () {
    Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index']);
    Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
    Route::post('/', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
    Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
    Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
});
