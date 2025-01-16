@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Votre Profil</h1>
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="photo">Télécharger une photo</label>
            <input type="file" name="profile_photo" id="photo" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary mt-2">Mettre à jour</button>
    </form>

    @if (Auth::user()->profile_photo)
        <h3>Votre photo de profil :</h3>
        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Photo de profil" class="img-fluid">
    @endif
</div>
@endsection
