@extends('layouts.app')

@section('content')
    <div class="row justify-content-md-center">
        <div class="col-lg-8">
            <h1>Create Post</h1>

            <!-- The form to create the post -->
            {!! Form::open(['action' => 'PostsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                
                <!-- Title -->
                <div class="form-group">
                    {{Form::label('title', 'Title')}}
                    {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}
                </div>
                
                <!-- Body. id => article-ckeditor is gotten from the ckeditor also included in the app file in layout folder -->
                <div class="form-group">
                    {{Form::label('body', 'Body')}}
                    {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body Text'])}}
                </div>

                <!-- The File Upload -->
                <div class="form-group">
                    {{Form::file('cover_image')}}
                </div>

                <!-- Submit Button -->
                {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
            {!! Form::close() !!}
        </div>
    </div>

@endsection