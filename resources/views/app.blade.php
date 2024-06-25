<nav>
    <ul>
        <li><a href="{{ route('posts.index') }}">Posts</a></li>
        @auth
            <li><a href="{{ route('posts.create') }}">Create Post</a></li>
        @endauth
    </ul>
</nav>
