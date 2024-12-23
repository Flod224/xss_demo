<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment Section</title>
</head>
<body>
    <h2>Search Comments:</h2>
    <form action="{{ route('comments.index') }}" method="GET">
        <input type="text" name="search" placeholder="Search..." value="{{ request()->get('search') }}">
        <button type="submit">Search</button>
    </form>

    <h1>Post a Comment</h1>
    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    <form action="{{ route('comments.store') }}" method="POST">
    @csrf
        <textarea name="content" rows="5" cols="50" placeholder="Write your comment here"></textarea><br>
        <button type="submit">Post Comment</button>
    </form>

    <h2>Comments:</h2>
    <ul>
        @foreach ($comments as $comment)
             <li>{!! $comment->content !!}</li> <!--Vulnérabilité XSS ici -->
             <!--<li>{{ $comment->content }}</li> Ceci permet d'échapper  automatiquement le contenu -->

        @endforeach
    </ul>
</body>
</html>
