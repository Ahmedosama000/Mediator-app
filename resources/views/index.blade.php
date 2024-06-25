<!-- resources/views/posts/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Posts</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Create New Post</a>
    <div class="list-group">
        @foreach($posts as $post)
            <a href="{{ route('posts.show', $post->id) }}" class="list-group-item list-group-item-action">
                <h5 class="mb-1">{{ $post->title }}</h5>
                <p class="mb-1">{{ Str::limit($post->content, 100) }}</p>
                <small>Posted by {{ $post->user->name }} on {{ $post->created_at->format('d M Y') }}</small>
            </a>
        @endforeach
    </div>
</div>
@endsection
