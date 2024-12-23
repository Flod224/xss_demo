<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;


class CommentController extends Controller
{
    // Affiche les commentaires et le formulaire
    public function index(Request $request)
    {
        $search = $request->get('search');
        if ($search) {
            $comments = Comment::where('content', 'like', '%' . $search . '%')->get();
        } else {
            $comments = Comment::all();
        }
        return view('comments.index', compact('comments'));
    }
    

    // Enregistre un commentaire dans la base de données
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);
        // Filtrer les balises HTML pour empêcher XSS
        //$content = strip_tags($request->content);
        // Convertir les caractères spéciaux en entités HTML
         //$content = htmlspecialchars($request->content, ENT_QUOTES, 'UTF-8');

        Comment::create(['content' => $request->content]);

        return redirect()->route('comments.index')->with('success', 'Comment posted successfully!');
    }
}

