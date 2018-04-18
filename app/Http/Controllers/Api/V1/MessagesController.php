<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Controller;
use Cmgmyr\Messenger\Models\Thread;
use App\Http\Resources\MessageResource;

class MessagesController extends Controller
{
     /**
     * Show all of the message threads to the user.
     *
     * @return mixed
     */
    public function unread()
    {
        return [
        	'count' => Auth::user()->newThreadsCount()
        ];
    }

    public function getMessages(Request $request, $thread)
    {
        try {
            $thread = Thread::findOrFail($thread);

            if(!$thread->hasParticipant(Auth::id()))
                return response()->json('Unauthorized.');
                
        } catch (ModelNotFoundException $e) {
            return response()->json('Not Found.');
        }

        $thread->markAsRead(Auth::id());

        return MessageResource::collection($thread->messages);
    }
   
}
