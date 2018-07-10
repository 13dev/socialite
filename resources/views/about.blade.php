@extends('layouts.app')

@section('content')
	<div class="columns is-centered">
		<div class="column is-half">
			<h3 class="title">About {{ config('app.name') }}</h3>
			<hr>
			<small class="subtitle">This project was developed to learn purposes.</small>
		</div>
	</div>
@endsection
