@extends('layouts.app')

@section('content')
    <div class="row justify-content-md-center">
        <div class="col-lg-8">
            <h1>Edit Post</h1>

            <!-- The form to edit the post -->
            <!-- The post id is added to get the specific post -->
            {!! Form::open(['action' => ['PostsController@update', $post->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                <!-- Title. The value for the post is added to bring in the already inputed value when the post was created -->
                
                <div class="form-group">
                    {{Form::label('title', 'Title')}}
                    {{Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}
                </div>

                <!-- Body. id => article-ckeditor is gotten from the ckeditor also included in the app file in layout folder -->
                <!-- The value for the post is added to bring in the already inputed value when the post was created -->
                <div class="form-group">
                    {{Form::label('body', 'Body')}}
                    {{Form::textarea('body', $post->body, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body Text'])}}
                </div>

                <!-- The File Upload -->
                <div class="form-group">
                    {{Form::file('cover_image')}}
                </div>

                <!-- the hidden is added for the method -->
                {{Form::hidden('_method', 'PUT')}}
                <!-- Submit Button -->
                {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
            {!! Form::close() !!}
        </div>
    </div>

@endsection