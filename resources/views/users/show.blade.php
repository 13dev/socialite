@extends('layouts.app')

@section('c-content')
<user-profile :user="{{ json_encode($user) }}"></user-profile>

@endsection

@push('inline-style')
<style>
	footer {
		display: none!important;
	}
</style>
@endpush