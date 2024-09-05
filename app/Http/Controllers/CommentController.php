<?php

namespace App\Http\Controllers;

use id;
use App\Models\Comment;
use Illuminate\Http\Request;

// app/Http/Controllers/CommentController.php
class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        $comment = Comment::create($request->all());

        return response()->json($comment, 201);
    }

    public function index()
    {
        $comments = Comment::all();
        return response()->json($comments);
    }

}
