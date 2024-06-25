<!-- resources/views/posts/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>
    <small>Posted by {{ $post->user->name }} on {{ $post->created_at->format('d M Y') }}</small>
    <br>
    <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back to Posts</a>
</div>
@endsection
