@extends('layouts.app');

@section('content')
    <a href="{{ url('/posts')}}" class="btn btn-default">Go back</a>
    <h1>{{$post->title}}</h1>
    <br>
    <br>
    <img src="{{ url("/storage/cover_images/{$post->cover_img}") }}" style="width:100%" alt="">
    <div>
        {!!$post->body!!}
    </div>
    <hr>
    <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
    <hr>
    @if (!Auth::guest()) {{--if a user is not a guest they will be able to see the edit and delete buttons --}}
        @if (Auth::user()->id == $post->user_id) {{--the user has to be the one logged in --}}
            <a href="{{ url("/posts/{$post->id}/edit")}}" class="btn btn-default">Edit</a>

            {!!Form::open(['route' => ['posts.destroy', $post->id], 'method', 'POST', 'class'=> 'pull-right']) !!}
                {{Form::hidden('_method', 'DELETE')}}
                {!!Form::submit('Delete', ['class'=> 'btn btn-danger'])!!}
            {!! Form::close() !!}
        @endif
    @endif


@endsection
