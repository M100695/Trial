@extends('layouts.app')

@section('content')
    <h1>Create Blog</h1>
    <!--Used laravel collective for forms-->     <!--"enctype kasama sa image "-->
    {!! Form::open(['action' => 'App\Http\Controllers\PostsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data'])  !!}
        <div class="form-group">
            {{  Form::label('title', 'Title')}}
            {{  Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])    }}
        </div>
        <div class="form-group">
            {{  Form::label('body', 'Body')}}
            {{  Form::textarea('body', '', ['class' => 'form-control', 'placeholder' => 'Body'])    }}
        </div>
        <div class="form-group">
            {{Form::file('cover_image')}}
        </div>
         <!--this is for creating the blog-->
    {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
    {!! Form::close() !!}



@endsection
