<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Cmgmyr\Messenger\Models\Thread;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Message as MessageResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ThreadMessageController extends Controller
{
    /**
     * Get all messages in thread.
     * @param  int $id
     * @return \App\Http\Resources\Message
     */
    public function index(int $id)
    {
        try {
            $thread = Thread::findOrFail($id);

            if (! $thread->hasParticipant(Auth::id())) {
                return response()->json('Unauthorized.');
            }
        } catch (ModelNotFoundException $e) {
            return response()->json('Not Found.');
        }

        $thread->markAsRead(Auth::id());

        return MessageResource::collection($thread->messages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
