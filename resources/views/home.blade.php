@extends('layouts.app')

@section('c-content')
	@guest
		Regista-te para usares o site por completo
	@else
		<div class="columns">
			<div class="column m-l-20">
				<!-- left sidebar -->
				@include('sidebar.left')
			</div>
			<div class="column is-half">
				<!-- include the post form -->

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
