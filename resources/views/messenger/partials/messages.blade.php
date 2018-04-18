<div class="chat-bubble {{ auth()->user()->id == $message->user->id ? 'right' : 'left' }} mb-5">
  <div class="p-3">
    {{ $message->body }}
  </div>
  <small class="d-inline-flex mt-1 ml-2 message-date" attr-date=""><i class="fa" style="margin-top:2px;">&#xf017;&nbsp;</i>{{ $message->created_at->diffForHumans() }}</small>
</div>