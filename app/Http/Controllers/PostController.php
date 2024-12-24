<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $posts = Post::with('comments')->get();
        return view('posts.index', compact('posts'));
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
