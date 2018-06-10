<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Cmgmyr\Messenger\Models\Thread as ThreadModel;
use App\Http\Resources\Message as MessageResource;

class Thread extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = Auth::guard('api')->user();

        return [          
            'id' => $this->id,
            'subject' => $this->subject,
            'created_at' => $this->created_at->diffForHumans(null, false, true),
            'updated_at' => $this->updated_at->diffForHumans(null, false, true),
            'participants_string' => $this->participantsString($user->id),
                'creator' => [
                    'name' => $this->creator()->name,
                    'id' => $this->creator()->id,
                ],
            'last_message' => new MessageResource($this->latestMessage),
            'unreadmessages' => $this->userUnreadMessages($user->id),
            'unreadmessagescount' => $this->userUnreadMessages($user->id)->count(),
            'unreadthread' => $this->isUnread($user->id),
        ];
    }
}
