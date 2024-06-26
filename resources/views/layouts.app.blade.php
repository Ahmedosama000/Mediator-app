<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body>
    <nav>
        <ul>
            <li><a href="{{ route('posts.index') }}">Posts</a></li>
            @auth
                <li><a href="{{ route('posts.create') }}">Create Post</a></li>
            @endauth
        </ul>
    </nav>
    <main class="py-4">
        @yield('content')
    </main>
</body>
</html>
