@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Publications</h1>
    @foreach ($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $post->title }}</h5>
                <p class="card-text">{{ $post->content }}</p>
                <h6>Commentaires :</h6>
                @foreach ($post->comments as $comment)
                    <p>{{ $comment->content }}</p>
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
