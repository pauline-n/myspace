@extends('layouts.app');

@section('content')
    <h1>Posts</h1>

    @if (count($posts) > 0)
        @foreach ($posts as $post)
            <div class="well">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img src="{{ url("/storage/cover_images/{$post->cover_img}") }}" style="width:100%" alt="">
                    <br>
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="{{ url('/posts', $post->id)}}">{{$post->title}}</a></h3>
                        <small>Written on {{$post->created_at}} by {{ $post->user ? $post->user->name : 'Unknown' }}</small>
                    </div>
                </div>

            </div>
        @endforeach
        {{ $posts->links() }}  {{-- this is for pagination that we decalred int he controller --}}
    @else
        <p>No posts found!</p>

    @endif
@endsection
