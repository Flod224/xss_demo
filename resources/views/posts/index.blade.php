@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Search Bar -->
    <h2>Search Comments:</h2>
        <form action="{{ route('posts.index') }}" method="GET">
            <div class="form-group">
                 <input type="text" name="search" placeholder="Search..." value="{{ request()->get('search') }}">
               <!--<input type="text" name="search" placeholder="Search..." value="{!! request()->get('search') !!}">-->
            </div>
            <button type="submit">Search</button>

        </form>

    <h1>Publications</h1>
    @foreach ($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $post->title }}</h5>
                <p class="card-text">{{ $post->content }}</p>
                <h6>Commentaires :</h6>
                <?php 
                //$search = strip_tags($_GET['search'] ?? ''); // Remove tags
                //$search = htmlspecialchars(($_GET['search'] ?? ''), ENT_QUOTES, 'UTF-8'); // Remove tags
                $search = ($_GET['search'] ?? ''); //  Vulnérabilité XSS ici
                
                echo "<pre>Results for : $search </pre>"; ?>
                
                @foreach ($post->comments as $comment)
                    <p>{!! $comment->content !!}</p>   <!-- Vulnérabilité XSS ici -->
                    <!-- <p>{{ $comment->content }}</p>  Correction XSS ici -->
                @endforeach

                <!-- Formulaire pour ajouter un commentaire -->
                <form action="{{ route('posts.comment', $post->id) }}" method="POST">
                    @csrf
                    <textarea name="content" rows="3" class="form-control" placeholder="Votre commentaire"></textarea>
                    <button type="submit" class="btn btn-primary mt-2">Commenter</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection
