<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

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
        return back();
    }
    
    public function comment(Request $request, Post $post) {
        $post->comments()->create($request->only(['content']));
        return back();
    }
    
}
