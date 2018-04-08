<?php $class = $thread->isUnread(Auth::id()) ? 'alert-info' : ''; ?>

<li class="list-group-item ">
    @if($thread->userUnreadMessagesCount(Auth::id()) == $thread->messages->count())
    NOVA
    @endif
    <h5>
        <a href="{{ route('messages.show', $thread->id) }}">{{ $thread->subject }}</a>
        @if($thread->userUnreadMessagesCount(Auth::id()) != 0)
            ({{ $thread->userUnreadMessagesCount(Auth::id()) }} unread)
        @endif
    </h5>
    {{ $thread->latestMessage->body }}
    <p>
        <strong>Creator:</strong>
        {{ $thread->creator()->name }}
        <br/>
        <strong>Participants:</strong>
        {{ $thread->participantsString(Auth::id()) }}
    </p>
</li>

