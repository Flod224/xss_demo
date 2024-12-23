<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;


class CommentController extends Controller
{
    // Affiche les commentaires et le formulaire
    public function index(Request $request)
        {
            $search = $request->get('search', ''); // Valeur par défaut vide
            $comments = Comment::query();

            if ($search) {
                $comments = $comments->where('content', 'like', "%{$search}%");
            }

            return view('comments.index', [
                'comments' => $comments->get(),
                'search' => $search,
            ]);
        }


    // Enregistre un commentaire dans la base de données
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);
        // Filtrer les balises HTML pour empêcher XSS
        //$content = strip_tags($request->content); // Remove tags

        // Convertir les caractères spéciaux en entités HTML
        //$content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8'); 

        //Comment::create(['content' => $request->content]);
        Comment::create(['content' => $content]);

        return redirect()->route('comments.index')->with('success', 'Comment posted successfully!');
    }

    public function storename(Request $request){
        $request->validate([
            'name' => 'required|string|unique',
        ]);
        // Filtrer les balises HTML pour empêcher XSS
        //$name = strip_tags($request->name); // Remove tags

        // Convertir les caractères spéciaux en entités HTML
        //$name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); 

        //Comment::create(['content' => $request->content]);
        
        User::create(['name' => $request->name]);

        return redirect()->route('comments.index')->with('success', 'User add successfully!');

    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->route('comments.index')->with('success', 'Comment deleted successfully!');
    }

}

