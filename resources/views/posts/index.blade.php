@extends('layouts.app')

@section('content')
    <div class="row justify-content-md-center">
        <div class="col-lg-8">
            <h1>Posts</h1>

            <!-- This loops through the posts being sent over from the controller -->
            @if(count($posts) > 0) <!-- Checks to see if there are posts -->
                @foreach($posts as $post)
                    <div class="card">
                        <div class="row card-body">
                            <div class="col-lg-4">
                                <img class="card-img" src="/storage/cover_images/{{$post->cover_image}}">
                            </div>
                            <div class="col-lg-8">
                                <h3 class="card-title"><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>   <!-- This links to the individual post -->
                                <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
                            </div>
                        </div>
                    </div>
                    <br>
                @endforeach
                <!-- Pagination Links -->
                {{$posts->links()}}
            @else  <!-- Activates when there are no posts -->
                <p>No posts found</p>
            @endif
        </div>
    </div>

@endsection