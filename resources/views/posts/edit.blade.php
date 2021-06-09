@extends('layouts.app')

@section('content')
    <h1>Edit Blog</h1>
    <!--Used laravel collective for forms-->
    {!! Form::open(['action' => ['App\Http\Controllers\PostsController@update', $post->id], 'method' => 'POST', 'enctype' => 'multipart/form-data'])  !!}
        <div class="form-group">
            {{  Form::label('title', 'Title')}}
            {{  Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'Title'])    }}
        </div>
        <div class="form-group">
            {{  Form::label('body', 'Body')}}
            {{  Form::textarea('body', $post->body, ['class' => 'form-control', 'placeholder' => 'Body'])    }}
        </div>

        <div class="form-group">
            {{Form::file('cover_image')}}
        </div>

        <!--this is for updated the blog-->
    {{ Form::hidden('_method', 'PUT') }}

    {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
    {!! Form::close() !!}

@endsection
