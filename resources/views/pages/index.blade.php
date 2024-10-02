@extends('layouts.app')

@section('content')
<div class="jumbotron text-center">
    <h1>{{$message}}</h1>
    <p>this is MySpace where we share everything about God, tech, baking, pets and so much more</p>
    <p><a class="btn btn-primary btn-lg" role="button" href="{{ url('/login')}}">Login</a><a class="btn btn-success btn-lg" href="{{ url('/register')}} role="button">Register</a></p>
</div>

@endsection
