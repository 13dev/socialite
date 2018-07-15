@extends('layouts.app')

@section('content')
<div class="columns is-centered">
    <div class="column is-half">

        <h1 class="title">@lang('auth.register')</h1>
        <hr>

        {!! Form::open(['route' => 'register', 'role' => 'form', 'method' => 'POST']) !!}
        <b-field label="Name"
            type="{{ ($errors->has('name') ? 'is-danger' : '') }}"
            message="{{ $errors->first('name') }}">
            <b-input placeholder="Name"
                type="text"
                icon="border-color"
                name="name"
                value="{{ old('name') }}">
            </b-input>
        </b-field>

        <b-field label="Username"
            type="{{ ($errors->has('username') ? 'is-danger' : '') }}"
            message="{{ $errors->first('username') }}">
            <b-input placeholder="Username"
                type="text"
                icon="border-color"
                name="username"
                value="{{ old('username') }}">
            </b-input>
        </b-field>

        <b-field label="Email"
            type="{{ ($errors->has('email') ? 'is-danger' : '') }}"
            message="{{ $errors->first('email') }}">
            <b-input placeholder="Email..."
                type="email"
                icon="at"
                name="email"
                value="{{ old('email') }}">
            </b-input>
        </b-field>

        <b-field label="Password"
            type="{{ ($errors->has('password') ? 'is-danger' : '') }}"
            message="{{ $errors->first('password') }}">
            <b-input placeholder="Password..."
                type="password"
                name="password"
                icon="textbox-password" password-reveal>
            </b-input>
        </b-field>

        <b-field label="Password Confirmation"
            type="{{ ($errors->has('password_confirmation') ? 'is-danger' : '') }}"
            message="{{ $errors->first('password_confirmation') }}">
            <b-input placeholder="Password..."
                type="password"
                name="password_confirmation"
                icon="textbox-password" password-reveal>
            </b-input>
        </b-field>

        {!! Form::submit(__('auth.register'), ['class' => 'button is-primary']) !!}
            </div>
        {!! Form::close() !!}

        <hr>
    </div>
</div>
@endsection

