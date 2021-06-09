@extends('layouts.app')

@section('content')
<a href="/posts" class="btn btn-default">Go Back</a>
<div class="row">
    <div class="col-md-12">
        <img style="width: 100%" src="/storage/cove_images/{{$post->cover_image}}" alt="">
    </div>
</div>
    <h1>{{ $post->title }}</h1>
        <p>{{ $post->body }}</p>
<!--separation-->
<hr>
    <small>Written on {{ $post->created_at }}</small>
<!--separation-->
<hr>
<!--Conditional statement if guest, hindi makikita yung button ng delete/edit-->
@if(!Auth::guest())
    <!--Conditional statement para yung owner ng post lang makakita ng delete/edit-->
    @if(Auth::user()->id == $post->user_id)
    
    <a href="/posts/{{ $post->id }}/edit" class="btn btn-default">Edit</a>
   
    {!!Form::open(['action' => ['App\Http\Controllers\PostsController@destroy', $post->id], 'method' => 'POST','class'=> 'pull-right'])!!}
    {{Form::hidden('_method', 'DELETE')}}
    {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
    {!!Form::close()!!}

    @endif
@endif

@endsection
