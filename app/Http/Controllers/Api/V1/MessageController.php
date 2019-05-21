<?php

namespace App\Http\Controllers\Api\V1;

use Carbon\Carbon;
use App\Events\NewMessage;
use App\Events\NewMessagePresence;
use Cmgmyr\Messenger\Models\Thread;
use App\Http\Controllers\Controller;
use Cmgmyr\Messenger\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Cmgmyr\Messenger\Models\Participant;
use App\Http\Requests\Api\SendMessageRequest;
use App\Http\Resources\Message as MessageResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Notifications\NewMessage as NewMessageNotification;

class MessageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SendMessageRequest $request)
    {
        sleep(0.2);

        $thread_id = $request->input('thread_id');
        $messsage = $request->input('message');

        try {
            $thread = Thread::findOrFail($thread_id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Not found.',
            ]);
        }

        $thread->activateAllParticipants();

        // Message
        $message = new Message([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => Input::get('message'),
        ]);

        $this->authorize('store', $message);

        $message->save();

        // Add replier as a participant
        $participant = Participant::firstOrCreate([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
        ]);

        $participant->last_read = new Carbon;
        $participant->save();

        // Recipients
        if (Input::has('recipients')) {
            $thread->addParticipant(Input::get('recipients'));
        }

        broadcast(new NewMessage($thread));
        broadcast(new NewMessagePresence($thread, $message))->toOthers();

        // Send notification
        $usersToNotify = $thread->users()
            ->where('user_id', '!=', Auth::id())->get();

        foreach ($usersToNotify as $user) {
            $user->notify(new NewMessageNotification($thread, $message->user));
        }

        return new MessageResource($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $message = Message::findOrFail($thread_id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Not found.',
            ]);
        }

        return new MessageResource($message);
    }
}
