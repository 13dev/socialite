<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

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
   
}
