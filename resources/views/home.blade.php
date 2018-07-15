@extends('layouts.app')

@section('c-content')
	@guest
		<div class="container">
			<div class="columns is-centered">
				<div class="column is-half" style="text-align: center;">
					<h3 class="title">Welcome to {{ config('app.name') }}</h3>
					<hr>
					<a href="/">
				      <img src="{{ asset('/assets/logo_big.png') }}" style="display: block;margin: 0 auto;" alt="Logo">
				    </a>
				    <br>
					<small class="subtitle" style="display: block;margin: 0 auto;">Connecting your friends around the world. 
						<br>A social network is a website that allows people with similar interests to come together and share information, photos and videos.</small>
					<br/><br/>
					<div style="display: flex;justify-content: space-around;">
						 <p class="control">
		                    <a class="bd-tw-button button is-warning is-rounded is-large" 
		                        href="{{ route('login') }}">
		                        <span class="icon">
		                            <i class="mdi mdi-login-variant"></i>
		                        </span>
		                        <span>
		                            Login
		                        </span>
		                    </a>
		                </p>
		                <p class="control">
		                    <a class="button is-primary is-large is-rounded" 
		                        href="{{ route('register') }}">
		                        <span class="icon">
		                            <i class="mdi mdi-account-plus"></i>
		                        </span>
		                        <span>Register</span>
		                    </a>
		                </p>
					</div>
				</div>
			</div>
		</div>
	@else
		<div class="columns">
			<div class="column m-l-20">
				<!-- left sidebar -->
				@include('sidebar.left')
			</div>
			<div class="column is-half">
				<!-- include the post form -->
				<post-form></post-form>
				<div class="card">
				  <header class="card-header">
				    <p class="card-header-title">
				      Feed
				    </p>
				  </header>
				  <div class="card-content">
				    <feed></feed>
				  </div>
				</div>
				<!-- list all publications -->
			</div>
			<div class="column m-r-20">
				<!-- right sidebar -->
				@include('sidebar.right')
			</div>
		</div>
	@endguest
@endsection
