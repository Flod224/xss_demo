<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Ad;

class PostController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->get('search', '');
        $posts = Post::with('comments') // Charger les commentaires en même temps
                    ->when($search, function($query, $search) {
                        return $query->whereHas('comments', function($query) use ($search) {
                            $query->where('content', 'like', "%{$search}%");
                        });
                    })
                    ->get();
        

        return view('posts.index', compact('posts', 'search'));
    }

    public function store(Request $request) {
        Post::create($request->only(['title', 'content']));
        return back()->with('message', 'Publication ajoutée avec succès');
    }
    
    public function comment(Request $request, Post $post)
        {
            // Vérifie si le champ 'content' est vide
            if (empty($request->content)) {
                return back()->withErrors(['content' => 'Le commentaire ne peut pas être vide.']);
            }

            // Créer un commentaire
            $post->comments()->create($request->only(['content']));

            return back();
        }
    
}
