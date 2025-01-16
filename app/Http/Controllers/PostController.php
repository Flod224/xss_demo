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
            $request->validate([
                'content' => 'required|string',
            ]);

            // Vulnérabilité ICI
            $content = $request->only(['content']);

            // Filtrer les balises HTML pour empêcher XSS
            //$content = strip_tags($content); // Remove tags
    
            // Convertir les caractères spéciaux en entités HTML
            //$content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8'); 
            
            // Créer un commentaire
            $post->comments()->create($content);

            return back();
        }
    
}
