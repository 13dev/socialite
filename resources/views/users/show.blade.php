@extends('layouts.app')

@section('c-content')
<user-profile :user="{{ json_encode($user) }}"></user-profile>
@endsection
