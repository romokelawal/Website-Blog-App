@extends('layouts.app')

@section('content')
    <div class="row justify-content-md-center">
        <div class="col-lg-8">
            <a href="/posts" class="btn btn-secondary">Go to Posts</a>
            <br><br>
            <!-- Post Title -->
            <h1>{{$post->title}}</h1> 
            <!-- Cover Image -->
            <img class="card-img" src="/storage/cover_images/{{$post->cover_image}}">
            &nbsp;
            <h5><span class="badge badge-light">{{$post->category}}</span></h5>
            <div>
                <!-- Post Body. Double exclamation marks are used in place of double brackets so that the body will parsing the html -->
                {!!$post->body!!}
            </div>
            <hr>
            <small>Written on {{$post->created_at}} by {{$post->user->name}}</small></small>
            <hr>
            <div>
                <!-- If the user is not a guest. they'll see the buttons, if not they won't -->
                @if(!Auth::guest())
                    <!-- Buttons should show if the posts belongs to the authenticated user id -->
                    @if(Auth::user()->id == $post->user_id)
                        <!-- Edit Button -->
                        <a href="/posts/{{$post->id}}/edit" class="btn btn-info float-left">Edit</a>
                        <!-- The Delete method and Button -->
                        {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'float-right'])!!}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                        {!!Form::close() !!}
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection