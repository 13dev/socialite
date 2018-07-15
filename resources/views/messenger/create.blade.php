@extends('layouts.app')

@section('content')
<div class="columns is-centered">
    <div class="column is-half">

        <h1 class="title">Create a new Group with your friends!</h1>
        <hr>

       <form action="{{ route('messages.store') }}" method="post">
        {{ csrf_field() }}

        @if($users->count() > 0)
         <b-field label="Recivers"
            type="{{ ($errors->has('recipients') ? 'is-danger' : '') }}"
            message="{{ $errors->first('recipients') }}">

            <div class="checkbox">
                @foreach($users as $user)
                    <div class="field m-r-5" style="display: inline-block;">
                        <b-checkbox name="recipients[]" type="is-info" native-value="{!! $user->id !!}">{{ $user->name }}</b-checkbox>
                    </div>
                @endforeach
            </div>
            </b-field>
        @endif

        <b-field label="Subject"
            type="{{ ($errors->has('subject') ? 'is-danger' : '') }}"
            message="{{ $errors->first('subject') }}">
            <b-input placeholder="Subject..."
                type="text"
                icon="border-color"
                name="subject"
                value="{{ old('subject') }}">
            </b-input>
        </b-field>

        <b-field label="First Message"
            type="{{ ($errors->has('message') ? 'is-danger' : '') }}"
            message="{{ $errors->first('message') }}">
            <b-input placeholder="First Message..."
                type="text"
                name="message"
                icon="border-color" >
            </b-input>
        </b-field>
        {!! Form::submit('Create!', ['class' => 'button is-primary']) !!}
            </div>
       </form>

        <hr>
    </div>
</div>
@endsection
