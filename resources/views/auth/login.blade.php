@extends('layouts.app')

@section('content')
<div class="columns is-centered">
    <div class="column is-half">

        <h1 class="title">@lang('auth.login')</h1>
        <hr>

        {!! Form::open(['route' => 'login', 'role' => 'form', 'method' => 'POST']) !!}
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

        <b-field>
            <b-checkbox 
            name="remember" 
            value="{{ old('remember') }}">
            @lang('auth.remember_me')
            </b-checkbox>
        </b-field>
        {!! Form::submit(__('auth.login'), ['class' => 'button is-primary']) !!}
        {{ link_to('/password/reset', __('auth.forgotten_password'), ['class' => 'button is-link'])}}
            </div>
        {!! Form::close() !!}

        <hr>

        <div class="d-flex justify-content-between flex-wrap">

            @if (env('FACEBOOK_ID'))
                <a href="{{ route('auth.provider', ['provider' => 'facebook']) }}" class="btn btn-secondary mb-2">
                    Facebook
                    <i class="fa fa-facebook" aria-hidden="true"></i>
                </a>
            @endif
            @if (env('GITHUB_ID'))
                <a href="{{ route('auth.provider', ['provider' => 'github']) }}" class="btn btn-secondary mb-2">
                    @lang('auth.services.github')
                    <i class="fa fa-github" aria-hidden="true"></i>
                </a>
            @endif

            @if (env('TWITTER_ID'))
                <a href="{{ route('auth.provider', ['provider' => 'twitter']) }}" class="btn btn-secondary mb-2">
                    @lang('auth.services.twitter')
                    <i class="fa fa-twitter" aria-hidden="true"></i>
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
